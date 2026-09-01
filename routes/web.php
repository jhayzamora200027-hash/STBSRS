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
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\ViewTicketController;
use App\Http\Controllers\TicketPdfController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\AuditLogController;

Route::get('/',[LandingpageController::class, 'index'])->name('home');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

        Route::get('/dashboard/filter', [DashboardController::class, 'filterTickets'])
    ->name('dashboard.filter');

    Route::get('/tickets',[AllticketController::class, 'index'])->name('tickets');
    Route::get('/feedback',[FeedBackController::class, 'index'])->name('feedback');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/approvals', [UserController::class, 'approvalIndex'])->name('users.approvals');
    Route::patch('/users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
    Route::patch('/users/{user}/status', [UserController::class, 'toggleStatus'])->name('users.status');
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
    Route::post('/programs', [ProgramController::class, 'store'])->name('programs.store');
    Route::put('/programs/{program}', [ProgramController::class, 'update'])->name('programs.update');
    Route::patch('/programs/{program}/status', [ProgramController::class, 'toggleStatus'])->name('programs.status');

    Route::get('/search/suggestions', [\App\Http\Controllers\NavbarSearchController::class, 'search'])->name('search.suggestions');
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password.update');

    Route::get('/tickets/{ticket_id}',[ViewTicketController::class, 'index'])->name('ticket.view');

    // PDF export
    Route::get('/tickets/{ticket}/pdf', [TicketPdfController::class, 'pdf'])->name('tickets.pdf');
    Route::get('/tickets/{ticket}/print-preview', [ViewTicketController::class, 'printPreview'])->name('tickets.print.preview');
    Route::post('/tickets/{ticket_id}/print', [ViewTicketController::class, 'recordPrint'])->name('tickets.print.record');

    Route::delete('/ticket/{ticket_id}',[ViewTicketController::class, 'delete'])->name('ticket.delete');
    Route::post('/tickets/{ticket}/comments',[ViewTicketController::class, 'storeComment'])->name('tickets.comments.store');
    Route::post('/tickets/{ticket_id}/resolution', [\App\Http\Controllers\ResolutionController::class, 'store'])->name('ticket.resolve');
    Route::post('/tickets/{ticket_id}/acknowledge', [\App\Http\Controllers\ViewTicketController::class, 'acknowledge'])->name('tickets.acknowledge');
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
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
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

// Guest access: send OTP by ticket reference, verify, and view as guest
Route::post('/guest/tickets/send-otp-by-ticket', [TicketController::class, 'sendOtpForTicket'])->name('guest.tickets.sendOtpByTicket');
Route::post('/guest/tickets/verify-otp-by-ticket', [TicketController::class, 'verifyOtpForTicket'])->name('guest.tickets.verifyOtpByTicket');

// Guest access: send OTP by email, verify, and view list of tickets tied to that email
Route::post('/guest/tickets/send-otp-by-email', [TicketController::class, 'sendOtpForEmail'])->name('guest.tickets.sendOtpByEmail');
Route::post('/guest/tickets/verify-otp-by-email', [TicketController::class, 'verifyOtpForEmail'])->name('guest.tickets.verifyOtpByEmail');
Route::get('/guest/tickets', [TicketController::class, 'guestListByEmail'])->name('guest.tickets.list');

Route::get('/guest/tickets/{ticket_id}', [TicketController::class, 'guestView'])->name('guest.ticket.view');
Route::post('/guest/tickets/{ticket_id}/comments', [TicketController::class, 'storeGuestComment'])->name('guest.tickets.comments.store');
Route::post('/guest/tickets/{ticket_id}/return', [TicketController::class, 'returnGuestTicket'])->name('guest.tickets.return');
Route::post('/guest/tickets/{ticket_id}/feedback', [TicketController::class, 'storeGuestFeedback'])->name('guest.tickets.feedback');
Route::post('tickets/{ticket}/complete', [TicketController::class, 'complete'])->name('tickets.complete');


//CHAT BOT
use App\Http\Controllers\ChatbotController;

Route::post('/chatbot', [
    ChatbotController::class,
    'chat'
]);


