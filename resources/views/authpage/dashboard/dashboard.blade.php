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

    border-radius:10px;

    padding:28px;

    box-shadow:
        0 10px 30px rgba(15,23,42,.06);

    border:1px solid #edf2f7;

    transition:.3s;

    width:100%;

    height:100%;

    display:flex;

    flex-direction:column;

    box-sizing:border-box;
}

.analytics-card:hover{

    transform:translateY(-3px);

    box-shadow:
        0 18px 45px rgba(15,23,42,.08);

}

.pie-card{

    min-height:390px;

}

.pie-card-body{

    display:grid;

    grid-template-columns:minmax(0, 1.05fr) minmax(0, .95fr);

    align-items:center;

    gap:18px;

    flex:1 1 auto;

    min-height:300px;

}

.pie-card-summary{

    display:flex;

    align-items:flex-start;

    justify-content:space-between;

    gap:16px;

    margin:4px 0 18px;

    padding:14px 16px;

    border-radius:16px;

    background:linear-gradient(135deg, #f8fbff 0%, #ffffff 100%);

    border:1px solid #e8eef8;

}

.pie-summary-label{

    font-size:12px;

    color:#64748b;

    text-transform:uppercase;

    letter-spacing:.08em;

    font-weight:700;

}

.pie-summary-value{

    font-size:28px;

    line-height:1.1;

    font-weight:800;

    color:#0f172a;

    margin-top:4px;

}

.pie-summary-subtext{

    margin-top:4px;

    color:#64748b;

    font-size:13px;

}

.pie-summary-chip{

    display:inline-flex;

    align-items:center;

    gap:8px;

    padding:8px 12px;

    border-radius:999px;

    background:#edf4ff;

    color:#1d4ed8;

    font-weight:700;

    font-size:12px;

    white-space:nowrap;

}

.status-change-mini-wrap{

    width:100%;

}

.status-change-mini-title{

    font-size:12px;

    color:#64748b;

    text-transform:uppercase;

    letter-spacing:.08em;

    font-weight:700;

    margin-bottom:10px;

}

.status-change-mini-graph{

    display:flex;

    align-items:flex-end;

    justify-content:space-between;

    gap:10px;

    padding:12px;

    border:1px solid #e8eef8;

    border-radius:14px;

    background:#f8fbff;

}

.status-change-mini-item{

    flex:1 1 0;

    display:flex;

    flex-direction:column;

    align-items:center;

    gap:6px;

    min-width:0;

}

.status-change-mini-bar-wrap{

    width:100%;

    height:44px;

    display:flex;

    align-items:flex-end;

    justify-content:center;

}

.status-change-mini-bar{

    width:70%;

    min-height:6px;

    border-radius:999px;

    background:linear-gradient(180deg, #5da2ff 0%, #2962ff 100%);

}

.status-change-mini-percent{

    font-size:11px;

    color:#0f172a;

    font-weight:700;

    line-height:1;

}

.status-change-mini-month{

    font-size:11px;

    color:#64748b;

    line-height:1;

}

.pie-chart-wrap{

    position:relative;

    width:100%;

    max-width:300px;

    height:280px;

    margin:0 auto;

}

.pie-chart-center{

    position:absolute;

    inset:0;

    display:flex;

    flex-direction:column;

    align-items:center;

    justify-content:center;

    pointer-events:none;

}

.pie-chart-total{

    color:#0f172a;

    font-size:30px;

    font-weight:800;

    line-height:1;

}

.pie-chart-caption{

    margin-top:7px;

    color:#64748b;

    font-size:11px;

    font-weight:700;

    letter-spacing:.08em;

    text-transform:uppercase;

}

.pie-chart-wrap canvas{

    display:block;

    width:100% !important;

    height:100% !important;

}

.pie-legend{

    flex:1 1 auto;

    display:flex;

    flex-direction:column;

    gap:10px;

    min-width:0;

}

.pie-legend-item{

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:12px;

    font-size:14px;

    color:#334155;

    min-height:34px;

    padding:7px 9px;

    border-radius:9px;

    transition:background-color .2s ease;

}

.pie-legend-item:hover{

    background:#f8fafc;

}

.pie-legend-left{

    display:flex;

    align-items:center;

    gap:8px;

    min-width:0;

}

.pie-legend-name{

    min-width:0;

    overflow:hidden;

    text-overflow:ellipsis;

    white-space:nowrap;

}

.pie-legend-meta{

    color:#64748b;

    white-space:nowrap;

    font-variant-numeric:tabular-nums;

}

.pie-dot{

    width:10px;

    height:10px;

    border-radius:999px;

    flex:0 0 10px;

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

    font-size:15px;

    font-weight:700;

    margin-bottom:5px;

    color:#1e293b;

    line-height:1.3;

}

@media(max-width:1399px){

.pie-card-body{

    grid-template-columns:1fr;

    gap:14px;

}

.pie-chart-wrap{

    max-width:260px;

    height:250px;

}

}

.response-wrapper{

    display:flex;

    flex-direction:column;

    gap:16px;

    margin-top:18px;

}

.response-item{

    display:flex;

    flex-direction:column;

    gap:8px;

}

.response-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:12px;

    font-size:14px;

    color:#1e293b;

    font-weight:600;

}

.response-label{

    display:flex;

    align-items:center;

    gap:8px;

    min-width:0;

}

.response-dot{

    width:10px;

    height:10px;

    border-radius:50%;

    flex:0 0 10px;

}

.response-meta{

    color:#64748b;

    font-size:12px;

    white-space:nowrap;

    font-weight:700;

}

.response-track{

    position:relative;

    width:100%;

    height:12px;

    border-radius:999px;

    background:#edf2f7;

    overflow:hidden;

}

.response-fill{

    position:absolute;

    top:0;

    left:0;

    bottom:0;

    border-radius:inherit;

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

    width:100%;

    min-height:200px;

    height:clamp(220px, 32vw, 220px);

    flex:1 1 auto;

}

.chart-container canvas{

    display:block;

    width:100% !important;

    height:100% !important;

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


.pie-card{

    min-height:auto;

}

.pie-card-body{

    grid-template-columns:1fr;

    align-items:stretch;

    min-height:auto;

    gap:18px;

}

.pie-card-summary{

    flex-direction:column;

}

.status-change-mini-graph{

    gap:8px;

}

.status-change-mini-percent,
.status-change-mini-month{

    font-size:10px;

}

.pie-chart-wrap{

    width:100%;

    max-width:260px;

    height:240px;

    margin:0 auto;

}

.pie-chart-total{

    font-size:26px;

}
.chart-container{

    min-height:220px;

    height:clamp(220px, 65vw, 240px);

}

.analytics-title{

    font-size:18px;

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

.dashboard-ticket-search{

    flex:1;

    position:relative;

}

.dashboard-ticket-search i{

    position:absolute;

    left:16px;

    top:50%;

    transform:translateY(-50%);

    color:#94a3b8;

}

.dashboard-ticket-search input{

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

.status{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:.35rem .8rem;
    border-radius:999px;
    font-size:.8rem;
    font-weight:600;
}

.status-review{
    background:#f1f3f5;
    color:#6c757d;
}

.status-progress{
    background:#cfe2ff;
    color:#0d6efd;
}

.status-resolved{
    background:#fff3cd;
    color:#b8860b;
}

.status-completed{
    background:#d1e7dd;
    color:#146c43;
}

.status-rejected{
    background:#f8d7da;
    color:#b02a37;
}

.recent-tickets-section{
    margin:24px 1.5rem 0;
    padding:22px 24px 10px;
    background:#fff;
    border:1px solid #e8eef5;
    border-radius:10px;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.recent-tickets-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    margin-bottom:14px;
}

.recent-tickets-title{
    margin:0;
    color:#1e293b;
    font-size:18px;
    font-weight:700;
}

.recent-tickets-link{
    color:#2962ff;
    font-size:12px;
    font-weight:600;
    text-decoration:none;
    white-space:nowrap;
}

.recent-tickets-link:hover{
    color:#0b3b75;
    text-decoration:underline;
}

.recent-tickets-table-wrap{
    overflow-x:auto;
}

.recent-tickets-table{
    width:100%;
    min-width:760px;
    margin:0;
    border-collapse:collapse;
    font-size:11px;
}

.recent-tickets-table th{
    padding:8px;
    background:#f8fafc;
    border-top:1px solid #e5e7eb;
    border-bottom:1px solid #e5e7eb;
    color:#1e293b;
    font-size:10px;
    font-weight:700;
    text-align:left;
    white-space:nowrap;
}

.recent-tickets-table td{
    padding:9px 8px;
    border-bottom:1px solid #eef2f7;
    color:#334155;
    vertical-align:middle;
    white-space:nowrap;
}

.recent-tickets-table tbody tr:hover{
    background:#f8fbff;
}

.recent-ticket-number{
    color:#0b5ed7;
    font-weight:700;
    text-decoration:none;
}

.recent-ticket-number:hover{
    text-decoration:underline;
}

.recent-ticket-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:68px;
    padding:4px 8px;
    border-radius:6px;
    font-size:10px;
    font-weight:600;
}

.recent-ticket-badge.status-review{background:#fff4d6;color:#b7791f;}
.recent-ticket-badge.status-inprogress{background:#e7f0ff;color:#2563eb;}
.recent-ticket-badge.status-resolved{background:#eee7ff;color:#7c3aed;}
.recent-ticket-badge.status-completed{background:#dff8ec;color:#15803d;}
.recent-ticket-badge.status-rejected{background:#ffe6e6;color:#dc2626;}
.recent-ticket-badge.priority-high{background:#ffe1e1;color:#dc2626;}
.recent-ticket-badge.priority-urgent{background:#ffe1e1;color:#dc2626;}
.recent-ticket-badge.priority-medium{background:#fff0d7;color:#d97706;}
.recent-ticket-badge.priority-low{background:#e5f7ed;color:#15803d;}

.recent-tickets-empty{
    padding:28px 12px;
    color:#64748b;
    text-align:center;
}

.recent-ticket-view{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:5px;
    padding:5px 9px;
    border:1px solid #cddcf5;
    border-radius:6px;
    background:#fff;
    color:#2563eb;
    font-size:10px;
    font-weight:600;
    text-decoration:none;
}

.recent-ticket-view:hover{
    border-color:#2563eb;
    background:#eaf2ff;
    color:#0b3b75;
}

@media(max-width:768px){
    .recent-tickets-section{
        margin-right:1rem;
        margin-left:1rem;
        padding-right:14px;
        padding-left:14px;
    }

    .recent-tickets-header{
        align-items:flex-start;
        flex-direction:column;
        gap:8px;
    }
}

.dashboard-filter-area{
    padding:0 2.5rem 1.25rem;
}

.dashboard-filter-summary{
    display:inline-flex;
    align-items:center;
    gap:8px;
    min-height:46px;
    padding:0 14px;
    border:1px solid #dfe6ef;
    border-radius:10px;
    background:#fff;
    color:#315b8b;
    font-size:12px;
    box-shadow:0 4px 12px rgba(15,23,42,.03);
}

.dashboard-filter-summary i{
    color:#1769e0;
    font-size:16px;
}

.dashboard-filter-panel{
    display:flex;
    align-items:center;
    gap:10px;
    min-height:64px;
    margin-top:18px;
    padding:10px 14px;
    border:1px solid #e1e7ef;
    border-radius:10px;
    background:#fff;
    box-shadow:0 8px 24px rgba(15,23,42,.04);
}

.dashboard-filter-heading{
    display:inline-flex;
    align-items:center;
    gap:8px;
    min-width:190px;
    color:#334155;
    font-size:13px;
    font-weight:700;
}

.dashboard-filter-heading i{
    color:#1769e0;
}

.dashboard-filter-fields{
    display:flex;
    justify-content:flex-end;
    align-items:center;
    gap:10px;
    flex:1;
}

.dashboard-filter-input{
    width:150px;
    height:38px;
    padding:0 10px;
    border:1px solid #dfe5ed;
    border-radius:10px;
    color:#16457b;
    font-size:12px;
    background:#fff;
}

.dashboard-filter-input:focus{
    border-color:#1769e0;
    box-shadow:0 0 0 3px rgba(23,105,224,.12);
    outline:0;
}

.dashboard-filter-apply{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:7px;
    height:38px;
    padding:0 18px;
    border:0;
    border-radius:10px;
    background:#062c52;
    color:#fff;
    font-size:12px;
    font-weight:700;
}

.dashboard-filter-apply:hover{
    background:#0b467c;
    color:#fff;
}

.dashboard-filter-clear{
    color:#64748b;
    font-size:12px;
    text-decoration:none;
    white-space:nowrap;
}

.dashboard-filter-clear:hover{
    color:#062c52;
    text-decoration:underline;
}

@media(max-width:768px){
    .dashboard-filter-area{
        padding:0 1rem 1rem;
    }

    .dashboard-filter-panel,
    .dashboard-filter-fields{
        align-items:stretch;
        flex-direction:column;
    }

    .dashboard-filter-panel{
        padding:14px;
    }

    .dashboard-filter-heading,
    .dashboard-filter-input,
    .dashboard-filter-apply{
        width:100%;
    }

    .dashboard-filter-input,
    .dashboard-filter-apply{
        height:42px;
    }

    .dashboard-filter-clear{
        text-align:center;
    }
}
</style>
<div class="dashboard-filter-area">
    <div class="dashboard-filter-summary">
        <i class="bi bi-calendar3" aria-hidden="true"></i>
        <span>
            @if(request('date_from') || request('date_to'))
                {{ request('date_from') ? \Carbon\Carbon::parse(request('date_from'))->format('M d, Y') : 'Any date' }}
                -
                {{ request('date_to') ? \Carbon\Carbon::parse(request('date_to'))->format('M d, Y') : 'Any date' }}
            @else
                All dates
            @endif
        </span>
    </div>

    <form method="GET" action="{{ route('dashboard') }}" class="dashboard-filter-panel">
        <div class="dashboard-filter-heading">
            <i class="bi bi-sliders2" aria-hidden="true"></i>
            <span>Report period</span>
        </div>
        <div class="dashboard-filter-fields">
            <label class="visually-hidden" for="date_from">Start date</label>
            <input type="date" id="date_from" name="date_from" class="dashboard-filter-input" value="{{ request('date_from') }}" aria-label="Start date">
            <label class="visually-hidden" for="date_to">End date</label>
            <input type="date" id="date_to" name="date_to" class="dashboard-filter-input" value="{{ request('date_to') }}" aria-label="End date">
            <button type="submit" class="dashboard-filter-apply">
                <i class="bi bi-funnel-fill" aria-hidden="true"></i>
                <span>Apply</span>
            </button>
            @if(request()->filled('date_from') || request()->filled('date_to'))
                <a href="{{ route('dashboard') }}" class="dashboard-filter-clear">Clear</a>
            @endif
        </div>
    </form>
</div>
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
<div class="row g-4 px-4 align-items-stretch">
    <div class="col-xl-8">
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
                </div>
                <div class="analytics-summary">
                    <span class="label">
                        Total Tickets
                        <h5 id="ticketTotal">
                            <small style="font-size: 0.3rem; margin-right:10px;">
                            @if ($ticketGrowth >= 0)
                                <span class="growth positive">
                                    <i class="bi bi-arrow-up-right">
                                    </i>
                                    +{{ abs($ticketGrowth) }}%
    
                                </span>
                           @else
                                <span class="growth negative">
                                    <i class="bi bi-arrow-down-right">
                                    </i>
                                    -{{ abs($ticketGrowth) }}%
                                </span>
                           @endif
                            </small>
                            {{ number_format($totalTickets) }}
                        </h5>                 
                        
                    </span>
                       
                </div>
            </div>
            <div class="chart-container">
                <canvas id="ticketChart"></canvas>
            </div>
            <div class="analytics-footer">
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="analytics-card pie-card">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div>
                    <h4 class="analytics-title">Tickets by Status</h4>
                    <p class="analytics-subtitle">Current ticket distribution</p>
                </div>
                <div class="text-end">
                    <div>
                        <small>Monthly Progress</small>
                    </div>
                    @if ($ticketGrowth >= 0)
                                <span class="growth positive">
                                    <i class="bi bi-arrow-up-right">
                                    </i>
                                    +{{ abs($ticketGrowth) }}%
    
                                </span>
                           @else
                                <span class="growth negative">
                                    <i class="bi bi-arrow-down-right">
                                    </i>
                                    -{{ abs($ticketGrowth) }}%
                                </span>
                    @endif
                </div>
            </div>
            @php
                $ticketStatusLabels = [
                    'inprogress' => 'In Progress',
                    'review' => 'For Review',
                    'resolved' => 'Resolved',
                    'completed' => 'Completed',
                    'rejected' => 'Rejected',
                ];

                $ticketStatusColors = [
                    'inprogress' => '#3b82f6',
                    'review' => '#f59e0b',
                    'resolved' => '#8b5cf6',
                    'completed' => '#22c55e',
                    'rejected' => '#ef4444',
                ];

                $ticketStatusTotal = array_sum($ticketStatusCounts ?? []);

                $statusKeyList = ['inprogress', 'review', 'resolved', 'completed', 'rejected'];

                $statusChangedMonthlyPercent = $statusChangedMonthlyPercent ?? [];
                $statusChangedMaxPercent = max(1, collect($statusChangedMonthlyPercent)->max('percentage') ?? 0);
            @endphp

            <div class="pie-card-body">
                <div class="pie-chart-wrap">
                    <canvas id="ticketStatusPie"></canvas>
                    <div class="pie-chart-center" aria-hidden="true">
                        <span class="pie-chart-total">{{ number_format($ticketStatusTotal) }}</span>
                        <span class="pie-chart-caption">Total tickets</span>
                    </div>
                </div>
                <div class="pie-legend">
                    @foreach($statusKeyList as $status)
                        @php
                            $count = $ticketStatusCounts[$status] ?? 0;
                        @endphp
                        <div class="pie-legend-item" title="{{ $ticketStatusLabels[$status] }}: {{ $count }} tickets">
                            <div class="pie-legend-left">
                                <span class="pie-dot" style="background: {{ $ticketStatusColors[$status] }};"></span>
                                <span class="pie-legend-name">{{ $ticketStatusLabels[$status] }}</span>
                            </div>
                            <div class="pie-legend-meta">
                                {{ $count }}
                                @if($ticketStatusTotal > 0)
                                    ({{ number_format(($count / $ticketStatusTotal) * 100, 1) }}%)
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
{{-- SLA Compliance Graph --}}
<div class="row g-4 px-4 pt-4">
    <div class="col-xl-4">
        <div class="analytics-card">

            <h4 class="analytics-title">
                Monthly SLA Compliance
            </h4>

            <div class="chart-container">
                <canvas id="slaFunnelChart"></canvas>
            </div>

        </div>
    </div>
    <div class="col-xl-4">
        <div class="analytics-card">
            <h4 class="analytics-title">
                Average Resolution Time
            </h4>
            
            <div class="chart-container">
                <canvas id="resolutionTimeChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="analytics-card">
            <h4 class="analytics-title">
                First Response Time Performance
            </h4>

            <div class="response-wrapper">
                @foreach ($firstResponseBands as $band)
                    <div class="response-item">
                        <div class="response-header">
                            <span class="response-label">
                                <span class="response-dot" style="background: {{ $band['color'] }};"></span>
                                {{ $band['label'] }}
                            </span>
                            <span class="response-meta">
                                {{ $band['count'] }} ({{ number_format($band['percent'], 1) }}%)
                            </span>
                        </div>
                        <div class="response-track">
                            <span class="response-fill" style="width: {{ $band['percent'] }}%; background: {{ $band['color'] }};"></span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
{{-- Recent Tickets --}}
<div class="row">
    <div class="col-md-12">
        <section class="recent-tickets-section" aria-labelledby="recentTicketsTitle">
            <div class="recent-tickets-header">
                <h2 class="recent-tickets-title" id="recentTicketsTitle">Recent Tickets</h2>
                <a class="recent-tickets-link" href="{{ route('tickets') }}">View All Tickets <span aria-hidden="true">&#8594;</span></a>
            </div>

            <div class="recent-tickets-table-wrap">
                <table class="recent-tickets-table">
                    <thead>
                        <tr>
                            <th scope="col">Ticket Number</th>
                            <th scope="col">Category</th>
                            <th scope="col">Requester</th>
                            <th scope="col">Status</th>
                            <th scope="col">Priority</th>
                            <th scope="col">Date Submitted</th>
                            <th scope="col">Last Updated</th>
                            <th scope="col"><span class="visually-hidden">View</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programName as $recentTicket)
                            @php
                                $status = strtolower($recentTicket->ticket_status ?? 'review');
                                $priority = strtolower($recentTicket->ticket_priority ?? 'medium');
                                $categoryLabels = [
                                    'resource' => 'Resource Person',
                                    'knowledge' => 'Knowledge Product',
                                    'completed' => 'TA on Completed Program',
                                    'enhancement' => 'TA on Program Development',
                                ];
                            @endphp
                            <tr>
                                <td>
                                    <a class="recent-ticket-number" href="{{ route('ticket.view', $recentTicket->ticket_id) }}">
                                        {{ $recentTicket->ticket_id }}
                                    </a>
                                </td>
                                <td>{{ $categoryLabels[$recentTicket->ticket_category] ?? ucfirst($recentTicket->ticket_category ?? '-') }}</td>
                                <td>{{ trim(($recentTicket->requestor_first_name ?? '') . ' ' . ($recentTicket->requestor_last_name ?? '')) ?: '-' }}</td>
                                <td><span class="recent-ticket-badge status-{{ $status }}">{{ $status === 'inprogress' ? 'In Progress' : ucfirst($status) }}</span></td>
                                <td><span class="recent-ticket-badge priority-{{ $priority }}">{{ ucfirst($priority) }}</span></td>
                                <td>{{ optional($recentTicket->created_at)->format('M d, Y g:i A') }}</td>
                                <td>{{ optional($recentTicket->updated_at)->format('M d, Y g:i A') }}</td>
                                <td class="text-end">
                                    <a class="recent-ticket-view" href="{{ route('ticket.view', $recentTicket->ticket_id) }}" aria-label="View {{ $recentTicket->ticket_id }}">
                                        <i class="bi bi-eye" aria-hidden="true"></i>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="recent-tickets-empty" colspan="8">No recent tickets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
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
                    <div class="dashboard-ticket-search">
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
                            <option value="rejected">Rejected</option>
                        </select>

                        <select class="form-select" id="category">
                            <option value="">Category</option>
                            <option value="completed">Technical Assistance on Completed Program</option>
                            <option value="enhancement">Technical Assistance on Development of Program</option>
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
                            <span class="status status-progress justify-content-center" style="font-size: 0.7rem;">
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
                                <a href="/tickets/${ticket.ticket_id}" class="btn btn-light">
                                    <i class="bi bi-eye"></i>
                                    View Details
                                </a>
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
                

            </div>

        </div>

        </div>

<script>

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

</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('resolutionTimeChart');

    if (!canvas) {
        return;
    }

    const monthlyAverageResolution = @json($monthlyAverageResolution);
    const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const monthMap = Object.fromEntries(monthLabels.map((month, index) => [month, index]));
    const fullYearAverage = new Array(12).fill(0);

    monthlyAverageResolution.forEach((item) => {
        const rawMonth = String(item.month ?? '').trim();
        const monthKey = rawMonth.slice(0, 3);
        const monthIndex = monthMap[monthKey] ?? ((Number(rawMonth) >= 1 && Number(rawMonth) <= 12) ? Number(rawMonth) - 1 : null);

        if (monthIndex !== null && monthIndex !== undefined) {
            fullYearAverage[monthIndex] = Number(item.days ?? 0);
        }
    });

    const existingChart = window.Chart.getChart(canvas);

    if (existingChart) {
        existingChart.destroy();
    }

    new window.Chart(canvas, {
        type: 'bar',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Average Resolution Time',
                data: fullYearAverage,
                backgroundColor: 'rgba(14, 165, 164, .72)',
                borderColor: '#0f766e',
                borderWidth: 1,
                borderRadius: 7,
                borderSkipped: false,
                barPercentage: .68,
                categoryPercentage: .72
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
                    padding: 12,
                    displayColors: false,
                    cornerRadius: 12,
                    callbacks: {
                        label: function (context) {
                            return context.parsed.y + ' Days';
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
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('ticketStatusPie');

    if (!canvas) {
        return;
    }

    const statusCounts = @json($ticketStatusCounts);
    const statusLabels = {
        inprogress: 'In Progress',
        review: 'For Review',
        resolved: 'Resolved',
        completed: 'Completed',
        rejected: 'Rejected'
    };

    const statusColors = {
        inprogress: '#3b82f6',
        review: '#f59e0b',
        resolved: '#8b5cf6',
        completed: '#22c55e',
        rejected: '#ef4444'
    };

    const statusKeys = ['inprogress', 'review', 'resolved', 'completed', 'rejected'];

    const existingChart = window.Chart.getChart(canvas);

    if (existingChart) {
        existingChart.destroy();
    }

    new window.Chart(canvas, {
        type: 'doughnut',
        data: {
            labels: statusKeys.map((key) => statusLabels[key]),
            datasets: [{
                data: statusKeys.map((key) => statusCounts[key] ?? 0),
                backgroundColor: statusKeys.map((key) => statusColors[key]),
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '62%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 12,
                    displayColors: false,
                    cornerRadius: 12,
                    callbacks: {
                        label: function (context) {
                                    const total = context.dataset.data.reduce((sum, value) => sum + value, 0);
                                    const percentage = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : '0.0';
                                    return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('slaFunnelChart');

    if (!canvas) {
        return;
    }

    const monthlySla = @json($monthlySla);
    const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const monthMap = Object.fromEntries(monthLabels.map((month, index) => [month, index]));
    const fullYearSla = new Array(12).fill(0);

    monthlySla.forEach((item) => {
        const rawMonth = String(item.month ?? '').trim();

        // Accept month formats like "Jan", "January", or numeric month values.
        const monthKey = rawMonth.slice(0, 3);
        const monthIndex = monthMap[monthKey] ?? ((Number(rawMonth) >= 1 && Number(rawMonth) <= 12) ? Number(rawMonth) - 1 : null);

        if (monthIndex !== null && monthIndex !== undefined) {
            fullYearSla[monthIndex] = Number(item.percentage ?? 0);
        }
    });

    const existingChart = window.Chart.getChart(canvas);

    if (existingChart) {
        existingChart.destroy();
    }

    new window.Chart(canvas, {
        type: 'radar',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Monthly SLA (%)',
                data: fullYearSla,
                backgroundColor: 'rgba(245,158,11,0.18)',
                borderColor: '#d97706',
                borderWidth: 2,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#d97706',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 12,
                    displayColors: false,
                    cornerRadius: 10,
                    callbacks: {
                        label: function (context) {
                            return context.label + ': ' + (context.parsed.r ?? context.raw) + '%';
                        }
                    }
                }
            },
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 20,
                        color: '#64748b',
                        backdropColor: 'transparent',
                        callback: function (value) {
                            return value + '%';
                        }
                    },
                    grid: {
                        color: 'rgba(148,163,184,.2)'
                    },
                    angleLines: {
                        color: 'rgba(148,163,184,.2)'
                    },
                    pointLabels: {
                        color: '#64748b',
                        font: {
                            size: 11,
                            weight: '600'
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection