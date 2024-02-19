<?php

use App\Http\Controllers\AreaController;
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
        });

});

