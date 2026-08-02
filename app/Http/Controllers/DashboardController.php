<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function index(){
        $totalTickets = Ticket::count();

        $newTicketsToday = Ticket::whereDate('created_at', Carbon::today())->count();

        $resolvedTickets = Ticket::where('ticket_status', 'resolved')->count();

        $resolvedTicketAve = Ticket::whereNotNull('ticket_resolved_at')->get();

         $ticketByMonth = Ticket::select(
    DB::raw('MONTH(created_at) as month'),
    DB::raw('COUNT(*) as total')
)
->groupBy(DB::raw('MONTH(created_at)'))
->orderBy(DB::raw('MONTH(created_at)'))
->get();

        $thisMonth = Ticket::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->count();

        $lastMonth = Ticket::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->subMonth()->year)
        ->count();

        if($lastMonth > 0) {
            $ticketGrowth = round((($thisMonth - $lastMonth) / $lastMonth)* 100, 1);
        } else {
            $ticketGrowth = $thisMonth > 0 ? 100 : 0;
        }

$monthlyTickets = array_fill(0, 12, 0);

foreach ($ticketByMonth as $ticket) {
    $monthlyTickets[$ticket->month - 1] = $ticket->total;
}

        $averageResolutionDays = round(
            $resolvedTicketAve->avg(function ($ticket){
                return $ticket->created_at->diffInDays($ticket->ticket_resolved_at);
            }), 
            1
        );

        

        $slaCompliant = $resolvedTicketAve->filter(function ($tickets){
            return $tickets->created_at->diffInDays($tickets->ticket_resolved_at) <=3;
        })->count();

        $totalResolved = $resolvedTicketAve->count();

        $slaCompliance = $totalResolved > 0 ? round(($slaCompliant / $totalResolved) * 100, 1) : 0;

        $overdueTickets = Ticket::whereNull('ticket_resolved_at')->where('created_at', '<', now()->subDays(3))->count();


        return view('authpage.dashboard.dashboard', compact(
            'totalTickets',
            'newTicketsToday',
            'resolvedTickets',
            'averageResolutionDays',
            'slaCompliance',
            'overdueTickets',
            'monthlyTickets',
            'ticketGrowth'
            ));
    }
}
