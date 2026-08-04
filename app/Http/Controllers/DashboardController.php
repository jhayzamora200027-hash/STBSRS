<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Program;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
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

        $lastMonth = Ticket::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        if ($lastMonth > 0) {
            $ticketGrowth = round((($thisMonth - $lastMonth) / $lastMonth) * 100, 1);
        } else {
            $ticketGrowth = $thisMonth > 0 ? 100 : 0;
        }

        $monthlyTickets = array_fill(0, 12, 0);

        foreach ($ticketByMonth as $ticket) {
            $monthlyTickets[$ticket->month - 1] = $ticket->total;
        }

        $averageResolutionDays = round(
            $resolvedTicketAve->avg(function ($ticket) {
                return $ticket->created_at->diffInDays($ticket->ticket_resolved_at);
            }),
            1
        );

        $slaCompliant = $resolvedTicketAve->filter(function ($ticket) {
            return $ticket->created_at->diffInDays($ticket->ticket_resolved_at) <= 3;
        })->count();

        $totalResolved = $resolvedTicketAve->count();

        $slaCompliance = $totalResolved > 0
            ? round(($slaCompliant / $totalResolved) * 100, 1)
            : 0;

        $overdueTickets = Ticket::whereNull('ticket_resolved_at')
            ->where('created_at', '<', now()->subDays(3))
            ->count();

        // Load tickets for the modal
        $programName = Ticket::with('programDetails')
            ->latest()
            ->paginate(3);

        $programs = Program::orderBy('program')->get();

        return view('authpage.dashboard.dashboard', compact(
            'totalTickets',
            'newTicketsToday',
            'resolvedTickets',
            'averageResolutionDays',
            'slaCompliance',
            'overdueTickets',
            'monthlyTickets',
            'ticketGrowth',
            'programName',
            'programs'
        ));
    }

public function filterTickets(Request $request)
{
    $tickets = Ticket::with('programDetails')
        ->when($request->status, function ($query) use ($request) {
            $query->where('ticket_status', $request->status);
        })

        ->when($request->category, function ($query) use ($request) {
            $query->where('ticket_category', $request->category);
        })

        ->when($request->program, function ($query) use ($request) {
            $query->where('program', $request->program);
        })

        ->when($request->search, function ($query) use ($request) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('ticket_id', 'like', "%{$search}%")
                    ->orWhere('requestor_first_name', 'like', "%{$search}%")
                    ->orWhere('purpose_of_request', 'like', "%{$search}%");
            })
            ->orWhereHas('programDetails', function ($q2) use ($search) {
                $q2->where('program', 'like', "%{$search}%");
            });
        })

        ->latest()
        ->paginate(3);

    // Preserve query parameters in pagination URLs
    $tickets->appends($request->all());

    return response()->json($tickets);
}

    
}