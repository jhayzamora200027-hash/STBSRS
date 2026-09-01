<?php

namespace App\Console\Commands;

use App\Mail\TicketOverdueMail;
use App\Mail\TicketSlaWarningMail;
use App\Models\Ticket;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EnforceTicketSla extends Command
{
    protected $signature = 'tickets:enforce-sla {--dry-run : Show tickets without sending notifications or changing status}';

    protected $description = 'Send the 19-day SLA warning and mark unresolved tickets overdue after 21 days';

    public function handle(): int
    {
        $warningCutoff = now()->subDays(19);
        $overdueCutoff = now()->subDays(21);
        $dryRun = $this->option('dry-run');

        $warningTickets = Ticket::query()
            ->whereIn('ticket_status', ['review', 'inprogress'])
            ->where('created_at', '<=', $warningCutoff)
            ->get()
            ->filter(fn (Ticket $ticket) => ! $ticket->activities()
                ->where('event', 'sla_warning_19_days')
                ->exists());

        foreach ($warningTickets as $ticket) {
            if ($dryRun) {
                $this->line("Warning: {$ticket->ticket_id}");
                continue;
            }

            $ticket->activities()->create([
                'event' => 'sla_warning_19_days',
                'title' => '19-day SLA warning sent',
                'description' => 'An automatic warning was sent because the ticket has not been resolved within 19 days.',
                'performed_by' => 'System',
            ]);

            if (!empty($ticket->requestor_email)) {
                try {
                    Mail::to($ticket->requestor_email)->send(new TicketSlaWarningMail($ticket));
                } catch (\Throwable $exception) {
                    report($exception);
                }
            }
        }

        $overdueTickets = Ticket::query()
            ->whereIn('ticket_status', ['review', 'inprogress'])
            ->where('created_at', '<=', $overdueCutoff)
            ->get();

        foreach ($overdueTickets as $ticket) {
            if ($dryRun) {
                $this->line("Overdue: {$ticket->ticket_id}");
                continue;
            }

            $ticket->update(['ticket_status' => 'overdue']);
            $ticket->activities()->create([
                'event' => 'ticket_overdue',
                'title' => 'Ticket marked overdue',
                'description' => 'The ticket was automatically marked overdue after exceeding the 21-day resolution deadline.',
                'performed_by' => 'System',
            ]);

            if (!empty($ticket->requestor_email)) {
                try {
                    Mail::to($ticket->requestor_email)->send(new TicketOverdueMail($ticket));
                } catch (\Throwable $exception) {
                    report($exception);
                }
            }
        }

        if ($dryRun) {
            $this->info("{$warningTickets->count()} warning(s) and {$overdueTickets->count()} overdue ticket(s) found.");
        } else {
            $this->info("{$warningTickets->count()} warning(s) sent and {$overdueTickets->count()} ticket(s) marked overdue.");
        }

        return self::SUCCESS;
    }
}
