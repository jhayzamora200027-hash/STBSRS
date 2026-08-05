@extends('layouts.app')

@section('title', 'ViewTicket')

@section('content')
<style>
.back-btn{
    display: inline-flex;
    align-items: center;
    gap: .6rem;
    background: #fff;
    color: #212529;
    text-decoration: none;
    border: 1px solid #e9ecef;
    border-radius: 50px;
    font-weight: 600;
    box-shadow: 0 .25rem .75rem rgba(0,0,0,.08);
    transition: all .3s ease;
    overflow: hidden;
}

.back-btn i{
    font-size: 1.1rem;
    transition: transform .3s ease;
}

.back-btn:hover{
    background: #0d6efd;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 .75rem 1.5rem rgba(13,110,253,.25);
}

.back-btn:hover i{
    transform: translateX(-6px);
}

.back-btn:active{
    transform: scale(.96);
}

.back-btn::after{
    content:'';
    position:absolute;
    width:0;
    height:100%;
    left:0;
    top:0;
    background:rgba(255,255,255,.15);
    transition:width .4s ease;
}

.back-btn{
    position:relative;
}

.back-btn:hover::after{
    width:100%;
}

.copy-ticket{
    transition: all .2 ease;
}

.copy-ticket:hover{
    transform: scale(1.1);
    color: #fff;
}
.tab-buttons:hover{
    transform: scale(1.1);
    color:#0d6efd;
}
.ticket-tabs{

    position:relative;

    display:flex;

    background:#fff;

    border-radius:16px;

    padding:8px;

    border:1px solid #e5e7eb;

    box-shadow:0 8px 25px rgba(0,0,0,.05);

    overflow:hidden;

}

.ticket-tab{

    flex:1;

    position:relative;

    z-index:2;

    border:none;

    background:transparent;

    padding:15px 20px;

    border-radius:12px;

    color:#64748b;

    font-weight:600;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:10px;

    transition:.35s ease;

}

.ticket-tab i{

    font-size:18px;

}

.ticket-tab:hover{

    color:#2563eb;

    transform:translateY(-2px);

}

.ticket-tab.active{

    color:#2563eb;

}

.tab-indicator{

    position:absolute;

    top:8px;

    left:8px;

    width:calc(25% - 10px);

    height:calc(100% - 16px);

    background:#EEF4FF;

    border-radius:12px;

    transition:.35s cubic-bezier(.4,0,.2,1);

    z-index:1;

}

.request-card{

    border-radius:20px;

    overflow:hidden;

    background:#fff;

}

