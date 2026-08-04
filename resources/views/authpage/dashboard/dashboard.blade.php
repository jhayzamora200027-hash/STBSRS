@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp
<style>
   .metric-card{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:14px;
    padding:22px 18px;
    cursor: pointer;
    height:200px;

    display:flex;
    flex-direction:column;
    align-items:center;

    transition:.25s;
}

.metric-card:hover{
    transform:translateY(-4px);
    border-color:#d1d5db;
    box-shadow:0 8px 20px rgba(0,0,0,.05);
}

.metric-title{
    height:52px;                 /* Every title occupies same space */
    display:flex;
    justify-content:center;
    align-items:center;

    text-align:center;

    font-size:18px;
    font-weight:600;
    color:#34495e;

    margin:0;
}

.metric-value{
    flex:1;                      /* Always center the number */
    display:flex;
    justify-content:center;
    align-items:center;
}

.metric-number{
    font-size:52px;
    font-weight:700;
    color:#0b3b75;
    line-height:1;
}

.metric-unit{
    font-size:24px;
    margin-left:8px;
    color:#64748b;
}

.metric-footer{
    height:42px;                 /* Equal footer height */
    display:flex;
    justify-content:center;
    align-items:center;

    text-align:center;

    font-size:14px;
    color:#94a3b8;

    margin:0;
}

.pagination{
    margin-bottom:0;
}

.page-link{
    border-radius:8px;
    margin:0 3px;
}

.page-item.active .page-link{
    background:#062c52;
    border-color:#062c52;
}

.empty-row td{
    height:55px;
    color:transparent;
}

/* ICON COLORS */

.bg-blue{

    background:#e9f2ff;

}

.bg-blue i{

    color:#0B5ED7;

}

.bg-purple{

    background:#f3e8ff;

}

.bg-purple i{

    color:#7c3aed;

}

.bg-green{

    background:#dcfce7;

}

.bg-green i{

    color:#15803d;

}

.bg-orange{

    background:#fff3df;

}

.bg-orange i{

    color:#d97706;

}

.bg-lime{

    background:#f2fbc7;

}

.bg-lime i{

    color:#65a30d;

}

.bg-red{

    background:#ffe3e3;

}

.bg-red i{

    color:#dc2626;

}

/* Responsive */

@media(max-width:768px){

    .metric-number{

        font-size:2.6rem;

    }

    .metric-icon{

        width:54px;

        height:54px;

    }

    .metric-icon i{

        font-size:24px;

    }

}
    .analytics-card{

    background:#fff;

    border-radius:22px;

    padding:28px;

    box-shadow:
        0 10px 30px rgba(15,23,42,.06);

    border:1px solid #edf2f7;

    transition:.3s;
}

.analytics-card:hover{

    transform:translateY(-3px);

    box-shadow:
        0 18px 45px rgba(15,23,42,.08);

}

.analytics-header{

    display:flex;

    justify-content:space-between;

    align-items:flex-start;

    margin-bottom:25px;

    gap:20px;

}

.analytics-badge{

    display:inline-flex;

    align-items:center;

    gap:8px;

    padding:6px 14px;

    background:#eef5ff;

    color:#2962ff;

    border-radius:30px;

    font-size:13px;

    font-weight:600;

    margin-bottom:14px;

}

.analytics-title{

    font-size:25px;

    font-weight:700;

    margin-bottom:5px;

    color:#1e293b;

}

.analytics-subtitle{

    color:#64748b;

    margin:0;

    font-size:15px;

}

.analytics-summary{

    text-align:right;

}

.analytics-summary .label{

    color:#94a3b8;

    font-size:13px;

}

.analytics-summary h2{

    font-size:40px;

    font-weight:700;

    margin:6px 0;

    color:#0f172a;

}

.growth{

    display:inline-flex;

    align-items:center;

    gap:5px;

    padding:6px 12px;

    border-radius:30px;

    font-size:13px;

    font-weight:600;

}

.growth.positive{

    background:#e8fff3;

    color:#16a34a;

}

