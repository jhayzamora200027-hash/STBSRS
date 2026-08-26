<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Program;


class AllticketController extends Controller
{
    public function index(Request $request){
        $totalTickets = Ticket::count();

        $completedTicket = Ticket::where('ticket_status', 'completed')->count();

        $newTicket = Ticket::whereDate
        ('created_at', Carbon::today())->count();

        $forreviewTicket = Ticket::where('ticket_status', 'review')->count();

        $inprogressTicket = Ticket::where('ticket_status', 'inprogress')->count();

        $rejectedTIcket = Ticket::where('ticket_status', 'rejected')->count();

        $requestors = Ticket::select('requestor_email', 'requestor_first_name', 'requestor_last_name')->groupby('requestor_email', 'requestor_first_name','requestor_last_name')->orderBy('requestor_last_name')->get();

        $tickets = Ticket::query();

         $tickets = Ticket::query();

       

        if ($request->filled('status')) {
            $tickets->where('ticket_status', $request->status);
        }


        if ($request->filled('category')) {
            $tickets->where('ticket_category', $request->category);
        }


        if ($request->filled('priority')) {
            $tickets->where('ticket_priority', $request->priority);
        }


        if ($request->filled('requestor')) {
            $tickets->where('requestor_email', $request->requestor);
        }


        if ($request->filled('date_from')) {
            $tickets->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $tickets->whereDate('created_at', '<=', $request->date_to);
        }


        if ($request->filled('program')) {
            $tickets->where('program', $request->program);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $tickets->where(function ($q) use ($search) {
                $q->where('ticket_id', 'like', "%{$search}%")
                    ->orWhere('requestor_first_name', 'like', "%{$search}%")
                    ->orWhere('requestor_last_name', 'like', "%{$search}%")
                    ->orWhere('purpose_of_request', 'like', "%{$search}%")
                    ->orWhereHas('programDetails', function ($q2) use ($search) {
                        $q2->where('program', 'like', "%{$search}%");
                    });
            });
        }

        $tickets = $tickets
        ->with('programDetails')
        ->latest()
        ->paginate(6)
        ->withQueryString();


        $requestors = Ticket::select(
                'requestor_email',
                DB::raw('MIN(requestor_first_name) as requestor_first_name'),
                DB::raw('MIN(requestor_last_name) as requestor_last_name')
            )
            ->groupBy('requestor_email')
            ->orderBy('requestor_last_name')
            ->get();

        $programs = Program::where('status', 'active')->orderBy('program')->get();



        return view('authpage.tickets.all_tickets',compact(
            'totalTickets',
            'completedTicket',
            'newTicket',
            'forreviewTicket',
            'inprogressTicket',
            'rejectedTIcket',
            'requestors',
            'tickets',
            'programs'
        ));

    }
}
