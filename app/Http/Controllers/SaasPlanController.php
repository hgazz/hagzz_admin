<?php

namespace App\Http\Controllers;

use App\Models\SaasPlan;
use Illuminate\Http\Request;

class SaasPlanController extends Controller
{
    public function index() { return view('Admin.pages.saas_plans.index', ['plans' => SaasPlan::latest()->paginate(20)]); }
    public function create() { return view('Admin.pages.saas_plans.form', ['plan' => new SaasPlan()]); }
    public function store(Request $request) { SaasPlan::create($this->data($request)); return to_route('admin.saas-plans.index')->with('success', trans('admin.saas.saved')); }
    public function edit(SaasPlan $saasPlan) { return view('Admin.pages.saas_plans.form', ['plan' => $saasPlan]); }
    public function update(Request $request, SaasPlan $saasPlan) { $saasPlan->update($this->data($request, $saasPlan)); return to_route('admin.saas-plans.index')->with('success', trans('admin.saas.saved')); }
    public function destroy(SaasPlan $saasPlan) { abort_if($saasPlan->subscriptions()->exists(), 422, trans('admin.saas.plan_in_use')); $saasPlan->delete(); return back()->with('success', trans('admin.saas.deleted')); }

    private function data(Request $request, ?SaasPlan $plan = null): array
    {
        $data = $request->validate([
            'code' => ['required','alpha_dash','max:50','unique:saas_plans,code,'.($plan?->id ?? 'NULL')],
            'name_ar' => ['required','string','max:255'], 'name_en' => ['required','string','max:255'],
            'monthly_price' => ['required','numeric','min:0'], 'annual_price' => ['required','numeric','min:0'],
            'max_venues' => ['required','integer','min:1'], 'max_spaces' => ['required','integer','min:1'], 'max_staff' => ['required','integer','min:1'],
            'features' => ['nullable','array'], 'active' => ['nullable','boolean'],
        ]);
        return ['code'=>$data['code'],'name'=>['ar'=>$data['name_ar'],'en'=>$data['name_en']], 'monthly_price'=>$data['monthly_price'],
            'annual_price'=>$data['annual_price'],'max_venues'=>$data['max_venues'],'max_spaces'=>$data['max_spaces'],'max_staff'=>$data['max_staff'],
            'features'=>$data['features'] ?? [],'active'=>$request->boolean('active')];
    }
}
