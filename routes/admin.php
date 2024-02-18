<?php

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
        Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
            Route::get('/', [DashboardController::class, 'index'])->name('admin.index');
        });

});

