@extends('layouts.app')

@section('title', 'AllTickets')

@section('content')
<style>
    .metric-title{
    display:block;
    line-height:1.2;
    white-space: normal;
    font-size:10px;
    font-weight:600;
    color:#34495e;
    margin:0;
    padding-right:0.25rem;
    letter-spacing: .01em;
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
    font-size:30px;
    font-weight:700;
    color:#0b3b75;
    line-height:1;
}


.card.metric-card {
    border: 1px solid rgba(108,117,125,0.16);
    overflow: hidden;
    transition: transform .16s ease, box-shadow .16s ease, border-color .16s ease;
    transition: transform .16s ease, box-shadow .16s ease;
}

.card.metric-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 16px 40px rgba(13,110,253,0.08);
}

.card.metric-card .card-body {
    min-height: 110px;
}

.card.metric-card .card-body .ps-3 {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 72px;
}

.metric-title {
    margin-bottom: 0.35rem;
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
        padding-left: 48% !important; /* reserve space for the label */
        box-sizing: border-box !important;
    }

    .ticket-card-table td::before {
        content: attr(data-label);
        position: absolute !important;
        left: 12px !important;
        top: 12px !important;
        width: calc(48% - 24px) !important;
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
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6 g-3 mb-4">
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

<div class="card mb-4">
    <div class="card-body">

        <div class="row mb-3">

            <div class="col-12">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input id="search" name="search" type="search" class="form-control"
                        placeholder="Search tickets or user..." value="{{ request('search') }}">
                </div>
            </div>

        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">

            {{-- STATUS --}}
            <div class="col-12 col-sm-6 col-lg-4">

                <label class="form-label fw-semibold">
                    Status
                </label>

                <select
                    name="status"
                    class="form-select">

                    <option value="">All</option>

                    <option value="review"
                        {{ request('status')=='review'?'selected':'' }}>
                        For Review
                    </option>

                    <option value="inprogress"
                        {{ request('status')=='inprogress'?'selected':'' }}>
                        In Progress
                    </option>

                    <option value="resolved"
                        {{ request('status')=='resolved'?'selected':'' }}>
                        Resolved
                    </option>

                    <option value="completed"
                        {{ request('status')=='completed'?'selected':'' }}>
                        Completed
                    </option>

                    <option value="rejected"
                        {{ request('status')=='rejected'?'selected':'' }}>
                        Rejected
                    </option>

                </select>

            </div>

            {{-- CATEGORY --}}
            <div class="col-12 col-sm-6 col-lg-4">

                <label class="form-label fw-semibold">
                    Category
                </label>

                <select
                    name="category"
                    class="form-select">

                    <option value="">All</option>

                    <option value="completed"
                        {{ request('category')=='completed'?'selected':'' }}>
                        Completed Program
                    </option>

                    <option value="enhancement"
                        {{ request('category')=='enhancement'?'selected':'' }}>
                        Program Development
                    </option>

                    <option value="resource"
                        {{ request('category')=='resource'?'selected':'' }}>
                        Resource Person
                    </option>

                    <option value="knowledge"
                        {{ request('category')=='knowledge'?'selected':'' }}>
                        Knowledge Product
                    </option>

                </select>

            </div>

            <div class="col-12 col-sm-6 col-lg-4">

                <label class="form-label fw-semibold">
                    Priority
                </label>

                <select
                    name="priority"
                    class="form-select">

                    <option value="">All</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="urgent">Urgent</option>

                </select>

            </div>

            {{-- REQUESTOR --}}
            <div class="col-12 col-sm-6 col-lg-4">

                <label class="form-label fw-semibold">
                    Requestor
                </label>

                <select
                    name="requestor"
                    class="form-select">

                    <option value="">
                        All Requestors
                    </option>

                    @foreach($requestors as $requestor)

                    <option
                        value="{{ $requestor->requestor_email }}"
                        {{ request('requestor')==$requestor->requestor_email?'selected':'' }}>

                        {{ $requestor->requestor_first_name }}
                        {{ $requestor->requestor_last_name }}

                    </option>

                    @endforeach

                </select>

            </div>

            {{-- PROGRAM --}}
            <div class="col-12 col-sm-6 col-lg-4">

                <label class="form-label fw-semibold">
                    Program
                </label>
                <select name="program" class="form-select">
                    <option value="">All Program</option>
                    @foreach($programs as $program)
                    <option value="{{$program->program_id}}">{{$program->program}}</option>
                    @endforeach
                </select>
            </div>

            {{-- DATE FROM --}}
            <div class="col-12 col-sm-6 col-lg-4">

                <label class="form-label fw-semibold">
                    From
                </label>

                <input
                    type="date"
                    class="form-control"
                    name="date_from"
                    value="{{ request('date_from') }}">

            </div>

            {{-- DATE TO --}}
            <div class="col-12 col-sm-6 col-lg-4">

                <label class="form-label fw-semibold">
                    To
                </label>

                <input
                    type="date"
                    class="form-control"
                    name="date_to"
                    value="{{ request('date_to') }}">

            </div>

            <div class="col-12 d-flex flex-column flex-sm-row align-items-stretch align-items-sm-end justify-content-end gap-2">

                <button type="submit" class="btn btn-primary w-100 w-sm-auto">
                    <i class="bi bi-search"></i>
                    Apply Filters
                </button>

                <a href="{{ route('tickets') }}" class="btn btn-outline-secondary w-100 w-sm-auto text-center">
                    <i class="bi bi-arrow-clockwise"></i>
                    Clear
                </a>

            </div>

        </div>

    </div>
</div>

</form>
{{-- Table --}}
<div id="tickets-container">
<div class="table-responsive ticket-card-table drag-scroll" id="dragScroll">
    <table class="table align-middle table-hover mb-0">

        <thead class="table-light">
            <tr>
                <th style="min-width:170px;">Ticket Number</th>
                <th style="min-width:250px;">Purpose</th>
                <th style="min-width:180px;">Category</th>
                <th style="min-width:180px;">Program</th>
                <th style="min-width:220px;">Requestor</th>
                <th style="min-width:140px;">Status</th>
                <th style="min-width:130px;">Priority</th>
                <th style="min-width:170px;">Last Updated</th>
                <th style="min-width:110px;">Actions</th>
            </tr>
        </thead>

        <tbody>

            @forelse($tickets as $ticket)

            <tr class="ticket-row" data-url="{{ route('ticket.view', $ticket->ticket_id) }}" tabindex="0" aria-label="Ticket {{ $ticket->ticket_id }}">
                

                {{-- Ticket Number --}}
                <td data-label="Ticket Number">
                    <div class="fw-bold text-primary">
                        {{ $ticket->ticket_id }}
                    </div>

                    <small class="text-muted">
                        {{ $ticket->created_at->format('M d, Y h:i A') }}
                    </small>
                </td>

                {{-- Purpose --}}
                <td data-label="Purpose">
                    <div class="fw-semibold">
                        {{ Str::limit($ticket->purpose_of_request, 55) }}
                    </div>
                </td>

                {{-- Category --}}
                <td data-label="Category">

                    @switch($ticket->ticket_category)

                        @case('enhancement')

                            <span class="badge rounded-pill bg-primary-subtle text-primary">
                                Program Enhancement
                            </span>

                        @break

                        @case('completed')

                            <span class="badge rounded-pill bg-success-subtle text-success">
                                Completed Program
                            </span>

                        @break

                        @case('resource')

                            <span class="badge rounded-pill bg-warning-subtle text-dark">
                                Resource Person
                            </span>

                        @break

                        @case('knowledge')

                            <span class="badge rounded-pill bg-info-subtle text-info">
                                Knowledge Product
                            </span>

                        @break

                        @default

                            <span class="badge bg-secondary">
                                N/A
                            </span>

                    @endswitch

                </td>

                {{-- Program --}}
                <td data-label="Program">

                    <div class="fw-semibold">
                        {{ Str::limit($ticket->programDetails->program ?? '-',25) }}
                    </div>

                </td>

                {{-- Requestor --}}
                <td data-label="Requestor">

                    <div class="fw-semibold">

                        {{ $ticket->requestor_first_name }}
                        {{ $ticket->requestor_last_name }}

                    </div>

                    <small class="text-muted">

                        {{ $ticket->requestor_email }}

                    </small>

                </td>

                {{-- Status --}}
                <td data-label="Status">

                    @switch($ticket->ticket_status)

                        @case('review')

                            <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                For Review
                            </span>

                        @break

                        @case('inprogress')

                            <span class="badge rounded-pill bg-primary px-3 py-2">
                                In Progress
                            </span>

                        @break

                        @case('resolved')

                            <span class="badge rounded-pill bg-info px-3 py-2">
                                Resolved
                            </span>

                        @break

                        @case('completed')

                            <span class="badge rounded-pill bg-success px-3 py-2">
                                Completed
                            </span>

                        @break

                        @case('rejected')

                            <span class="badge rounded-pill bg-danger px-3 py-2">
                                Rejected
                            </span>

                        @break

                        @default

                            <span class="badge bg-secondary">
                                Unknown
                            </span>

                    @endswitch

                </td>

                <td data-label="Priority">

                    @php
                        $priority = strtolower($ticket->ticket_priority ?? 'low');
                    @endphp

                    @switch($priority)

                        @case('urgent')
                            <span class="badge rounded-pill bg-danger px-3 py-2">
                                Urgent
                            </span>
                        @break

                        @case('high')
                            <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                High
                            </span>
                        @break

                        @case('medium')
                            <span class="badge rounded-pill bg-info px-3 py-2">
                                Medium
                            </span>
                        @break

                        @case('low')
                            <span class="badge rounded-pill bg-success px-3 py-2">
                                Low
                            </span>
                        @break
                        @default
                            <span class="badge rounded-pill bg-success px-3 py-2">
                                -
                            </span>

                    @endswitch

                </td>

                {{-- Last Updated --}}
                <td data-label="Last Updated">

                    <div class="fw-semibold">
                        {{ $ticket->updated_at->format('M d, Y') }}
                    </div>

                    <small class="text-muted">
                        {{ $ticket->updated_at->format('h:i A') }}
                    </small>

                </td>

                <td data-label="Actions" class="text-end">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Actions for ticket {{ $ticket->ticket_id }}">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li>
                                <a class="dropdown-item" href="{{route('ticket.view', $ticket->ticket_id)}}">
                                    <i class="bi bi-eye me-2"></i> View Ticket
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{route('ticket.delete', $ticket->ticket_id)}}" class="delete-form m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-trash me-2"></i> Delete
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </td>

            </tr>

            @empty

            <tr>

                <td colspan="9" class="text-center py-5">

                    <i class="bi bi-inbox fs-1 text-muted"></i>

                    <h6 class="mt-3 mb-1">

                        No tickets found

                    </h6>

                    <small class="text-muted">

                        There are currently no tickets matching your filters.

                    </small>

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>
    @if ($tickets->hasPages())
        <div class="d-flex justify-content-end mt-4">
            {{ $tickets->links('pagination::bootstrap-5') }}
        </div>
    @endif
    </div>
</div>

<script>
document.addEventListener('click', function(e){
    const link = e.target.closest('.pagination a');
    if(!link) return;
    e.preventDefault();
    const url = link.getAttribute('href');
    if(!url) return;

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
                current.scrollIntoView({behavior:'smooth'});
            }
        })
        .catch(err => {
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