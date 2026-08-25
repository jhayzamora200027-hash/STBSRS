<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketActivity;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Program;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $dateFrom = !empty($validated['date_from'])
            ? Carbon::parse($validated['date_from'])->startOfDay()
            : null;
        $dateTo = !empty($validated['date_to'])
            ? Carbon::parse($validated['date_to'])->endOfDay()
            : null;

        $ticketQuery = function () use ($dateFrom, $dateTo) {
            return Ticket::query()
                ->when($dateFrom, fn ($query) => $query->where('created_at', '>=', $dateFrom))
                ->when($dateTo, fn ($query) => $query->where('created_at', '<=', $dateTo));
        };

        $activityQuery = function () use ($dateFrom, $dateTo) {
            return TicketActivity::query()
                ->when($dateFrom, fn ($query) => $query->where('created_at', '>=', $dateFrom))
                ->when($dateTo, fn ($query) => $query->where('created_at', '<=', $dateTo));
        };

        $totalTickets = $ticketQuery()->count();

        $newTicketsToday = $ticketQuery()->whereDate('created_at', Carbon::today())->count();

        $resolvedTickets = $ticketQuery()->where('ticket_status', 'resolved')->count();

        $ticketStatusCounts = [
            'inprogress' => $ticketQuery()->where('ticket_status', 'inprogress')->count(),
            'review' => $ticketQuery()->where('ticket_status', 'review')->count(),
            'resolved' => $ticketQuery()->where('ticket_status', 'resolved')->count(),
            'completed' => $ticketQuery()->where('ticket_status', 'completed')->count(),
            'rejected' => $ticketQuery()->where('ticket_status', 'rejected')->count(),
        ];

        $statusChangedStart = Carbon::now()->copy()->subMonths(5)->startOfMonth();

        $statusChangedRows = $activityQuery()
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->where('event', 'status_changed')
            ->where('created_at', '>=', $statusChangedStart)
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderByRaw('YEAR(created_at), MONTH(created_at)')
            ->get();

        $statusChangedByMonth = [];

        foreach ($statusChangedRows as $row) {
            $statusChangedByMonth[$row->year . '-' . $row->month] = (int) $row->total;
        }

        $statusChangedSeries = [];
        $statusChangedCursor = $statusChangedStart->copy();

        for ($i = 0; $i < 6; $i++) {
            $seriesKey = $statusChangedCursor->year . '-' . $statusChangedCursor->month;

            $statusChangedSeries[] = [
                'label' => $statusChangedCursor->format('M'),
                'count' => $statusChangedByMonth[$seriesKey] ?? 0,
            ];

            $statusChangedCursor->addMonth();
        }

        $statusChangedTotalPeriod = array_sum(array_column($statusChangedSeries, 'count'));

        $statusChangedMonthlyPercent = array_map(function ($month) use ($statusChangedTotalPeriod) {
            $count = (int) $month['count'];

            return [
                'label' => $month['label'],
                'count' => $count,
                'percentage' => $statusChangedTotalPeriod > 0
                    ? round(($count / $statusChangedTotalPeriod) * 100, 1)
                    : 0,
            ];
        }, $statusChangedSeries);

        $resolvedTicketAve = $ticketQuery()->whereNotNull('ticket_resolved_at')->get();

        $ticketByMonth = $ticketQuery()->select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy(DB::raw('MONTH(created_at)'))
        ->get();

        $currentMonth = Carbon::now();
        $previousMonth = $currentMonth->copy()->subMonth();

        $thisMonthStatusChanges = $activityQuery()
            ->where('event', 'status_changed')
            ->whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();

        $lastMonthStatusChanges = $activityQuery()
            ->where('event', 'status_changed')
            ->whereMonth('created_at', $previousMonth->month)
            ->whereYear('created_at', $previousMonth->year)
            ->count();

        if ($lastMonthStatusChanges > 0) {
            $ticketGrowth = round((($thisMonthStatusChanges - $lastMonthStatusChanges) / $lastMonthStatusChanges) * 100, 1);
        } else {
            $ticketGrowth = $thisMonthStatusChanges > 0 ? 100 : 0;
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

        $slaDays = 21;


        $allTickets = $ticketQuery()->get();

        $slaCompliant = $allTickets->filter(function ($ticket) use ($slaDays) {
            return in_array(strtolower($ticket->ticket_status), [
                'resolved',
                'completed'
            ])
            && $ticket->ticket_resolved_at
            && $ticket->created_at->diffInDays($ticket->ticket_resolved_at) <= $slaDays;
        })->count();


        $slaViolated = $allTickets->filter(function ($ticket) use ($slaDays) {

            // Ignore rejected tickets
            if (strtolower($ticket->ticket_status) === 'rejected') {
                return false;
            }

            $isResolved = in_array(strtolower($ticket->ticket_status), [
                'resolved',
                'completed'
            ]);

            // Resolved but exceeded SLA
            if ($isResolved) {
                return $ticket->ticket_resolved_at &&
                    $ticket->created_at->diffInDays($ticket->ticket_resolved_at) > $slaDays;
            }

            // Unresolved and exceeded SLA
            return $ticket->created_at->diffInDays(now()) > $slaDays;

        })->count();


        $totalSLATickets = $slaCompliant + $slaViolated;


        $slaCompliance = $totalSLATickets > 0
            ? round(($slaCompliant / $totalSLATickets) * 100, 1)
            : 0;

        $overdueTickets = $ticketQuery()->whereNull('ticket_resolved_at')
            ->where('created_at', '<', now()->subDays(21))->whereNot('ticket_status', 'rejected')
            ->count();

        // Load tickets for the modal
        $programName = $ticketQuery()->with('programDetails')
            ->latest()
            ->paginate(3)
            ->withQueryString();

        // Tickets created today for the New Tickets modal body
        $newProgramName = $ticketQuery()->with('programDetails')
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->paginate(3, ['*'], 'new_page')
            ->withQueryString();

        // Tickets with resolved status for the Resolved Tickets modal body
        $resolvedProgramName = $ticketQuery()->with('programDetails')
            ->where('ticket_status', 'resolved')
            ->latest()
            ->paginate(3, ['*'], 'resolved_page')
            ->withQueryString();

        $programs = Program::orderBy('program')->get();

        $monthlySla = [];

        for ($month = 1; $month <= 12; $month++) {

            $tickets = $ticketQuery()->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $month)
                ->get();


            $slaCompliant = $tickets->filter(function ($ticket) use ($slaDays) {

                return in_array(strtolower($ticket->ticket_status), [
                    'resolved',
                    'completed'
                ])
                && $ticket->ticket_resolved_at
                && $ticket->created_at->diffInDays($ticket->ticket_resolved_at) <= $slaDays;

            })->count();


            $slaViolated = $tickets->filter(function ($ticket) use ($slaDays) {

                if (strtolower($ticket->ticket_status) === 'rejected') {
                    return false;
                }

                if (in_array(strtolower($ticket->ticket_status), [
                    'resolved',
                    'completed'
                ])) {

                    return $ticket->ticket_resolved_at &&
                        $ticket->created_at->diffInDays($ticket->ticket_resolved_at) > $slaDays;
                }

                return $ticket->created_at->diffInDays(now()) > $slaDays;

            })->count();


            $total = $slaCompliant + $slaViolated;


            $monthlySla[] = [
                'month' => date('M', mktime(0,0,0,$month,1)),
                'percentage' => $total > 0
                    ? round(($slaCompliant / $total) * 100, 1)
                    : 0
            ];
        }

        $monthlyAverageResolution = [];

        for ($month = 1; $month <= 12; $month++) {
            $tickets = $ticketQuery()->whereNotNull('ticket_resolved_at')
                ->whereYear('ticket_resolved_at', now()->year)
                ->whereMonth('ticket_resolved_at', $month)
                ->get();

            $monthlyAverageResolution[] = [
                'month' => date('M', mktime(0, 0, 0, $month, 1)),
                'days' => $tickets->count() > 0
                    ? round($tickets->avg(function ($ticket) {
                        return $ticket->created_at->diffInDays($ticket->ticket_resolved_at);
                    }), 1)
                    : 0,
            ];
        }

        $firstResponseBands = [
            ['label' => 'Within 4 hours', 'count' => 0, 'color' => '#3b82f6'],
            ['label' => 'Within 24 hours', 'count' => 0, 'color' => '#22c55e'],
            ['label' => 'Within 48 hours', 'count' => 0, 'color' => '#f59e0b'],
            ['label' => 'More than 48 hours', 'count' => 0, 'color' => '#ef4444'],
        ];

        $acknowledgedTickets = $ticketQuery()->whereNotNull('ticket_acknowledged_at')
            ->whereNotNull('created_at')
            ->get(['created_at', 'ticket_acknowledged_at']);

        foreach ($acknowledgedTickets as $ticket) {
            $responseHours = $ticket->created_at->diffInMinutes($ticket->ticket_acknowledged_at) / 60;

            if ($responseHours <= 4) {
                $firstResponseBands[0]['count']++;
            } elseif ($responseHours <= 24) {
                $firstResponseBands[1]['count']++;
            } elseif ($responseHours <= 48) {
                $firstResponseBands[2]['count']++;
            } else {
                $firstResponseBands[3]['count']++;
            }
        }

        $acknowledgedTicketTotal = count($acknowledgedTickets);

        $firstResponseBands = array_map(function ($band) use ($acknowledgedTicketTotal) {
            $band['percent'] = $acknowledgedTicketTotal > 0
                ? round(($band['count'] / $acknowledgedTicketTotal) * 100, 1)
                : 0;

            return $band;
        }, $firstResponseBands);

        return view('authpage.dashboard.dashboard', compact(
            'totalTickets',
            'newTicketsToday',
            'resolvedTickets',
            'averageResolutionDays',
            'slaCompliance',
            'overdueTickets',
            'monthlyTickets',
            'ticketGrowth',
            'ticketStatusCounts',
            'statusChangedMonthlyPercent',
            'statusChangedTotalPeriod',
            'programName',
            'newProgramName',
            'resolvedProgramName',
            'programs',
            'monthlySla',
            'monthlyAverageResolution',
            'firstResponseBands',
            'dateFrom',
            'dateTo',
        ));
    }

public function filterTickets(Request $request)
{
    $validated = $request->validate([
        'date_from' => ['nullable', 'date'],
        'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
    ]);

    $tickets = Ticket::with('programDetails')
        ->when($validated['date_from'] ?? null, function ($query, $dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        })
        ->when($validated['date_to'] ?? null, function ($query, $dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        })
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