.chart-container{

    position:relative;

    height:340px;

}

.analytics-footer{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-top:20px;

    border-top:1px solid #edf2f7;

    padding-top:18px;

    color:#64748b;

    font-size:14px;

}

.footer-item{

    display:flex;

    align-items:center;

    gap:10px;

}

.dot{

    width:12px;

    height:12px;

    border-radius:50%;

}

.dot.blue{

    background:#2962ff;

}

@media(max-width:768px){

.analytics-header{

    flex-direction:column;

}

.analytics-summary{

    text-align:left;

}

.chart-container{

    height:260px;

}

.analytics-title{

    font-size:22px;

}

.analytics-summary h2{

    font-size:34px;

}


}

.ticket-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:30px;

}

.ticket-header h2{

    font-weight:700;

    margin:0;

}

.ticket-header p{

    color:#64748b;

    margin:0;

}

.ticket-toolbar{

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:20px;

    margin-bottom:25px;

}

.search-box{

    flex:1;

    position:relative;

}

.search-box i{

    position:absolute;

    left:16px;

    top:50%;

    transform:translateY(-50%);

    color:#94a3b8;

}

.search-box input{

    width:100%;

    padding:12px 18px 12px 45px;

    border:1px solid #dbe4ee;

    border-radius:12px;

    outline:none;

}

.filter-group{

    display:flex;

    gap:12px;

}

.filter-group select{

    width:180px;

}

.ticket-card{
    background:#fff;
    border:1px solid #e8eef5;
    border-radius:18px;
    padding:22px;

    display:flex;
    flex-direction:column;

    height:430px; 
}

.ticket-card:hover{

    transform:translateY(-3px);

    box-shadow:0 12px 30px rgba(15,23,42,.10);

}

.ticket-top{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:22px;

}

.ticket-top h5{

    margin:0;

    font-weight:700;

    color:#062c52;

}

.ticket-top small{

    color:#94a3b8;

}

.status{

    padding:6px 14px;

    border-radius:50px;

    font-size:.6rem;

    font-weight:600;

    min-width: 90px;

    padding-right:7px;

}

.status-progress{
    background:#e9f3ff;
    font-size:0.6rem;
    color:#0d6efd;

}

.ticket-body{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:22px;

}

.info label{

    font-size:.75rem;

    color:#94a3b8;

    text-transform:uppercase;

    margin-bottom:6px;

}

.info p{

    margin:0;

    font-weight:500;

    color:#1e293b;

}

.full{

    grid-column:1 / -1;

}

.ticket-footer{

    margin-top:auto;

    padding-top:18px;

    border-top:1px solid #eef2f7;

}

.priority{

    font-weight:600;

    display:flex;

    gap:8px;

    align-items:center;

}

.priority.medium{

    color:#d97706;

}

.btn-light{

    border-radius:10px;

    border:1px solid #dbe4ee;

    padding:8px 18px;

}

.btn-light:hover{

    background:#062c52;

    color:#fff;

}

@media(max-width:992px){

.ticket-body{

    display:grid;

    grid-template-columns:1fr 1fr;

    gap:18px;

    margin-top:18px;

}

.ticket-toolbar{

flex-direction:column;

align-items:stretch;

}

.filter-group{

flex-direction:column;

}

.filter-group select{

width:100%;

}

.ticket-header{

flex-direction:column;

align-items:flex-start;

gap:15px;

}

}
.ticket-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:20px;

    margin-top:25px;

}

