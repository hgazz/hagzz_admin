<?php

namespace App\Http\Controllers;

use App\DataTables\TrainingDataTable;
use App\Exports\TrainingExport;
use App\Http\Requests\Booking\BookingRequest;
use App\Models\Academies;
use App\Models\Area;
use App\Models\City;
use App\Models\Coach;
use App\Models\Country;
use App\Models\Follow;
use App\Models\Invoice;
use App\Models\Join;
use App\Models\Training;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TrainingController extends Controller
{
    private Country $countryModel;
    private City $cityModel;
    private $areaModel;

    public function __construct(Country $country, City $city, Area $area)
    {
        $this->countryModel = $country;
        $this->cityModel = $city;
        $this->areaModel = $area;
    }

    public function index(TrainingDataTable $dataTable)
    {
        return $dataTable->render('Admin.pages.training.index');
    }

    public function show(Training $training)
    {
        return view('Admin.pages.training.show', get_defined_vars());
    }

    public function updateTrainingStatus(Training $training)
    {
        $training->update(['active' => ! $training->active]);
        if ($training->active){
            $this->sendNotification($training);
        }

        return back()->with('success', __('admin.training.Training Status Updated'));
    }

    public function export()
    {
        return Excel::download(new TrainingExport(),'training.xlsx');
    }

    public function createBooking(Training $training)
    {
        $countries = Country::get(['id','name']);
        return view('Admin.pages.training.booking', get_defined_vars());
    }

    public function storeBooking(BookingRequest $request)
    {
        try {
            $training = Training::findOrFail($request->training_id);
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'country_code' => $request->country_code,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'area_id' => $request->area_id,
                'user_type'=> 'system',
                'birth_date'=> $request->birth_date,
            ]);
            $booking = Invoice::create([
                'user_id' => $user->id,
                'training_id' => $request->training_id,
                'amount' => $request->price,
                'order_number' => uniqid(),
                'status' => 'paid',
                'user_type' => 'offline'
            ]);
            Join::create([
                'user_id' => $user->id,
                'training_id' => $request->training_id,
                'price' => $booking->amount,
                'invoice_id' => $booking->id,
            ]);
            DB::commit();
            session()->flash('success', __('admin.training.Booking created successfully'));
            return to_route('admin.training.index');
        }catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getAreaByCity(Request $request)
    {
        $areas = $this->areaModel::where('city_id', $request->city_id)->get();
        return response()->json($areas);
    }

    public function getCityByCountry(Request $request)
    {
        $cities = $this->cityModel::where('country_id', $request->country_id)->get();
        return response()->json($cities);
    }

    public function delete(Request $request)
    {
        try {
            $training = Training::findOrFail($request->id);
            $training->delete();
            return response()->json(['data' => [
                'status' => 'success',
                'model'   => trans('admin.training.training'),
                'message' => trans('admin.training.deleted_successfully'),
            ]]);
        }catch (\Exception $e) {
            return response()->json(['data' => [
                'status' => 'failed',
            ]]);
        }
    }

    /**
     * @param Training $training
     * @return void
     */
    public function sendNotification(Training $training): void
    {
            $details = [
                'training_id' => $training->id,
                'longitude' => $training->longitude,
                'latitude' => $training->latitude,
                'academy_name' => $training->academy->commercial_name
            ];
            $AcademyTitle = 'Don’t miss out!';
            $AcademyBody = 'just added a new activity. Check it out!';
            $academyFollows = Follow::where([
                'followable_type' => Academies::class,
                'followable_id' => $training->academy_id,
            ])->get();
            $academyFollows->map(function ($follow) use ($AcademyTitle, $AcademyBody, $details, $training) {
                NotificationService::dbNotification($follow->user_id, User::class, 1, $AcademyTitle, $AcademyBody, $training->image, $details);
            });
        $coachTitle = 'Don’t miss out!';
            $coachBody = $training->coach->name . ' is leading a new training.Tap for details';
            $coachFollows = Follow::where([
                'followable_type' => Coach::class,
                'followable_id' => $training->coach_id,
            ])->get();
            $coachFollows->map(function ($follow) use ($coachTitle, $coachBody, $details, $training) {
                NotificationService::dbNotification($follow->user_id, User::class, 1, $coachTitle, $coachBody, $training->image, $details);
            });
    }
}
