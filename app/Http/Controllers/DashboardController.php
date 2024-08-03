<?php

namespace App\Http\Controllers;

use App\Http\Traits\BookingFilterTrait;
use App\Http\Traits\UsersTrait;
use App\Models\Follow;
use App\Models\Join;
use App\Models\Notification;
use App\Models\Settlement;
use App\Models\Sport;
use App\Models\User;
use App\Services\Chart\ChartsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

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

        $totalUsers = $this->getAllUsersCount();
        $maleUsers = $this->getAllMaleUsersCount();
        $femaleUsers = $this->getAllFemaleUsersCount();
        $usersBooking = $this->getUsersBooking();
        $newCustomers = $this->getUserBookingLast7Days();
        $beginnerLevels = $this->getBeginnerSportsCount();
        $intermediateLevels = $this->getIntermediateSportsCount();
        $advancedLevels = $this->getAdvancedSportsCount();
        $settlements = Settlement::latest()->first();
        $totalSettlements = Settlement::sum('total_amount');
        $follows = Follow::count();
        return view('Admin.index', compact('totalUsers','totalSettlements','follows','maleUsers', 'femaleUsers', 'usersBooking', 'newCustomers', 'beginnerLevels', 'intermediateLevels', 'advancedLevels', 'settlements'));
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
