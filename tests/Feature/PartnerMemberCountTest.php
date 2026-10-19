<?php

namespace Tests\Feature;

use App\DataTables\AcademiesDataTable;
use App\Exports\AcademiesExport;
use App\Models\Academies;
use App\Models\AcademyStudent;
use App\Models\Admin;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PartnerMemberCountTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        Schema::create('academies', function (Blueprint $table) {
            $table->id(); $table->text('commercial_name'); $table->string('email')->nullable();
            $table->string('phone')->nullable(); $table->string('role')->default('owner');
            $table->string('business_type'); $table->string('status')->default('active');
            foreach (['country_id', 'city_id', 'area_id', 'branch_to'] as $field) $table->unsignedBigInteger($field)->nullable();
            $table->timestamps();
        });
        Schema::create('academy_students', function (Blueprint $table) {
            $table->id(); $table->unsignedBigInteger('academy_id'); $table->string('name');
            $table->string('status')->default('active'); $table->timestamps();
        });
        foreach (['sports', 'countries', 'cities', 'areas'] as $name) {
            Schema::create($name, function (Blueprint $table) { $table->id(); $table->string('name')->nullable(); });
        }
        Schema::create('academy_sport', function (Blueprint $table) { $table->unsignedBigInteger('academy_id'); $table->unsignedBigInteger('sport_id'); });
        Schema::create('trainings', function (Blueprint $table) { $table->id(); $table->unsignedBigInteger('academy_id'); });
        Schema::create('joins', function (Blueprint $table) { $table->id(); $table->unsignedBigInteger('training_id'); $table->decimal('price', 10, 2); });
        foreach (['academy', 'gym', 'health_center', 'hybrid', 'venue'] as $index => $type) {
            Academies::create(['id' => $index + 1, 'commercial_name' => ['ar' => 'الشريك '.$type, 'en' => $type.' partner'], 'business_type' => $type]);
        }
        foreach ([[1, 'active'], [1, 'inactive'], [1, 'suspended'], [2, 'active'], [2, 'active'], [4, 'active']] as [$partner, $status]) {
            AcademyStudent::create(['academy_id' => $partner, 'name' => 'Member', 'status' => $status]);
        }
        // Bookings are deliberately duplicated: they must never inflate member counts.
        DB::table('trainings')->insert(['id' => 10, 'academy_id' => 1]);
        DB::table('joins')->insert([['training_id' => 10, 'price' => 100], ['training_id' => 10, 'price' => 100]]);
        $admin = new Admin(['first_name' => 'Test', 'last_name' => 'Admin']); $admin->id = 900;
        $this->actingAs($admin, 'admin');
    }

    public function test_counts_are_per_partner_include_inactive_members_and_handle_empty_partners(): void
    {
        $partners = app(AcademiesDataTable::class)->query(new Academies())->orderBy('id')->get();
        $this->assertSame([3, 2, 0, 1, 0], $partners->pluck('members_count')->all());
        $this->assertSame(3, $partners[0]->students()->count());
    }

    public function test_counts_are_aggregated_without_per_partner_count_queries(): void
    {
        DB::enableQueryLog(); DB::flushQueryLog();
        $partners = app(AcademiesDataTable::class)->query(new Academies())->get();
        foreach ($partners as $partner) $this->assertIsInt($partner->members_count);
        $this->assertCount(2, DB::getQueryLog()); // Partners with the count subquery, then eager-loaded sports.
        DB::disableQueryLog();
    }

    public function test_counts_update_when_members_are_added_or_deleted_and_are_sortable(): void
    {
        $member = AcademyStudent::create(['academy_id' => 3, 'name' => 'New member', 'status' => 'active']);
        $this->assertSame(1, app(AcademiesDataTable::class)->query(new Academies())->findOrFail(3)->members_count);
        $member->delete();
        $partners = app(AcademiesDataTable::class)->query(new Academies())->orderByDesc('members_count')->orderBy('id')->get();
        $this->assertSame([1, 2, 4, 3, 5], $partners->modelKeys());
    }

    public function test_column_is_localized_and_not_used_as_a_search_predicate(): void
    {
        foreach (['ar', 'en'] as $locale) {
            app()->setLocale($locale);
            $columns = collect(app(AcademiesDataTable::class)->getColumns());
            $column = $columns->firstWhere('data', 'members_count');
            $this->assertSame(trans('admin.academies.members_count'), $column['title']);
            $this->assertFalse($column['searchable']); $this->assertTrue($column['orderable']);
            $this->assertLessThan($columns->search(fn ($column) => $column['data'] === 'email'), $columns->search(fn ($column) => $column['data'] === 'members_count'));
        }
    }

    public function test_the_actual_ajax_table_returns_numeric_counts_and_orders_by_them(): void
    {
        $columns = array_map(fn ($column) => ['name' => $column['name'], 'data' => $column['data'], 'searchable' => 'false', 'orderable' => ($column['orderable'] ?? true) ? 'true' : 'false', 'search' => ['value' => '', 'regex' => false]], app(AcademiesDataTable::class)->getColumns());
        $index = array_search('members_count', array_column($columns, 'data'));
        $this->withoutMiddleware([\Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class, \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class]);
        $this->app->forgetInstance('datatables.request');
        $response = $this->getJson(route('admin.academies.index').'?'.http_build_query([
            'draw' => 1, 'start' => 0, 'length' => 10, 'columns' => $columns,
            'order' => [['column' => $index, 'dir' => 'desc']], 'search' => ['value' => '', 'regex' => false],
        ]), ['X-Requested-With' => 'XMLHttpRequest'])->assertOk();
        $response->assertJsonPath('data.0.members_count', 3)->assertJsonPath('data.1.members_count', 2);
        $this->assertSame([3, 2, 1, 0, 0], array_column($response->json('data'), 'members_count'));
    }

    public function test_export_includes_the_same_count_and_column_label(): void
    {
        $view = (new AcademiesExport())->view();
        $this->assertSame([3, 2, 0, 1, 0], $view->getData()['academies']->pluck('members_count')->all());
        $this->assertStringContainsString(trans('admin.academies.members_count'), $view->render());
    }
}
