@extends('layouts.app')

@section('title', 'Home')

@section('content')
<style>
.dashed-card{
    border: 2px dashed #abcdff;
    border-radius: 15px;
    background-color: #ecf7ff;
}

.img-fluid {
    max-width: 100%;
    height: auto;
}

.input-wrapper{
    position:relative;
}

.custom-input{
    height: 50px;
    border-radius: 10px;
    padding-left: 45px;
    padding-right: 45px;
    border: 1px solid #d9d9d9;
    font-size:14px;

}

.position-relative{
    position: relative;
}

.custom-input::placeholder{
    color:#9e9e9e;
}

.input-email-icon{
    position:absolute;
    left:15px;
    top:50%;
    transform: translateY(-50%);
    z-index: 10;
    color: #6c757d;
    pointer-events:none;
}

.input-password-icon{
    position:absolute;
    left:15px;
    transform: translateY(50%);
    z-index: 10;
    color: #6c757d;
    pointer-events:none;
}

.input-signin{
    position:center;
    left:15px;
    z-index: 10;
    color: #ffffff;
    pointer-events:none;

}

.eye-icon{
    position: absolute;
    right: 15px;
    top:50%;
    transform: translateY(-50%);
    color:#6c757d;
    cursor: pointer;
    z-index:2;
}


.forgot-link{
    font-size:13px;
    text-decoration: none;
}

.service-card{
    transition: all 0.3s ease;
    border: 2x solid #dee2e6;
    border-radius:12px;
}

.service-card:hover{
    cursor: pointer;
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(6,44,82,0.15);
    border-color:#062c52;
    background-color:#ddecff;
}

.upload-card{
    border-radius:12px;
}

.upload-box{
    border: 2px dashed #9ec5fe;
    border-radius: 10px;
    background: #f8fbff;

    height: 110px;          
    padding: 10px;

    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

    text-align: center;
    cursor: pointer;
}

.upload-box:hover{
    background:#f8fbff;
    border-color:#0d6efd;
}

.upload-box div{
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    line-height: 1.3;
}

.upload-box small{
    margin-top: 4px;
    font-size: .85rem;
}

.upload-box.dragover{
    background:#ddecff;
    border-color:#0d6efd;
}
.vertical-divider{
    border-left: 1px solid #dee2e6;
    height: 150px;
}
.vertical-divider-act{
    border-left: 1px solid #dee2e6;
    height: 250;
}
.act-card-ftf,
.act-card-vt,
.act-card-blended{
    flex: 1;
    cursor: pointer;
    transition: .3s ease;
}

.act-card-ftf .card-body,
.act-card-vt .card-body,
.act-card-blended .card-body{
    display:flex;
    flex-direction:column;
    height:100%;
    min-height: 220px;
}

.act-card-ftf:hover {
    border-color: #0d6efd;
    background: #f4eeff;
}

.act-card-vt:hover {
    border-color: #198754;
    background: #eafaf1;
}

.act-card-blended:hover {
    border-color: #6c01a1;
    background: #f5f0ff;
}

.kp-card{
    display:block;
    cursor:pointer;
}

.kp-content{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    padding: 18px;
    border: 1px solid #ddd;
    border-radius: 10px;
}
.kp-title{
    font-weight: 500;
    word-break: break-word;
}

.kp-check{
    font-size: 1.4rem;
    flex-shrink: 0; 
}

.kp-input:checked + .kp-content{
    border:2px solid #0d6efd;
    background:#eef5ff;
}

.kp-input:checked + .kp-content .kp-check{
    color:#0d6efd;
}