.request-header{

    padding:25px 30px;

    background:linear-gradient(135deg,#2563eb,#1d4ed8);

    color:#fff;

}

.request-icon{

    width:60px;

    height:60px;

    border-radius:16px;

    background:rgba(255,255,255,.15);

    display:flex;

    justify-content:center;

    align-items:center;

    backdrop-filter:blur(10px);

}

.request-icon i{

    font-size:28px;

}

.info-box{

    background:#f8fafc;

    border:1px solid #e5e7eb;

    border-radius:16px;

    padding:22px;

    transition:.3s;

}

.info-box:hover{

    transform:translateY(-3px);

    box-shadow:0 10px 25px rgba(0,0,0,.06);

}

.info-title{

    display:flex;

    align-items:center;

    gap:10px;

    color:#2563eb;

    font-weight:700;

    margin-bottom:15px;

}

.info-title i{

    font-size:20px;

}

.info-content{

    color:#334155;

    font-size:15px;

    line-height:1.8;

}

/* =========================================================
   A4 PRINTABLE DOCUMENT
   STB Service Request System
========================================================= */

.a4-document{

    width:210mm;
    min-height:297mm;

    margin:0 auto;

    background:#ffffff;

    padding:18mm;

    box-sizing:border-box;

    font-family:"Segoe UI", Arial, sans-serif;

    color:#222;

    box-shadow:0 15px 40px rgba(0,0,0,.15);

    border-radius:8px;

}

/* =========================================================
HEADER
========================================================= */

.document-header{

    margin-bottom:20px;

}

.document-header img{

    max-width:70px;

}

.document-header h5{

    font-size:18px;

    font-weight:700;

    margin-bottom:3px;

}

.document-header h6{

    font-size:13px;

    margin-bottom:2px;

}

.document-header span{

    font-size:13px;

    color:#555;

}

.document-header small{

    color:#777;

    font-size:12px;

}

/* =========================================================
TITLE
========================================================= */

.a4-document h3{

    font-size:22px;

    font-weight:700;

    letter-spacing:1px;

    margin-bottom:5px;

}

/* =========================================================
SECTION TITLE
========================================================= */

.section-title{

    margin-top:28px;

    margin-bottom:12px;

    padding:10px 15px;

    background:#0d6efd;

    color:#fff;

    font-size:15px;

    font-weight:600;

    border-radius:6px;

}

/* =========================================================
TABLES
========================================================= */

.a4-document table{

    width:100%;

    border-collapse:collapse;

    margin-bottom:18px;

}

.a4-document table th{

    background:#f5f7fa;

    font-weight:600;

    color:#374151;

    width:28%;

}

.a4-document table th,
.a4-document table td{

    border:1px solid #d7dde7;

    padding:10px 12px;

    vertical-align:top;

    font-size:13px;

    line-height:1.6;

}

.a4-document table td{

    background:#fff;

}

/* =========================================================
FOOTER
========================================================= */

.document-footer{

    margin-top:50px;

    font-size:11px;

    color:#666;

}

.document-footer hr{

    margin-bottom:12px;

}

/* =========================================================
LINES
========================================================= */

hr{

    border:0;

    border-top:1px solid #d9d9d9;

}

/* =========================================================
PRINT PREVIEW
========================================================= */

.print-preview{

    background:#eef2f7;

    padding:30px;

    border-radius:15px;

    overflow:auto;

    max-height:900px;

}

.print-preview .a4-document{

    transform:scale(.42);

    transform-origin:top center;

    margin-bottom:-170mm;

}

/* =========================================================
PRINT BUTTON
========================================================= */

#printBtn{

    border-radius:10px;

    padding:8px 18px;

    font-weight:600;

}

/* =========================================================
PRINT
========================================================= */

@page{

    size:A4 portrait;

    margin:12mm;

}

@media print{

    html,
    body{

        background:#fff !important;

        margin:0;

        padding:0;

        width:210mm;

        height:297mm;

    }

    body *{

        visibility:hidden !important;

    }

    #printArea,
    #printArea *{

        visibility:visible !important;

    }

    #printArea{

        position:absolute;

        left:0;

        top:0;

        width:210mm;

        min-height:297mm;

        margin:0;

        padding:15mm;

        transform:none !important;

        box-shadow:none !important;

        border-radius:0;

        background:#fff;

    }

    .print-preview{

    display:flex;

    justify-content:center;

    align-items:flex-start;

    background:#eef3f8;

    padding:25px;

    border-radius:18px;

    overflow:hidden;

}
.print-preview .a4-document{

    transform:scale(.34);

    transform-origin:top center;

    margin-bottom:-195mm;

}

    #printBtn{

        display:none !important;

    }

    .card{

        border:none !important;

        box-shadow:none !important;

    }

}

/* =========================================================
RESPONSIVE PREVIEW
========================================================= */

@media(max-width:1200px){

    .print-preview .a4-document{

        transform:scale(.32);

        margin-bottom:-195mm;

    }

}

@media(max-width:992px){

    .print-preview{

        display:none;

    }

}

</style>
<div class="p-2">
    <a href="{{ route('tickets') }}" class="btn back-btn border shadow-sm rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i>
        Back to tickets
    </a>
</div>
<div class="p-2">
    
    <h4>
        Ticket Details
    </h4>
    <div class="mb-2">
        <small>View the status and details of request.</small>
    </div>
    <div class="row">
    <div class="col-md-12 mb-3">
        <div class="ticket-tabs mt-4">

            <button class="ticket-tab active" id="btnRequestInfo">
                <i class="bi bi-file-earmark-text"></i>
                <span>Request Information</span>
            </button>

            <button class="ticket-tab" id="btnComment">
                <i class="bi bi-chat-dots"></i>
                <span>Comments</span>
            </button>

            <button class="ticket-tab" id="btnHistory">
                <i class="bi bi-clock-history"></i>
                <span>History</span>
            </button>

            <button class="ticket-tab" id="btnPrint">
                <i class="bi bi-printer"></i>
                <span>Print</span>
            </button>

            <div class="tab-indicator"></div>

        </div>
    </div>
