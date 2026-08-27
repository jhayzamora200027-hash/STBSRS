@extends('layouts.app')

@section('title', 'AllTickets')

@section('content')
<style>
    .tickets-page {
        --tickets-ink: #17324d;
        --tickets-muted: #6b7c8f;
        --tickets-line: #e6edf3;
        --tickets-blue: #0b5cab;
        color: var(--tickets-ink);
    }

    .tickets-page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1rem;
        padding: .2rem 0 .35rem;
    }

    .tickets-page-header h1 {
        font-size: clamp(1.5rem, 2vw, 2.05rem);
        font-weight: 700;
        letter-spacing: -0.03em;
        line-height: 1.2;
        margin: 0;
    }

    .tickets-page-header p {
        color: var(--tickets-muted);
        font-size: .96rem;
        margin: .25rem 0 0;
    }

    .tickets-page-header .text-sm-end {
        min-width: 120px;
        text-align: right;
    }

    .tickets-page-header .text-sm-end .small {
        color: #6a7b8d !important;
        font-size: .72rem;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .tickets-page-header .text-sm-end strong {
        color: var(--tickets-ink);
        font-size: 1.25rem;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .metric-card,
    .filter-card,
    .table-card {
        border: 1px solid var(--tickets-line);
        border-radius: .75rem;
        box-shadow: 0 8px 24px rgba(23, 50, 77, .045);
    }

    .metric-card .card-body {
        padding: 1rem;
    }

    .metrics-grid {
        display: grid;
        gap: 1rem;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        margin-bottom: 1.5rem;
        align-items: stretch;
    }

    .metrics-grid > .col {
        min-width: 0;
    }

    .metric-card .container-fluid,
    .metric-card .ps-3 {
        min-width: 0;
    }

    .metric-card {
        position: relative;
        background: rgba(255, 255, 255, 0.7);
        border: 1px solid rgba(112, 131, 147, 0.18);
        border-radius: .9rem;
        box-shadow: 0 8px 18px rgba(18, 38, 63, 0.03);
        transition: transform .16s ease, box-shadow .16s ease, border-color .16s ease;
    }

    .filter-card {
        background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(247,250,252,0.94));
        border: 1px solid #dfeaf3;
        border-radius: 0.95rem;
        box-shadow: 0 14px 32px rgba(15, 34, 56, 0.04);
        overflow: hidden;
    }

    .filter-card .card-header,
    .table-card .card-header {
        background: rgba(255,255,255,0.75);
        border-bottom: 1px solid var(--tickets-line);
        padding: .9rem 1.1rem;
    }

    .filter-card .card-body {
        padding: 1rem 1.1rem .8rem;
    }

    .filter-header-title {
        color: var(--tickets-ink);
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        margin: 0;
    }

    .filter-card .form-label {
        color: var(--tickets-ink);
        display: block;
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: -0.01em;
        margin-bottom: .38rem;
    }

    .filter-card .form-control,
    .filter-card .form-select {
        background: rgba(255,255,255,0.8);
        border: 1px solid #d9e3ee;
        border-radius: .7rem;
        box-shadow: inset 0 1px 2px rgba(15, 34, 56, 0.02);
        color: var(--tickets-ink);
        min-height: 40px;
        padding: .58rem .8rem;
        transition: border-color .15s ease, box-shadow .15s ease, background-color .15s ease;
    }

    .filter-card .form-control::placeholder {
        color: #7f8fa3;
    }

    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        border-color: var(--tickets-blue);
        box-shadow: 0 0 0 .22rem rgba(11, 92, 171, .12);
        background: #fff;
    }

    .filter-search-wrap {
        position: relative;
    }

    .filter-search-wrap .input-group-text {
        background: rgba(255,255,255,0.7);
        border: 1px solid #d9e3ee;
        border-right: 0;
        border-radius: .7rem 0 0 .7rem;
        color: #6f7f93;
        min-height: 40px;
        padding-inline: .8rem;
    }

    .filter-search-wrap .form-control {
        border-left: 0;
        padding-left: .25rem;
    }

    .filter-search-wrap .btn-clear-search {
        border: 1px solid #d9e3ee;
        border-left: 0;
        border-radius: 0 .7rem .7rem 0;
        min-height: 40px;
        padding: 0 .75rem;
    }

    .filter-search-wrap .btn-clear-search:hover {
        background: #f5f8fb;
    }

    .date-range {
        display: grid;
        gap: .5rem;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .date-range .form-control {
        box-sizing: border-box;
        min-width: 0;
        max-width: 100%;
        width: 100%;
    }

    .filter-card .row > .col,
    .filter-card .row > [class*="col-"] {
        min-width: 0;
    }

    .filter-grid {
        gap: .8rem 1rem;
        margin-bottom: 0;
    }

    .filter-actions {
        align-items: center;
        border-top: 1px solid var(--tickets-line);
        display: flex;
        flex-wrap: wrap;
        gap: .7rem;
        margin-top: .75rem;
        padding-top: .8rem;
    }

    .filter-actions .btn {
        border-radius: .7rem;
        font-weight: 600;
        min-height: 38px;
        padding: .62rem 1rem;
        transition: transform .15s ease, box-shadow .15s ease;
    }

    .filter-actions .btn:hover {
        transform: translateY(-1px);
    }

    .filter-actions .btn-primary {
        background: linear-gradient(180deg, #1d78d3, #0f5faa);
        border-color: #0f5faa;
        box-shadow: 0 8px 18px rgba(15, 95, 170, .18);
    }

    .filter-actions .btn-outline-secondary {
        background: rgba(255,255,255,0.7);
        border-color: #d4dfe8;
        color: #35516b;
    }

    .filter-count {
        color: var(--tickets-muted);
        font-size: .76rem;
    }

    .filter-badge {
        align-items: center;
        background: linear-gradient(180deg, #eaf3ff, #dfeeff);
        border: 1px solid rgba(22, 108, 191, 0.16);
        border-radius: 999px;
        color: var(--tickets-blue);
        display: inline-flex;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .01em;
        padding: .42rem .7rem;
    }

    .table-card {
        overflow: hidden;
    }

    .table-card .table-responsive {
        margin: 0;
    }

    .table-card .table {
        --bs-table-bg: #fff;
        color: var(--tickets-ink);
    }

    .table-card .table thead th {
        background: #f7f9fb;
        border-bottom: 1px solid var(--tickets-line);
        color: #52677a;
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .04em;
        padding: .9rem 1rem;
        text-transform: uppercase;
    }

    .table-card .table tbody td {
        border-color: #edf2f6;
        padding: 1rem;
    }

    .table-card .pagination {
        margin: 0;
    }

    .table-card .pagination-wrap {
        border-top: 1px solid var(--tickets-line);
        padding: 1rem 1.25rem;
    }

    .table-card .dropdown-toggle::after {
        display: none;
    }

    .ticket-grid {
        display: grid;
        gap: 1rem;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        padding: 1.25rem;
    }

    .ticket-item {
        background: #fff;
        border: 1px solid var(--tickets-line);
        border-radius: .7rem;
        display: flex;
        flex-direction: column;
        min-width: 0;
        padding: 1.1rem;
        transition: border-color .16s ease, box-shadow .16s ease, transform .16s ease;
    }

    .ticket-item:hover {
        border-color: #b9d0e5;
        box-shadow: 0 10px 24px rgba(23, 50, 77, .08);
        transform: translateY(-2px);
    }

    .ticket-item:focus-visible {
        border-color: var(--tickets-blue);
        box-shadow: 0 0 0 .2rem rgba(11, 92, 171, .12);
        outline: none;
    }

    .ticket-item-header,
    .ticket-item-footer {
        align-items: center;
        display: flex;
        gap: .75rem;
        justify-content: space-between;
    }

    .ticket-item-number {
        color: var(--tickets-blue);
        font-size: .82rem;
        font-weight: 700;
        letter-spacing: .02em;
    }

    .ticket-item-purpose {
        color: var(--tickets-ink);
        font-size: 1rem;
        font-weight: 600;
        line-height: 1.4;
        margin: 1rem 0 .85rem;
        min-height: 2.8rem;
    }

    .ticket-item-meta {
        border-top: 1px solid #edf2f6;
        display: grid;
        gap: .75rem;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        margin-top: auto;
        padding: .9rem 0;
    }

    .ticket-meta-label {
        color: var(--tickets-muted);
        display: block;
        font-size: .68rem;
        margin-bottom: .2rem;
        text-transform: uppercase;
    }

    .ticket-meta-value {
        display: block;
        font-size: .78rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .ticket-item-footer {
        border-top: 1px solid #edf2f6;
        padding-top: .85rem;
    }

    .ticket-view-link {
        font-size: .8rem;
        font-weight: 600;
        text-decoration: none;
    }

    .ticket-empty {
        grid-column: 1 / -1;
        padding: 2.5rem 1rem;
        text-align: center;
    }

    .ticket-grid > .pagination-wrap {
        grid-column: 1 / -1;
    }

    @media (max-width: 1199.98px) {
        .ticket-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 575.98px) {
        .ticket-grid {
            grid-template-columns: 1fr;
            padding: 1rem;
        }
    }

    .table-card .table caption {
        caption-side: top;
    }

    .ticket-row:focus-visible {
        box-shadow: inset 0 0 0 2px var(--tickets-blue);
        outline: none;
    }

    .tickets-loading {
        opacity: .55;
        pointer-events: none;
        transition: opacity .15s ease;
    }

    @media (max-width: 575.98px) {
        .tickets-page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .filter-card .card-body {
            padding: 1rem;
        }

        .date-range {
            grid-template-columns: 1fr;
        }

        .metrics-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (min-width: 768px) and (max-width: 1199.98px) {
        .filter-fields-grid > .col-lg-4 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    @media (min-width: 576px) and (max-width: 767.98px) {
        .metrics-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1200px) and (max-width: 1799.98px) {
        .metrics-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (min-width: 768px) and (max-width: 1199.98px) {
        .metrics-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (min-width: 576px) {
        .filter-actions .w-sm-auto {
            min-width: 150px;
            width: auto !important;
        }
    }

    .metric-title{
    display:block;
    line-height:1.2;
    white-space: normal;
    font-size:12px;
    font-weight:700;
    color:#33475b;
    margin:0;
    padding-right:0.25rem;
    letter-spacing: -0.01em;
    text-transform: none;
}
.filter-title{
    display:block;
    line-height:1.2;
    white-space: normal;
    font-size:12px;
    font-weight:600;
    color:#34495e;
    margin:0;
    padding-right:0.25rem;
    word-break: break-word;
}

.metric-number{
    font-size: clamp(2rem, 2.3vw, 2.8rem);
    font-weight:800;
    color:#0b3b75;
    line-height:1;
    letter-spacing: -0.04em;
}


.card.metric-card {
    border: 1px solid rgba(108,117,125,0.16);
    overflow: hidden;
    transition: transform .16s ease, box-shadow .16s ease, border-color .16s ease;
}

.card.metric-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 16px 40px rgba(13,110,253,0.08);
    border-color: rgba(11, 92, 171, 0.18);
}

.card.metric-card .card-body {
    min-height: 120px;
    display: flex;
    align-items: center;
    padding: 1.1rem 1.2rem;
}

.card.metric-card .card-body .container-fluid {
    width: 100%;
    gap: .9rem;
    padding: 0;
}

.card.metric-card .card-body .ps-3 {
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 72px;
    flex: 1;
}

.metric-title {
    margin-bottom: 0.35rem;
}

.card .rounded-circle {
    width: 52px;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, 0.8);
    box-shadow: inset 0 1px 1px rgba(255,255,255,0.6);
}

.card .rounded-circle i {
    font-size: 1.75rem !important;
    padding: 0 !important;
}

.drag-scroll.dragging{
    cursor: grabbing;
}

.drag-scroll::-webkit-scrollbar{
    height: 8px;
}

.drag-scroll::-webkit-scrollbar-thumb{
    background: #cfd4da;
    border-radius: 10px;
}

.drag-scroll::-webkit-scrollbar-thumb:hover{
    background: #adb5bd;
}
.ticket-row {
    cursor: pointer;
}
#ticketMenu{
    z-index: 9999;
    min-width: 220px;
    animation: fadeIn .15s ease;
}

/* Table and row improvements */
.table thead th {
    position: sticky;
    top: 0;
    z-index: 4;
    background-color: #fff;
}

.table tbody tr.ticket-row {
    transition: background-color .12s ease, transform .08s ease;
}

    .table tbody tr.ticket-row:hover {
    background-color: rgba(13,110,253,0.04);
        transform: translateY(-1px);
}

.table tbody tr.ticket-row td {
    vertical-align: middle;
}

.table td .fw-semibold,
.table td .fw-bold {
    word-break: break-word;
}

/* Card-style table on smaller screens */
.ticket-card-table table,
.ticket-card-table thead,
.ticket-card-table tbody,
.ticket-card-table th,
.ticket-card-table td,
.ticket-card-table tr {
    border: none;
}

@media (max-width: 930px) {
    .ticket-card-table thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
    }

    .ticket-card-table tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid rgba(108,117,125,0.16);
        border-radius: .85rem;
        padding: 1rem;
        background: #fff;
    }

    .ticket-card-table td {
        display: block;
        text-align: left;
        padding: .9rem 1rem .9rem 0;
        position: relative;
        border: none;
    }

    .ticket-card-table td::before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        top: .5rem;
        width: 45%;
        font-weight: 700;
        color: #495057;
        white-space: nowrap;
    }

    .ticket-card-table td.text-end {
        text-align: left !important;
    }

    .ticket-card-table td .badge {
        margin-top: .4rem;
        display: inline-flex;
    }

    .ticket-card-table td:first-child {
        padding-top: 1.25rem;
    }

    .ticket-card-table tr {
        box-shadow: 0 16px 40px rgba(0,0,0,0.04);
    }
}

/* Additional mobile tweaks: force card-style table and remove min-width constraints */
@media (max-width: 767.98px) {
    .table-responsive.ticket-card-table {
        overflow: visible;
    }

    .ticket-card-table thead tr,
    .ticket-card-table thead th {
        position: absolute !important;
        top: -9999px !important;
        left: -9999px !important;
        display: none !important;
    }

    .ticket-card-table table,
    .ticket-card-table tbody,
    .ticket-card-table tr,
    .ticket-card-table td {
        display: block !important;
        width: 100% !important;
    }

    .ticket-card-table td {
        padding: .9rem 1rem !important;
        border: none !important;
        text-align: left !important;
        position: relative !important;
        padding-left: 36% !important;
        box-sizing: border-box !important;
    }

    .ticket-card-table td::before {
        content: attr(data-label);
        position: absolute !important;
        left: 12px !important;
        top: 12px !important;
        width: calc(36% - 24px) !important;
        font-weight: 700;
        color: #495057;
        white-space: normal !important;
        display: block !important;
    }

    .ticket-card-table td.text-end {
        text-align: left !important;
    }

    /* override inline min-widths on small screens */
    .ticket-card-table th,
    .ticket-card-table td,
    .table thead th {
        min-width: auto !important;
        white-space: normal !important;
    }

    .ticket-card-table tr {
        margin-bottom: 1rem;
        border: 1px solid rgba(108,117,125,0.12);
        border-radius: 10px;
        padding: .75rem;
        box-shadow: 0 8px 20px rgba(0,0,0,0.04);
        background: #fff;
    }

    .ticket-card-table td .fw-semibold,
    .ticket-card-table td .fw-bold { font-size: 0.98rem; }
}

/* Metric card tweaks */
.card .rounded-circle { width:44px; height:44px; display:flex; align-items:center; justify-content:center; }
.metric-number{ font-size:28px; }

@keyframes fadeIn{
    from{
        opacity:0;
        transform:scale(.95);
    }
    to{
        opacity:1;
        transform:scale(1);
    }
}
</style>
<div class="tickets-page">
<div class="tickets-page-header">
    <div>
        <h1>All Tickets</h1>
        <p>Track, review, and manage service requests in one place.</p>
    </div>
    <div class="text-sm-end">
        <div class="small text-muted">Showing</div>
        <strong>{{ number_format($tickets->total()) }} {{ Str::plural('ticket', $tickets->total()) }}</strong>
    </div>
</div>
<div class="metrics-grid">
    <div class="col">
        <div class="card metric-card h-100">
            <div class="card-body">
                <div class="container-fluid d-flex align-items-center">
                    <div class="rounded-circle" style="background-color:#e9ebff">
                        <i class="bi bi-ticket fs-3 p-2" style="color:#031d94"></i>
                    </div>
                    <div class="ps-3">
                        <div class="metric-title"> 
                           All Tickets
                        </div> 
                        <div class="metric-number pt-3">
                             {{number_format($totalTickets)}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card metric-card h-100">
            <div class="card-body">
                <div class="container-fluid d-flex align-items-center">
                    <div class="rounded-circle" style="background-color:#e9ffec">
                        <i class="bi bi-check-circle fs-3 p-2" style="color:#059403"></i>
                    </div>
                    <div class="ps-3">
                        <div class="metric-title"> 
                           Completed
                        </div> 
                        <div class="metric-number pt-3">
                             {{number_format($completedTicket)}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card metric-card h-100">
            <div class="card-body">
                <div class="container-fluid d-flex align-items-center">
                    <div class="rounded-circle" style="background-color:#f8ffe9">
                        <i class="bi bi-hourglass-split fs-3 p-2" style="color:#919403"></i>
                    </div>
                    <div class="ps-3">
                        <div class="metric-title"> 
                           New Tickets
                        </div> 
                        <div class="metric-number pt-3">
                             {{number_format($newTicket)}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card metric-card h-100">
            <div class="card-body">
                <div class="container-fluid d-flex align-items-center">
                    <div class="rounded-circle" style="background-color:#f2e9ff">
                        <i class="bi bi-search fs-3 p-2" style="color:#310394"></i>
                    </div>
                    <div class="ps-3">
                        <div class="metric-title"> 
                           For Review
                        </div> 
                        <div class="metric-number pt-3">
                             {{number_format($forreviewTicket)}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card metric-card h-100">
            <div class="card-body">
                <div class="container-fluid d-flex align-items-center">
                    <div class="rounded-circle" style="background-color:#e9ebff">
                        <i class="bi bi-arrow-repeat fs-3 p-2" style="color:#031d94"></i>
                    </div>
                    <div class="ps-3">
                        <div class="metric-title"> 
                           In Progress
                        </div> 
                        <div class="metric-number pt-3">
                             {{number_format($inprogressTicket)}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card metric-card h-100">
            <div class="card-body">
                <div class="container-fluid d-flex align-items-center">
                    <div class="rounded-circle" style="background-color:#ffe9e9">
                        <i class="bi bi-x-circle-fill fs-3 p-2" style="color:#940303"></i>
                    </div>
                    <div class="ps-3">
                        <div class="metric-title"> 
                           Rejected
                        </div> 
                        <div class="metric-number pt-3">
                             {{number_format($rejectedTIcket)}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<form method="GET" action="{{ route('tickets') }}">

<div class="card filter-card mb-4">
    @php
        $activeFilters = collect([
            request('search'),
            request('status'),
            request('category'),
            request('priority'),
            request('requestor'),
            request('program'),
            request('date_from'),
            request('date_to'),
        ])->filter(fn ($filter) => filled($filter))->count();
    @endphp
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
            <h2 class="filter-header-title">Find a ticket</h2>
            <div class="filter-count">Use one or more filters to narrow the list.</div>
        </div>
        @if($activeFilters)
            <span class="filter-badge">{{ $activeFilters }} active {{ Str::plural('filter', $activeFilters) }}</span>
        @endif
    </div>
    <div class="card-body">

        <div class="row mb-3">
            <div class="col-12">
                <div class="input-group filter-search-wrap">
                    <span class="input-group-text" aria-hidden="true"><i class="bi bi-search"></i></span>
                    <input id="search" name="search" type="search" class="form-control"
                        placeholder="Search by ticket number, requestor, purpose, or program" value="{{ request('search') }}" aria-label="Search tickets">
                    @if(request('search'))
                        <a href="{{ request()->fullUrlWithoutQuery('search') }}" class="btn btn-outline-secondary btn-clear-search" aria-label="Clear search">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3 filter-grid filter-fields-grid">

            {{-- STATUS --}}
            <div class="col-12 col-sm-6 col-lg-4">
                <label class="form-label" for="statusFilter">Status</label>
                <select id="statusFilter" name="status" class="form-select">
                    <option value="">All</option>
                    <option value="review" {{ request('status')=='review'?'selected':'' }}>For Review</option>
                    <option value="inprogress" {{ request('status')=='inprogress'?'selected':'' }}>In Progress</option>
                    <option value="resolved" {{ request('status')=='resolved'?'selected':'' }}>Resolved</option>
                    <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option>
                    <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
                </select>
            </div>

            {{-- CATEGORY --}}
            <div class="col-12 col-sm-6 col-lg-4">
                <label class="form-label" for="categoryFilter">Category</label>
                <select id="categoryFilter" name="category" class="form-select">
                    <option value="">All</option>
                    <option value="completed" {{ request('category')=='completed'?'selected':'' }}>Completed Program</option>
                    <option value="enhancement" {{ request('category')=='enhancement'?'selected':'' }}>Program Development</option>
                    <option value="resource" {{ request('category')=='resource'?'selected':'' }}>Resource Person</option>
                    <option value="knowledge" {{ request('category')=='knowledge'?'selected':'' }}>Knowledge Product</option>
                </select>
            </div>

            <div class="col-12 col-sm-6 col-lg-4">
                <label class="form-label" for="priorityFilter">Priority</label>
                <select id="priorityFilter" name="priority" class="form-select">
                    <option value="">All</option>
                    <option value="low" {{ request('priority')=='low'?'selected':'' }}>Low</option>
                    <option value="medium" {{ request('priority')=='medium'?'selected':'' }}>Medium</option>
                    <option value="high" {{ request('priority')=='high'?'selected':'' }}>High</option>
                    <option value="urgent" {{ request('priority')=='urgent'?'selected':'' }}>Urgent</option>
                </select>
            </div>

            {{-- REQUESTOR --}}
            <div class="col-12 col-sm-6 col-lg-4">
                <label class="form-label" for="requestorFilter">Requestor</label>
                <select id="requestorFilter" name="requestor" class="form-select">
                    <option value="">All Requestors</option>
                    @foreach($requestors as $requestor)
                        <option value="{{ $requestor->requestor_email }}" {{ request('requestor')==$requestor->requestor_email?'selected':'' }}>
                            {{ $requestor->requestor_first_name }}
                            {{ $requestor->requestor_last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- PROGRAM --}}
            <div class="col-12 col-sm-6 col-lg-4">
                <label class="form-label" for="programFilter">Program</label>
                <select id="programFilter" name="program" class="form-select">
                    <option value="">All Program</option>
                    @foreach($programs as $program)
                        <option value="{{$program->program_id}}" {{ request('program') == $program->program_id ? 'selected' : '' }}>{{$program->program}}</option>
                    @endforeach
                </select>
            </div>

            {{-- DATE RANGE --}}
            <div class="col-12 col-sm-6 col-lg-4">
                <label class="form-label">Date range</label>
                <div class="date-range">
                    <input id="dateFromFilter" type="date" class="form-control" name="date_from" value="{{ request('date_from') }}" aria-label="From date">
                    <input id="dateToFilter" type="date" class="form-control" name="date_to" value="{{ request('date_to') }}" aria-label="To date">
                </div>
            </div>

            <div class="col-12 filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                    Apply Filters
                </button>

                <a href="{{ route('tickets') }}" class="btn btn-outline-secondary text-center">
                    <i class="bi bi-arrow-clockwise"></i>
                    Clear
                </a>
            </div>

        </div>

    </div>
</div>

</form>
{{-- Table --}}
<div class="table-card">
<div id="tickets-container">
<div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
    <div>
        <h2 class="h6 mb-1">Ticket directory</h2>
        <div class="filter-count">Select a row to view the full request.</div>
    </div>
    <span class="filter-count">Page {{ $tickets->currentPage() }} of {{ $tickets->lastPage() }}</span>
</div>
<div class="ticket-grid" aria-live="polite">
    @forelse($tickets as $ticket)
        @php
            $priority = strtolower($ticket->ticket_priority ?? 'low');
        @endphp
        <article class="ticket-item ticket-row" data-url="{{ route('ticket.view', $ticket->ticket_id) }}" tabindex="0" role="link" aria-label="View ticket {{ $ticket->ticket_id }}">
            <div class="ticket-item-header">
                <span class="ticket-item-number">#{{ $ticket->ticket_id }}</span>
                @switch($ticket->ticket_status)
                    @case('review') <span class="badge rounded-pill bg-warning text-dark">For Review</span> @break
                    @case('inprogress') <span class="badge rounded-pill bg-primary">In Progress</span> @break
                    @case('resolved') <span class="badge rounded-pill bg-info">Resolved</span> @break
                    @case('completed') <span class="badge rounded-pill bg-success">Completed</span> @break
                    @case('rejected') <span class="badge rounded-pill bg-danger">Rejected</span> @break
                    @default <span class="badge rounded-pill bg-secondary">Unknown</span>
                @endswitch
            </div>

            <h3 class="ticket-item-purpose">{{ Str::limit($ticket->purpose_of_request, 80) }}</h3>

            <div class="mb-3">
                @switch($ticket->ticket_category)
                    @case('enhancement') <span class="badge rounded-pill bg-primary-subtle text-primary">Program Enhancement</span> @break
                    @case('completed') <span class="badge rounded-pill bg-success-subtle text-success">Completed Program</span> @break
                    @case('resource') <span class="badge rounded-pill bg-warning-subtle text-dark">Resource Person</span> @break
                    @case('knowledge') <span class="badge rounded-pill bg-info-subtle text-info">Knowledge Product</span> @break
                    @default <span class="badge rounded-pill bg-secondary-subtle text-secondary">N/A</span>
                @endswitch
            </div>

            <div class="ticket-item-meta">
                <div>
                    <span class="ticket-meta-label">Requestor</span>
                    <strong class="ticket-meta-value">{{ $ticket->requestor_first_name }} {{ $ticket->requestor_last_name }}</strong>
                </div>
                <div>
                    <span class="ticket-meta-label">Program</span>
                    <strong class="ticket-meta-value">
                        {{ $ticket->program_count > 1 ? $ticket->program_count . ' programs selected' : Str::limit($ticket->program_display, 24) }}
                    </strong>
                </div>
                <div>
                    <span class="ticket-meta-label">Priority</span>
                    @switch($priority)
                        @case('urgent') <span class="badge rounded-pill bg-danger">Urgent</span> @break
                        @case('high') <span class="badge rounded-pill bg-warning text-dark">High</span> @break
                        @case('medium') <span class="badge rounded-pill bg-info">Medium</span> @break
                        @default <span class="badge rounded-pill bg-success">Low</span>
                    @endswitch
                </div>
                <div>
                    <span class="ticket-meta-label">Updated</span>
                    <span class="ticket-meta-value">{{ $ticket->updated_at->format('M d, Y') }}</span>
                </div>
            </div>

            <div class="ticket-item-footer">
                <a class="ticket-view-link" href="{{ route('ticket.view', $ticket->ticket_id) }}">View ticket <i class="bi bi-arrow-right"></i></a>
                <div class="btn-group">
                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Actions for ticket {{ $ticket->ticket_id }}">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><a class="dropdown-item" href="{{ route('ticket.view', $ticket->ticket_id) }}"><i class="bi bi-eye me-2"></i> View Ticket</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            @if(auth()->user()->usergroup === 'sysadmin')
                                <form method="POST" action="{{ route('ticket.delete', $ticket->ticket_id) }}" class="delete-form m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i> Delete</button>
                                </form>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </article>
    @empty
        <div class="ticket-empty">
            <i class="bi bi-inbox fs-1 text-muted"></i>
            <h3 class="h6 mt-3 mb-1">No tickets found</h3>
            <p class="small text-muted mb-0">There are currently no tickets matching your filters.</p>
        </div>
    @endforelse

    @if ($tickets->hasPages())
        <div class="pagination-wrap d-flex justify-content-end">
            {{ $tickets->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
</div>
</div>

<script>
document.addEventListener('click', function(e){
    const link = e.target.closest('.pagination a');
    if(!link) return;
    e.preventDefault();
    const url = link.getAttribute('href');
    if(!url) return;

    const current = document.querySelector('#tickets-container');
    if(current) current.classList.add('tickets-loading');

    fetch(url, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContainer = doc.querySelector('#tickets-container');
            if(newContainer && current){
                current.innerHTML = newContainer.innerHTML;
                window.history.pushState({}, '', url);
                current.scrollIntoView({behavior:'smooth'});
            }
            if(current) current.classList.remove('tickets-loading');
        })
        .catch(err => {
            if(current) current.classList.remove('tickets-loading');
            console.error('Pagination load failed', err);
        });
});

window.addEventListener('popstate', function(){
    fetch(location.href, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContainer = doc.querySelector('#tickets-container');
            const current = document.querySelector('#tickets-container');
            if(newContainer && current){
                current.innerHTML = newContainer.innerHTML;
            }
        })
        .catch(err => console.error(err));
});

// Debounced AJAX search/filter submission
(function(){
    const form = document.querySelector('form[action="{{ route('tickets') }}"]');
    if(!form) return;

    const searchInput = document.getElementById('search');
    let timer = null;

    function submitFilters(){
        const params = new URLSearchParams(new FormData(form));
        const url = form.action + '?' + params.toString();

        fetch(url, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContainer = doc.querySelector('#tickets-container');
                const current = document.querySelector('#tickets-container');
                if(newContainer && current){
                    current.innerHTML = newContainer.innerHTML;
                    window.history.pushState({}, '', url);
                }
            })
            .catch(err => console.error('Filter load failed', err));
    }

    if(searchInput){
        searchInput.addEventListener('input', function(){
            clearTimeout(timer);
            timer = setTimeout(submitFilters, 400);
        });
    }

})();

const slider = document.getElementById("dragScroll");

let isDown = false;
let isDragging = false;
let startX;
let scrollLeft;

if (slider) {
    // Drag to scroll
    slider.addEventListener("mousedown", (e) => {
        isDown = true;
        isDragging = false;
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
        slider.classList.add("dragging");
    });

    document.addEventListener("mousemove", (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = x - startX;
        if (Math.abs(walk) > 5) {
            isDragging = true;
        }
        slider.scrollLeft = scrollLeft - walk;
    });

    document.addEventListener("mouseup", () => {
        isDown = false;
        if (slider) slider.classList.remove("dragging");
    });
}

// Use event delegation so newly loaded rows work after AJAX replaces content
document.addEventListener('click', function(e){
    // If clicking on a ticket row (but not on an actionable child like a link/button)
    const row = e.target.closest('.ticket-row');
    if(row && !e.target.closest('a, button')){

        if (isDragging) { isDragging = false; return; }

        const url = row.dataset.url;
        if(url) {
            window.location.href = url;
        }
        return;
    }

    // Close any open dropdowns when clicking outside
    if(!e.target.closest('.dropdown-menu') && !e.target.closest('.dropdown-toggle')){
        document.querySelectorAll('.dropdown-menu.show').forEach(m => m.classList.remove('show'));
    }

});

document.addEventListener('keydown', function(e){
    const row = e.target.closest('.ticket-row');
    if(!row || e.target.closest('a, button, input, select')) return;

    if(e.key === 'Enter' || e.key === ' '){
        e.preventDefault();
        if(row.dataset.url) window.location.href = row.dataset.url;
    }
});

document.addEventListener('submit', function(e){
    const form = e.target.closest('.delete-form');
    if(!form) return;

    e.preventDefault();

    Swal.fire({
        title: 'Delete Ticket?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if(result.isConfirmed){
            form.submit();
        }
    });
});

</script>


@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function(){
        Swal.fire({
            icon:'Success',
            title: 'Deleted',
            text: @json(session('success')),
            confirmButtonColor: '#198754',
            timer : 2500,
            timerProgressBar: true,
            showConfirmButton: false
        });
    });
</script>
@endif

@endsection