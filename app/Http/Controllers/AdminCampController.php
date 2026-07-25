<?php

namespace App\Http\Controllers;

use App\Models\Academies;
use App\Models\AcademyCamp;
use App\Models\AcademyCampExpense;
use App\Models\AcademyCampParticipant;
use App\Models\Sport;
use Illuminate\Http\Request;

class AdminCampController extends Controller
{
    public function index(Request $request)
    {
        $query = AcademyCamp::with(['academy', 'sport', 'country'])
            ->withCount('participants');

        if ($request->filled('academy_id')) {
            $query->where('academy_id', $request->academy_id);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('sport_id')) {
            $query->where('sport_id', $request->sport_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%")
                  ->orWhere('hotel_name', 'like', "%{$search}%");
            });
        }

        $camps = $query->latest()->paginate(15);

        // Platform-wide Metrics
        $totalCamps = AcademyCamp::count();
        $domesticCamps = AcademyCamp::where('type', 'domestic')->count();
        $internationalCamps = AcademyCamp::where('type', 'international')->count();
        $totalParticipants = AcademyCampParticipant::count();

        $academies = Academies::select('id', 'name', 'commercial_name')->get();
        $sports = Sport::select('id', 'name')->get();

        return view('Admin.pages.camps.index', compact(
            'camps', 'totalCamps', 'domesticCamps', 'internationalCamps',
            'totalParticipants', 'academies', 'sports'
        ));
    }

    public function show($id)
    {
        $camp = AcademyCamp::with(['academy.country', 'sport', 'country', 'supervisors', 'participants', 'expenses'])
            ->findOrFail($id);

        $totalRevenue = (float) $camp->participants->sum('paid_amount');
        $totalExpenses = (float) $camp->expenses->sum('amount');
        $netProfit = $totalRevenue - $totalExpenses;

        return view('Admin.pages.camps.show', compact('camp', 'totalRevenue', 'totalExpenses', 'netProfit'));
    }
}
