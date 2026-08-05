@extends('layouts.app')

@section('title', 'AllTickets')

@section('content')
<style>
    .metric-title{
    height:20px;                 
    display:flex;
    justify-content:center;
    align-items:start;

    text-align:start;

    font-size:12px;
    font-weight:600;
    color:#34495e;

    margin:0;
}
.filter-title{
    height:20px;                 
    display:flex;
    justify-content:start;
    align-items:start;

    text-align:start;

    font-size:12px;
    font-weight:600;
    color:#34495e;

    margin:0;
}

.metric-number{
    font-size:30px;
    font-weight:700;
    color:#0b3b75;
    line-height:1;
}

.drag-scroll{
    overflow-x: auto;
    overflow-y: hidden;
    cursor: grab;
    user-select: none;
    -webkit-overflow-scrolling: touch;
    scroll-behavior: smooth;
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
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card">
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
    <div class="col-md-2">
        <div class="card">
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
    <div class="col-md-2">
        <div class="card">
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
    <div class="col-md-2">
        <div class="card">
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
    <div class="col-md-2">
        <div class="card">
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
    <div class="col-md-2">
        <div class="card">
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

        <div class="row g-3">

            {{-- STATUS --}}
            <div class="col-md-2">

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
            <div class="col-md-2">

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

            {{-- PRIORITY --}}
            <div class="col-md-2">

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
            <div class="col-md-3">

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
            <div class="col-md-3">

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
            <div class="col-md-2">

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
            <div class="col-md-2">

                <label class="form-label fw-semibold">
                    To
                </label>

                <input
                    type="date"
                    class="form-control"
                    name="date_to"
                    value="{{ request('date_to') }}">

            </div>

            <div class="col-md-8 d-flex align-items-end justify-content-end">

                <button
                    class="btn btn-primary me-2">

                    <i class="bi bi-search"></i>

                    Apply Filters

                </button>

                <a
                    href="{{ route('tickets') }}"
                    class="btn btn-outline-secondary">

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
<div class="table-responsive drag-scroll" id="dragScroll">
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
            </tr>
        </thead>

        <tbody>

            @forelse($tickets as $ticket)

            <tr class="ticket-row" data-url="{{ route('ticket.view', $ticket->ticket_id) }}">
                

                {{-- Ticket Number --}}
                <td>
                    <div class="fw-bold text-primary">
                        {{ $ticket->ticket_id }}
                    </div>

                    <small class="text-muted">
                        {{ $ticket->created_at->format('M d, Y h:i A') }}
                    </small>
                </td>

                {{-- Purpose --}}
                <td>
                    <div class="fw-semibold">
                        {{ Str::limit($ticket->purpose_of_request, 55) }}
                    </div>
                </td>

                {{-- Category --}}
                <td>

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
                <td>

                    <div class="fw-semibold">
                        {{ Str::limit($ticket->programDetails->program ?? '-',25) }}
                    </div>

                </td>

                {{-- Requestor --}}
                <td>

                    <div class="fw-semibold">

                        {{ $ticket->requestor_first_name }}
                        {{ $ticket->requestor_last_name }}

                    </div>

                    <small class="text-muted">

                        {{ $ticket->requestor_email }}

                    </small>

                </td>

                {{-- Status --}}
                <td>

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

                {{-- Priority --}}
                <td>

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

                        @default
                            <span class="badge rounded-pill bg-success px-3 py-2">
                                -
                            </span>

                    @endswitch

                </td>

                {{-- Last Updated --}}
                <td>

                    <div class="fw-semibold">
                        {{ $ticket->updated_at->format('M d, Y') }}
                    </div>

                    <small class="text-muted">
                        {{ $ticket->updated_at->format('h:i A') }}
                    </small>

                </td>

                {{-- Actions --}}
                <div id="ticketMenu" class="dropdown-menu shadow">
                    <a class="dropdown-item view-ticket" href="{{route('ticket.view', $ticket->ticket_id)}}">
                        <i class="bi bi-eye me-2"></i> View Ticket
                    </a>

                    <div class="dropdown-divider"></div>

                    <form method="POST" action={{route('ticket.delete', $ticket->ticket_id)}} class="delete-form">
                    @csrf
                    @method('DELETE')

                        <button type="submit" class="dropdown-item text-danger delete-button" >
                            <i class="bi bi-trash me-2"></i>
                            Delete
                        </button>
                    </form>
                </div>

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
    slider.classList.remove("dragging");
});

function getTicketMenu(){
    return document.getElementById('ticketMenu');
}

// Use event delegation so newly loaded rows work after AJAX replaces content
document.addEventListener('click', function(e){

    const row = e.target.closest('.ticket-row');

    // If clicking on a row (but not on an actionable child like a link/button)
    if(row && !e.target.closest('a, button')){

        if (isDragging) {
            isDragging = false;
            return;
        }

        const menu = getTicketMenu();
        if(!menu) return;

        const viewLink = menu.querySelector('.view-ticket');
        if(viewLink) viewLink.href = row.dataset.url;

        menu.style.position = 'fixed';
        const menuWidth = menu.offsetWidth;
        const menuHeight = menu.offsetHeight;

        let left = e.clientX;
        let top = e.clientY;

        if (left + menuWidth > window.innerWidth) {
            left = window.innerWidth - menuWidth - 10;
        }

        if (top + menuHeight > window.innerHeight) {
            top = window.innerHeight - menuHeight - 10;
        }

        left = Math.max(10, left);
        top = Math.max(10, top);

        menu.style.left = `${left}px`;
        menu.style.top = `${top}px`;
        menu.classList.add('show');

        return;
    }

    // If click outside any row and outside the menu, hide the menu
    const menu = getTicketMenu();
    if(menu && !menu.contains(e.target) && !e.target.closest('.ticket-row')){
        menu.classList.remove('show');
    }

});

document.querySelectorAll('.delete-button').forEach(btn => {
    btn.addEventListener('click', function(){
        menu.classList.remove('show');
    })
})

document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e){

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