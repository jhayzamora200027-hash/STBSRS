<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use App\Mail\TicketCompletedMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CompleteResolvedTickets extends Command
{
    protected $signature = 'tickets:complete-resolved {--dry-run : Show eligible tickets without changing them}';

    protected $description = 'Complete tickets that have remained resolved for at least three days';

    public function handle(): int
    {
        $eligibleTickets = Ticket::query()
            ->where('ticket_status', 'resolved')
            ->whereNotNull('ticket_resolved_at')
            ->whereDate('ticket_resolved_at', '<=', now()->subDays(3)->toDateString())
            ->get();

        if ($this->option('dry-run')) {
            $this->info($eligibleTickets->count() . ' ticket(s) would be completed.');

            foreach ($eligibleTickets as $ticket) {
                $this->line($ticket->ticket_id);
            }

            return self::SUCCESS;
        }

        foreach ($eligibleTickets as $ticket) {
            $ticket->update(['ticket_status' => 'completed']);
            $ticket->activities()->create([
                'event' => 'ticket_auto_completed',
                'title' => 'Status changed to Completed',
                'description' => 'The ticket was automatically completed after remaining resolved for three days.',
                'performed_by' => 'System',
            ]);

            if (!empty($ticket->requestor_email)) {
                try {
                    Mail::to($ticket->requestor_email)->send(new TicketCompletedMail($ticket, 'automatic'));
                } catch (\Throwable $exception) {
                    report($exception);
                }
            }
        }

        $this->info($eligibleTickets->count() . ' ticket(s) completed.');

        return self::SUCCESS;
    }
}
