<?php

use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AcademiesController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ //...
        Route::middleware('web')->group(function () {
            // login page , login route and logout route
            Route::group(['prefix' => 'admin', 'as' => 'admin.', 'controller' => AuthController::class], function () {
                Route::group(['middleware' => 'guest:admin'], function () {
                    Route::get('/login', 'loginPage')->name('loginPage');
                    Route::post('/login', 'login')->name('login');
                });
                Route::post('/logout', 'logout')->name('logout')->middleware('auth:admin');
            });

            Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin', 'as' => 'admin.'], function () {
                Route::get('/', [DashboardController::class, 'index'])->name('index');
                Route::get('booking/filter', [DashboardController::class, 'filterBookings'])->name('filter-bookings');
                Route::get('/revenue-data', [DashboardController::class, 'getRevenueDataByMonth'])->name('revenue-data');
                Route::get('/chart/users-by-month', [DashboardController::class, 'getUserDataByMonthAjax'])->name('getUserDataByMonth');
                Route::get('/chart/users-by-year', [DashboardController::class, 'getUserDataByYearAjax'])->name('getUserDataByYear');
                Route::get('/beginner/sports', [DashboardController::class, 'getBeginnerSportsCount'])->name('beginner.sports');
                Route::get('/intermediate/sports', [DashboardController::class, 'getIntermediateSportsCount'])->name('intermediate.sports');
                Route::get('/advanced/sports', [DashboardController::class, 'getAdvancedSportsCount'])->name('advanced.sports');

                // city routes
                Route::controller(CityController::class)->group(function () {
                    Route::get('/cities', 'index')->name('cities.index');
                    Route::get('/cities/create', 'create')->name('cities.create');
                    Route::post('/cities/store', 'store')->name('cities.store');
                    Route::get('/cities/edit/{city}', 'edit')->name('cities.edit');
                    Route::put('/cities/update/{city}', 'update')->name('cities.update');
                    Route::delete('/cities/delete', 'destroy')->name('cities.delete');
                });

                // area routes
                Route::controller(AreaController::class)->group(function () {
                    Route::get('/areas', 'index')->name('areas.index');
                    Route::get('/areas/create', 'create')->name('areas.create');
                    Route::post('/areas/store', 'store')->name('areas.store');
                    Route::get('/areas/edit/{area}', 'edit')->name('areas.edit');
                    Route::put('/areas/update/{area}', 'update')->name('areas.update');
                    Route::delete('/areas/delete', 'destroy')->name('areas.delete');
                });

                Route::controller(AcademiesController::class)->group(function () {
                    Route::get('/academies', 'index')->name('academies.index');
                    Route::get('/academies/create', 'create')->name('academies.create');
                    Route::post('/academies/store', 'store')->name('academies.store');
                    Route::get('/academies/edit/{academies}', 'edit')->name('academies.edit');
                    Route::put('/academies/update/{academies}', 'update')->name('academies.update');
                    Route::put('/academies/updateStatus/{academies}', 'updateStatus')->name('academies.updateStatus');
                    Route::delete('/academies/delete', 'delete')->name('academies.delete');
                    Route::get('academies/area/{city}', 'getAreaByCity')->name('area.getAreaByCity');
//                    Route::get('academies/edit/area/{city}', 'getAreaByCity')->name('area.getAreaByCity');
                    Route::get('academies/country/{country}', 'getAllCountry')->name('country.getCountry');
//                    Route::get('academies/edit/country/{country}', 'getAllCountry')->name('country.getCountry');
                    Route::get('academies/show/{academies}', 'show')->name('academies.show');
                    Route::get('academies/export', 'export')->name('academies.export');
                    Route::get('partner/locations', 'partnerLocation')->name('academies.locations');
                    Route::get('partner/coaches', 'partnerCoach')->name('academies.coaches');
                });

                // banner routes
                Route::controller(BannerController::class)->group(function () {
                    Route::get('/banners', 'index')->name('banners.index');
                    Route::get('/banners/create', 'create')->name('banners.create');
                    Route::post('/banners/store', 'store')->name('banners.store');
                    Route::get('/banners/edit/{banner}', 'edit')->name('banners.edit');
                    Route::put('/banners/update/{banner}', 'update')->name('banners.update');
                    Route::delete('/banners/delete', 'destroy')->name('banners.delete');
                });

                Route::controller(SportController::class)->group(function () {
                    Route::get('sport', 'index')->name('sport.index');
                    Route::get('sport/create', 'create')->name('sport.create');
                    Route::post('sport/store', 'store')->name('sport.store');
                    Route::get('sport/edit/{sport}', 'edit')->name('sport.edit');
                    Route::put('sport/update/{sport}', 'update')->name('sport.update');
                    Route::delete('sport/delete', 'delete')->name('sport.delete');
                    Route::put('sport/updateStatus/{sport}', 'updateStatus')->name('sport.updateStatus');
                });

                Route::controller(SettingController::class)->group(function () {
                    Route::get('setting', 'index')->name('setting.index');
                    Route::get('setting/create', 'create')->name('setting.create');
                    Route::post('setting/store', 'store')->name('setting.store');
                    Route::get('setting/edit/{setting}', 'edit')->name('setting.edit');
                    Route::put('setting/update/{setting}', 'update')->name('setting.update');
                    Route::delete('setting/delete', 'delete')->name('setting.delete');

                });
                Route::controller(FaqController::class)->group(function () {
                    Route::get('faq', 'index')->name('faq.index');
                    Route::get('faq/create', 'create')->name('faq.create');
                    Route::post('faq/store', 'store')->name('faq.store');
                    Route::get('faq/edit/{faq}', 'edit')->name('faq.edit');
                    Route::put('faq/update/{faq}', 'update')->name('faq.update');
                    Route::delete('faq/delete', 'delete')->name('faq.delete');
                });
                Route::controller(CountryController::class)->group(function () {
                    Route::get('country', 'index')->name('country.index');
                    Route::get('country/create', 'create')->name('country.create');
                    Route::post('country/store', 'store')->name('country.store');
                    Route::get('country/edit/{country}', 'edit')->name('country.edit');
                    Route::put('country/update/{country}', 'update')->name('country.update');
                    Route::delete('country/delete', 'delete')->name('country.delete');
                });
                Route::controller(ProfileController::class)->group(function () {
                    Route::get('profile', 'index')->name('profile.index');
                    Route::put('profile/update/{id}', 'update')->name('profile.update');
                });
                Route::controller(UserController::class)->group(function () {
                    Route::get('user', 'index')->name('user.index');
                    Route::get('user/show/{user}', 'show')->name('user.show');
                    Route::delete('user/delete', 'delete')->name('user.delete');
                    Route::get('user.export', 'export')->name('user.export');
                });

                Route::controller(BookingController::class)->group(function () {
                    Route::get('bookings', 'index')->name('booking.index');
                    Route::get('bookings/cancel/', 'cancelBooking')->name('booking.cancel');
                });


                Route::controller(TrainingController::class)->group(function () {
                    Route::get('trainings', 'index')->name('training.index');
                    Route::get('trainings/show/{training}', 'show')->name('training.show');
                    Route::put('trainings/active/{training}', 'updateTrainingStatus')->name('training.active');
                    Route::get('trainings/export', 'export')->name('training.export');
                    Route::get('trainings/booking/{training}', 'createBooking')->name('training.createBooking');
                    Route::post('trainings/booking', 'storeBooking')->name('training.storeBooking');
                    Route::post('trainings/areas', 'getAreaByCity')->name('training.getAreaByCity');
                    Route::post('trainings/cities', 'getCityByCountry')->name('training.getCities');
                    Route::delete('trainings/delete', 'delete')->name('trainings.delete');
                });

                Route::controller(GalleryController::class)->group(function () {
                    Route::get('galleries', 'index')->name('gallery.index');
                    Route::put('galleries/active/{gallery}', 'makeActive')->name('gallery.active');
                    Route::post('galleries/active/bulk', 'bulkActive')->name('gallery.bulkActive');
                });

                Route::prefix('report')->as('report.')->controller(ReportController::class)
                    ->group(function () {
                        Route::get('settlement', 'settlement')->name('settlement');
                        Route::get('settlement/filter', 'filter')->name('settlement.filter');
                        Route::get('settlement/export', 'export')->name('settlement.export');
                        Route::get('transactions', 'transactions')->name('transactions');
                        Route::get('invoice', 'invoice')->name('invoice.filter');
                        Route::get('bookings/export', 'bookingExport')->name('booking.export');
                        Route::get('joins', 'joins')->name('joins');
                        Route::get('joins/filter', 'joinFilter')->name('join.filter');
                        Route::get('joins/export', 'joinExport')->name('join.export');
                        Route::get('coach', 'coach')->name('coach');
                        Route::get('coach/filter', 'coachFilter')->name('coach.filter');
                        Route::get('coach/export', 'coachExport')->name('coach.export');
                        Route::put('settlement/change/{settlement}', 'change')->name('settlement.change');
                    });
            });
        });
});

