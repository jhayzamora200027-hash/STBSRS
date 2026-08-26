<?php

namespace App\Providers;

use App\Models\Agency;
use App\Models\AuditLog;
use App\Models\City;
use App\Models\Program;
use App\Models\Province;
use App\Models\Region;
use App\Models\Resolution;
use App\Models\ResolutionAttachment;
use App\Models\Ticket;
use App\Models\TicketActivity;
use App\Models\TicketAttachment;
use App\Models\TicketComment;
use App\Models\TicketCommentAttachment;
use App\Models\TicketFeedback;
use App\Models\TicketReturn;
use App\Models\User;
use App\Observers\AuditObserver;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        foreach ([
            Agency::class, City::class, Program::class, Province::class, Region::class,
            Resolution::class, ResolutionAttachment::class, Ticket::class,
            TicketActivity::class, TicketAttachment::class, TicketComment::class,
            TicketCommentAttachment::class, TicketFeedback::class, TicketReturn::class,
            User::class,
        ] as $model) {
            $model::observe(AuditObserver::class);
        }

        Event::listen(Login::class, fn (Login $event) => AuditLog::create([
            'user_id' => $event->user->getAuthIdentifier(),
            'event' => 'login',
            'auditable_type' => $event->user::class,
            'auditable_id' => $event->user->getKey(),
            'url' => request()->fullUrl(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        Event::listen(Logout::class, fn (Logout $event) => AuditLog::create([
            'user_id' => $event->user?->getAuthIdentifier(),
            'event' => 'logout',
            'auditable_type' => $event->user ? $event->user::class : null,
            'auditable_id' => $event->user?->getKey(),
            'url' => request()->fullUrl(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        Event::listen(Failed::class, fn (Failed $event) => AuditLog::create([
            'user_id' => $event->user?->getAuthIdentifier(),
            'event' => 'login_failed',
            'auditable_type' => $event->user ? $event->user::class : null,
            'auditable_id' => $event->user?->getKey(),
            'new_values' => ['guard' => $event->guard],
            'url' => request()->fullUrl(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));
    }
}
