<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LocationController;
use App\Models\Region;

Route::get('/', function () {
    if(Auth::check()){
        return redirect()->route('dashboard');
    }

    $regions = Region::orderBy('name')->get();

    return view('landingpage.home', compact('regions'));

       
})->name('home');


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
