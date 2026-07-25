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
use App\Models\AcademyStudent;
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
        $trainings = Training::get(['id', 'name', 'price', 'academy_id']);
        $students = AcademyStudent::orderBy('name')->get(['id', 'name', 'phone', 'guardian_name']);
        return view('Admin.pages.training.booking', compact('trainings', 'students'));
    }

    public function storeBooking(BookingRequest $request)
    {
        try {
            $training = Training::findOrFail($request->training_id);

            if ($request->filled('academy_student_id')) {
                $student = AcademyStudent::findOrFail($request->academy_student_id);
            } else {
                $student = AcademyStudent::create([
                    'academy_id' => $training->academy_id ?: 1,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'gender' => $request->gender ?: 'male',
                    'status' => 'active',
                ]);
            }

            $totalAmount = round((float) $training->price, 2);
            $paidAmount = round((float) $request->paid_amount, 2);

            DB::beginTransaction();

            $user = $student->user ?: User::where('phone', $student->phone)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $student->name,
                    'phone' => $student->phone,
                    'gender' => $student->gender ?: 'male',
                    'user_type' => 'system',
                ]);
            }
            if ((int) $student->user_id !== (int) $user->id) {
                $student->update(['user_id' => $user->id]);
            }

            $booking = Invoice::create([
                'user_id' => $user->id,
                'training_id' => $request->training_id,
                'amount' => $totalAmount,
                'paid_amount' => $paidAmount,
                'order_number' => uniqid(),
                'status' => $paidAmount >= $totalAmount ? 'paid' : 'pending',
                'user_type' => 'offline',
                'payment_method' => $request->payment_method ?: 'cash',
            ]);

            Join::create([
                'user_id' => $user->id,
                'training_id' => $request->training_id,
                'academy_student_id' => $student->id,
                'price' => $booking->amount,
                'paid_amount' => $paidAmount,
                'invoice_id' => $booking->id,
            ]);

            DB::commit();

            session()->flash('success', __('admin.training.Booking created successfully'));
            return redirect()->route('admin.report.joins-offline');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
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