.ticket-info span{

    display:-webkit-box;

    -webkit-line-clamp:2;

    -webkit-box-orient:vertical;

    overflow:hidden;

    line-height:1.5;

    min-height:48px;
}
</style>
{{-- Greeting --}}
<div class="row g-4 px-4 pb-4">

    <!-- Total Tickets -->
    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2">
        <div class="metric-card" id="totalTickets" data-title="Total Tickets">

            <div class="metric-header">

                <div class="metric-title" >
                    Total Tickets
                </div>

                {{-- <div class="metric-icon bg-blue">
                    <i class="bi bi-ticket"></i>
                </div> --}}

            </div>
            
            <div class="metric-number">
                {{ number_format($totalTickets) }}
            </div>

            <div class="metric-footer">
                Overall submitted requests
            </div>

        </div>
    </div>

    <!-- New Tickets -->
    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2">
        <div class="metric-card" id="newTickets" data-title="New Tickets">

            <div class="metric-header">

                <div class="metric-title" >
                    New Tickets
                </div>

                {{-- <div class="metric-icon bg-purple">
                    <i class="bi bi-ticket-perforated"></i>
                </div> --}}

            </div>

            <div class="metric-number">
                {{ number_format($newTicketsToday) }}
            </div>

            <div class="metric-footer">
                Received today
            </div>

        </div>
    </div>

    <!-- Resolved -->
    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2">
        <div class="metric-card" id="resolvedTickets" data-title="Resolved Tickets">

            <div class="metric-header">

                <div class="metric-title">
                    Resolved Tickets
                </div>

                {{-- <div class="metric-icon bg-green">
                    <i class="bi bi-check-circle-fill"></i>
                </div> --}}

            </div>

            <div class="metric-number">
                {{ number_format($resolvedTickets) }}
            </div>

            <div class="metric-footer">
                Successfully completed
            </div>

        </div>
    </div>

    <!-- Average Resolution -->
    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2">
        <div class="metric-card" id="averageTickets" data-title="Average Resolution Time">

            <div class="metric-header">

                <div class="metric-title">
                    Average Resolution Time
                </div>

                {{-- <div class="metric-icon bg-orange">
                    <i class="bi bi-stopwatch-fill"></i>
                </div> --}}

            </div>

            <div class="metric-number">
                {{ number_format($averageResolutionDays) }}
                <span class="metric-unit">Days</span>
            </div>

            <div class="metric-footer">
                Average completion time
            </div>

        </div>
    </div>

    <!-- SLA -->
    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2">
        <div class="metric-card" id="slaCompliance" data-title="SLA Compliance">

            <div class="metric-header">

                <div class="metric-title">
                    SLA Compliance
                </div>

                {{-- <div class="metric-icon bg-lime">
                    <i class="bi bi-shield-check"></i>
                </div> --}}

            </div>

            <div class="metric-number">
                {{ number_format($slaCompliance) }}
                <span class="metric-unit">%</span>
            </div>

            <div class="metric-footer" data-title="Requests within SLA">
                Requests within SLA
            </div>

        </div>
    </div>

    <!-- Overdue -->
    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2">
        <div class="metric-card" id="overdueTickets" data-title="Overdue Tickets">

            <div class="metric-header">

                <div class="metric-title">
                    Overdue Tickets
                </div>

                {{-- <div class="metric-icon bg-red">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div> --}}

            </div>

            <div class="metric-number">
                {{ number_format($overdueTickets) }}
            </div>

            <div class="metric-footer">
                Requires immediate action
            </div>

        </div>
    </div>

</div>
{{-- Ticket Volume Over Time --}}
<div class="row ps-4">
    <div class="col-md-5">
        <div class="analytics-card">

            <div class="analytics-header">

                <div>

                    {{-- <span class="analytics-badge">
                        <i class="bi bi-graph-up-arrow"></i>
                        Analytics
                    </span> --}}

                    <h4 class="analytics-title">
                        Ticket Volume Over Time
                    </h4>

                    <p class="analytics-subtitle">
                        Monthly submitted service requests
                    </p>

                </div>

                <div class="analytics-summary">

                    <span class="label">
                        Total Tickets
                    </span>

                    <h2 id="ticketTotal">{{ number_format($totalTickets) }}</h2>

                    
                       @if ($ticketGrowth >= 0)
                            <span class="growth positive">
                                <i class="bi bi-arrow-up-right">
                                </i>
                                +{{$ticketGrowth}}%

                            </span>
                       
                       @else
                        <span class="growth negative">
                                <i class="bi bi-arrow-down-right">
                                </i>
                                +{{$ticketGrowth}}%

                            </span>
                       @endif

                </div>

            </div>

            <div class="chart-container">

                <canvas id="ticketChart"></canvas>

            </div>

            <div class="analytics-footer">

            </div>

        </div>
    </div>
