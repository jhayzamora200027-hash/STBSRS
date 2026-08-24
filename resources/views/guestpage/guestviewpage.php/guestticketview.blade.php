@extends('layouts.app')

@section('title', 'GuestViewTicket')

@section('content')

<style>
    .section-icon {
    width:45px;
    height:45px;
    border-radius:50%;
    background:#e8eeff;
    color:#000099;
    display:flex;
    align-items:center;
    justify-content:center;
}

.section-icon i {
    font-size:22px;
}


.info-box {
    background:#f8f9fa;
    border-radius:14px;
    padding:15px;
    height:100%;
    border:1px solid #f0f0f0;
}


.info-box label {
    display:block;
    font-size:.78rem;
    color:#6c757d;
    margin-bottom:6px;
}


.info-box span,
.info-box p {
    font-size:.95rem;
    font-weight:500;
}

.summary-item {
    display:flex;
    align-items:center;
    gap:15px;

    padding:15px;
    height:100%;

    border:1px solid #eeeeee;
    border-radius:14px;
    background:#fff;
}


.summary-icon {
    width:55px;
    height:55px;

    border-radius:50%;

    display:flex;
    align-items:center;
    justify-content:center;

    flex-shrink:0;

    background:#e8efff;
    color:#000099;
}


.summary-icon.success {
    background:#e9ffe8;
    color:#059900;
}


.summary-icon i {
    font-size:24px;
}


.summary-content {
    min-width:0;
    flex:1;
}


.summary-content h6 {
    font-size:.95rem;
    font-weight:600;
}


.email-text {
    display:block;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}


@media(max-width:768px){

    .summary-item {
        padding:12px;
    }

}

.summary-icon {
    width:55px;
    height:55px;

    border-radius:50%;

    display:flex;
    justify-content:center;
    align-items:center;

    background:#e8eeff;
    color:#000099;

    flex-shrink:0;
}


.summary-icon i {
    font-size:24px;
}



.ticket-number-box {
    padding:15px;
    border-radius:12px;
    background:#f8f9fa;
    border:1px solid #eeeeee;
    width:100%;
}



.ticket-number-box h5 {

    width:250px;

    max-width:250px;

    overflow:hidden;

    text-overflow:ellipsis;

    white-space:nowrap;

}
.ticket-summary-card {
    min-height: 300px;
}
.ticket-id-wrapper {

    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:10px;

}
.ticket-id {

    font-size:1.1rem;
    font-weight:700;

    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;

    max-width:230px;

}
.copy-btn {
    flex-shrink:0;
}
.status-timeline {
    position: relative;
    padding-left: 5px;
}

/* Individual step */
.status-step {
    position: relative;
    display: flex;
    gap: 18px;
    min-height: 70px;
    padding: 5px 12px 5px 0;
}

/* Vertical dashed line */
.status-step:not(:last-child)::after {
    content: "";
    position: absolute;

    left: 17px;
    top: 38px;
    bottom: -5px;

    border-left: 2px dashed #d1d5db;
}

/* Icon */
.status-icon {
    position: relative;
    z-index: 2;

    width: 36px;
    height: 36px;

    min-width: 36px;

    border-radius: 50%;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #f1f1f1;
    color: #777;

    font-size: 17px;
}

/* Completed */
.status-step.completed .status-icon {
    background: #4f7df3;
    color: #fff;
}

.status-step.completed::after {
    border-color: #4f7df3;
}

/* Active */
.status-step.active {
    background: #edf4ff;
    border-radius: 10px;
}

.status-step.active .status-icon {
    background: #073b91;
    color: #fff;
}

.status-step.active::after {
    border-color: #4f7df3;
}

/* Content */
.status-content {
    flex: 1;
    padding-top: 1px;
}

.status-content h6 {
    margin: 0 0 2px;
    font-size: 15px;
    font-weight: 500;
    color: #111827;
}

