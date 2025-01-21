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

    public function createBooking()
    {
        $countries = Country::get(['id','name']);
        $trainings = Training::get(['id', 'name']);
        return view('Admin.pages.training.booking', get_defined_vars());
    }

    public function storeBooking(BookingRequest $request)
    {

        try {
            $training = Training::findOrFail($request->training_id);
            DB::beginTransaction();
            $user = User::updateOrCreate(
                // Attributes to search for an existing user
                ['phone' => $request->phone],
                // Data to update or create
                [
                    'name' => $request->name,
                    'gender' => $request->gender,
                    'country_code' => $request->country_code,
                    'country_id' => $request->country_id,
                    'city_id' => $request->city_id,
                    'area_id' => $request->area_id,
                    'user_type'=> 'system',
                    'birth_date'=> $request->birth_date,
                    'email' => $request->email,
                    'child_type' => $request->child_type,
                    'school_name' => $request->school_name,
                    'parent_name' => $request->parent_name,
                    'parent_phone' => $request->parent_phone,
                    'club_member' => $request->club_member,
                    'coach_preference' =>  $request->coach_preference,
                    'frequent_attendance' => $request->frequent_attendance,
                    'relation_with_child' => $request->relation_with_child,
                    'referral_source' => $request->referral_source,
                    'delivery_service' => $request->delivery_service,
                    'medical_condition' => $request->medical_condition,
                    'medical_condition_details' => $request->medical_condition == 'yes' ? $request->medical_condition_details : null,
                    'additional_information' => $request->has('additional_information') ? $request->additional_information : null
                ]
            );
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
            return to_route('admin.booking.index');
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
                'academy_name' => $training->academy->getTranslation('commercial_name', 'en'),
            ];
            $AcademyTitle = 'Don’t miss out!';
            $AcademyBody = $training->academy->getTranslation('commercial_name', 'en') .' just added a new activity. Check it out!';
            $academyFollows = Follow::where([
                'followable_type' => Academies::class,
                'followable_id' => $training->academy_id,
            ])->get();
            $data = [
                'title' => $AcademyTitle,
                'body' => $AcademyBody,
                'image' => $training->academy->image,
                'details' => $details,
                "id" => $training->id,
                'page' => 'checkout'
            ];
            $academyFollows->map(function ($follow) use ($data) {
                NotificationService::firebaseNotification($data, $follow->user->fcm_token);
            });
        $coachTitle = 'Exciting News!';
            $coachBody = $training->coach->name . ' is leading a new training.Tap for details';
            $data = [
                'title' => $coachTitle,
                'body' => $coachBody,
                'image' => $training->academy->image,
                'details' => $details,
                "id" => $training->id,
                'page' => 'checkout'
            ];
            $coachFollows = Follow::where([
                'followable_type' => Coach::class,
                'followable_id' => $training->coach_id,
            ])->get();
            $coachFollows->map(function ($follow) use ($data) {
                NotificationService::firebaseNotification($data, $follow->user->fcm_token, );
            });
    }
}