</div>
        {{-- Modal Metrics --}}
        <div class="modal fade"
        id="modalMetrics"
        tabindex="-1"
        aria-labelledby="modalMetricsLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered modal-xl">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="modalMetricsLabel">
                    </h5>

                    <button class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

    {{-- Total Tickets --}}
    <div id="totalTicketBody" class="d-none">
        <div id="ticketTableContainer">
            <div class="container-fluid p-4">

                <!-- Header -->
                <div class="ticket-header">

                    <div>
                        <h2>All Tickets</h2>
                        <p>Manage and monitor all submitted service requests.</p>
                    </div>

                </div>

                <!-- Search & Filters -->

                <div class="ticket-toolbar">

                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input id="search" class="ps-5" type="text" placeholder="Search ticket number, requestor or program...">
                    </div>

                    <div class="filter-group">

                        <select class="form-select" id="status"> 
                            <option value="">Status</option>
                            <option value="review">For Review</option>
                            <option value="inprogress">In Progress</option>
                            <option value="resolved">Resolved</option>
                            <option value="completed">Completed</option>
                        </select>

                        <select class="form-select" id="category">
                            <option value="">Category</option>
                            <option value="completed">Technical Assistance on Completed Program</option>
                            <option value="enhancement">Technical Assistance on Development of Program</option>
                            <option value="resource">Resource Person</option>
                            <option value="knowledge">Knowledge Product</option>
                        </select>

                        <select class="form-select" id="program">
                            <option value="">Program</option>
                            @foreach($programs as $program)
                            <option value="{{$program->program_id}}">{{$program->program}}</option>
                            @endforeach
                        </select>

                    </div>

                </div>

                <!-- Ticket Cards -->
                <div class="ticket-grid" id="ticketGrid">
                    @foreach($programName as $programname)

                    <div class="ticket-card">

                        <div class="ticket-top">

                            <div>

                                <h5>{{ $programname->ticket_id }}</h5>

                                <small>
                                    Submitted {{ $programname->created_at->format('F d, Y') }}
                                </small>

                            </div>

                            <span class="status status-progress justify-content-center">
                                In Progress
                            </span>

                        </div>

                        <div class="ticket-body">

                            <div class="info">

                                <label>Requestor</label>

                                <p>{{ $programname->requestor_first_name }}</p>

                            </div>

                            <div class="info">

                                <label>Category</label>

                                <p>

                                    @switch($programname->ticket_category)

                                        @case('completed')
                                            Technical Assistance on Completed Program
                                            @break

                                        @case('enhancement')
                                            Technical Assistance on Program Development
                                            @break

                                        @case('resource')
                                            Resource Person
                                            @break

                                        @case('knowledge')
                                            Knowledge Product
                                            @break

                                    @endswitch

                                </p>

                            </div>

                            <div class="info">

                                <label>Program</label>

                                <span title="{{ $programname->programDetails->program ?? '-' }}">
                                    {{ Str::limit($programname->programDetails->program ?? '-', 35) }}
                                </span>

                            </div>

                            <div class="info full">

                                <label>Purpose of Request</label>

                                <span title="{{ $programname->purpose_of_request }}">
                                    {{ Str::limit($programname->purpose_of_request, 45) }}
                                </span>

                            </div>

                        </div>

                        <div class="ticket-footer">

                            <div>

                                <button class="btn btn-light">

                                    <i class="bi bi-eye"></i>

                                    View Details

                                </button>

                            </div>

                        </div>

                    </div>

                    @endforeach
                </div>

                <!-- Pagination -->

               <div class="mt-4 d-flex justify-content-end" id="paginationContainer">

    <ul class="pagination" id="ajaxPagination">

        @if($programName->hasPages())

            {{-- Previous --}}
            @if($programName->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Previous</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link ajax-page"
                        href="{{ $programName->previousPageUrl() }}">
                        Previous
                    </a>
                </li>
            @endif

            {{-- Pages --}}
            @for($i = 1; $i <= $programName->lastPage(); $i++)

                <li class="page-item {{ $programName->currentPage() == $i ? 'active' : '' }}">

                    <a class="page-link ajax-page"
                        href="{{ $programName->url($i) }}">
                        {{ $i }}
                    </a>

                </li>

            @endfor

            {{-- Next --}}
            @if($programName->hasMorePages())

                <li class="page-item">

                    <a class="page-link ajax-page"
                        href="{{ $programName->nextPageUrl() }}">
                        Next
                    </a>

                </li>

            @else

                <li class="page-item disabled">

                    <span class="page-link">
                        Next
                    </span>

                </li>

            @endif

        @endif

    </ul>

</div>

            </div>
        </div>
    </div>
                <div class="modal-body d-none" id="newTicketBody">

                    newTicketBody

                </div>
                <div class="modal-body d-none" id="resolvedTicketBody">

                    resolvedTicketBody

                </div>
                <div class="modal-body d-none" id="averageResolutionBody">

                    averageResolutionBody

                </div>
                <div class="modal-body d-none" id="slaComplianceBody">

                    slaComplianceBody

                </div>
                <div class="modal-body d-none" id="overdueTicketBody">

                    overdueTicketBody

                </div>

            </div>

        </div>

        </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

    const modal = new bootstrap.Modal(
        document.getElementById('modalMetrics')
    );

    document.querySelectorAll('.metric-card').forEach(card => {

        card.addEventListener('click', function () {
            const title = this.dataset.title;
            document.getElementById('modalMetricsLabel').textContent =
                this.dataset.title;

                switch(title){
                    case 'Total Tickets': 
                        document.getElementById('totalTicketBody').classList.remove('d-none');
                        document.getElementById('newTicketBody').classList.add('d-none');
                        document.getElementById('resolvedTicketBody').classList.add('d-none');
                        document.getElementById('averageResolutionBody').classList.add('d-none');
                        document.getElementById('slaComplianceBody').classList.add('d-none');
                        document.getElementById('overdueTicketBody').classList.add('d-none');
                        break;

                    case 'New Tickets': 
                        document.getElementById('totalTicketBody').classList.add('d-none');
                        document.getElementById('newTicketBody').classList.remove('d-none');
                        document.getElementById('resolvedTicketBody').classList.add('d-none');
                        document.getElementById('averageResolutionBody').classList.add('d-none');
                        document.getElementById('slaComplianceBody').classList.add('d-none');
                        document.getElementById('overdueTicketBody').classList.add('d-none');
                        break;
                    
                    case 'Resolved Tickets': 
                        document.getElementById('totalTicketBody').classList.add('d-none');
                        document.getElementById('newTicketBody').classList.add('d-none');
                        document.getElementById('resolvedTicketBody').classList.remove('d-none');
                        document.getElementById('averageResolutionBody').classList.add('d-none');
                        document.getElementById('slaComplianceBody').classList.add('d-none');
                        document.getElementById('overdueTicketBody').classList.add('d-none');
                        break;

                    case 'Average Resolution Time': 
                        document.getElementById('totalTicketBody').classList.add('d-none');
                        document.getElementById('newTicketBody').classList.add('d-none');
                        document.getElementById('resolvedTicketBody').classList.add('d-none');
                        document.getElementById('averageResolutionBody').classList.remove('d-none');
                        document.getElementById('slaComplianceBody').classList.add('d-none');
                        document.getElementById('overdueTicketBody').classList.add('d-none');
                        break;

                    case 'SLA Compliance': 
                        document.getElementById('totalTicketBody').classList.add('d-none');
                        document.getElementById('newTicketBody').classList.add('d-none');
                        document.getElementById('resolvedTicketBody').classList.add('d-none');
                        document.getElementById('averageResolutionBody').classList.add('d-none');
                        document.getElementById('slaComplianceBody').classList.remove('d-none');
                        document.getElementById('overdueTicketBody').classList.add('d-none');
                        break;

                    case 'Overdue Tickets': 
                        document.getElementById('totalTicketBody').classList.add('d-none');
                        document.getElementById('newTicketBody').classList.add('d-none');
                        document.getElementById('resolvedTicketBody').classList.add('d-none');
                        document.getElementById('averageResolutionBody').classList.add('d-none');
                        document.getElementById('slaComplianceBody').classList.add('d-none');
                        document.getElementById('overdueTicketBody').classList.remove('d-none');
                        break;
                }
            
            modal.show();

        });

    });

});