.status-date {
    display: block;
    font-size: 11px;
    color: #777;
    line-height: 1.2;
}

.status-content p {
    margin: 1px 0 0;
    font-size: 12px;
    color: #777;
    line-height: 1.3;
}
</style>
<div class=" p-5 ">
    <div class="row">
        <h3>Ticket Details</h3>
    </div>
    {{-- HEADER --}}
    <div class="row">
        <div class="col-xl-8 col-lg-12 pt-3">

            <div class="card border-0 shadow-sm w-100 h-100">
                <div class="card-body">

                    <div class="row g-3">

                        {{-- REQUESTOR --}}
                        <div class="col-md-4">

                            <div class="summary-item">

                                <div class="summary-icon">
                                    <i class="bi bi-person"></i>
                                </div>


                                <div class="summary-content">

                                    <small class="text-muted">
                                        Requested by
                                    </small>

                                    <h6 class="mb-1 text-truncate"
                                        title="{{ $ticket->requestor_first_name }} {{ $ticket->requestor_last_name }}">
                                        
                                        {{ ucwords($ticket->requestor_first_name) }}
                                        {{ $ticket->requestor_middle_name 
                                            ? Str::upper(Str::substr($ticket->requestor_middle_name,0,1)).'.' 
                                            : '' 
                                        }}
                                        {{ ucwords($ticket->requestor_last_name) }}

                                    </h6>


                                    <small class="text-muted email-text">
                                        <i class="bi bi-envelope me-1"></i>
                                        {{ $ticket->requestor_email }}
                                    </small>

                                </div>

                            </div>

                        </div>



                        {{-- DATE SUBMITTED --}}
                        <div class="col-md-4">

                            <div class="summary-item">

                                <div class="summary-icon">
                                    <i class="bi bi-calendar-event"></i>
                                </div>


                                <div class="summary-content">

                                    <small class="text-muted">
                                        Date Submitted
                                    </small>

                                    <h6 class="mb-1">
                                        {{ $ticket->created_at->format('F d, Y') }}
                                    </h6>

                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $ticket->created_at->format('h:i A') }}
                                    </small>

                                </div>

                            </div>

                        </div>




                        {{-- LAST UPDATED --}}
                        <div class="col-md-4">

                            <div class="summary-item">

                                <div class="summary-icon success">
                                    <i class="bi bi-clock-history"></i>
                                </div>


                                <div class="summary-content">

                                    <small class="text-muted">
                                        Last Updated
                                    </small>

                                    <h6 class="mb-1">
                                        {{ $ticket->updated_at->format('F d, Y') }}
                                    </h6>

                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $ticket->updated_at->format('h:i A') }}
                                    </small>

                                </div>

                            </div>

                        </div>


                    </div>

                </div>
            </div>

        </div>
        <div class="col-xl-4 col-lg-12 mt-3 mt-xl-0 pt-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    {{-- HEADER --}}
                    <div class="d-flex align-items-center mb-3">
                        {{-- TICKET NUMBER + STATUS --}}
                            <div class="ticket-number-box">

                                <div class="d-flex justify-content-between align-items-center mb-2">

                                    <small class="text-muted">
                                        Ticket Number
                                    </small>


                                    @switch($ticket->ticket_status)

                                        @case('review')
                                            <span class="badge rounded-pill bg-secondary-subtle text-secondary px-3 py-2">
                                                <i class="bi bi-eye me-1"></i>
                                                For Review
                                            </span>
                                        @break


                                        @case('inprogress')
                                            <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                                                <i class="bi bi-hourglass-split me-1"></i>
                                                In Progress
                                            </span>
                                        @break


                                        @case('resolved')
                                            <span class="badge rounded-pill bg-info-subtle text-info px-3 py-2">
                                                <i class="bi bi-check2-circle me-1"></i>
                                                Resolved
                                            </span>
                                        @break


                                        @case('completed')
                                            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                                <i class="bi bi-check-circle-fill me-1"></i>
                                                Completed
                                            </span>
                                        @break


                                        @case('rejected')
                                            <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">
                                                <i class="bi bi-x-circle-fill me-1"></i>
                                                Rejected
                                            </span>
                                        @break


                                        @default
                                            <span class="badge rounded-pill bg-light text-dark px-3 py-2">
                                                <i class="bi bi-question-circle me-1"></i>
                                                Unknown
                                            </span>

                                    @endswitch

                                </div>


                                <div class="ticket-id-wrapper">

                                    <span class="ticket-id">
                                        {{ $ticket->ticket_id }}
                                    </span>


                                    <button 
                                        type="button"
                                        class="btn btn-sm btn-light copy-btn"
                                        onclick="copyTicket('{{ $ticket->ticket_id }}')">

                                        <i class="bi bi-copy"></i>

                                    </button>

                                </div>

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Body --}}
    <div class="row pt-3">
        <div class="col-md-8 pt-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    {{-- REQUEST INFORMATION --}}
                    <div class="d-flex align-items-center mb-4">
                        <div class="section-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold mb-0">
                                Request Information
                            </h6>
                            <small class="text-muted">
                                Details and requirements of the request
                            </small>
                        </div>
                    </div>


                    {{-- PURPOSE --}}
                    <div class="info-box mb-3">
                        <label>
                            <i class="bi bi-chat-dots me-2"></i>
                            Purpose of Request
                        </label>

                        <p class="mb-0 text-muted">
                            {{$ticket->purpose_of_request}}
                        </p>
                    </div>


                    {{-- PROGRAM + PRIORITY --}}
                    <div class="row g-3">

                        <div class="col-md-7">
                            <div class="info-box">

                                <label>
                                    <i class="bi bi-briefcase me-2"></i>
                                    Program Requested
                                </label>

                                <span>
                                    @if($ticket->program_others !== null)
                                        {{$ticket->program_others}}
                                    @else
                                        {{$ticket->programDetails->program}}
                                    @endif
                                </span>

                            </div>
                        </div>


                        <div class="col-md-5">
                            <div class="info-box">

                                <label>
                                    <i class="bi bi-flag me-2"></i>
                                    Priority
                                </label>

                                <span class="badge rounded-pill 
                                    @if($ticket->ticket_priority == 'urgent')
                                        bg-danger-subtle text-danger
                                    @elseif($ticket->ticket_priority == 'high')
                                        bg-warning-subtle text-warning
                                    @elseif($ticket->ticket_priority == 'medium')
                                        bg-primary-subtle text-primary
                                    @else
                                        bg-secondary-subtle text-secondary
                                    @endif
                                ">
                                    {{ucfirst($ticket->ticket_priority)}}
                                </span>

                            </div>
                        </div>

                    </div>



                    {{-- KNOWLEDGE PRODUCT --}}
                    @if($ticket->type_of_knowledge_product !== null)

                    <hr class="my-4">


                    <div class="d-flex align-items-center mb-3">

                        <div class="section-icon">
                            <i class="bi bi-journal-text"></i>
                        </div>

                        <div class="ms-3">
                            <h6 class="fw-bold mb-0">
                                Knowledge Product
                            </h6>
                            <small class="text-muted">
                                Requested learning materials
                            </small>
                        </div>

                    </div>


                    <div class="info-box">

                        <label>
                            <i class="bi bi-file-earmark-text me-2"></i>
                            Knowledge Product Requested
                        </label>


                        @php
                            $knowledgeProducts = json_decode($ticket->type_of_knowledge_product, true) ?? [];
                        @endphp


                        <div class="d-flex flex-wrap gap-2">

                            @foreach($knowledgeProducts as $product)

                                @if($product === 'Others')

                                    <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                                        <i class="bi bi-file-earmark me-1"></i>
                                        {{$ticket->type_of_knowledge_product_others}}
                                    </span>

                                @else

                                    <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                                        <i class="bi bi-file-earmark me-1"></i>
                                        {{$product}}
                                    </span>

                                @endif

                            @endforeach

                        </div>

                    </div>

                    @endif




                    {{-- RESOURCE PERSON --}}
                    @if($ticket->title_of_activity !== null)

                    <hr class="my-4">


                    <div class="d-flex align-items-center mb-3">

                        <div class="section-icon">
                            <i class="bi bi-person-badge"></i>
                        </div>

                        <div class="ms-3">
                            <h6 class="fw-bold mb-0">
                                Resource Person Activity
                            </h6>

                            <small class="text-muted">
                                Activity details
                            </small>
                        </div>

                    </div>



                    <div class="row g-3">


                        {{-- TITLE --}}
                        <div class="col-md-12">

                            <div class="info-box">

                                <label>
                                    <i class="bi bi-card-heading me-2"></i>
                                    Title of Activity
                                </label>

                                <span>
                                    {{$ticket->title_of_activity}}
                                </span>

                            </div>

                        </div>



                        {{-- TYPE --}}
                        <div class="col-md-6">

                            <div class="info-box">

                                <label>
                                    <i class="bi bi-calendar-event me-2"></i>
                                    Type of Activity
                                </label>

                                <span>
                                    {{$ticket->type_of_activity}}
                                </span>

                            </div>

                        </div>



                        {{-- VENUE --}}
                        @if($ticket->venue)

                        <div class="col-md-6">

                            <div class="info-box">

                                <label>
                                    <i class="bi bi-geo-alt me-2"></i>
                                    Venue
                                </label>

                                <span>
                                    {{$ticket->venue}}
                                </span>

                            </div>

                        </div>

                        @endif




                        {{-- PARTICIPANTS --}}
                        @if($ticket->target_participants)

                        <div class="col-md-6">

                            <div class="info-box">

                                <label>
                                    <i class="bi bi-people me-2"></i>
                                    Target Participants
                                </label>

                                <span>
                                    {{$ticket->target_participants}}
                                </span>

                            </div>

                        </div>

                        @endif




                        {{-- DATE --}}
                        @if($ticket->date_of_activity)

                        <div class="col-md-6">

                            <div class="info-box">

                                <label>
                                    <i class="bi bi-calendar-event me-2"></i>
                                    Date of Activity
                                </label>

                                <span>
                                    {{$ticket->date_of_activity}}
                                    @if($ticket->date_of_activity_end)
                                        - {{$ticket->date_of_activity_end}}
                                    @endif
                                </span>

                            </div>

                        </div>

                        @endif


                    </div>

                    @endif



                </div>
            </div>
        </div>
        <div class="col-md-4 pt-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <h5 class="mb-4">Status & Progress</h5>

                    <div class="status-timeline">

                        {{-- REQUEST SUBMITTED --}}
                        <div class="status-step completed"  id="submitted">

                            <div class="status-icon">
                                <i class="bi bi-calendar3"></i>
                            </div>

                            <div class="status-content">

                                <h6>Request Submitted</h6>

                                <small class="status-date">
                                    {{ $ticket->created_at->format('M d, Y • h:i A') }}
                                </small>

                                <p>
                                    Your request has been successfully submitted.
                                </p>

                            </div>

                        </div>


                        {{-- UNDER REVIEW --}}
                        <div class="status-step" id="review">

                            <div class="status-icon">
                                <i class="bi bi-search"></i>
                            </div>

                            <div class="status-content">
                                <h6 class="pt-2">Under Review</h6>
                                @if($ticket->ticket_acknowledged_at === null)
                                <p>Your ticket will be reviewed by the team.</p>
                                @else
                                <p>Your ticket has been reviewed by the team.</p>
                                @endif

                            </div>

                        </div>


                        {{-- IN PROGRESS --}}
                        <div class="status-step" id="inprogress">

                            <div class="status-icon">
                                <i class="bi bi-gear-fill"></i>
                            </div>

                            <div class="status-content">

                                <h6>In Progress</h6>

                                @if($ticket->ticket_acknowledged_at !== null)
                                <small class="status-date">
                                    {{ $ticket->ticket_acknowledged_at?->format('M d, Y • h:i A') ?? '-' }}
                                </small>

                                <p>
                                    Your request is reviewed and processing your request.
                                </p>
                                @else
                                <p>You request will be marked as inprogress once the ticket is ackowledged by the team.</p>
                                @endif



                            </div>

                        </div>


                        {{-- RESOLVED --}}
                        <div class="status-step" id="resolved">

                            <div class="status-icon">
                                <i class="bi bi-question-lg"></i>
                            </div>

                            <div class="status-content">

                                <h6>Resolved</h6>
                                @if($ticket->ticket_resolved_at !== null)
                                <p>
                                    {{$ticket->ticket_resolved_at?->format('M d, Y • h:i A') ?? '-'}}
                                </p>
                                <p>Your request has been resolved</p>

                                @else
                                <p>
                                    Your request will be marked as resolved once the request is fulfilled.
                                </p>
                                @endif
                            </div>

                        </div>


                        {{-- COMPLETED --}}
                        <div class="status-step" id="completed">

                            <div class="status-icon">
                                <i class="bi bi-check2-circle"></i>
                            </div>

                            <div class="status-content">

                                <h6>Completed</h6>
                                @if($ticket->ticket_completed_at !== null)
                                <p>{{$ticket->ticket_completed_at?->format('M d, Y • h:i A')?? '-'}}</p>
                                <p>Your request is completed</p>
                                @else
                                <p>
                                    Your request will be marked as completed once the request is verified as completed.
                                </p>
                                @endif
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyTicket(ticketId) {
        navigator.clipboard.writeText(ticketId)
            .then(() => {

                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'Ticket number copied to clipboard.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });

            })
            .catch(() => {

                Swal.fire({
                    icon: 'error',
                    title: 'Copy failed',
                    text: 'Unable to copy the ticket number.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });

            });
    }

    switch(@json($ticket->ticket_status)){
        case 'review': 
            document.getElementById('review').classList.remove('active','completed');
            document.getElementById('inprogress').classList.remove('active' , 'completed');
            document.getElementById('resolved').classList.remove('active', 'completed');
            document.getElementById('completed').classList.remove('active', 'completed');

            document.getElementById('review').classList.add('active');


            
        break;

        case 'inprogress':
            document.getElementById('review').classList.remove('active','completed');
            document.getElementById('inprogress').classList.remove('active' , 'completed');
            document.getElementById('resolved').classList.remove('active', 'completed');
            document.getElementById('completed').classList.remove('active', 'completed');

            document.getElementById('review').classList.add('completed');
            document.getElementById('inprogress').classList.add('active');
        break;

        case 'resolved':
            document.getElementById('review').classList.remove('active','completed');
            document.getElementById('inprogress').classList.remove('active' , 'completed');
            document.getElementById('resolved').classList.remove('active', 'completed');
            document.getElementById('completed').classList.remove('active', 'completed');

            document.getElementById('review').classList.add('completed');
            document.getElementById('inprogress').classList.add('completed');
            document.getElementById('resolved').classList.add('active');
        break;

        case 'completed':
            document.getElementById('review').classList.remove('active','completed');
            document.getElementById('inprogress').classList.remove('active' , 'completed');
            document.getElementById('resolved').classList.remove('active', 'completed');
            document.getElementById('completed').classList.remove('active', 'completed');

            document.getElementById('review').classList.add('completed');
            document.getElementById('inprogress').classList.add('completed');
            document.getElementById('resolved').classList.add('completed');
            document.getElementById('completed').classList.add('active');
        break;


        
        
    }
    
</script>
@endsection