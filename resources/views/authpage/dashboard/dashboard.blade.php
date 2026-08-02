@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
   .metric-card{
    background:#fff;
    border-radius:20px;
    padding:24px 20px;
    min-height:190px;
    max-height:200px;

    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;

    text-align:center;

    border:1px solid #edf2f7;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
    transition:.3s;
}

.metric-card:hover{
    cursor:pointer;
    transform:translateY(-6px);
    border-color:#062c52;
    box-shadow:0 14px 35px rgba(15,23,42,.12);
}

.metric-header{
    width:100%;
    display:flex;
    justify-content:center;
    margin-bottom:12px;
}

.metric-title{
    font-size:.9rem;
    font-weight:600;
    color:#64748b;
    line-height:1.4;
}

.metric-title{
    font-size:1rem;
    font-weight:600;
    color:#49627d;
    line-height:1.35;
    min-height:54px;      /* keeps every card aligned */
}

.metric-icon{
    width:60px;
    height:60px;
    border-radius:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    align-self:flex-start; /* icon stays on left */
}

.metric-icon i{
    font-size:28px;
}

.metric-number{
    font-size:3rem;
    font-weight:700;
    color:#062c52;
    line-height:1;
    margin:8px 0;
}

.metric-unit{

    font-size:20px;

    font-weight:500;

    color:#64748b;

    margin-left:6px;

}

.metric-footer{
    font-size:.82rem;
    color:#94a3b8;
    margin-top:12px;
}

/* Hover footer */

.metric-card:hover .metric-footer{

    color:#062c52;

}

.metric-body{

    min-height:150px;

    display:flex;

    flex-direction:column;

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

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="modalMetricsLabel">
                    </h5>

                    <button class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body d-none" id="totalTicketBody">
                    <table>
                        <thead class="table-light">
                            <tr>                            
                                <th class="p-2">Ticket Number</th>
                                <th class="p-2">Ticket Category</th>
                                <th class="p-2">Ticket Program</th>
                                <th class="p-2">Request Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>TEST number<strong></td>
                                <td>TEST category</td>
                                <td>TEST program</td>
                                <td>TEST description</td>
                            </tr>
                        </tbody>
                    </table>

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
</script>
@endsection