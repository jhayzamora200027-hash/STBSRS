<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ViewTicketController extends Controller
{
    public function index(string $ticket_id){
            $ticket = Ticket::with([
                'programDetails',
                'requestRegion',
                'requestProvince',
                'requestCity'
                ])->where('ticket_id', $ticket_id)->firstOrFail();


            return view('authpage.tickets.viewticket', compact('ticket'));
    }

    public function delete(string $ticket_id){
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstorFail();

        $ticket->delete();
    return redirect()->route('tickets')->with('success', 'Ticket #'. $ticket->ticket_id .' deleted successfully') ;
    }
}
