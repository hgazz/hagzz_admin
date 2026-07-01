<?php

namespace App\Http\Controllers;

use App\Models\SaasPlan;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class SaasPlanController extends Controller
{
    public function index() { return view('Admin.pages.saas_plans.index', ['plans' => SaasPlan::with('prices.country')->latest()->paginate(20)]); }
    public function create() { return view('Admin.pages.saas_plans.form', ['plan' => new SaasPlan(), 'countries' => Country::orderBy('id')->get()]); }
    public function store(Request $request)
    {
        $validated = $this->validateData($request);
        DB::transaction(function () use ($validated) {
            $plan = SaasPlan::create($this->planData($validated));
            $this->syncPrices($plan, $validated['prices']);
        });
        return to_route('admin.saas-plans.index')->with('success', trans('admin.saas.saved'));
    }
    public function edit(SaasPlan $saasPlan) { return view('Admin.pages.saas_plans.form', ['plan' => $saasPlan->load('prices'), 'countries' => Country::orderBy('id')->get()]); }
    public function update(Request $request, SaasPlan $saasPlan)
    {
        $validated = $this->validateData($request, $saasPlan);
        DB::transaction(function () use ($validated, $saasPlan) {
            $saasPlan->update($this->planData($validated));
            $this->syncPrices($saasPlan, $validated['prices']);
        });
        return to_route('admin.saas-plans.index')->with('success', trans('admin.saas.saved'));
    }
    public function destroy(SaasPlan $saasPlan) { abort_if($saasPlan->subscriptions()->exists(), 422, trans('admin.saas.plan_in_use')); $saasPlan->delete(); return back()->with('success', trans('admin.saas.deleted')); }

    private function validateData(Request $request, ?SaasPlan $plan = null): array
    {
        $validated = $request->validate([
            'code' => ['required','alpha_dash','max:50','unique:saas_plans,code,'.($plan?->id ?? 'NULL')],
            'name_ar' => ['required','string','max:255'], 'name_en' => ['required','string','max:255'],
            'max_venues' => ['required','integer','min:1'], 'max_spaces' => ['required','integer','min:1'], 'max_staff' => ['required','integer','min:1'],
            'features' => ['nullable','array'], 'active' => ['nullable','boolean'],
            'prices' => ['required','array','min:1'], 'prices.*.enabled' => ['nullable','boolean'],
            'prices.*.country_id' => ['required','integer','exists:countries,id'],
            'prices.*.currency_code' => ['nullable','string','size:3'],
            'prices.*.monthly_price' => ['nullable','numeric','min:0'],
            'prices.*.annual_price' => ['nullable','numeric','min:0'],
            'prices.*.tax_rate' => ['nullable','numeric','between:0,100'],
            'prices.*.tax_included' => ['nullable','boolean'],
        ]);

        $enabledPrices = collect($validated['prices'])->filter(fn ($price) => ! empty($price['enabled']));

        if ($enabledPrices->isEmpty()) {
            throw ValidationException::withMessages([
                'prices' => app()->getLocale() === 'ar'
                    ? 'يجب تفعيل سعر دولة واحدة على الأقل قبل حفظ الباقة.'
                    : trans('admin.saas.enable_one_market'),
            ]);
        }

        $enabledPrices->each(function ($price, $index) {
            foreach (['currency_code', 'monthly_price', 'annual_price'] as $field) {
                if (! isset($price[$field]) || $price[$field] === '') {
                    throw ValidationException::withMessages([
                        "prices.$index.$field" => app()->getLocale() === 'ar'
                            ? 'كل دولة مفعلة يجب أن تحتوي على عملة وسعر شهري وسعر سنوي.'
                            : trans('admin.saas.enabled_market_requires_price'),
                    ]);
                }
            }
        });

        return $validated;
    }

    private function planData(array $data): array
    {
        $firstPrice = collect($data['prices'])->firstWhere('enabled', '1') ?? collect($data['prices'])->firstWhere('enabled', 1);
        return ['code'=>$data['code'],'name'=>['ar'=>$data['name_ar'],'en'=>$data['name_en']],
            'monthly_price'=>$firstPrice['monthly_price'] ?? 0,'annual_price'=>$firstPrice['annual_price'] ?? 0,
            'max_venues'=>$data['max_venues'],'max_spaces'=>$data['max_spaces'],'max_staff'=>$data['max_staff'],
            'features'=>$data['features'] ?? [],'active'=>(bool)($data['active'] ?? false)];
    }

    private function syncPrices(SaasPlan $plan, array $prices): void
    {
        $countryIds = [];
        foreach ($prices as $price) {
            if (empty($price['enabled'])) continue;
            $countryIds[] = $price['country_id'];
            $plan->prices()->updateOrCreate(['country_id' => $price['country_id']], [
                'currency_code' => strtoupper($price['currency_code']), 'monthly_price' => $price['monthly_price'],
                'annual_price' => $price['annual_price'], 'tax_rate' => $price['tax_rate'] ?? 0,
                'tax_included' => (bool)($price['tax_included'] ?? false), 'active' => true,
            ]);
        }
        $plan->prices()->whereNotIn('country_id', $countryIds)->update(['active' => false]);
    }
}
