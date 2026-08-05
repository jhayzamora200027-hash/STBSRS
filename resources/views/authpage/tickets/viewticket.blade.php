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
    <div class="card shadow-sm border-0">
        <div class="card-body">
                <div class="row">
                <div class="col-md-6 border-end pe-4">
                    <div class="d-flex justify-content-between align-items-start">

                        <!-- Left -->
                        <div class="d-flex align-items-center">

                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                style="background:#e9eeff;width:55px;height:55px;">
                                <i class="bi bi-file-earmark-text fs-3 text-primary"></i>
                            </div>

                            <div class="ms-3">

                                <small class="text-muted d-block">
                                    Ticket Number
                                </small>

                                <h5 class="mb-0 fw-bold">

                                    {{ $ticket->ticket_id }}

                                    <i class="bi bi-copy fs-6 copy-ticket text-muted ms-1"
                                        role="button"
                                        title="Copy Ticket Number"
                                        data-ticket="{{ $ticket->ticket_id }}">
                                    </i>

                                </h5>

                            </div>

                        </div>

                        <!-- Right -->
                        <div class="text-end">

                            <small class="text-muted d-block">
                                Ticket Status
                            </small>

                            @switch($ticket->ticket_status)

                                @case('review')
                                    <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                        <i class="bi bi-clock-history me-1"></i>
                                        For Review
                                    </span>
                                @break

                                @case('inprogress')
                                    <span class="badge rounded-pill bg-primary px-3 py-2">
                                        <i class="bi bi-arrow-repeat me-1"></i>
                                        In Progress
                                    </span>
                                @break

                                @case('completed')
                                    <span class="badge rounded-pill bg-success px-3 py-2">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Completed
                                    </span>
                                @break

                                @case('rejected')
                                    <span class="badge rounded-pill bg-danger px-3 py-2">
                                        <i class="bi bi-x-circle me-1"></i>
                                        Rejected
                                    </span>
                                @break

                            @endswitch

                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-start pt-3">
                        <div class="d-flex align-items-center pt-3">
                            <div>
                                <div>
                                    <small class="text-muted d-block">
                                        Category
                                    </small>
                                    @switch($ticket->ticket_category)

                                    @case('enhance')
                                    <h6>Technical Assitance on Program Development</h6>
                                    @break

                                    @case('completed')
                                    <h6>Technical Assitance on Completed Program</h6>
                                    @break

                                    @case('resource')
                                    <h6>Resource Person</h6>
                                    @break

                                    @case('knowledge')
                                    <h6>Knowledge Product</h6>
                                    @break 

                                    @endswitch
                                </div>
                                <div class="pt-2">
                                    <small class="text-muted d-block">Program</small>
                                    <h6>{{optional($ticket->programDetails)->program ?? '-'}}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-end pt-3"> 
                            <div>
                                <small class="text-muted d-block">Priority</small>
                                @switch($ticket->ticket_priority)
                                    @case('low')
                                    <span class="badge  bg-success px-3 py-2">
                                    Low
                                    </span>
                                    @break
                                    
                                    @case('medium')
                                    <span class="badge  bg-warning text-dark px-3 py-2">
                                    Medium
                                    </span>
                                    @break

                                    @case('high')
                                    <span class="badge  bg-warning text-dark px-3 py-2">
                                    High
                                    </span>
                                    @break

                                    @case('urgent')
                                    <span class="badge  bg-danger px-3 py-2">
                                    Urgent
                                    </span>
                                    @break
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="align-items-center">
                        <div class="m-3">
                            <h6>Date Submitted</h6> 
                            <span>{{$ticket->created_at}}</span>
                        </div>
                        <div class="ms-3 mb-0">
                            <h6>Requester</h6>
                            <span>
                                {{ $ticket->requestor_first_name }}
                                @if(!empty($ticket->requestor_middle_name))
                                    {{ strtoupper(substr($ticket->requestor_middle_name, 0, 1)) }}.
                                @endif
                                {{ $ticket->requestor_last_name }}
                            </span>
                        </div>
                        <div class="ms-3">
                            <small class="text-muted">{{$ticket->requestor_email}}</small>     
                        </div>    
                        <div class="ms-3 pt-3">
                            <h6>Requestor Location</h6>
                            {{$ticket->requestRegion->name}},
                            {{$ticket->requestProvince->name}},
                            {{$ticket->requestCity->name}}
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div> 
        <div class="pt-2">
            <button class="p-3 tab-buttons" id="btnRequestInfo">
                Request Information
            </button>
            <button class="p-3 tab-buttons" id="btnComment">
                Comments
            </button>
            <button class="p-3 tab-buttons" id="btnHistory">
                History
            </button>
        </div>
    </div>
    <div class="row" id="requestInformationBody">
        <div class="col-md-8"> 
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="p-4">
                            <div class="col-md-12 border-bottom">
                                <h5>Request Information</h5>
                                <div class="pt-3 pb-3">
                                    <span>Purpose of request</span>
                                    <h6>{{$ticket->purpose_of_request}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($ticket->ticket_category === 'knowledge')
                    <div class="row">
                        <div class="col-md-6">
                            <div class=" d-flex align-items-center justify-content-center">
                                <h5 >Document Type</h5>
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="d-flex align-items-center justify-content-center">
                                <h5>Knowledge Product Requested</h5>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row d-none" id="commentBody"> 
        commentBody
    </div>
    <div class="row d-none" id="historyBody">
        historyBody
    </div>
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
    });

    document.getElementById('btnComment').addEventListener('click', function(){
        document.getElementById('requestInformationBody').classList.add('d-none')
        document.getElementById('commentBody').classList.remove('d-none');
        document.getElementById('historyBody').classList.add('d-none');
    });

    document.getElementById('btnHistory').addEventListener('click', function(){
        document.getElementById('requestInformationBody').classList.add('d-none')
        document.getElementById('commentBody').classList.add('d-none');
        document.getElementById('historyBody').classList.remove('d-none');
    });
</script>
@endsection