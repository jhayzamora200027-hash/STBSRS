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

</style>
<div class="p-2">
    <a href="{{ route('tickets') }}" class="btn back-btn border shadow-sm rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i>
        Back to tickets
    </a>
</div>
<div class="row">
    <div class="p-2">
        
        <h4>
            Ticket Details
        </h4>
        <div class="mb-2">
        <small>View the status and details of request.</small>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-body">
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
                                    <h6>{{$ticket->programDetails->program}}</h6>
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
            </div>
        </div>
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
</script>
@endsection