</div>
<div class="row" id="requestInformationBody">
    <div class="col-xl-8 col-lg-7">

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-start mb-4">

                    <div class="d-flex align-items-center">

                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:65px;height:65px;background:#EEF4FF;">
                            <i class="bi bi-ticket-detailed-fill text-primary fs-2"></i>
                        </div>

                        <div class="ms-3">

                            <small class="text-muted">
                                Ticket Number
                            </small>

                            <h3 class="fw-bold mb-1">

                                {{ $ticket->ticket_id }}

                                <i class="bi bi-copy copy-ticket text-muted ms-2"
                                   role="button"
                                   data-ticket="{{ $ticket->ticket_id }}"
                                   title="Copy Ticket Number"></i>

                            </h3>

                            <small class="text-muted">
                                Created {{ $ticket->created_at->format('F d, Y h:i A') }}
                            </small>

                        </div>

                    </div>

                    <div>

                        @switch($ticket->ticket_status)

                            @case('review')
                                <span class="badge rounded-pill bg-light text-dark border px-4 py-2">
                                    <i class="bi bi-hourglass me-1"></i>
                                    For Review
                                </span>
                            @break

                            @case('inprogress')
                                <span class="badge rounded-pill bg-primary px-4 py-2">
                                    <i class="bi bi-arrow-repeat me-1"></i>
                                    In Progress
                                </span>
                            @break

                            @case('resolved')
                                <span class="badge rounded-pill bg-warning text-dark px-4 py-2">
                                    <i class="bi bi-check2-circle me-1"></i>
                                    Resolved
                                </span>
                            @break

                            @case('completed')
                                <span class="badge rounded-pill bg-success px-4 py-2">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Completed
                                </span>
                            @break

                            @case('rejected')
                                <span class="badge rounded-pill bg-danger px-4 py-2">
                                    <i class="bi bi-x-circle me-1"></i>
                                    Rejected
                                </span>
                            @break

                        @endswitch

                    </div>

                </div>

                <hr>

                <div class="row mt-4">

                    <!-- LEFT -->
                    <div class="col-md-6 border-end">

                        <div class="mb-4">

                            <small class="text-muted">
                                <i class="bi bi-grid me-1"></i>
                                Category
                            </small>

                            <h6 class="fw-semibold mt-2">

                                @switch($ticket->ticket_category)

                                    @case('enhance')
                                        Technical Assistance on Program Development
                                    @break

                                    @case('completed')
                                        Technical Assistance on Completed Program
                                    @break

                                    @case('resource')
                                        Resource Person
                                    @break

                                    @case('knowledge')
                                        Knowledge Product
                                    @break

                                @endswitch

                            </h6>

                        </div>

                        <div class="mb-4">

                            <small class="text-muted">
                                <i class="bi bi-diagram-3 me-1"></i>
                                Program
                            </small>

                            <h6 class="fw-semibold mt-2">
                                {{ optional($ticket->programDetails)->program ?? '-' }}
                            </h6>

                        </div>

                        <div class="row">

                            <div class="col-6">

                                <small class="text-muted">
                                    <i class="bi bi-flag me-1"></i>
                                    Priority
                                </small>

                                <div class="mt-2">

                                    @switch($ticket->ticket_priority)

                                        @case('low')
                                            <span class="badge bg-success px-3 py-2">
                                                Low
                                            </span>
                                        @break

                                        @case('medium')
                                            <span class="badge bg-warning text-dark px-3 py-2">
                                                Medium
                                            </span>
                                        @break

                                        @case('high')
                                            <span class="badge bg-primary px-3 py-2">
                                                High
                                            </span>
                                        @break

                                        @case('urgent')
                                            <span class="badge bg-danger px-3 py-2">
                                                Urgent
                                            </span>
                                        @break

                                    @endswitch

                                </div>

                            </div>

                            <div class="col-6">

                                <small class="text-muted">
                                    <i class="bi bi-check2-square me-1"></i>
                                    Current Status
                                </small>

                                <div class="mt-2">

                                    @switch($ticket->ticket_status)

                                        @case('review')
                                            <span class="badge bg-light text-dark border px-3 py-2">
                                                For Review
                                            </span>
                                        @break

                                        @case('inprogress')
                                            <span class="badge bg-info px-3 py-2">
                                                In Progress
                                            </span>
                                        @break

                                        @case('resolved')
                                            <span class="badge bg-warning text-dark px-3 py-2">
                                                Resolved
                                            </span>
                                        @break

                                        @case('completed')
                                            <span class="badge bg-success px-3 py-2">
                                                Completed
                                            </span>
                                        @break

                                        @case('rejected')
                                            <span class="badge bg-danger px-3 py-2">
                                                Rejected
                                            </span>
                                        @break

                                    @endswitch

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div class="col-md-6 ps-md-4">

                        <div class="card bg-light border-0 rounded-4">

                            <div class="card-body">

                                <h6 class="fw-bold mb-4">

                                    <i class="bi bi-person-circle me-2"></i>

                                    Requester Information

                                </h6>

                                <div class="mb-3">

                                    <small class="text-muted">
                                        Full Name
                                    </small>

                                    <h6 class="mb-0">

                                        {{ $ticket->requestor_first_name }}

                                        @if(!empty($ticket->requestor_middle_name))
                                            {{ strtoupper(substr($ticket->requestor_middle_name,0,1)) }}.
                                        @endif

                                        {{ $ticket->requestor_last_name }}

                                    </h6>

                                </div>

                                <div class="mb-3">

                                    <small class="text-muted">
                                        Email Address
                                    </small>

                                    <div>

                                        <i class="bi bi-envelope text-primary me-2"></i>

                                        {{ $ticket->requestor_email }}

                                    </div>

                                </div>

                                <div class="mb-3">

                                    <small class="text-muted">
                                        Location
                                    </small>

                                    <div>

                                        <i class="bi bi-geo-alt text-danger me-2"></i>

                                        {{ $ticket->requestRegion->name }},
                                        {{ $ticket->requestProvince->name }},
                                        {{ $ticket->requestCity->name }}

                                    </div>

                                </div>

                                <div>

                                    <small class="text-muted">
                                        Date Submitted
                                    </small>

                                    <div>

                                        <i class="bi bi-calendar-event text-success me-2"></i>

                                        {{ $ticket->created_at->format('F d, Y h:i A') }}

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>

    <div class="col-xl-4 col-lg-5">

        <div class="card request-card border-0 shadow-sm">


            <div class="request-header">

                <div class="d-flex align-items-center">

                    <div class="request-icon">

                        <i class="bi bi-file-earmark-text-fill"></i>

                    </div>

                    <div class="ms-3">

                        <h4 class="mb-1 fw-bold">
                            Request Information
                        </h4>

                        <small class="mb-1">
                            Details submitted by the requester
                        </small>

                    </div>

                </div>

            </div>

            <div class="card-body p-4">

                <!-- Purpose -->

                <div class="info-box mb-4">

                    <div class="info-title">

                        <i class="bi bi-chat-left-text"></i>

                        Purpose of Request

                    </div>

                    <div class="info-content">

                        {{ $ticket->purpose_of_request }}

                    </div>

                </div>

                @if($ticket->ticket_category === 'knowledge')

                <div class="row g-4">

                    <div class="col-md-6">

                        <div class="info-box h-100">

                            <div class="info-title">

                                <i class="bi bi-folder2-open"></i>

                                Document Type

                            </div>

                            <div class="info-content">

                                {{ $ticket->document_type ?? '-' }}

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="info-box h-100">

                            <div class="info-title">

                                <i class="bi bi-journal-bookmark"></i>

                                Knowledge Product Requested

                            </div>

                            <div class="info-content">

                                {{ $ticket->knowledge_product ?? '-' }}

                            </div>

                        </div>

                    </div>

                </div>

                @endif


                @if($ticket->ticket_category === 'completed')

                <div class="info-box mt-4">

                    <div class="info-title">

                        <i class="bi bi-diagram-3"></i>

                        Program

                    </div>

                    <div class="info-content">

                        {{ optional($ticket->programDetails)->program ?? '-' }}

                    </div>

                </div>

                @endif

            </div>

        </div>

    </div>
