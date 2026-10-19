<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CatalogProposalTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite'); // No live partner or training tables: proposals must not depend on them.
        $this->withoutMiddleware([
            \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        ]);
    }

    private function catalog(): array
    {
        return json_decode(file_get_contents(resource_path('catalog/egypt-qatar-proposals.json')), true, 512, JSON_THROW_ON_ERROR);
    }

    private function signIn(): void
    {
        $admin = new Admin(['first_name' => 'Reviewer']); $admin->id = 91;
        $this->actingAs($admin, 'admin');
    }

    public function test_selection_contains_fifteen_distinct_partners_per_country_and_ninety_nonbookable_proposals(): void
    {
        $academies = collect($this->catalog()['academies']);
        $this->assertCount(30, $academies);
        $this->assertCount(30, $academies->unique('key'));
        $trainings = $academies->flatMap(fn ($row) => $row['trainings']);
        $this->assertCount(90, $trainings->unique('key'));
        $this->assertCount(90, $trainings->unique('name_ar'));
        foreach (['eg' => 'EGP', 'qa' => 'QAR'] as $country => $currency) {
            $selected = $academies->where('country', $country);
            $this->assertCount(15, $selected);
            $this->assertCount(15, $selected->unique('selected_sport'));
            foreach ($selected as $academy) {
                $this->assertCount(3, $academy['trainings']);
                $this->assertSame('proposal_only', $academy['listing_status']);
                $this->assertFalse($academy['partnership_verified']);
                $this->assertNull($academy['logo_url']);
                foreach ($academy['trainings'] as $training) {
                    $this->assertSame($currency, $training['currency']);
                    $this->assertFalse($training['is_bookable']);
                    $this->assertFalse($training['price_approved']);
                    $this->assertSame('proposal', $training['status']);
                    $this->assertGreaterThan(0, $training['proposed_price']);
                    $this->assertEquals($training['proposed_price'], $training['price_per_session'] * $training['proposed_sessions']);
                    $this->assertNotNull($training['start_date']);
                    $this->assertNotEmpty($training['weekdays']);
                }
            }
        }
    }

    public function test_demo_operations_have_consistent_calendars_and_no_coach_conflicts(): void
    {
        $sessions = 0;
        $coachKeys = [];
        foreach ($this->catalog()['academies'] as $academy) {
            $this->assertSame('fictional_unverified', $academy['demo_coach']['status']);
            $this->assertSame('demo_unverified', $academy['demo_location']['status']);
            $this->assertNull($academy['demo_location']['latitude']);
            $this->assertNull($academy['demo_location']['longitude']);
            $coachKeys[] = $academy['demo_coach']['key'];
            $intervals = [];
            foreach ($academy['trainings'] as $training) {
                $this->assertSame($academy['country'] === 'eg' ? 'Africa/Cairo' : 'Asia/Qatar', $training['timezone']);
                $this->assertCount($training['proposed_sessions'], $training['proposed_sessions_calendar']);
                $this->assertSame('demo_unverified', $training['operational_details_status']);
                foreach ($training['proposed_sessions_calendar'] as $session) {
                    $start = new \DateTimeImmutable($session['start_at']);
                    $end = new \DateTimeImmutable($session['end_at']);
                    $local = $start->setTimezone(new \DateTimeZone($training['timezone']));
                    $this->assertSame($start->format('H:iP'), $local->format('H:iP'));
                    $this->assertSame(3600, $end->getTimestamp() - $start->getTimestamp());
                    $this->assertContains((int) $local->format('N'), $training['weekdays_iso']);
                    $this->assertSame($training['start_time'], $local->format('H:i'));
                    $intervals[] = [$start->getTimestamp(), $end->getTimestamp()];
                    $sessions++;
                }
            }
            usort($intervals, fn ($left, $right) => $left[0] <=> $right[0]);
            for ($i = 1; $i < count($intervals); $i++) {
                $this->assertGreaterThanOrEqual($intervals[$i - 1][1], $intervals[$i][0]);
            }
        }
        $this->assertCount(30, array_unique($coachKeys));
        $this->assertSame(600, $sessions);
    }

    public function test_guest_cannot_view_or_download_the_internal_proposals(): void
    {
        $this->getJson('/admin/catalog-proposals')->assertUnauthorized();
        $this->getJson('/admin/catalog-proposals/download')->assertUnauthorized();
    }

    public function test_review_page_filters_and_paginates_without_accessing_live_partner_data(): void
    {
        $this->signIn();
        DB::enableQueryLog();
        $response = $this->get('/admin/catalog-proposals?country=qa');
        $response->assertOk()->assertViewHas('academies', fn ($rows) => $rows->total() === 15 && $rows->count() === 12);
        $this->get('/admin/catalog-proposals?country=qa&page=2')->assertOk()
            ->assertViewHas('academies', fn ($rows) => $rows->total() === 15 && $rows->count() === 3);
        $this->get('/admin/catalog-proposals?country=eg&sport=swimming')->assertOk()
            ->assertViewHas('academies', fn ($rows) => $rows->total() === 1 && $rows->first()['name'] === 'Liquid Lane Swimming Academy');
        $this->get('/admin/catalog-proposals?q=HAMILTON')->assertOk()
            ->assertViewHas('academies', fn ($rows) => $rows->total() === 1);
        $this->assertSame([], DB::getQueryLog());
        DB::disableQueryLog();
    }

    public function test_filters_are_validated_and_empty_results_render(): void
    {
        $this->signIn();
        $this->getJson('/admin/catalog-proposals?country=sa')->assertUnprocessable();
        $this->getJson('/admin/catalog-proposals?sport=not-a-sport')->assertUnprocessable();
        $this->get('/admin/catalog-proposals?q=nonexistent-partner')->assertOk()
            ->assertViewHas('academies', fn ($rows) => $rows->total() === 0);
    }

    public function test_download_matches_the_reviewed_ninety_training_proposals(): void
    {
        $this->signIn();
        $response = $this->get('/admin/catalog-proposals/download');
        $response->assertOk()->assertDownload('Hagzz-Egypt-Qatar-90-Proposals.csv');
        $file = $response->baseResponse->getFile()->getPathname();
        $handle = fopen($file, 'r'); $header = fgetcsv($handle); $rows = [];
        while (($row = fgetcsv($handle)) !== false) $rows[] = $row;
        fclose($handle);
        $this->assertCount(90, $rows);
        $this->assertNotContains('Phone', $header);
        $this->assertNotContains('Email', $header);
        $this->assertNotContains('Notes', $header);
        $this->assertNotContains('Customer Reply', $header);
    }

    public function test_arabic_and_english_notices_explain_that_prices_are_unapproved(): void
    {
        $this->signIn();
        foreach (['ar', 'en'] as $locale) {
            app()->setLocale($locale);
            $this->withSession(['locale' => $locale])->get('/admin/catalog-proposals')
                ->assertOk()->assertSee(trans('admin.catalog.notice'))->assertSee(trans('admin.catalog.price_proposal'));
        }
    }
}
