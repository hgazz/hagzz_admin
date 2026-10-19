<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

class CatalogProposalController extends Controller
{
    public function index(Request $request)
    {
        // Internal proposals never enter the live academies/trainings tables.
        $catalog = json_decode(file_get_contents(resource_path('catalog/egypt-qatar-proposals.json')), true, 512, JSON_THROW_ON_ERROR);
        $all = collect($catalog['academies']);
        $sports = $all->unique('selected_sport')->mapWithKeys(fn ($row) => [$row['selected_sport'] => app()->getLocale() === 'ar' ? $row['sport_ar'] : $row['sport_en']]);
        $filters = $request->validate([
            'country' => ['nullable', Rule::in(['eg', 'qa'])],
            'sport' => ['nullable', Rule::in($sports->keys()->all())],
            'q' => ['nullable', 'string', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);
        $filtered = $all->filter(function ($row) use ($filters) {
            if (!empty($filters['country']) && $row['country'] !== $filters['country']) return false;
            if (!empty($filters['sport']) && $row['selected_sport'] !== $filters['sport']) return false;
            if (!empty($filters['q'])) {
                $haystack = implode(' ', [$row['name'], $row['name_ar_proposed'], $row['city_region_from_lead'], $row['sport_ar'], $row['sport_en']]);
                if (!str_contains(mb_strtolower($haystack), mb_strtolower(trim($filters['q'])))) return false;
            }
            return true;
        })->values();
        $page = (int) ($filters['page'] ?? 1);
        $academies = new LengthAwarePaginator($filtered->forPage($page, 12)->values(), $filtered->count(), 12, $page, [
            'path' => $request->url(), 'query' => $request->except('page'),
        ]);
        return view('Admin.pages.catalog-proposals.index', compact('academies', 'catalog', 'sports', 'filters'));
    }

    public function download()
    {
        return response()->download(base_path('docs/content/egypt-qatar-training-proposals.csv'), 'Hagzz-Egypt-Qatar-90-Proposals.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8', 'Cache-Control' => 'private, no-store',
        ]);
    }
}
