<?php

namespace App\Http\Controllers;

use App\Http\Traits\BookingFilterTrait;
use App\Http\Traits\UsersTrait;
use App\Models\Academies;
use App\Models\Follow;
use App\Models\Invoice;
use App\Models\Join;
use App\Models\Notification;
use App\Models\Settlement;
use App\Models\Sport;
use App\Models\Training;
use App\Models\User;
use App\Services\Chart\ChartsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    use BookingFilterTrait, UsersTrait;

    private ChartsService $chartsService;

    /**
     * @param ChartsService $chartsService
     */
    public function __construct(ChartsService $chartsService)
    {
        $this->chartsService = $chartsService;
    }


    public function index()
    {
        $now = now();
        $monthStart = $now->copy()->subMonths(11)->startOfMonth();
        $currentPeriodStart = $now->copy()->subDays(29)->startOfDay();
        $previousPeriodStart = $currentPeriodStart->copy()->subDays(30);

        $totalUsers = User::count();
        $totalAcademies = Academies::count();
        $activeAcademies = Academies::where('status', 'active')->count();
        $totalTrainings = Training::count();
        $activeTrainings = Training::where('active', 1)->count();
        $totalBookings = Join::count();
        $totalRevenue = (float) Join::sum('price');
        $pendingBookings = Invoice::where('status', 'pending')->count();

        $currentBookings = Join::where('created_at', '>=', $currentPeriodStart)->count();
        $previousBookings = Join::whereBetween('created_at', [$previousPeriodStart, $currentPeriodStart])->count();
        $currentUsers = User::where('created_at', '>=', $currentPeriodStart)->count();
        $previousUsers = User::whereBetween('created_at', [$previousPeriodStart, $currentPeriodStart])->count();

        $monthlyBookings = Join::query()
            ->where('created_at', '>=', $monthStart)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month_key, COUNT(*) as bookings_count, COALESCE(SUM(price), 0) as revenue")
            ->groupBy('month_key')
            ->get()
            ->keyBy('month_key');

        $monthlyUsers = User::query()
            ->where('created_at', '>=', $monthStart)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month_key, COUNT(*) as users_count")
            ->groupBy('month_key')
            ->get()
            ->keyBy('month_key');

        $months = collect(range(0, 11))->map(function ($offset) use ($monthStart, $monthlyBookings, $monthlyUsers) {
            $month = $monthStart->copy()->addMonths($offset);
            $key = $month->format('Y-m');
            $booking = $monthlyBookings->get($key);
            $users = $monthlyUsers->get($key);

            return [
                'label' => $month->locale(app()->getLocale())->translatedFormat('M Y'),
                'bookings' => (int) ($booking->bookings_count ?? 0),
                'revenue' => round((float) ($booking->revenue ?? 0), 2),
                'users' => (int) ($users->users_count ?? 0),
            ];
        });

        $topSports = DB::table('sports')
            ->leftJoin('trainings', 'trainings.sport_id', '=', 'sports.id')
            ->leftJoin('joins', 'joins.training_id', '=', 'trainings.id')
            ->select('sports.id', 'sports.name')
            ->selectRaw('COUNT(joins.id) as bookings_count')
            ->groupBy('sports.id', 'sports.name')
            ->orderByDesc('bookings_count')
            ->limit(6)
            ->get()
            ->map(fn ($sport) => [
                'name' => $this->localizedValue($sport->name),
                'bookings' => (int) $sport->bookings_count,
            ]);

        $academyPerformance = DB::table('academies')
            ->leftJoin('trainings', 'trainings.academy_id', '=', 'academies.id')
            ->leftJoin('joins', 'joins.training_id', '=', 'trainings.id')
            ->select('academies.id', 'academies.commercial_name', 'academies.status')
            ->selectRaw('COUNT(DISTINCT trainings.id) as trainings_count')
            ->selectRaw('COUNT(DISTINCT joins.id) as bookings_count')
            ->selectRaw('COALESCE(SUM(joins.price), 0) as revenue')
            ->groupBy('academies.id', 'academies.commercial_name', 'academies.status')
            ->orderByDesc('bookings_count')
            ->limit(5)
            ->get()
            ->map(fn ($academy) => [
                'id' => $academy->id,
                'name' => $this->localizedValue($academy->commercial_name),
                'status' => $academy->status,
                'trainings' => (int) $academy->trainings_count,
                'bookings' => (int) $academy->bookings_count,
                'revenue' => round((float) $academy->revenue, 2),
            ]);

        $recentBookings = Join::with([
            'user:id,name,phone',
            'training:id,name,academy_id',
            'training.academy:id,commercial_name',
            'invoice:id,status,is_canceled',
        ])->latest()->limit(6)->get();

        $canceledBookings = Schema::hasColumn('invoices', 'is_canceled')
            ? Invoice::where('is_canceled', 1)->count()
            : 0;
        $paidBookings = Invoice::where('status', 'paid')
            ->when(Schema::hasColumn('invoices', 'is_canceled'), fn ($query) => $query->where('is_canceled', 0))
            ->count();

        $dashboard = [
            'adminName' => trim((auth('admin')->user()->first_name ?? '') . ' ' . (auth('admin')->user()->last_name ?? '')),
            'totalUsers' => $totalUsers,
            'totalAcademies' => $totalAcademies,
            'activeAcademies' => $activeAcademies,
            'totalTrainings' => $totalTrainings,
            'activeTrainings' => $activeTrainings,
            'totalBookings' => $totalBookings,
            'totalRevenue' => $totalRevenue,
            'pendingBookings' => $pendingBookings,
            'followers' => Follow::count(),
            'bookingTrend' => $this->percentageChange($currentBookings, $previousBookings),
            'userTrend' => $this->percentageChange($currentUsers, $previousUsers),
            'monthLabels' => $months->pluck('label'),
            'monthlyBookings' => $months->pluck('bookings'),
            'monthlyRevenue' => $months->pluck('revenue'),
            'monthlyUsers' => $months->pluck('users'),
            'topSports' => $topSports,
            'academyPerformance' => $academyPerformance,
            'recentBookings' => $recentBookings,
            'bookingStatuses' => [
                'paid' => $paidBookings,
                'pending' => $pendingBookings,
                'canceled' => $canceledBookings,
            ],
        ];

        return view('Admin.index', compact('dashboard'));
    }

    public function filterBookings(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $totalBookingBalance = $this->getTotalBookingBalance($startDate, $endDate);
        $totalBookingRefundCount = $this->getTotalBookingRefundCount($startDate, $endDate);
        $totalBookingRefundAmount = $this->getTotalBookingRefundAmount($startDate, $endDate);
        $totalBookingCount = $this->getTotalBookingCount($startDate, $endDate);

        return response()->json([
            'total_booking_balance' => $totalBookingBalance,
            'total_booking_refund_count' => $totalBookingRefundCount,
            'total_booking_refund_amount' => $totalBookingRefundAmount,
            'total_booking_count' => $totalBookingCount,
        ]);
    }

    public function getRevenueDataByMonth()
    {
        $ordersData = $this->chartsService->getBookingsDataByMonth();


        return response()->json([
            'ordersData' => $ordersData['joinsData'],
            'totalProfit' => $ordersData['total']
        ]);
    }

    public function getUserDataByMonthAjax(Request $request): JsonResponse
    {
        $maleUsersByMonth = User::select('id')
            ->whereGender('male')
            ->whereMonth('created_at', now()->month)
            ->get()
            ->count();

        $femaleUsersByMonth = User::select('id')
            ->whereGender('female')
            ->whereMonth('created_at', now()->month)
            ->get()
            ->count();

        return Response::json(['maleUsersByMonth' => $maleUsersByMonth, 'femaleUsersByMonth' => $femaleUsersByMonth]);
    }

    public function getUserDataByYearAjax(Request $request): JsonResponse
    {
        $maleUsersByYear = User::select('id')
            ->whereGender('male')
            ->whereYear('created_at', now()->year)
            ->count();

        $femaleUsersByYear = User::select('id')
            ->whereGender('female')
            ->whereYear('created_at', now()->year)
            ->count();

        return Response::json(['maleUsersByYear' => $maleUsersByYear, 'femaleUsersByYear' => $femaleUsersByYear]);
    }

    public function getBeginnerSportsCount()
    {
        return Sport::select('sports.id', 'sports.name', 'user_sport.level')
            ->join('academy_sport', 'sports.id', '=', 'academy_sport.sport_id')
            ->join('user_sport', 'sports.id', '=', 'user_sport.sport_id')
            ->where('user_sport.level', 'Beginner')
            ->count();
    }

    public function getIntermediateSportsCount()
    {

        return Sport::select('sports.id', 'sports.name', 'user_sport.level')
            ->join('academy_sport', 'sports.id', '=', 'academy_sport.sport_id')
            ->join('user_sport', 'sports.id', '=', 'user_sport.sport_id')
            ->where('user_sport.level', 'Intermediate')
            ->count();
    }

    public function getAdvancedSportsCount()
    {

        return Sport::select('sports.id', 'sports.name', 'user_sport.level')
            ->join('academy_sport', 'sports.id', '=', 'academy_sport.sport_id')
            ->join('user_sport', 'sports.id', '=', 'user_sport.sport_id')
            ->where('user_sport.level', 'Advanced')
            ->count();
    }
    private function getAllMaleUsersCount()
    {
        return User::select('id')->whereGender('male')->count();
    }

    private function getAllFemaleUsersCount()
    {
        return User::select('id')->whereGender('female')->count();
    }

    /**
     * @return mixed
     */
    public function getUsersBooking()
    {
        return Join::whereHas('training')->get()->unique('user_id');
    }

    private function getUserBookingLast7Days()
    {
        return Join::whereHas('training')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->get()
            ->unique('user_id');
    }

    private function percentageChange(int $current, int $previous): float
    {
        if ($previous === 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function localizedValue(?string $value): string
    {
        if (blank($value)) {
            return app()->getLocale() === 'ar' ? 'غير محدد' : 'Not specified';
        }

        $translations = json_decode($value, true);
        if (!is_array($translations)) {
            return $value;
        }

        return $translations[app()->getLocale()]
            ?? $translations['en']
            ?? $translations['ar']
            ?? reset($translations)
            ?? $value;
    }

    public function checkNotifications()
    {
        $unreadCount = Notification::whereNull('read_at')->count();
        $previousCount = session('notification_count', 0);

        // Save the new count in the session
        session(['notification_count' => $unreadCount]);

        // Return the current count and whether it has changed
        return response()->json([
            'unreadCount' => $unreadCount,
            'hasChanged' => $unreadCount !== $previousCount,
        ]);

        return response()->json(['unreadCount' => $unreadCount]);
    }

}
