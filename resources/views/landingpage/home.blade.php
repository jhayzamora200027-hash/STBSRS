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
                            <div class="rounded-circle d-flex justify-content-center align-items-center mb-3" style="background-color:rgb(255, 222, 222); padding:10px;">
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
                            <div class="rounded-circle d-flex justify-content-center align-items-center mb-3" style="background-color:rgb(235, 233, 255); padding:10px;">
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
        </div>    

        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p style="font-size: 1.2rem">You have existing service request?</h4>
                    <p class="text-muted" style="font-size: 0.8rem">Search and view the status of your service request.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection