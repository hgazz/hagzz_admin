<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AcademiesController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
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

            // city routes
            Route::controller(CityController::class)->group(function () {
                Route::get('/cities', 'index')->name('cities.index');
                Route::get('/cities/create', 'create')->name('cities.create');
                Route::post('/cities/store', 'store')->name('cities.store');
                Route::get('/cities/edit/{city}', 'edit')->name('cities.edit');
                Route::put('/cities/update/{city}', 'update')->name('cities.update');
                Route::delete('/cities/delete/{city}', 'destroy')->name('cities.delete');
            });

            // area routes
            Route::controller(AreaController::class)->group(function () {
                Route::get('/areas', 'index')->name('areas.index');
                Route::get('/areas/create', 'create')->name('areas.create');
                Route::post('/areas/store', 'store')->name('areas.store');
                Route::get('/areas/edit/{area}', 'edit')->name('areas.edit');
                Route::put('/areas/update/{area}', 'update')->name('areas.update');
                Route::delete('/areas/delete/{area}', 'destroy')->name('areas.delete');
            });

            Route::controller(AcademiesController::class)->group(function (){
                Route::get('/academies', 'index')->name('academies.index');
                Route::get('/academies/create','create')->name('academies.create');
                Route::post('/academies/store','store')->name('academies.store');
                Route::get('/academies/edit/{academies}','edit')->name('academies.edit');
                Route::put('/academies/update/{academies}','update')->name('academies.update');
                Route::put('/academies/updateStatus/{academies}','updateStatus')->name('academies.updateStatus');
                Route::delete('/academies/delete/{academies}','delete')->name('academies.delete');
            });

            // banner routes
            Route::controller(BannerController::class)->group(function () {
                Route::get('/banners', 'index')->name('banners.index');
                Route::get('/banners/create', 'create')->name('banners.create');
                Route::post('/banners/store', 'store')->name('banners.store');
                Route::get('/banners/edit/{banner}', 'edit')->name('banners.edit');
                Route::put('/banners/update/{banner}', 'update')->name('banners.update');
                Route::delete('/banners/delete/{banner}', 'destroy')->name('banners.delete');
            });
        });

});