document.addEventListener('DOMContentLoaded', function () {

    const monthlyTickets = @json($monthlyTickets);

   

    // Get canvas
    const canvas = document.getElementById('ticketChart');

    if (!canvas) {
        console.error('Canvas #ticketChart not found.');
        return;
    }

    // Destroy previous chart if it exists
    const existingChart = window.Chart.getChart(canvas);

    if (existingChart) {
        existingChart.destroy();
    }

    new window.Chart(canvas, {

        type: 'line',

        data: {

            labels: [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],

            datasets: [{

                label: 'Tickets',

                data: monthlyTickets,
                borderColor: '#2962ff',

                backgroundColor: function (context) {

                    const chart = context.chart;
                    const { ctx, chartArea } = chart;

                    if (!chartArea) return null;

                    const gradient = ctx.createLinearGradient(
                        0,
                        chartArea.top,
                        0,
                        chartArea.bottom
                    );

                    gradient.addColorStop(0, 'rgba(41,98,255,.35)');
                    gradient.addColorStop(.6, 'rgba(41,98,255,.08)');
                    gradient.addColorStop(1, 'rgba(41,98,255,0)');

                    return gradient;

                },

                fill: true,

                borderWidth: 4,

                tension: .45,

                pointRadius: 6,

                pointHoverRadius: 9,

                pointBackgroundColor: '#fff',

                pointBorderColor: '#2962ff',

                pointBorderWidth: 3

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            interaction: {
                mode: 'index',
                intersect: false
            },

            plugins: {

                legend: {
                    display: false
                },

                tooltip: {

                    backgroundColor: '#0f172a',

                    titleColor: '#fff',

                    bodyColor: '#fff',

                    padding: 14,

                    displayColors: false,

                    cornerRadius: 12,

                    callbacks: {

                        label: function (context) {
                            return context.parsed.y + ' Tickets';
                        }

                    }

                }

            },

            scales: {

                x: {

                    grid: {
                        display: false
                    },

                    ticks: {

                        color: '#64748b',

                        font: {
                            size: 13,
                            weight: '600'
                        }

                    }

                },

                y: {

                    beginAtZero: true,

                    ticks: {
                        color: '#64748b'
                    },

                    grid: {
                        color: 'rgba(148,163,184,.15)'
                    }

                }

            }

        }

    });

});

document.addEventListener('DOMContentLoaded', function () {

$(document).ready(function () {

    // Load tickets when the modal opens to ensure #ticketGrid is populated
    document.getElementById('modalMetrics').addEventListener('show.bs.modal', function (event) {

        // If the Total Tickets tab/body is visible, load tickets
        const label = document.getElementById('modalMetricsLabel').textContent;

        if (label === 'Total Tickets') {
            loadTickets();
        }

    });

    function loadTickets(page = 1) {

        $.ajax({

            url: "/dashboard/filter",

            type: "GET",

            data: {
                page: page,
                status: $('#status').val(),
                category: $('#category').val(),
                program: $('#program').val(),
                search: $('#search').val() // remove if you don't have a search box
            },

            success: function (response) {

                let html = '';

                response.data.forEach(function (ticket) {

                    let category = '';

                    switch (ticket.ticket_category) {
                        case 'completed':
                            category = 'Technical Assistance on Completed Program';
                            break;

                        case 'enhancement':
                            category = 'Technical Assistance on Program Development';
                            break;

                        case 'resource':
                            category = 'Resource Person';
                            break;

                        case 'knowledge':
                            category = 'Knowledge Product';
                            break;
                    }

                    html += `
                    <div class="ticket-card">

                        <div class="ticket-top">

                            <div>

                                <h5>${ticket.ticket_id}</h5>

                                <small>
                                    Submitted ${new Date(ticket.created_at).toLocaleDateString('en-US',{
                                        year:'numeric',
                                        month:'long',
                                        day:'2-digit'
                                    })}
                                </small>

                            </div>

                            <span class="status status-progress justify-content-center">
                                ${ticket.ticket_status}
                            </span>

                        </div>

                        <div class="ticket-body">

                            <div class="info">

                                <label>Requestor</label>

                                <p>${ticket.requestor_first_name}</p>

                            </div>

                            <div class="info">

                                <label>Category</label>

                                <p>${category}</p>

                            </div>

                            <div class="info">

                                <label>Program</label>

                                <span title="${ticket.program_details?.program ?? '-'}">

                                    ${(ticket.program_details?.program ?? '-').length > 35
                                        ? (ticket.program_details.program.substring(0,35) + '...')
                                        : (ticket.program_details?.program ?? '-')}

                                </span>

                            </div>

                            <div class="info full">

                                <label>Purpose of Request</label>

                                <span title="${ticket.purpose_of_request}">

                                    ${ticket.purpose_of_request.length > 45
                                        ? ticket.purpose_of_request.substring(0,45)+'...'
                                        : ticket.purpose_of_request}

                                </span>

                            </div>

                        </div>

                        <div class="ticket-footer">

                            <div>

                                <button class="btn btn-light">

                                    <i class="bi bi-eye"></i>

                                    View Details

                                </button>

                            </div>

                        </div>

                    </div>
                    `;
                });

                $('#ticketGrid').html(html);

                //---------------- Pagination ----------------//

                let pagination = '';

                if (response.prev_page_url) {

                    pagination += `
                        <li class="page-item">
                            <a class="page-link ajax-page"
                               href="${response.prev_page_url}">
                                Previous
                            </a>
                        </li>
                    `;
                }

                for (let i = 1; i <= response.last_page; i++) {

                    pagination += `
                        <li class="page-item ${response.current_page == i ? 'active' : ''}">
                            <a class="page-link ajax-page"
                               href="?page=${i}">
                               ${i}
                            </a>
                        </li>
                    `;
                }

                if (response.next_page_url) {

                    pagination += `
                        <li class="page-item">
                            <a class="page-link ajax-page"
                               href="${response.next_page_url}">
                                Next
                            </a>
                        </li>
                    `;
                }

                $('#paginationContainer').html(
                    `<ul class="pagination">${pagination}</ul>`
                );

            },

            error: function (xhr) {

                console.log(xhr.responseText);

            }

        });

    }

    //---------------- Filters ----------------//

    $('#status,#category,#program').change(function () {

        loadTickets();

    });

    //---------------- Search ----------------//

    $('#search').keyup(function () {

        loadTickets();

    });

    //---------------- Pagination ----------------//

                $(document).on('click', '.ajax-page', function (e) {

        e.preventDefault();

        // Try to read page param robustly from href, fallback to data-page
        let href = $(this).attr('href') || '';

        let page = null;

        try {
            const url = new URL(href, window.location.origin);
            page = url.searchParams.get('page');
        } catch (err) {
            // href might be a relative URL or just ?page=2 or something else
            const match = href.match(/[?&]page=(\d+)/);
            if (match) page = match[1];
        }

        // allow data-page attribute like <a data-page="2" ...>
        if (!page) page = $(this).data('page');

        // fallback to 1
        page = page ? parseInt(page, 10) : 1;

        loadTickets(page);

    });

});
});

</script>
@endsection