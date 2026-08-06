<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LandingpageController;
use App\Models\Region;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AllticketController;
use App\Http\Controllers\ViewTicketController;

Route::get('/',[LandingpageController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

        Route::get('/dashboard/filter', [DashboardController::class, 'filterTickets'])
    ->name('dashboard.filter');

    Route::get('/tickets',[AllticketController::class, 'index'])->name('tickets');

    Route::get('/tickets/{ticket_id}',[ViewTicketController::class, 'index'])->name('ticket.view');

    Route::delete('/ticket/{ticket_id}',[ViewTicketController::class, 'delete'])->name('ticket.delete');
    Route::post('/tickets/{ticket}/comments',[ViewTicketController::class, 'storeComment'])->name('tickets.comments.store');
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

Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::post('/tickets/send-otp', [TicketController::class, 'sendOtp'])->name('tickets.sendOtp');
Route::post('/tickets/verify-otp', [TicketController::class, 'verifyOtp'])->name('tickets.verifyOtp');
Route::get('/tickets/otp-status', [TicketController::class, 'otpStatus'])->name('tickets.otpStatus');


