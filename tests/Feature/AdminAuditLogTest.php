<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\AdminAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AdminAuditLogTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        (require database_path('migrations/2026_10_20_000001_create_admin_audit_logs_table.php'))->up();
        $this->withoutMiddleware([
            \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        ]);
        Route::middleware(['web', 'auth:admin'])->prefix('_audit-test')->name('admin.audit-test.')->group(function () {
            Route::post('/save/{partner}', fn () => response()->json(['saved' => true]))->name('save');
            Route::delete('/delete', fn () => response()->noContent())->name('delete');
            Route::post('/invalid', function (Request $request) { $request->validate(['name' => 'required']); })->name('invalid');
            Route::post('/denied', fn () => abort(403))->name('denied');
            Route::get('/read', fn () => 'read')->name('read');
        });
        Route::middleware('web')->post('/_audit-test/login', function () {
            auth('admin')->setUser($this->actor());
            return redirect('/admin');
        })->name('admin.login');
        Route::middleware(['web', 'auth:admin'])->get('/_audit-test/logout', function () {
            auth('admin')->forgetUser();
            return redirect('/admin/login');
        })->name('admin.logout');
    }

    private function actor(): Admin
    {
        $actor = new Admin(['first_name' => '<script>Admin</script>', 'last_name' => 'Test']);
        $actor->id = 91;
        return $actor;
    }

    public function test_authenticated_write_records_actor_target_and_status_without_secrets(): void
    {
        $this->actingAs($this->actor(), 'admin')->postJson('/_audit-test/save/12?token=QUERY_SECRET', [
            'password' => 'PASSWORD_SECRET', 'api_key' => 'KEY_SECRET', 'email' => 'private@example.test',
            'nested' => ['token' => 'NESTED_SECRET'],
        ])->assertOk();
        $log = AdminAuditLog::sole();
        $this->assertSame(91, $log->admin_id);
        $this->assertSame(['partner' => '12'], $log->target_ids);
        $this->assertSame('completed', $log->result);
        $this->assertSame('admin.audit-test.save', $log->action);
        foreach (['QUERY_SECRET', 'PASSWORD_SECRET', 'KEY_SECRET', 'NESTED_SECRET', 'private@example.test'] as $secret) {
            $this->assertStringNotContainsString($secret, $log->toJson());
        }
    }

    public function test_numeric_bulk_targets_only_and_no_read_logging(): void
    {
        $this->actingAs($this->actor(), 'admin')->deleteJson('/_audit-test/delete', ['ids' => [2, 3, 'SECRET', ['token' => 'SECRET']]])->assertNoContent();
        $this->assertSame(['ids' => [2, 3]], AdminAuditLog::sole()->target_ids);
        $this->get('/_audit-test/read')->assertOk();
        $this->assertSame(1, AdminAuditLog::count());
    }

    public function test_validation_and_authorization_errors_are_not_labelled_completed(): void
    {
        $this->actingAs($this->actor(), 'admin')->postJson('/_audit-test/invalid')->assertUnprocessable();
        $this->postJson('/_audit-test/denied')->assertForbidden();
        $this->assertSame(['rejected', 'rejected'], AdminAuditLog::orderBy('id')->pluck('result')->all());
        $this->assertSame([422, 403], AdminAuditLog::orderBy('id')->pluck('response_status')->all());
    }

    public function test_successful_login_and_logout_preserve_actor_identity(): void
    {
        $this->post('/_audit-test/login')->assertRedirect('/admin');
        $this->get('/_audit-test/logout')->assertRedirect('/admin/login');
        $this->assertSame(['admin.login', 'admin.logout'], AdminAuditLog::orderBy('id')->pluck('action')->all());
        $this->assertSame([91, 91], AdminAuditLog::orderBy('id')->pluck('admin_id')->all());
    }

    public function test_guests_cannot_read_or_create_audit_records(): void
    {
        $this->getJson('/admin/audit-logs')->assertUnauthorized();
        $this->postJson('/_audit-test/save/12')->assertUnauthorized();
        $this->assertSame(0, AdminAuditLog::count());
    }

    public function test_read_only_page_filters_escapes_values_and_displays_historical_actor_snapshots(): void
    {
        $this->actingAs($this->actor(), 'admin');
        foreach ([['admin_id' => 91, 'action' => 'admin.academies.update', 'created_at' => '2026-10-20 10:00:00'],
            ['admin_id' => 92, 'action' => 'admin.academies.delete', 'created_at' => '2026-10-19 10:00:00']] as $entry) {
            AdminAuditLog::create($entry + ['actor_name' => '<script>Admin</script>', 'method' => 'POST', 'result' => 'completed', 'response_status' => 200]);
        }
        $response = $this->get('/admin/audit-logs?admin_id=91&from=2026-10-20&to=2026-10-20');
        $response->assertOk()->assertSee('admin.academies.update')->assertDontSee('admin.academies.delete')->assertSee('&lt;script&gt;Admin&lt;/script&gt;', false);
        $this->assertCount(1, $response->viewData('logs'));
        $this->get('/admin/audit-logs?to=2026-10-19')->assertOk()->assertViewHas('logs', fn ($logs) => $logs->total() === 1);
        $this->get('/admin/audit-logs?result=rejected')->assertOk()->assertViewHas('logs', fn ($logs) => $logs->total() === 0);
        $this->assertSame(2, AdminAuditLog::count());
    }

    public function test_audit_storage_failure_does_not_turn_a_completed_operation_into_an_error(): void
    {
        \Illuminate\Support\Facades\Schema::drop('admin_audit_logs');
        \Illuminate\Support\Facades\Log::spy();
        $this->actingAs($this->actor(), 'admin')->postJson('/_audit-test/save/12')->assertOk();
        \Illuminate\Support\Facades\Log::shouldHaveReceived('critical')->once()->with('Admin audit write failed', [
            'action' => 'admin.audit-test.save', 'admin_id' => 91,
        ]);
    }

    public function test_invalid_date_filter_is_rejected_and_migration_rolls_back(): void
    {
        $this->actingAs($this->actor(), 'admin')->getJson('/admin/audit-logs?from=2026-10-21&to=2026-10-20')->assertUnprocessable();
        $migration = require database_path('migrations/2026_10_20_000001_create_admin_audit_logs_table.php');
        $migration->down();
        $this->assertFalse(\Illuminate\Support\Facades\Schema::hasTable('admin_audit_logs'));
    }
}
