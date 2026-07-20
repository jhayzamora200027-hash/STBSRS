@extends('layouts.app')

@section('title', 'Home')

@section('content')
<style>
.dashed-card{
    border: 2px dashed #abcdff;
    border-radius: 15px;
    background-color: #ecf7ff;
}
</style>
<div class="container py-5">
    <div class="row">
        <div class="col-lg-7">
            
            <img src ="{{asset('images/logo/DSWD STB Bagong Pil logo.png')}}" class="img-fluid mb-5" style ="max-width: 400px; height?:auto;">
            <h2 class="fw-bold">
                How can we help you today?
            </h2>
            <p style="font-size: 1rem;" class="text-muted">
                Welcome to the STB Service Request System! We make it easy for you to request assistance or get information.
            </p>
            <div class="row g-3">
                <div class="col-md-3 py-2">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column align-items-center" >
                            <div class="rounded-circle d-flex justify-content-center align-items-center mb-3" style="background-color:#b8d5f7; padding:10px;" >
                            <img src = "{{asset('images/icons/ticket.png')}}" width="60" height="60">
                            </div>
                            <h6 class="fw-bold text-center">Submit Requests</h6>

                            <p class="text-muted small text-center" style="font-size: 0.8rem;">
                                Easily create new requests.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 py-2">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="rounded-circle d-flex justify-content-center align-items-center mb-3" style="background-color:#e9ffeb; padding:10px;" >
                            <img src = "{{asset('images/icons/track.png')}}" width="60" height="60">
                            </div>

                            <h6 class="fw-bold text-center">Track Progress</h6>

                            <p class="text-muted small text-center"  style="font-size: 0.8rem;"">
                                Monitor the status and updates of your ticket in real-time.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 py-2">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="rounded-circle d-flex justify-content-center align-items-center mb-3" style="background-color:rgb(255, 222, 222); padding:10px; height:85px;">
                            <img src = "{{asset('images/icons/notification.png')}}" width="60" height="60">
                            </div>
                            <h6 class="fw-bold text-center">Timely Updates</h6>

                            <p class="text-muted small text-center" style="font-size: 0.8rem;">
                            Receive notifications and updates on your registered email.                            
                        </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 py-2">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="rounded-circle d-flex justify-content-center align-items-center mb-3" style="background-color:rgb(235, 233, 255); padding:10px; height:85px;">
                            <img src = "{{asset('images/icons/shield.png')}}" width="60" height="5" >
                            </div>
                            <h6 class="fw-bold text-center">Secured Features</h6>

                            <p class="text-muted small text-center" style="font-size: 0.8rem;">
                            Your data is protected and handled with the highest security.                          
                        </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card dashed-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="mb-2"> Need to create a new request?</h4>
                                    <p class="text-muted mb-0"> Click the button to get started.</p>
                                </div>
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <a href="#" class="btn btn-primary btn-lg px-4">
                                        <i class="bi bi=plus-square me-2"></i>
                                        Create New Request
                                    </a> 
                                </div> 
                            </div>   
                        </div>    
                    </div>
                </div>    
            </div>   
                
                            <div class="row mt-4">
                                <div class="col-md-3-py-2">
                                        <div class="card" style="background-color:#062c52">
                                            <div class="card-body">
                                                <div class="row text-center text-md-start">

                                                    <div class="col-md-4 border-end d-flex align-items-center py-3">
                                                        <div class="rounded-circle d-flex justify-content-center align-items-center"
                                                            style="background:#cfe0ff; width:50px; height:50px; flex-shrink:0;">
                                                            <img src="{{ asset('images/icons/clock.png') }}" width="30">
                                                        </div>

                                                        <div class="ms-3 text-start">
                                                            <p class="mb-1 fw-bold" style="color:white; font-size:.85rem;">Support Schedule</p>
                                                            <span style="font-size:.85rem; color:white";>
                                                                Monday - Friday<br>
                                                                8:00 AM - 5:00 PM
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 border-end d-flex align-items-center py-3">
                                                        <div class="rounded-circle d-flex justify-content-center align-items-center"
                                                            style="background:#cfe0ff; width:50px; height:50px; flex-shrink:0;">
                                                            <img src="{{ asset('images/icons/telephone.png') }}" width="30">
                                                        </div>

                                                        <div class="ms-3 text-start">
                                                            <p class="mb-1 fw-bold" style="color:white; font-size: 0.85rem">Contact Us</p>
                                                            <span style="font-size:.7rem; color:white">
                                                                (02) 8951-7124<br>
                                                                stb@dswd.gov.ph
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 d-flex align-items-center py-3">
                                                        <div class="rounded-circle d-flex justify-content-center align-items-center"
                                                            style="background:#cfe0ff; width:50px; height:50px; flex-shrink:0;">
                                                            <img src="{{ asset('images/icons/location.png') }}" width="25">
                                                        </div>

                                                        <div class="ms-3 text-start">
                                                            <p class="mb-1 fw-bold" style="color:white; font-size:0.85rem;">Office Address</p>
                                                            <span style="font-size:.7rem; color:white">
                                                                DSWD Central Office,
                                                                IBP Road, Constitution Hills,
                                                                Quezon City
                                                            </span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                </div>    
                                
                            </div>    
        </div>    

        <div class="col-lg-5 mt-4 mt-lg-0">
            <div class="card shadow-sm  w-100 h-100">
                <div class="card-body d-flex flex-column">
                    <p style="font-size: 1.2rem">You have existing service request?</p>
                    <p class="text-muted" style="font-size: 0.8rem">Search and view the status of your service request.</p>
                    <div class="input-group">
                                <span class="input-group-text bg-white"> 
                                    <img src="{{asset('images/icons/magnifying.png')}}" width="20" height="10">
                                </span>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter Ticket Reference No..." 
                                    aria-label="Ticket Reference Number">
                                    
                                <button class="btn btn-primary" type="button">
                                    <i class="bi bi-search"></i> Search
                                </button>
                    </div>
                                <div class="d-flex align-items-center my-4">
                                    <div class="flex-grow-1 border-top"> </div>
                                        <span class="mx-3 text-secondary fw-medium">
                                            or
                                        </span>
                                    <div class="flex-grow-1 border-top"> </div>
                                </div>
                    <div class="card mt-3">
                        <div class="card-body shadow-sm">  
                            <div class="d-flex align-item-center" style="padding:10px;">

                                <img src="{{asset('images/icons/email.png')}}" style="max-width: 40px; max-height: 40px; padding-top:10px;">
                                <div class="ms-3">
                                    <p class="mb-0" style="font-size: 1.0rem;"> Find your ticket using your email address </p>
                                    <p class="text-muted" style="font-size: 0.8rem;"> We will send you One Time Password for security purposes </p>
                                </div>
                            </div>
                            <div class="input-group">  
                                            <span class="input-group-text bg-white"> 
                                                <img src="{{asset('images/icons/magnifying.png')}}" width="20" height="10">
                                            </span>
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Enter Email Address..." 
                                                aria-label="Ticket Reference Number">
                                                
                                            <button class="btn btn-primary" type="button">
                                                <i class="bi bi-search"></i> Search
                                            </button>
                            </div>
                        </div>
                    </div>
                        <div class="card mt-3">
                            <div class="card-body shadow-sm d-flex flex-column justify-content-center align-items-center"
                                style="height:360px;">
                                <img src="{{ asset('images/icons/norecentact.png') }}"
                                    style="max-height:40px; max-width:40px;">

                                <p class="mt-2 mb-0 text-muted">No recent activity</p>
                            </div>
                        </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@push('modals')
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="row g-0">
                    {{-- Column Left --}}
                    <div class="col-auto p-5" style="width:350px; background-color:#ecf4fe;">
                        <img src="{{ asset('images/logo/DSWD STB Bagong Pil logo.png') }}" class="img-fluid">

                        <h5 class="mt-5">Welcome Back!</h5>

                        <p class="text-muted" style="font-size:0.7rem;">
                            Sign in to your account to continue to the STB Service Request System.
                        </p>
                    <img src="{{asset("images/attachments/loginpic.png")}}" class="img-fluid" style="width:auto; height:200px;">
                    </div>

                    {{-- Collumn right --}}
                    <div class="col-auto justify-content-center g-0" style="width:430px;"> 
                                <div class="modal-header">
                                    <h5 class="modal-title" id="loginModalLabel">
                                        Login
                                    </h5>
                                    <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <form>
                                        <div class="mb-3">
                                            <label class="form-label">Email Address</label>

                                            <input type="email" class="form-control" placeholder="Enter your email">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Password</label>

                                            <input type="password" class="form-control" placeholder="Enter your password">
                                        </div>    

                                        <button class="btn btn-primary w-100">
                                            Login
                                        </button>
                                    </form>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush
@endsection