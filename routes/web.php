<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('landingpage.home');
});


Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function(){
            return view('dashboard');
        });

});


//Login
Route::post('/login', [Authcontroller::class, 'login'])-> name('login');

//Logout
Route::post('/logout', [AuthController::class], 'logout')->name('logout');
