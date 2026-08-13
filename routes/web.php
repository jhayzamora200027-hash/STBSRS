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
use App\Http\Controllers\TicketPdfController;

Route::get('/',[LandingpageController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

        Route::get('/dashboard/filter', [DashboardController::class, 'filterTickets'])
    ->name('dashboard.filter');

    Route::get('/tickets',[AllticketController::class, 'index'])->name('tickets');

    Route::get('/tickets/{ticket_id}',[ViewTicketController::class, 'index'])->name('ticket.view');

    // PDF export
    Route::get('/tickets/{ticket}/pdf', [TicketPdfController::class, 'pdf'])->name('tickets.pdf');
    Route::get('/tickets/{ticket}/print-preview', [ViewTicketController::class, 'printPreview'])->name('tickets.print.preview');
    Route::post('/tickets/{ticket_id}/print', [ViewTicketController::class, 'recordPrint'])->name('tickets.print.record');

    Route::delete('/ticket/{ticket_id}',[ViewTicketController::class, 'delete'])->name('ticket.delete');
    Route::post('/tickets/{ticket}/comments',[ViewTicketController::class, 'storeComment'])->name('tickets.comments.store');
    Route::post('/tickets/{ticket_id}/resolution', [\App\Http\Controllers\ResolutionController::class, 'store'])->name('ticket.resolve');
});

// Public signed links for requestor to confirm or return a resolution
Route::get('/tickets/{ticket_id}/resolution/{resolution_id}/confirm', [\App\Http\Controllers\ResolutionResponseController::class, 'confirm'])
    ->name('tickets.resolution.confirm')
    ->middleware('signed');

Route::get('/tickets/{ticket_id}/resolution/{resolution_id}/return', [\App\Http\Controllers\ResolutionResponseController::class, 'returned'])
    ->name('tickets.resolution.return')
    ->middleware('signed');



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
Route::get('/agencies/{regionCode?}', [LocationController::class, 'agencies']);

Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::match(['put','patch'], '/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
Route::post('/tickets/send-otp', [TicketController::class, 'sendOtp'])->name('tickets.sendOtp');
Route::post('/tickets/verify-otp', [TicketController::class, 'verifyOtp'])->name('tickets.verifyOtp');
Route::get('/tickets/otp-status', [TicketController::class, 'otpStatus'])->name('tickets.otpStatus');


