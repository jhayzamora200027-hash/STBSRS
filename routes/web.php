<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LandingpageController;
use App\Models\Region;

Route::get('/',[LandingpageController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function(){
            return view('authpage.dashboard.dashboard');
        })->name('dashboard');
});


//Login
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login', function(){
    return redirect('/');
})->name('login.page');

//Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Locations
Route::get('/regions',[LocationController::class, 'regions']);
Route::get('/provinces/{regionCode}', [LocationController::class, 'provinces']);
Route::get('/cities/{provinceCode}',[LocationController::class, 'cities']);