</div>

    <div id="printBody" class="d-none mt-3">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <strong>Printable A4 Preview</strong>
            </div>
            <div>
                <button id="printBtn" class="btn btn-sm btn-primary">Print</button>
            </div>
        </div>

        <div id="printArea" class="a4-document">


    <div class="document-header">

        <table width="100%">
            <tr>

                <td style="width:250px; text-align:center; vertical-align:middle; border:none">
                    <img src="{{ asset('images/logo/DSWD STB Bagong Pil logo.png') }}"
                        style="width:250px; max-width:100%; height:auto; display:block; margin:auto;">
                </td>

                <td class="text-center" style="border:none">

                    <h6 class="mb-0">
                        Republic of the Philippines
                    </h6>

                    <h5 class="fw-bold mb-0">
                        SOCIAL TECHNOLOGY BUREAU
                    </h5>

                    <span>
                        Department of Social Welfare and Development
                    </span>

                    <br>

                    <small>
                        iSTAksyon System
                    </small>

                </td>

            </tr>
        </table>

    </div>

    <hr>


    <div class="text-center mb-4">

        <h3 class="fw-bold">
            SERVICE REQUEST FORM
        </h3>

        <small class="text-muted">
            Printable Copy
        </small>

    </div>


    <table class="table table-bordered">

        <tr>

            <th width="25%">
                Ticket Number
            </th>

            <td width="25%">
                {{ $ticket->ticket_id }}
            </td>

            <th width="25%">
                Date Submitted
            </th>

            <td>

                {{ $ticket->created_at->format('F d, Y h:i A') }}

            </td>

        </tr>

        <tr>

            <th>
                Status
            </th>

            <td>

                {{ ucwords($ticket->ticket_status) }}

            </td>

            <th>
                Priority
            </th>

            <td>

                {{ ucfirst($ticket->ticket_priority) }}

            </td>

        </tr>

        <tr>

            <th>
                Category
            </th>

            <td colspan="3">

                @switch($ticket->ticket_category)

                    @case('enhance')

                        Technical Assistance on Program Development

                    @break

                    @case('completed')

                        Technical Assistance on Completed Program

                    @break

                    @case('resource')

                        Resource Person

                    @break

                    @case('knowledge')

                        Knowledge Product

                    @break

                @endswitch

            </td>

        </tr>

        <tr>

            <th>

                Program

            </th>

            <td colspan="3">

                {{ optional($ticket->programDetails)->program ?? '-' }}

            </td>

        </tr>

    </table>




    <h5 class="section-title">

        Requester Information

    </h5>

    <table class="table table-bordered">

        <tr>

            <th width="25%">
                Full Name
            </th>

            <td>

                {{ $ticket->requestor_first_name }}

                @if(!empty($ticket->requestor_middle_name))
                    {{ strtoupper(substr($ticket->requestor_middle_name,0,1)) }}.
                @endif

                {{ $ticket->requestor_last_name }}

            </td>

        </tr>

        <tr>

            <th>

                Email Address

            </th>

            <td>

                {{ $ticket->requestor_email }}

            </td>

        </tr>

        <tr>

            <th>

                Region

            </th>

            <td>

                {{ $ticket->requestRegion->name }}

            </td>

        </tr>

        <tr>

            <th>

                Province

            </th>

            <td>

                {{ $ticket->requestProvince->name }}

            </td>

        </tr>

        <tr>

            <th>

                City / Municipality

            </th>

            <td>

                {{ $ticket->requestCity->name }}

            </td>

        </tr>

    </table>




    <h5 class="section-title">

        Request Details

    </h5>

    <table class="table table-bordered">

        <tr>

            <th width="25%">
                Purpose of Request
            </th>

            <td style="height:120px;">

                {!! nl2br(e($ticket->purpose_of_request)) !!}

            </td>

        </tr>

    </table>



    <!-- ===================== KNOWLEDGE PRODUCT ===================== -->

    @if($ticket->ticket_category == 'knowledge')

    <h5 class="section-title">

        Knowledge Product Details

    </h5>

    <table class="table table-bordered">

        <tr>

            <th width="25%">
                Document Type
            </th>

            <td>

                {{ $ticket->document_type ?? '-' }}

            </td>

        </tr>

        <tr>

            <th>

                Knowledge Product Requested

            </th>

            <td>

                {{ $ticket->knowledge_product ?? '-' }}

            </td>

        </tr>

    </table>

    @endif



    <!-- ===================== REMARKS ===================== -->

    <h5 class="section-title">

        Remarks

    </h5>

    <table class="table table-bordered">

        <tr>

            <td style="height:120px;"></td>

        </tr>

    </table>



    <!-- ===================== SIGNATURES ===================== -->

    <br><br>

    <table width="100%">

        <tr>

            <td width="45%" align="center">

                _______________________________

                <br>

                <strong>iSTAksyon Personnel</strong>

            </td>


            <td width="45%" align="center">

                _______________________________

                <br>

                <strong>Receiving Personnel</strong>

            </td>

        </tr>

    </table>



    <!-- ===================== FOOTER ===================== -->

    <div class="document-footer">

        <hr>

        <table width="100%">

            <tr>

                <td>

                    Generated by

                    <strong>

                        STB Service Request System

                    </strong>

                </td>

                <td align="right">

                    Printed on

                    {{ now()->format('F d, Y h:i A') }}

                </td>

            </tr>

        </table>

    </div>

            </div>
        </div>
    </div>