.kp-content:hover{
    border-color:#0d6efd;
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
                            <div class="rounded-circle d-flex justify-content-center align-items-center mb-3" style="background-color:#b8d5f7; padding:10px; width:80px; height:80px;" >
                            <img src = "{{asset('images/icons/ticket.png')}}" width="40" height="40">
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
                            <div class="rounded-circle d-flex justify-content-center align-items-center mb-3" style="background-color:#e9ffeb; padding:10px; width:80px; height:80px;" >
                            <img src = "{{asset('images/icons/track.png')}}" width="40" height="40">
                            </div>

                            <h6 class="fw-bold text-center">Track Progress</h6>

                            <p class="text-muted small text-center"  style="font-size: 0.8rem;">
                                Monitor the status and updates of your ticket in real-time.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 py-2">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="rounded-circle d-flex justify-content-center align-items-center mb-3" style="background-color:rgb(255, 222, 222); padding:10px; width:80px; height:80px;">
                            <img src = "{{asset('images/icons/notification.png')}}" width="40" height="40">
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
                            <div class="rounded-circle d-flex justify-content-center align-items-center mb-3" style="background-color:rgb(235, 233, 255); padding:10px; width:80px; height:80px;">
                            <img src = "{{asset('images/icons/shield.png')}}" width="40" height="40" >
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
                                    <h5 class="mb-2"> Need to create a new request?</h5>
                                    <p class="text-muted mb-0" style="font-size:0.7rem;"> Click the button to get started.</p>
                                </div>
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <button type="button" id="new_ticket" data-bs-toggle="modal" data-bs-target="#createTicketModal" class="btn btn-primary btn-lg px-4" style="height:50px; font-size:1rem; align-items-center">
                                        <i class="bi bi-plus-square me-2"></i>
                                        Create New Request
                                    </button> 
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
                                                            style="background:#e0cfff; width:50px; height:50px; flex-shrink:0;">
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
                                    <img src="{{asset('images/icons/magnifying.png')}}" width="20" height="20">
                                </span>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter your ticket reference no..." 
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
                                                <img src="{{asset('images/icons/magnifying.png')}}" width="20" height="20">
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
{{-- MODAL LOGIN --}}
@push('modals')
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="row g-0">
                    {{-- Column Left --}}
                    <div class="col-12 col-lg-5 p-5" style="background-color:#ecf4fe;">
                        <img src="{{ asset('images/logo/DSWD STB Bagong Pil logo.png') }}" class="img-fluid">

                        <h4 class="mt-5">Welcome Back!</h4>

                        <p class="text-muted" style="font-size:0.8rem;">
                            Sign in to your account to continue to the STB Service Request System.
                        </p>
                        <div class="col-md-5 d-flex justify-content-center align-items-end">

                        </div>
                        <div style="padding-top:60px;">
                            <img
                            src="{{ asset('images/attachments/loginpic.png') }}"
                            class="img-fluid d-block mx-auto"
                            style="max-width: 250px !important;">   
                        </div>             
                    </div>

                    {{-- Collumn right --}}
                    <div class="col-12 col-lg-7"> 
                                <div class="m-3">
                                    <h4 class="modal-title" id="loginModalLabel">
                                            Login to your account
                                    </h4>
                                    <p class="text-muted" style="font-size:0.7rem;">Enter your credentials to access your account</p>
                                    <div class="modal-body">
                                        <form method="POST" id="loginForm" action="{{ route('login')}}">
                                            @csrf
                                            <div id="loginError"></div>
                                            <div class="mb-3">
                                                <label class="form-label">Email Address</label>

                                                <div class="position-relative">
                                                    <i class="bi bi-envelope input-email-icon"></i>
                                                    <input type="email" name="email" class="form-control custom-input" placeholder="Enter your email address" required value="{{old('email')}}">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Password</label>
                                                
                                                <div class="position-relative">
                                                <i class="bi bi-lock input-password-icon" style="width:30px;"></i>
                                                <input type="password" name="password" id="password" class="form-control custom-input"  placeholder="Enter your password"  required>
                                                
                                                <i class="bi bi-eye eye-icon" id="togglePassword"></i>

                                                </div>

                                                <div class="text-end mt-2">
                                                    <a href="#" class="forgot-link">Forgot Password?</a>
                                                </div>
                                            </div>
                                            <button class="btn w-100 d-submit-button" type="submit">
                                                <i class="bi bi-lock"></i>
                                                Sign-In
                                            </button>
                                        </form>
                                        <div class="d-flex align-items-center my-4">
                                            <div class="flex-grow-1 border-top"> </div>
                                                <span class="mx-3 text-secondary fw-medium">
                                                    or
                                                </span>
                                            <div class="flex-grow-1 border-top"> </div>
                                        </div>
                                            <button class="btn w-100 d-submit-white-button" >
                                                    <i class="bi bi-person-circle"></i>
                                                    Sign-In with Google
                                            </button>

                                            <div class="text-center mt-3">
                                               <span style="font-size:0.8rem;"> Need help? </span> <a href="#" class="forgot-link"> Contact your system a`dministator.</a>
                                            </div>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL NEW REQUEST --}}
    <div class="modal fade" id="createTicketModal" tabindex="-1" arialabelledby="createTicketLabel" aria-hideen="true">
        <form method="POST" id="ticketForm" action="{{route('tickets.store')}}" enctype="multipart/form-data" novalidate>
        @csrf
        @if(session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger m-3">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <input type="hidden" name="ticket_category" id="ticket_category">
        <input type="hidden" name="type_of_activity" id="type_of_activity">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                {{-- Header --}}
                <div class="modal-header mt-3">
                    <div class="modal-title" id="createTicketModalLabel">
                        <div class="d-flex align-items-start" style="padding-left: 20px;">
                                <div class="rounded-circle d-flex p-2 me-3 justify-content-center align-items-center" style="background-color:#cfe0ff; width:40px;"> 
                                    <img src="{{asset('images/icons/new_ticket.png')}}" width="20">
                                </div>
                                <div>
                                    <h5 class="mb-0">
                                        Request Ticket
                                    </h5>
                                    <small class="text-muted">
                                    Please provide your details and describe your request so we can assist you better.
                                    </small>
                                </div>
                                <div class="flex-grow-1 border-top" style="padding-top: 10px;"> </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="otpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content otp-modal border-0">

            <div class="modal-header border-0 pb-0">
                <div>
                    <small class="text-uppercase otp-label">Secure Sign-In</small>
                    <h2 class="otp-title mb-0">Two-step verification</h2>
                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <!-- Information Card -->
                <div class="otp-info-card">

                    <div class="otp-icon">
                        2FA
                    </div>

                    <div class="ms-3">
                        <p class="mb-0 text-muted">
                            Verification code has been sent to
                            <strong id="otpEmailMasked"></strong>.
                            Confirm the request first, complete the verification to proceed with your request.
                        </p>
                    </div>

                </div>

                <!-- OTP Card -->
                <div class="otp-code-card">

                    <h2 class="text-center text-primary mb-4">
                        Verification Code
                    </h2>

                    <div class="d-flex justify-content-center gap-2 mb-3">

                        <input type="text" maxlength="1" class="form-control otp-input">
                        <input type="text" maxlength="1" class="form-control otp-input">
                        <input type="text" maxlength="1" class="form-control otp-input">
                        <input type="text" maxlength="1" class="form-control otp-input">
                        <input type="text" maxlength="1" class="form-control otp-input">
                        <input type="text" maxlength="1" class="form-control otp-input">

                    </div>

                    <p class="text-center text-muted mb-0">
                        Enter the 6-digit code you received by email.
                    </p>

                </div>

            </div>

            <div class="modal-footer border-0 d-block">

                <button class="btn btn-primary w-100 mb-3 otp-btn"
                        id="verifyOtpBtn">
                    Verify
                </button>

                <button class="btn btn-outline-secondary w-100 otp-btn"
                        data-bs-dismiss="modal">
                    Cancel
                </button>

            </div>

        </div>
    </div>
</div>

    <style>
    .otp-modal{
        border-radius:18px;
    }

    .otp-label{
        color:#0b3ea9;
        font-weight:600;
        letter-spacing:.5px;
    }

    .otp-title{
        color:#0b3ea9;
        font-weight:500;
    }

    .otp-info-card{
        display:flex;
        align-items:center;
        border:2px solid #8d4dff;
        border-radius:10px;
        padding:18px;
        margin-top:15px;
    }

    .otp-icon{
        width:64px;
        height:64px;
        border-radius:14px;
        background:#4c7ff7;
        color:#fff;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:24px;
        font-weight:700;
        flex-shrink:0;
    }

    .otp-code-card{
        margin-top:25px;
        border:1px solid #ddd;
        border-radius:18px;
        padding:25px;
    }

    .otp-input{
        width:60px;
        height:60px;
        text-align:center;
        font-size:24px;
        font-weight:600;
        border-radius:14px;
    }

    .otp-btn{
        height:52px;
        border-radius:14px;
        font-size:24px;
    }

    .btn-primary.otp-btn{
        background:#123c90;
        border:none;
    }

    .btn-outline-secondary.otp-btn{
        border:1px solid #ddd;
    }
    </style>

                {{-- Body --}}
                
                    <div class="m-3">
                        <div class="row mx-5">
                                <div class="col-md-6 py-2">
                                    <div class= "card shadow-sm cursor-pointer" id ="card1" style="background-color: #ddecff; border-color:#062c52; cursor: pointer;">
                                        <div class="d-flex align-items-center">    
                                                <div class="justify-content-center align-items-center d-flex h-100" >
                                                    <div class="card-body d-flex align-items-center">
                                                        <div id="card1Rounded" class="rounded-circle d-flex p-2 me-3 justify-content-center align-items-center" style="background-color:#062c52; width:55px;">
                                                            <h3 class="mb-0" style="color:#ffffff" id="card1Number">1</h3>
                                                        </div>
                                                        <div>
                                                            <h6  id="card1Label" class="mb-0" style="color: #062c52">
                                                                Personal Details
                                                            </h6>
                                                            <small class="text-muted">
                                                                Tell us who you are
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-md-6 py-2">
                                    <div class= "card shadow-sm" id="card2" style="background-color:#e4e4e4; cursor:pointer;">
                                        <div class="d-flex align-items-center">    
                                                <div class="justify-content-center align-items-center d-flex h-100">
                                                    <div class="card-body d-flex align-items-center" >
                                                        <div id="card2Rounded" class="rounded-circle d-flex p-2 me-3 justify-content-center align-items-center" style="background-color:#fff; width:55px;">
                                                            <h3 class="mb-0" id="card2Number">2</h3>
                                                        </div>
                                                            <div>
                                                                <h6 class="mb-0" id="card2Label">
                                                                    Request Details
                                                                </h6>
                                                                <small class="text-muted">
                                                                    What do you need help with?
                                                                </small>
                                                            </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div> 

                    {{-- Step 1 Body --}}
                            <div id="step1">
                                <div class="m-3">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex p-2 me-3 justify-content-center align-items-center" style="background-color:#cfe0ff; width:55px; height: 55px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16" aria-hidden="true">
                                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 100-6 3 3 0 000 6z"/>
                                            </svg>
                                        </div>
                                        <div>
                                                <h6 class="mb-0">Personal Information</h6>
                                                <small class="text-muted">Provide your personal details so we can identify and reach you.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                            <div class="row">
                                                <div class="col-md-4 py-2">
                                                    <label class="form-label">First name <i style="color:red">*</i></label>
                                                    <input id="first_name" name="requestor_first_name" type="text" class="form-control" placeholder="Input your first name..." required>
                                                </div>
                                                <div class="col-md-4 py-2">
                                                    <label class="form-label">Middle name</label>
                                                    <input id="middle_name" name="requestor_middle_name" type="text" class="form-control" placeholder="Input your middle name...">
                                                </div>
                                                <div class="col-md-4 py-2">
                                                    <label class="form-label">Last name <i style="color:red">*</i></label>
                                                    <input id="last_name" name="requestor_last_name" type="text" class="form-control" placeholder="Input your last name..." required>
                                                </div>
                                                <div class="col-md-4 py-2">
                                                    <label class="form-label">Extension name</label>
                                                    <input id="extension_name" name="requestor_extension_name" type="text" class="form-control" placeholder="eg. Jr III">
                                                </div>
                                                <div class="col-md-4 py-2">
                                                    <label class="form-label">Sex <i style="color:red">*</i></label>
                                                    <select id="sex" name="requestor_sex" type="text" class="form-select" required>
                                                        <option value="">Select your sex</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                        <option value="na">Prefer not to say</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 py-2">
                                                    <label class="form-label">Email Address <i style="color:red">*</i></label>
                                                    <div class="input-group">
                                                        <input id="email" name="requestor_email" type="email" class="form-control" placeholder="Input your email..." required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 py-2">
                                                    <label class="form-label">Region <i style="color:red">*</i></label>
                                                    <select id="region" name="requestor_region" class="form-select" required>
                                                            <option value="">Select your Region</option>

                                                            @foreach($regions as $region)
                                                            <option value="{{$region->region_code}}">
                                                                {{$region->name}}
                                                            </option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 py-2">
                                                    <label class="form-label">Province <i style="color:red">*</i></label>
                                                    <select id="province" name="requestor_province" type="text" class="form-select"  required>
                                                        <option value="">Select Province</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 py-2">
                                                    <label class="form-label">City/Municipality <i style="color:red">*</i></label>
                                                    <select id="city" class="form-select" name="requestor_city" required>
                                                        <option value="">Select City</option>
                                                    </select>
                                                </div>
                                            </div>
                                </div>
                                <div class="mt-3">
                                    <div class="card p-3" style="background-color:#ddecff; border-color:#4d7cff">
                                        <div class="d-flex align-items-start"> 
                                            <i class="bi bi-info-circle fs-2 me-3" style="color:#062c52;"></i>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1">Why do we need your information?</h6>
                                                <small class="text-muted">This help us verify your identity and keep you updated on your request</small>
                                            </div>  
                                        </div>      
                                    </div>
                                    
                                </div>
                                <div class="flex-grow-1 border-top mt-4"> </div>
                                <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
                                    <div style="width:320px;"> 
                                        <small class="text-muted" id="stepText">Step 1 of 2</small>
                                    
                                        <div class="progress mt-2" style="height:8px;"> 
                                            <div 
                                                class="progress-bar"
                                                id="progressBar"
                                                role="progressbar"
                                                style="width:50%; background-color:#3b41f6"
                                                aria-valuenow="50"
                                                aria-volummin="0"
                                                aria-voluemax="100"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row w-100 w-md-auto gap-2 justify-content-end">
                                                <button type="button" class="btn btn-outline-secondary wizard-btn" data-bs-dismiss="modal"  style="width:100px; border-radius:10px;">Cancel</button>
                                                <button type="button" id="nextBtn" class="d-submit-button btn btn-primary wizard-bt" style="width:200px; border-radius:10px;" >Next: Request Details <i class="bi bi-arrow-right"></i></button>
                                    </div>
                                </div>
                            </div>

                    {{-- Step 2 Body--}}
                            <div id="step2" class="d-none">
                                <div class="row g-3 mt-3">
                                    <h5>What assistance do you need?</h5>
                                        <div class="col-md-6">
                                            <div id="tacp" class="card service-card h-100" data-service="completed" style="cursor: pointer;">
                                                <div class="card-body text-center" p-4>
                                                    <i class="bi bi-tools fs-1 text-primary"></i>
                                                    <h5 class="mt-3">Technical Assistance</h5>
                                                    <h6 style="color:#062c52"> On Completed Program</h6> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="tapd" class="card service-card h-100" data-service="enhancement" style="cursor: pointer;">
                                                <div class="card-body text-center" p-4>
                                                    <i class="bi bi-graph-up-arrow fs-1 text-primary"></i>
                                                    <h5 class="mt-3">Technical Assistance</h5>
                                                    <h6 style="color:#062c52"> On Program Development</h6> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="rp" class="card service-card h-100" data-service="resource" style="cursor: pointer;">
                                                <div class="card-body text-center" p-4>
                                                    <i class="bi bi-mic-fill fs-1 text-primary"></i>
                                                    <h5 class="mt-3">Resouce Person</h5>
                                                    <h6 style="color:#062c52"> Schedule meeting</h6> 

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="kp" class="card service-card h-100" data-service="knowledge" style="cursor: pointer;">
                                                <div class="card-body text-center" p-4>
                                                    <i class="bi bi-book-half fs-1 text-primary"></i>
                                                    <h5 class="mt-3">Knowledge product</h5>
                                                    <h6 style="color:#062c52"> STB Documents</h6> 

                                                </div>
                                            </div>
                                        </div>
                                <div class="flex-grow-1 border-top mt-4"> </div>
                                    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
                                        <div style="width:320px;"> 
                                            <small class="text-muted" id="stepText">Step 2 of 2</small>
                                            
                                            <div class="progress mt-2" style="height:8px;"> 
                                                <div 
                                                    class="progress-bar"
                                                    id="progressBar"
                                                    role="progressbar"
                                                    style="width:100%; background-color:#3b82F6"
                                                    aria-valuenow="100"
                                                    aria-volummin="0"
                                                    aria-voluemax="100"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                       <div class="d-flex flex-column flex-sm-row w-100 w-md-auto gap-2 justify-content-end">
                                                <button type="button" class="btn btn-outline-secondary wizard-btn" data-bs-dismiss="modal"  style="width:100px; border-radius:10px;">Cancel</button>
                                       </div>
                                    </div>
                                </div>
                            </div>
                    {{-- Step 3 Body--}}
                            <div id="step3" class="d-none">
                            {{-- TA Completed Program --}}
                                <div id="tacpBody" class="d-none">
                                    <div class="mb-3 mt-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="p-2">
                                                    <div class="d-flex align-items-start p-2">
                                                        <div class="rounded-circle d-flex p-1 align-items-center justify-content-center flex-shrink-0 me-3" style="background-color: #cfe0ff; width:50px; height:50px;">
                                                                <i class="bi bi-file-earmark fs-5 text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="me-1">
                                                                Purpose of request <span style="color:red;">*</span>
                                                            </h6>
                                                            <span class="text-muted">
                                                                Briefly describe the purpose of your request
                                                            </span>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <textarea 
                                                    id="reasonRequestTACP" 
                                                    name="purpose_of_request" 
                                                    class="form-control" 
                                                    rows="5" 
                                                    placeholder="Input purpose of your request..."
                                                    style="height:30px;"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-2">
                                                    <div class="d-flex align-item-center p-2">
                                                        <div class="rounded-circle d-flex p-1 align-items-center justify-content-center flex-shrink-0 me-3" style="background-color:#cfe0ff; width:50px; height:50px;">
                                                                <i class="bi bi-activity fs-5 text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="me-1">
                                                                Program <span style="color:red">*</span>
                                                            </h6>
                                                            <span class="text-muted">
                                                                Select a program you want for this request
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <select class="form-select" id="programSelectTACP" name="program">
                                                        <option value="">Select a program</option>
                                                        @foreach($programs as $program)
                                                        <option value="{{$program->id}}">{{$program->program}}</option>
                                                        @endforeach
                                                        <option value="others">Others</option>
                                                    </select>
                                                    
                                            </div>
                                             {{-- Uploading --}}

                                             <div class="col-md-6">
                                                <div class="mt-3">
                                                        <h6 class="me-1">
                                                            Supporting Document (Optional)
                                                        </h6>

                                                    <div class="card p-4">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <i class="bi bi-file-earmark-arrow-up fs-1 text-primary"></i>
                                                                <div style="padding-left:20px;">
                                                                    <h5 class="mb-0 text-primary">Upload File</h4>
                                                                    <small class="text-muted"> PDF, JPG, PNG (Max. 10MB)</small>
                                                                </div>
                                                            </div>
                                                        
                                                            
                                                                    <label class="upload-box" for="supportFileTACP">
                                                                        <div class="mt-2">
                                                                            Drag & Drop your file here
                                                                        </div>
                                                                        <small class="text-muted">or click to browse</small>
                                                                    </label>

                                                         <input type="file" id="supportFileTACP" class="d-none" accept=".pdf,.jpg,.png" name="attachment">

                                                         <div class="file-name mt-3 text-success fw-semibold d-none"></div>
                                                    </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div id="otherProgramFieldTACP" class="mt-3 d-none">
                                                        <label class="form-label">Specify Program <span style="color:red">*</span></label>
                                                        <input type="text" class="form-control" id="otherProgramInputTACP" name="program_others">
                                                </div>
                                             </div>
                                        </div>
                                    </div>                                
                                </div>
                            {{-- TA Program Development --}}
                                <div id="tapdBody" class="d-none">
                                    <div class="mb-3 mt-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="p-2">
                                                    <div class="d-flex align-items-start p-2">
                                                        <div class="rounded-circle d-flex p-1 align-items-center justify-content-center flex-shrink-0 me-3" style="background-color: #cfe0ff; width:50px; height:50px;">
                                                                <i class="bi bi-file-earmark fs-5 text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="me-1">
                                                                Purpose of request <span style="color:red;">*</span>
                                                            </h6>
                                                            <span class="text-muted">
                                                                Briefly describe the purpose of your request
                                                            </span>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <textarea 
                                                    id="reasonRequestTAPD" 
                                                    name="purpose_of_request" 
                                                    class="form-control" 
                                                    rows="5" 
                                                    placeholder="Input purpose of your request..."
                                                    style="height:30px;"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-2">
                                                    <div class="d-flex align-item-center p-2">
                                                        <div class="rounded-circle d-flex p-1 align-items-center justify-content-center flex-shrink-0 me-3" style="background-color:#cfe0ff; width:50px; height:50px;">
                                                                <i class="bi bi-activity fs-5 text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="me-1">
                                                                Program <span style="color:rgb(72, 0, 255)">*</span>
                                                            </h6>
                                                            <span class="text-muted">
                                                                Select a program you want for this request
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <select class="form-select" id="programSelectTAPD" name="program">
                                                        <option value="">Select a program</option>
                                                        @foreach($programs as $program)
                                                        <option value="{{$program->id}}">{{$program->program}}</option>
                                                        @endforeach
                                                        <option value="others">Others</option>
                                                    </select>
                                                    
                                            </div>
                                             {{-- Uploading --}}

                                             <div class="col-md-6">
                                                <div class="mt-3">
                                                        <h6 class="me-1">
                                                            Supporting Document (Optional)
                                                        </h6>

                                                    <div class="card p-4">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <i class="bi bi-file-earmark-arrow-up fs-1 text-primary"></i>
                                                                <div style="padding-left:20px;">
                                                                    <h5 class="mb-0 text-primary">Upload File</h4>
                                                                    <small class="text-muted"> PDF, JPG, PNG (Max. 10MB)</small>
                                                                </div>
                                                            </div>
                                                        
                                                            
                                                                    <label class="upload-box" for="supportFileTAPD">
                                                                        <div class="mt-2">
                                                                            Drag & Drop your file here
                                                                        </div>
                                                                        <small class="text-muted">or click to browse</small>
                                                                    </label>

                                                         <input type="file" id="supportFileTAPD" class="d-none" accept=".pdf,.jpg,.png" name="attachment">

                                                         <div class="file-name mt-3 text-success fw-semibold d-none"></div>
                                                    </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div id="otherProgramFieldTAPD" class="mt-3 d-none">
                                                        <label class="form-label">Specify Program <span style="color:red">*</span></label>
                                                        <input type="text" class="form-control" id="otherProgramInputTAPD" name="program_others">
                                                </div>
                                             </div>
                                        </div>
                                    </div>                                
                                </div>
                        {{-- Resource Person --}}
                                <div id="rpBody" class="d-none">
                                    <div class="mb-3 mt-3">
                                        <div class="row">
                                            <div class="col-md" style="flex: 0 0 31%; max width:31px;">
                                                        <div class="p-2">
                                                            <div class="d-flex align-items-start p-2">
                                                                <div class="rounded-circle d-flex p-1 align-items-center justify-content-center flex-shrink-0 me-3" style="background-color: #cfe0ff; width:50px; height:50px;">
                                                                        <i class="bi bi-file-earmark fs-5 text-primary"></i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="me-1">
                                                                        Purpose of request <span style="color:red;">*</span>
                                                                    </h6>
                                                                    <small class="text-muted">
                                                                        Briefly describe the purpose of your request
                                                                    </small>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        <textarea 
                                                            id="reasonRequestRP" 
                                                            name="purpose_of_request" 
                                                            class="form-control" 
                                                            rows="5" 
                                                            placeholder="Input purpose of your request..."
                                                            style="height:30px;"></textarea>
                                                </div>
                                                <div class="vertical-divider" style="width: 1px;"></div>
                                                <div class="col-md" style="flex: 0 0 31%; max width:31px;">
                                                        <div class="p-2">
                                                            <div class="d-flex align-item-center p-2">
                                                                <div class="rounded-circle d-flex p-1 align-items-center justify-content-center flex-shrink-0 me-3" style="background-color:#cfe0ff; width:50px; height:50px;">
                                                                        <i class="bi bi-activity fs-5 text-primary"></i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="me-1">
                                                                        Program <span style="color:red">*</span>
                                                                    </h6>
                                                                    <small class="text-muted">
                                                                        Select a program you want for this request
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                            <select class="form-select" id="programSelectRP" name="program">
                                                                <option value="">Select a program</option>
                                                                @foreach($programs as $program)
                                                                <option value="{{$program->id}}">{{$program->program}}</option>
                                                                @endforeach
                                                                <option value="others">Others</option>
                                                            </select>
                                                    <div id="otherProgramFieldRP" class="mt-3 d-none">
                                                        <label class="form-label">Specify Program <span style="color:red">*</span></label>
                                                        <input type="text" class="form-control" id="otherProgramInputRP" name="program_others">
                                                    </div>
                                                </div>
                                                <div class="vertical-divider" style="width: 1px;"></div>
                                                <div class="col-md" style="flex: 0 0 31%; max width:31px;">
                                                       <div class="mb-3">
                                                            <div class="d-flex align-items-center p-2">
                                                                <div class="rounded-circle d-flex p-1 align-items-center justify-content-center flex-shrink-0 me-3" style="background-color:#cfe0ff; width:50px; height:50px;">
                                                                    <i class="bi bi-geo-alt-fill"> </i>
                                                                </div>
                                                                <div>
                                                                    
                                                                    <h6 class="me-1">
                                                                        Venue<span class="text-danger">*</span>
                                                                    </h6>

                                                                    <small class="text-muted">
                                                                        Select the venue or location of the activity.
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <div class="input-group mt-3">
                                                                <span class="input-group-text bg-white border-end-0">
                                                                    <i class="bi bi-geo-alt-fill text-secondary"></i>
                                                                </span>

                                                                <input type="text" class="form-control border-start-0" id="venue" name="venue" placeholder="Input venue or location">
                                                            </div>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="flex-grow-1 border-top mt-4"> </div>
                                                    <div class="row p-3">
                                                        <div class= "col-md-8 border-end d-flex flex-column">
                                                            <div class="d-flex gap-3 p--2 flex-grow-1">
                                                                <div class="rounded-circle d-flex p-1 align-items-center justify-content-center flex-shrink-0 me-3" style="background-color:#cfe0ff; width:50px; height:50px;">
                                                                    <i class="bi bi-people-fill"></i>
                                                                </div>
                                                                <div>
                                                                    <h6>
                                                                        Type of Activity <span style="color:red;">*</span>
                                                                    </h6>
                                                                    <small class="text-muted">
                                                                        Select the format or delivery method of activity
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-start p-2">
                                                                <div class="card m-2 act-card-ftf" id="facetoface">
                                                                    <div class="card-body">
                                                                        <div class="p-3">
                                                                            <div class="rounded-circle d-flex p-1 align-items-center justify-content-center flex-shrink-0 me-3" style="background-color:#cfe0ff; width:30px; height:30px;">
                                                                                <i class="bi bi-people"></i>
                                                                            </div>
                                                                        </div>
                                                                            <h6 class="mb-0">Face to Face</h6>
                                                                            <p class="text-muted" style="font-size: 0.7rem;">In-person activity with attendees at the same location</p>
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="card m-2 act-card-vt" id="virtual">
                                                                    <div class="card-body">
                                                                        <div class="p-3">
                                                                            <div class="rounded-circle d-flex p-1 align-items-center justify-content-center flex-shrink-0 me-3" style="background-color:#daffee; width:30px; height:30px;">
                                                                                <i class="bi bi-display"></i>
                                                                            </div>
                                                                        </div>
                                                                            <h6 class="mb-0">Virtual</h6>
                                                                            <p class="text-muted" style="font-size: 0.7rem;">Activity conducted online through digital platforms</p>
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="card m-2 act-card-blended" id="blended">
                                                                    <div class="card-body">
                                                                        <div class="p-3">
                                                                            <div class="rounded-circle d-flex p-1 align-items-center justify-content-center flex-shrink-0 me-3" style="background-color:#ece5ff; width:30px; height:30px;">
                                                                                <i class="bi bi-arrow-left-right"></i>
                                                                            </div>
                                                                        </div>
                                                                            <h6 class="mb-0">Blended</h6>
                                                                            <p class="text-muted" style="font-size: 0.7rem;">Combination of in-person and online parcitipation</p>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                          </div>

                                                        <div class='col-md-4 d-flex flex-column'>
                                                            <div class="d-flex align-items-center ps-3"> 
                                                                <div class="pt-3">
                                                                    <div>
                                                                        <h6 class="mb-0">
                                                                            Date of Activity <span style="color:red">*</span>
                                                                        </h6>
                                                                        <small class="text-muted">
                                                                            Select the date or date range of the activity
                                                                        </small>    
                                                                    </div>
                                                                        <input type="date" class="form-control" id="dateOfActivity" name="date_of_activity">

                                                                    <h6 class="mb-0 p-1 mt-3">
                                                                        Supporting Document(Optional)
                                                                    </h6>
                                                                    <div class="card p-2 mt-2">
                                                                            <div class="d-flex align-items-center mb-2">
                                                                                <i class="bi bi-file-earmark-arrow-up fs-2 text-primary"></i>
                                                                                <div class="ps-3">
                                                                                    <h6 class="mb-0 text-primary fw-bold">Upload File</h6>
                                                                                    <small class="text-muted"> PDF, JPG, PNG (Max. 10MB)</small>
                                                                                </div>
                                                                            </div>
                                                        
                                                            
                                                                    <label class="upload-box" for="supportFileRP">
                                                                        <div class="mt-2">
                                                                            Drag &amp; Drop your file here
                                                                        </div>
                                                                        <small class="text-muted">or click to browse</small>
                                                                    </label>

                                                                        <input type="file" id="supportFileRP" class="d-none" accept=".pdf,.jpg,.png" name="attachment">

                                                                        <div class="file-name mt-3 text-success fw-semibold d-none"></div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                    </div>
                                </div>
                                
                                <div id="kpBody" class="d-none">
                                    <div class="row p-2">
                                        <div class="col-md-6"> 
                                                <div class="d-flex align-items-start p-2">
                                                        <div class="rounded-circle d-flex p-1 align-items-center justify-content-center flex-shrink-0 me-3" style="background-color: #cfe0ff; width:50px; height:50px;">
                                                                <i class="bi bi-file-earmark fs-5 text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="me-1">
                                                                Purpose of request <span style="color:red;">*</span>
                                                            </h6>
                                                            <span class="text-muted">
                                                                Briefly describe the purpose of your request
                                                            </span>
                                                        </div>
                                                </div>
                                                                <textarea 
                                                                id="reasonRequestKP" 
                                                                name="purpose_of_request" 
                                                                class="form-control" 
                                                                rows="5" 
                                                                placeholder="Input purpose of your request..."
                                                                style="height:30px;"></textarea>
                                                                    <h6 class="mb-0 p-1 mt-3">
                                                                        Supporting Document(Optional)
                                                                    </h6>
                                                                    <div class="card p-2 mt-2">
                                                                            <div class="d-flex align-items-center mb-2">
                                                                                <i class="bi bi-file-earmark-arrow-up fs-2 text-primary"></i>
                                                                                <div class="ps-3">
                                                                                    <h6 class="mb-0 text-primary fw-bold">Upload File</h6>
                                                                                    <small class="text-muted"> PDF, JPG, PNG (Max. 10MB)</small>
                                                                                </div>
                                                                            </div>
                                                        
                                                            
                                                                    <label class="upload-box" for="supportFileKP">
                                                                        <div class="mt-2">
                                                                            Drag &amp; Drop your file here
                                                                        </div>
                                                                        <small class="text-muted">or click to browse</small>
                                                                    </label>

                                                                        <input type="file" id="supportFileKP" class="d-none" accept=".pdf,.jpg,.png" name="attachment">

                                                                        <div class="file-name mt-3 text-success fw-semibold d-none"></div>
                                                                    </div>
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="p-2">
                                                            <div class="d-flex align-item-center p-2">
                                                                <div class="rounded-circle d-flex p-1 align-items-center justify-content-center flex-shrink-0 me-3" style="background-color:#cfe0ff; width:50px; height:50px;">
                                                                        <i class="bi bi-activity fs-5 text-primary"></i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="me-1">
                                                                        Program <span style="color:red">*</span>
                                                                    </h6>
                                                                    <small class="text-muted">
                                                                        Select a program you want for this request
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <select class="form-select" id="programSelectKP" name="program">
                                                                <option value="">Select a program</option>
                                                                @foreach($programs as $program)
                                                                <option value="{{$program->id}}">{{$program->program}}</option>
                                                                @endforeach
                                                                <option value="others">Others</option>
                                                </select>
                                                    <div id="otherProgramFieldKP" class="mt-3 d-none">
                                                        <label class="form-label">Specify Program <span style="color:red">*</span></label>
                                                        <input type="text" class="form-control" id="otherProgramInputKP" name="program_others">
                                                    </div> 
                                                    
                                                <div class="mb-0 mt-3">
                                                                    <h6>
                                                                        Type of knowledge product requesting: <span style="color:red">*</span>
                                                                    </h6>
                                                            </div>
                                                <div class="row g-3">
                                                                            <div class="col-md-6">
                                                                                <label class="kp-card">
                                                                                    <input
                                                                                        type="checkbox"
                                                                                        name="type_of_knowledge_product[]"
                                                                                        value="Program Manual"
                                                                                        class="d-none kp-input">

                                                                                    <div class="kp-content">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <i class="bi bi-journal-bookmark fs-4 text-primary me-3" ></i>

                                                                                            <span>Program Manual</span>
                                                                                        </div>

                                                                                        <i class="bi bi-square kp-check"></i>
                                                                                    </div>
                                                                                </label>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="kp-card">
                                                                                    <input
                                                                                        type="checkbox"
                                                                                        name="type_of_knowledge_product[]"
                                                                                        value="Handbook"
                                                                                        class="d-none kp-input">

                                                                                    <div class="kp-content">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <i class="bi bi-journal-text fs-4 text-primary me-3" ></i>

                                                                                            <span>Handbook</span>
                                                                                        </div>

                                                                                        <i class="bi bi-square kp-check"></i>
                                                                                    </div>
                                                                                </label>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="kp-card">
                                                                                    <input
                                                                                        type="checkbox"
                                                                                        name="type_of_knowledge_product[]"
                                                                                        value="Modules/Session Guides"
                                                                                        class="d-none kp-input">

                                                                                    <div class="kp-content">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <i class="bi bi-compass fs-4 text-primary me-3" ></i>

                                                                                            <span>Modules/Session Guides</span>
                                                                                        </div>

                                                                                        <i class="bi bi-square kp-check"></i>
                                                                                    </div>
                                                                                </label>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="kp-card">
                                                                                    <input
                                                                                        type="checkbox"
                                                                                        name="type_of_knowledge_product[]"
                                                                                        value="Project Briefer"
                                                                                        class="d-none kp-input">

                                                                                    <div class="kp-content">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <i class="bi bi-bookmark fs-4 text-primary me-3" ></i>

                                                                                            <span>Project Briefer</span>
                                                                                        </div>

                                                                                        <i class="bi bi-square kp-check"></i>
                                                                                    </div>
                                                                                </label>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="kp-card">
                                                                                    <input
                                                                                        type="checkbox"
                                                                                        name="type_of_knowledge_product[]"
                                                                                        value="Training Manual"
                                                                                        class="d-none kp-input">

                                                                                    <div class="kp-content">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <i class="bi bi-card-text fs-4 text-primary me-3" ></i>

                                                                                            <span>Training Manual</span>
                                                                                        </div>

                                                                                        <i class="bi bi-square kp-check"></i>
                                                                                    </div>
                                                                                </label>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="kp-card">
                                                                                    <input
                                                                                        type="checkbox"
                                                                                        name="type_of_knowledge_product[]"
                                                                                        value="ST Compendium"
                                                                                        class="d-none kp-input">

                                                                                    <div class="kp-content">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <i class="bi bi-file-earmark-richtext fs-4 text-primary me-3" ></i>

                                                                                            <span>ST Compendium</span>
                                                                                        </div>

                                                                                        <i class="bi bi-square kp-check"></i>
                                                                                    </div>
                                                                                </label>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="kp-card">
                                                                                    <input
                                                                                        type="checkbox"
                                                                                        name="type_of_knowledge_product[]"
                                                                                        value="ST Portfolio"
                                                                                        class="d-none kp-input">

                                                                                    <div class="kp-content">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <i class="bi bi-folder2-open fs-4 text-primary me-3" ></i>

                                                                                            <span>ST Portfolio</span>
                                                                                        </div>

                                                                                        <i class="bi bi-square kp-check"></i>
                                                                                    </div>
                                                                                </label>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="kp-card">
                                                                                    <input
                                                                                        type="checkbox"
                                                                                        name="type_of_knowledge_product[]"
                                                                                        value="Others"
                                                                                        class="d-none kp-input">

                                                                                    <div class="kp-content">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <i class="bi bi-three-dots fs-4 text-primary me-3" ></i>

                                                                                            <span>Others</span>
                                                                                        </div>

                                                                                        <i class="bi bi-square kp-check"></i>
                                                                                    </div>
                                                                                </label>
                                                                            </div>

                                                                        </div>

                                                                        <input
                                                                            type="text"
                                                                            class="form-control mt-3 d-none"
                                                                            id="otherKnowledgeProduct"
                                                                            name="type_of_knowledge_product_others"
                                                                            placeholder="Please specify">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 border-top mt-4"> </div>
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <button type="button" id="back" class="btn btn-outline-secondary wizard-btn">
                                        <i class="bi bi-arrow-left"></i>
                                    </button> 

  
                                        <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-outline-secondary wizard-btn" data-bs-dismiss="modal"  style="width:100px; border-radius:10px;">Cancel</button>
                                                <button type="submit" id="submitBtn" class="d-submit-button" class="btn btn-primary wizard-bt" style="width:200px; border-radius:10px;" >Submit</i></button>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
            </div>
        </div>
        </form>
    </div>
</div>
</div>
    <script>
        let step2Unlocked = false;
        const serviceCards = ['tacp', 'tapd','rp', 'kp'];   
        const toggle = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const input1 = document.getElementById('supportFileTACP');
        const input2 = document.getElementById('supportFileTAPD');
        const input3 = document.getElementById('supportFileRP');
        const input4 = document.getElementById('supportFileKP');
        const uploadBoxes = document.querySelectorAll('.upload-box');
        const textarea = document.getElementById('reasonRequestTAPD');
        const checkboxes = document.querySelectorAll('.kp-input');
        const otherInput = document.getElementById('otherKnowledgeProduct');

    toggle.addEventListener('click', function () {
        if(password.type === 'password'){
            password.type = 'text';
            this.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            password.type = 'password';
            this.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });

    document.getElementById('loginForm').addEventListener('submit', function(e){
        e.preventDefault();
    let form = this;
    let formData = new FormData(form);

    document.getElementById('loginError').innerHTML = '';

    fetch(form.action, {
        method: 'POST',
        headers:{
            'X-Requested-With' : 'XMLHttpRequest',
            'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').content
        },
        body:formData
    }).then(response => response.json())
    .then(data => {
        if(data.success){
            window.location.href= data.redirect;
        }else {
            document.getElementById('loginError').innerHTML = 
            `<div class="alert alert-danger">${data.message}</div>`;
        }
    })
    .catch(error=>{
        console.log(error);
        });
    });

    document.getElementById('region').addEventListener('change', function(){
        let regionCode = this.value;

        fetch('provinces/' + regionCode)
        .then(response => response.json())
        .then(data => {
            let province = document.getElementById('province');

            province.innerHTML =
            '<option value="">Select Province</option>';

            document.getElementById('city').innerHTML =
            '<option value="">Select City</option>';

            data.forEach(function(item){
                province.innerHTML +=
                `<option value="${item.province_code}">
                ${item.name}
                </option>`;
            });
        }).catch(error => console.error(error));
    });

    document.getElementById('province').addEventListener('change', function () {
    let provinceCode = this.value;

    fetch('/cities/' + provinceCode)
        .then(async response => {
            if (!response.ok) {
                const error = await response.text();
                console.log(error);
                throw new Error('Server returned ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            let city = document.getElementById('city');

            city.innerHTML = '<option value="">Select City</option>';

            data.forEach(function(item) {
                city.innerHTML += `
                    <option value="${item.city_code}">
                        ${item.name}
                    </option>`;
            });
        })
        .catch(error => console.error(error));
});

        // Request details bodies transition
        document.addEventListener('DOMContentLoaded', function () {
                    // Remove purpose_of_request and program names initially; they'll be set when a service is selected
                    const initialTa = ['reasonRequestTACP','reasonRequestTAPD','reasonRequestRP','reasonRequestKP'];
                    initialTa.forEach(id => {
                        const ta = document.getElementById(id);
                        if(ta) ta.removeAttribute('name');
                    });
                    const initialSelects = ['programSelectTACP','programSelectTAPD','programSelectRP','programSelectKP'];
                    initialSelects.forEach(id => {
                        const sel = document.getElementById(id);
                        if(sel) sel.removeAttribute('name');
                    });
                    const initialOtherInputs = ['otherProgramInputTACP','otherProgramInputTAPD','otherProgramInputRP','otherProgramInputKP'];
                    initialOtherInputs.forEach(id => {
                        const inp = document.getElementById(id);
                        if(inp) inp.removeAttribute('name');
                    });
            
            
            //Next Button
            document.getElementById('nextBtn').addEventListener('click', function () { 
            if(
                document.getElementById('first_name').value.trim() === '' ||
                document.getElementById('last_name').value.trim() === '' ||
                document.getElementById('email').value.trim() === '' ||
                document.getElementById('sex').value.trim() === '' ||
                document.getElementById('region').value.trim() === '' ||
                document.getElementById('province').value.trim() === '' ||
                document.getElementById('city').value.trim() === ''
            ){
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Information',
                    text: 'Please complete all required fields before proceeding.',
                    confirmButtonColor: '#062c52',
                    confirmButtonText: 'OK'
                });

                return;
            }
            step2Unlocked = true;

            //Step 1
            document.getElementById('step1').classList.add('d-none');
            //Step 2
            document.getElementById('step2').classList.remove('d-none');
            //step 3
            document.getElementById('step3').classList.add('d-none');
            
            document.getElementById('card1').style.backgroundColor = '#e4e4e4';
            document.getElementById('card1').style.borderColor = '#dee2e6';
            document.getElementById('card1Number').style.color = "black";
            document.getElementById('card1Rounded').style.backgroundColor = "#fff";
            document.getElementById('card1Label').style.color = "black";

            document.getElementById('card2').style.backgroundColor = '#ddecff';
            document.getElementById('card2').style.borderColor = '#062c52';
            document.getElementById('card2Number').style.color = "#fff";
            document.getElementById('card2Rounded').style.backgroundColor = "#062c52";
            document.getElementById('card2Label').style.color = "#062c52";

            });
            //Card 1 Body
            document.getElementById('card1').addEventListener('click', function(){
            //Step 1
            document.getElementById('step1').classList.remove('d-none');
            //Step 2
            document.getElementById('step2').classList.add('d-none');
            //Step3
            document.getElementById('step3').classList.add('d-none');
            
            document.getElementById('card1').style.backgroundColor = '#ddecff';
            document.getElementById('card1').style.borderColor = '#062c52';
            document.getElementById('card1Number').style.color = "#fff";
            document.getElementById('card1Rounded').style.backgroundColor = "#062c52";

            document.getElementById('card2').style.backgroundColor = '#e4e4e4';
            document.getElementById('card2').style.borderColor = '#dee2e6';
            document.getElementById('card2Number').style.color = "black";
            document.getElementById('card2Rounded').style.backgroundColor = "#fff";

            })

            //Card 2 Body
            document.getElementById('card2').addEventListener('click', function(){
                if(
                document.getElementById('first_name').value.trim() === '' ||
                document.getElementById('last_name').value.trim() === '' ||
                document.getElementById('email').value.trim() === '' ||
                document.getElementById('sex').value.trim() === '' ||
                document.getElementById('region').value.trim() === '' ||
                document.getElementById('province').value.trim() === '' ||
                document.getElementById('city').value.trim() === ''
            ){
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Information',
                    text: 'Please complete all required fields before proceeding.',
                    confirmButtonColor: '#062c52',
                    confirmButtonText: 'OK'
                });

                return;
            }
            
                if(step2Unlocked){
            //Step 1
            document.getElementById('step1').classList.add('d-none');
            //Step 2
            document.getElementById('step2').classList.remove('d-none');
            //Step 3
            document.getElementById('step3').classList.add('d-none');
            
            document.getElementById('card1').style.backgroundColor = '#e4e4e4';
            document.getElementById('card1').style.borderColor = '#dee2e6';
            document.getElementById('card1Number').style.color = "black";
            document.getElementById('card1Rounded').style.backgroundColor = "#fff";

            document.getElementById('card2').style.backgroundColor = '#ddecff';
            document.getElementById('card2').style.borderColor = '#062c52';
            document.getElementById('card2Number').style.color = "#fff";
            document.getElementById('card2Rounded').style.backgroundColor = "#062c52";
            document.getElementById('card2Label').style.color = "#062c52";
                }
                else {
                    Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Information',
                    text: 'Please complete all required fields before proceeding.',
                    confirmButtonColor: '#062c52',
                    confirmButtonText: 'OK'
                });

                return;
                }
            
            })

            // Service Cards body
        serviceCards.forEach(service => {

        document.getElementById(service).addEventListener('click', function () {

                // Hide previous steps
                document.getElementById('step1').classList.add('d-none');
                document.getElementById('step2').classList.add('d-none');
                document.getElementById('step3').classList.remove('d-none');

                // Hide all service bodies
                document.getElementById('tacpBody').classList.add('d-none');
                document.getElementById('tapdBody').classList.add('d-none');
                document.getElementById('rpBody').classList.add('d-none');
                document.getElementById('kpBody').classList.add('d-none');

                // Show only the selected one
                document.getElementById(service + 'Body').classList.remove('d-none');
                // set hidden ticket_category input to the selected service
                const svc = document.getElementById(service).dataset.service || '';
                const ticketCatInput = document.getElementById('ticket_category');
                if(ticketCatInput) ticketCatInput.value = svc;

                // ensure only the active service textarea is submitted as `purpose_of_request`
                const map = {
                    tacp: 'reasonRequestTACP',
                    tapd: 'reasonRequestTAPD',
                    rp: 'reasonRequestRP',
                    kp: 'reasonRequestKP'
                };

                Object.keys(map).forEach(key => {
                    const ta = document.getElementById(map[key]);
                    if (!ta) return;
                    if (key === service) {
                        ta.setAttribute('name', 'purpose_of_request');
                        ta.setAttribute('required', '');
                    } else {
                        ta.removeAttribute('name');
                        ta.removeAttribute('required');
                    }
                });

                // ensure only the active service program select has name='program'
                const progMap = {
                    tacp: 'programSelectTACP',
                    tapd: 'programSelectTAPD',
                    rp: 'programSelectRP',
                    kp: 'programSelectKP'
                };
                Object.keys(progMap).forEach(key => {
                    const sel = document.getElementById(progMap[key]);
                    if (!sel) return;
                    if (key === service) {
                        sel.setAttribute('name', 'program');
                    } else {
                        sel.removeAttribute('name');
                    }
                });

                // set program_others name only for active other input
                const otherMap = {
                    tacp: 'otherProgramInputTACP',
                    tapd: 'otherProgramInputTAPD',
                    rp: 'otherProgramInputRP',
                    kp: 'otherProgramInputKP'
                };
                Object.keys(otherMap).forEach(key => {
                    const inp = document.getElementById(otherMap[key]);
                    if (!inp) return;
                    if (key === service) {
                        inp.setAttribute('name', 'program_others');
                    } else {
                        inp.removeAttribute('name');
                    }
                });

                // ensure purpose_of_request has content when moving to step3
                const activePurpose = document.querySelector('textarea[name="purpose_of_request"]');
                if (activePurpose) {
                    // remove previous invalid style/message
                    activePurpose.classList.remove('is-invalid');
                }

        });



    });

    document.getElementById('back').addEventListener('click', function(){
            //Step 1
            document.getElementById('step1').classList.add('d-none');
            //Step 2
            document.getElementById('step2').classList.remove('d-none');
            //step 3
            document.getElementById('step3').classList.add('d-none');
    })
});

document.getElementById('programSelectTACP').addEventListener('change', function(){
    const otherFieldTACP = document.getElementById('otherProgramFieldTACP');
    const ProgramInputFieldTACP = document.getElementById('otherProgramInputTACP');

    if(this.value==='others'){
        otherFieldTACP.classList.remove('d-none');
        ProgramInputFieldTACP.setAttribute('required', '');
    } else {
        otherFieldTACP.classList.add('d-none');
        ProgramInputFieldTACP.value = '';
        ProgramInputFieldTACP.removeAttribute('required');
    }
});

document.getElementById('programSelectTAPD').addEventListener('change', function(){
    const otherFieldTAPD = document.getElementById('otherProgramFieldTAPD');
    const ProgramInputFieldTAPD = document.getElementById('otherProgramInputTAPD');

    if(this.value==='others'){
        otherFieldTAPD.classList.remove('d-none');
        ProgramInputFieldTAPD.setAttribute('required', '');
    } else {
        otherFieldTAPD.classList.add('d-none');
        ProgramInputFieldTAPD.value = '';
        ProgramInputFieldTAPD.removeAttribute('required');
    }
});

document.getElementById('programSelectRP').addEventListener('change', function(){
    const otherFieldRP = document.getElementById('otherProgramFieldRP');
    const ProgramInputFieldRP = document.getElementById('otherProgramInputRP');

    if(this.value==='others'){
        otherFieldRP.classList.remove('d-none');
        ProgramInputFieldRP.setAttribute('required', '');
    } else {
        otherFieldRP.classList.add('d-none');
        ProgramInputFieldRP.removeAttribute('required');
        ProgramInputFieldRP.value = '';                                                                                                                                                                                                     

    }
});

document.getElementById('programSelectKP').addEventListener('change', function(){
    const otherFieldKP = document.getElementById('otherProgramFieldKP');
    const ProgramInputFieldKP = document.getElementById('otherProgramInputKP');

    if(this.value==='others'){
        otherFieldKP.classList.remove('d-none');
        ProgramInputFieldKP.setAttribute('required', '');
    } else {
        otherFieldKP.classList.add('d-none');
        ProgramInputFieldKP.removeAttribute('required');
        ProgramInputFieldKP.value = '';                                                                                                                                                                                                 

    }
});

// OTP send & verify flow (used by Submit flow)
async function startOtpFlow(email) {
    if (!email) {
        Swal.fire({ icon: 'warning', title: 'Email required', text: 'Please enter your email first.', confirmButtonColor: '#062c52' });
        return;
    }

    try {
        const res = await fetch('{{ route('tickets.sendOtp') }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email })
        });

        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Failed to send OTP');

        // show custom OTP modal with 6-digit inputs
        const otpModalEl = document.getElementById('otpModal');
        const otpEmailMasked = document.getElementById('otpEmailMasked');
        const otpInputs = otpModalEl.querySelectorAll('.otp-input');
        otpEmailMasked.innerText = email.replace(/(.).*(.@)/, '$1***$2');
        const bsOtpModal = new bootstrap.Modal(otpModalEl);
        otpInputs.forEach(i => { i.value = ''; i.disabled = false; });
        bsOtpModal.show();

        setTimeout(() => otpInputs[0].focus(), 200);

        const gatherCode = () => Array.from(otpInputs).map(i => i.value.trim()).join('');

        otpInputs.forEach((input, idx) => {
            input.addEventListener('input', function (e) {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length === 1 && idx < otpInputs.length - 1) {
                    otpInputs[idx + 1].focus();
                }
            });
            input.addEventListener('keydown', function (e) {
                if (e.key === 'Backspace' && !this.value && idx > 0) {
                    otpInputs[idx - 1].focus();
                }
            });
            input.addEventListener('paste', function (e) {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text').trim().slice(0,6);
                for (let i = 0; i < paste.length && i < otpInputs.length; i++) {
                    otpInputs[i].value = paste[i];
                }
            });
        });

        const verifyBtn = document.getElementById('verifyOtpBtn');
        const onVerify = async () => {
            const otp = gatherCode();
            if (!otp || otp.length < 6) {
                Swal.fire({ icon: 'warning', title: 'Invalid code', text: 'Please enter the 6-digit code.', confirmButtonColor: '#062c52' });
                return;
            }

            verifyBtn.disabled = true;
            verifyBtn.innerText = 'Verifying...';

            try {
                const verifyRes = await fetch('{{ route('tickets.verifyOtp') }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email, otp })
                });
                const verifyData = await verifyRes.json();
                if (!verifyRes.ok) throw new Error(verifyData.message || 'OTP verification failed');

                Swal.fire({ icon: 'success', title: 'Verified', text: 'Your email has been verified.', confirmButtonColor: '#062c52' });
                ticketForm.dataset.otpVerified = 'true';
                try { ticketForm.dispatchEvent(new Event('otp:verified')); } catch (e) {}
                bsOtpModal.hide();
                verifyBtn.removeEventListener('click', onVerify);
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'OTP Error', text: err.message || 'Could not complete OTP flow', confirmButtonColor: '#062c52' });
                verifyBtn.disabled = false;
                verifyBtn.innerText = 'Verify';
            }
        };

        verifyBtn.removeEventListener('click', onVerify);
        verifyBtn.addEventListener('click', onVerify);

    } catch (err) {
        Swal.fire({ icon: 'error', title: 'OTP Error', text: err.message || 'Could not complete OTP flow', confirmButtonColor: '#062c52' });
    }
}

        // Show filename for the specific file input
        [input1, input2, input3, input4].forEach(input => {
            if (!input) return;
            input.addEventListener('change', function () {
                const card = this.closest('.card');
                const fn = card ? card.querySelector('.file-name') : document.querySelector('.file-name');
                if (this.files && this.files.length) {
                    if (fn) {
                        fn.classList.remove('d-none');
                        fn.innerHTML = `<i class="bi bi-check-circle-fill me-2"></i>${this.files[0].name}`;
                    }
                } else if (fn) {
                    fn.classList.add('d-none');
                    fn.innerHTML = '';
                }
            });
        });

        // Wire up each upload-box label to its corresponding input for drag/drop and click
        uploadBoxes.forEach(label => {
            const forId = label.getAttribute('for');
            const input = forId ? document.getElementById(forId) : null;
            if (!input) return;

            label.addEventListener('dragover', function (e) {
                e.preventDefault();
                this.classList.add('dragover');
            });
            label.addEventListener('dragleave', function (e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });
            label.addEventListener('drop', function (e) {
                e.preventDefault();
                this.classList.remove('dragover');
                input.files = e.dataTransfer.files;
                input.dispatchEvent(new Event('change'));
            });
            // clicking label will focus file input automatically via for="id"
        });
// document.addEventListener('DOMContentLoaded', function(){
    
    const cardBodyChangeftf = document.getElementById('facetoface');
    const cardBodyChangev = document.getElementById('virtual');
    const cardBodyChangeb = document.getElementById('blended');

    
document.getElementById('facetoface').addEventListener('click', function(){

    cardBodyChangeftf.style.backgroundColor = "#eef6ff";
    cardBodyChangeftf.style.borderColor = "#0d6efd";
    cardBodyChangev.style.backgroundColor = "#fff";
    cardBodyChangev.style.borderColor = "#dee2e6";
    cardBodyChangeb.style.backgroundColor = "#fff";
    cardBodyChangeb.style.borderColor = "#dee2e6";
    const typeInput = document.getElementById('type_of_activity');
    if(typeInput) typeInput.value = 'Face to Face';
});

document.getElementById('virtual').addEventListener('click', function(){

    cardBodyChangev.style.backgroundColor = "#ebffec";
    cardBodyChangev.style.borderColor = "#4d06d1";
    cardBodyChangeftf.style.backgroundColor = "#fff";
    cardBodyChangeftf.style.borderColor = "#dee2e6";
    cardBodyChangeb.style.backgroundColor = "#fff";
    cardBodyChangeb.style.borderColor = "#dee2e6";
    const typeInput = document.getElementById('type_of_activity');
    if(typeInput) typeInput.value = 'Virtual';
});

document.getElementById('blended').addEventListener('click', function(){

    cardBodyChangeb.style.backgroundColor = "#f5f0ff";
    cardBodyChangeb.style.borderColor = "#6c01a1";
    cardBodyChangeftf.style.backgroundColor = "#fff";
    cardBodyChangeftf.style.borderColor = "#dee2e6";
    cardBodyChangev.style.backgroundColor = "#fff";
    cardBodyChangev.style.borderColor = "#dee2e6";
    const typeInput = document.getElementById('type_of_activity');
    if(typeInput) typeInput.value = 'Blended';
});

// Client-side guard + AJAX submit so file uploads are reliably sent
const ticketForm = document.getElementById('ticketForm');
if (ticketForm) {
    ticketForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const ticketCat = document.getElementById('ticket_category')?.value || '';
        const first = document.getElementById('first_name')?.value.trim() || '';
        const last = document.getElementById('last_name')?.value.trim() || '';
        const email = document.getElementById('email')?.value.trim() || '';
        const sex = document.getElementById('sex')?.value || '';
        const region = document.getElementById('region')?.value || '';
        const province = document.getElementById('province')?.value || '';
        const city = document.getElementById('city')?.value || '';

        const missing = [];
        if (!first) missing.push('First name');
        if (!last) missing.push('Last name');
        if (!email) missing.push('Email');
        if (!sex) missing.push('Sex');
        if (!region) missing.push('Region');
        if (!province) missing.push('Province');
        if (!city) missing.push('City/Municipality');
        if (!ticketCat) missing.push('Service selection');

        const activeProgram = document.querySelector('select[name="program"]');
        if (activeProgram && (!activeProgram.value || activeProgram.value === '')) {
            missing.push('Program selection');
        }

        if (missing.length) {

            Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Information',
                    text: 'Please complete required fields: ' + missing.join(', '),
                    confirmButtonColor: '#062c52',
                    confirmButtonText: 'OK'
                });
            if (missing.some(m => ['First name','Last name','Email','Sex','Region','Province','City/Municipality'].includes(m))) {
                document.getElementById('step1').classList.remove('d-none');
                document.getElementById('step2').classList.add('d-none');
                document.getElementById('step3').classList.add('d-none');
            }
            return false;
        }

        // Ensure the active service's purpose_of_request is filled
        const purposeEl = ticketForm.querySelector('textarea[name="purpose_of_request"]');
        if (purposeEl && purposeEl.value.trim() === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Purpose',
                text: 'Please enter Purpose of request for the selected service.',
                confirmButtonColor: '#062c52'
            });
            purposeEl.classList.add('is-invalid');
            purposeEl.focus();
            return false;
        }

        // If OTP not yet verified, trigger OTP flow then submit after verification
        const proceedAfterOtp = async () => {
            // attach one-time listener to continue submission when OTP verified
            const handler = async () => {
                try {
                    await doSubmit();
                } catch (e) {
                    // doSubmit handles errors
                }
            };
            ticketForm.addEventListener('otp:verified', handler, { once: true });
            // start OTP flow which will show modal and continue submission on verify
            startOtpFlow(email);
            return;
        };

        // If Knowledge Product (KP) service selected, require at least one product checkbox
        if (ticketCat === 'knowledge') {
            const selectedProducts = ticketForm.querySelectorAll('input[name="type_of_knowledge_product[]"]:checked');
            if (!selectedProducts || selectedProducts.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Select Knowledge Product',
                    text: 'Please select at least one Type of knowledge product.',
                    confirmButtonColor: '#062c52'
                });
                // Bring user back to KP step
                document.getElementById('step1').classList.add('d-none');
                document.getElementById('step2').classList.add('d-none');
                document.getElementById('step3').classList.remove('d-none');
                const firstKp = ticketForm.querySelector('input[name="type_of_knowledge_product[]"]');
                if (firstKp) {
                    const kpCard = firstKp.closest('.kp-card');
                    if (kpCard) kpCard.scrollIntoView({behavior: 'smooth', block: 'center'});
                }
                return false;
            }

            // If 'Others' is selected, require the specification field
            const othersEl = ticketForm.querySelector('input[name="type_of_knowledge_product[]"][value="Others"]');
            const otherSpec = document.getElementById('otherKnowledgeProduct');
            if (othersEl && othersEl.checked && otherSpec && otherSpec.value.trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Specify Other Knowledge Product',
                    text: 'You selected "Others" — please specify the knowledge product.',
                    confirmButtonColor: '#062c52'
                });
                otherSpec.classList.add('is-invalid');
                otherSpec.focus();
                return false;
            }
        }

        // Build FormData and ensure the selected file (if any) is included explicitly
        const fd = new FormData(ticketForm);

        // Find any file input that has files (priority to the visible/active one)
        const fileInputs = Array.from(ticketForm.querySelectorAll('input[type="file"]'));
        for (const fi of fileInputs) {
            if (fi.files && fi.files.length) {
                // append under 'attachment' name (overwrites any blank entries)
                fd.set('attachment', fi.files[0], fi.files[0].name);
                break;
            }
        }

        const submitBtn = document.getElementById('submitBtn');

        // helper to perform the actual submission
        const doSubmit = async () => {
            if (submitBtn) submitBtn.disabled = true;

            const response = await fetch(ticketForm.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: fd,
            credentials: 'same-origin'
            }).then(async response => {
                const text = await response.text();
                let data = null;
                try { data = text ? JSON.parse(text) : null; } catch(e) { data = null; }

                if (response.ok) {
                    const title = (data && data.title) ? data.title : 'Request submitted';
                    const message = (data && data.message) ? data.message : 'Your ticket was submitted successfully.';
                    await Swal.fire({
                        icon: 'success',
                        title: title,
                        text: message,
                        confirmButtonColor: '#062c52'
                    });

                    if (data && data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        window.location.reload();
                    }
                    return;
                }

                const errMsg = (data && data.message) ? data.message : text || 'Unknown server error';
                throw new Error(errMsg);
            }).catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Submission failed',
                    text: err.message || 'An error occurred while submitting your request.',
                    confirmButtonColor: '#062c52'
                });
                if (submitBtn) submitBtn.disabled = false;
            });
        };

        // If OTP not verified, trigger OTP flow then submit when verified
        if (ticketForm.dataset.otpVerified !== 'true') {
            proceedAfterOtp();
            return;
        }
        // otherwise submit immediately
        doSubmit();
    });
}



checkboxes.forEach(checkbox => {

    checkbox.addEventListener('change', function () {

        const icon = this.closest('.kp-card').querySelector('.kp-check');

        if (this.checked) {
            icon.classList.remove('bi-square');
            icon.classList.add('bi-check-square-fill');
        } else {
            icon.classList.remove('bi-check-square-fill');
            icon.classList.add('bi-square');
        }

        // Show "Others" textbox if Others is checked
        const othersChecked = document.querySelector(
            '.kp-input[value="Others"]'
        ).checked;

        if (othersChecked) {
            otherInput.classList.remove('d-none');
            otherInput.required = true;
        } else {
            otherInput.classList.add('d-none');
            otherInput.required = false;
            otherInput.value = '';
        }
    });

});

// });


        
    
</script>
@endpush
@endsection

@if(session('success') || ($errors && $errors->any()))
    <script>
        (function(){
            const success = {!! json_encode(session('success') ?? null) !!};
            const errors = {!! json_encode($errors->any() ? $errors->all() : []) !!};
            if(success){
                alert(success);
            } else if(errors && errors.length){
                alert(errors.join('\n'));
            }
        })();
    </script>
@endif