</div>

    
    
    <div id="commentBody" class="d-none mt-3">commentBody</div>
    <div id="historyBody" class="d-none mt-3">historyBody</div>
</div>
<script>
    document.querySelector('.copy-ticket').addEventListener('click', async function(){
        const ticketNumber = this.dataset.ticket;

        try{
            await navigator.clipboard.writeText(ticketNumber);

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Ticket number copied!',
                showConfirmButton: false,
                timer: 1800,
                timerProgressBar: true
            });
        } catch (err){
            Swal.fure({
                icon: 'error',
                title: 'Copy failed',
                text: 'Unable to copy the ticket number.'
            });
        }
    });

    document.getElementById('btnRequestInfo').addEventListener('click', function(){
        document.getElementById('requestInformationBody').classList.remove('d-none')
        document.getElementById('commentBody').classList.add('d-none');
        document.getElementById('historyBody').classList.add('d-none');
        document.getElementById('printBody').classList.add('d-none');
    });

    document.getElementById('btnComment').addEventListener('click', function(){
        document.getElementById('requestInformationBody').classList.add('d-none')
        document.getElementById('commentBody').classList.remove('d-none');
        document.getElementById('historyBody').classList.add('d-none');
        document.getElementById('printBody').classList.add('d-none');
    });

    document.getElementById('btnHistory').addEventListener('click', function(){
        document.getElementById('requestInformationBody').classList.add('d-none')
        document.getElementById('commentBody').classList.add('d-none');
        document.getElementById('historyBody').classList.remove('d-none');
        document.getElementById('printBody').classList.add('d-none');
    });

    document.getElementById('btnPrint').addEventListener('click', function(){
        document.getElementById('requestInformationBody').classList.add('d-none')
        document.getElementById('commentBody').classList.add('d-none');
        document.getElementById('historyBody').classList.add('d-none');
        document.getElementById('printBody').classList.remove('d-none');
    });

    const tabs = document.querySelectorAll('.ticket-tab');
    const indicator = document.querySelector('.tab-indicator');

    tabs.forEach((tab, index) => {

        tab.addEventListener('click', function () {

            tabs.forEach(t => t.classList.remove('active'));

            this.classList.add('active');

            indicator.style.transform = `translateX(${index * 100}%)`;

        });

    });

    // Print handler for printable A4 panel
    const printBtn = document.getElementById('printBtn');
    if(printBtn){
        printBtn.addEventListener('click', function(){
            window.print();
        });
    }
</script>
@endsection