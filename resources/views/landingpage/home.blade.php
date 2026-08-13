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

.receiving-office-panel{
    padding:16px;
    border:1px solid #dbe5f0;
    border-radius:10px;
    background:#f8fbff;
}

.receiving-office-panel .form-select{
    min-height:42px;
}

#fieldOfficeSelection{
    animation: fieldOfficeReveal .2s ease-out;
}

@keyframes fieldOfficeReveal{
    from{ opacity:0; transform:translateY(-6px); }
    to{ opacity:1; transform:translateY(0); }
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

/* OTP modal stacking and blur styles */
.otp-modal{ border-radius:18px; }
.otp-label{ color:#0b3ea9; font-weight:600; letter-spacing:.5px; }
.otp-title{ color:#0b3ea9; font-weight:500; }
.otp-info-card{ display:flex; align-items:center; border:2px solid #8d4dff; border-radius:10px; padding:18px; margin-top:15px; }
.otp-icon{ width:64px; height:64px; border-radius:14px; background:#4c7ff7; color:#fff; display:flex; align-items:center; justify-content:center; font-size:24px; font-weight:700; flex-shrink:0; }
.otp-code-card{ margin-top:25px; border:1px solid #ddd; border-radius:18px; padding:25px; }
.otp-input{ width:60px; height:60px; text-align:center; font-size:24px; font-weight:600; border-radius:14px; }
.otp-btn{ height:52px; border-radius:14px; font-size:24px; }
.btn-primary.otp-btn{ background:#123c90; border:none; }
.btn-outline-secondary.otp-btn{ border:1px solid #ddd; }

/* Ensure OTP modal is above other modals */
#otpModal { z-index: 2050 !important; }
.modal-backdrop.otp-backdrop { z-index: 2040 !important; background: rgba(255,255,255,0.08) !important; backdrop-filter: blur(1000px); }
/* Ensure SweetAlert2 appears above the OTP modal */
.swal2-container { z-index: 99999 !important; }
.swal2-popup { z-index: 100000 !important; }

.review-section{
    background:#fff;
    border:1px solid #e9ecef;
    border-radius:12px;
    padding:20px;
}

.review-section h6{
    font-weight:700;
    margin-bottom:18px;
    color:#0d6efd;
}

.review-item{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    padding:10px 0;
    border-bottom:1px dashed #e5e7eb;
}

.review-item:last-child{
    border-bottom:none;
}

.review-item span{
    color:#6c757d;
}

.review-item strong{
    text-align:right;
    max-width:60%;
}

.review-section{
    border:1px solid #e9ecef;
    border-radius:12px;
    padding:20px;
    background:#fff;
}

.review-section h6{
    font-weight:600;
    color:#0d6efd;
    margin-bottom:20px;
}

.review-item{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    padding:10px 0;
    border-bottom:1px dashed #dee2e6;
}

.review-item:last-child{
    border-bottom:none;
}

.review-item span{
    color:#6c757d;
    font-size:.9rem;
}

.review-item strong{
    max-width:60%;
    text-align:right;
    font-weight:600;
}

#reviewKnowledgeProduct div,
#reviewAttachment div{
    padding:8px 0;
    border-bottom:1px dashed #dee2e6;
}

#reviewKnowledgeProduct div:last-child,
#reviewAttachment div:last-child{
    border-bottom:none;
}
.step-card{
    position: relative;
    overflow: hidden;
    border-radius: 12px;
}

.step-card.clicked{
    animation: cardPop .35s ease;
}

.step-card::after{
    content: "";
    position: absolute;
    left: var(--x,50%);
    top: var(--y,50%);
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(13,110,253,.18);
    transform: translate(-50%,-50%);
    pointer-events: none;
}

.step-card.clicked::after{
    animation: ripple .55s ease-out;
}

@keyframes cardPop{

    0%{
        transform:scale(1);
    }

    35%{
        transform:scale(.97);
    }

    70%{
        transform:scale(1.02);
    }

    100%{
        transform:scale(1);
    }

}

@keyframes ripple{

    0%{
        width:0;
        height:0;
        opacity:.5;
    }

    100%{
        width:420px;
        height:420px;
        opacity:0;
    }

}

.wizard-back-btn{

    display:flex;
    align-items:center;
    gap:8px;

    padding:.75rem 1.2rem;

    border:1px solid #d0d7de;

    border-radius:12px;

    background:#fff;

    color:#495057;

    font-weight:600;

    transition:all .25s ease;

}

.wizard-back-btn:hover{

    background:#f8f9fa;

    color:#062c52;

    border-color:#062c52;

    transform:translateX(-3px);

    box-shadow:0 8px 18px rgba(0,0,0,.08);

}

.wizard-back-btn:active{

    transform:scale(.97);

}

.wizard-back-btn i{

    transition:transform .25s ease;

}

.wizard-back-btn:hover i{

    transform:translateX(-5px);

}

.wizard-cancel-btn{

    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;

    min-width:130px;
    height:48px;

    border:1px solid #d6dbe3;
    border-radius:12px;

    background:#fff;
    color:#6c757d;

    font-weight:600;

    transition:all .25s ease;

}

.wizard-cancel-btn:hover{

    background:#f8f9fa;
    border-color:#adb5bd;
    color:#343a40;

    transform:translateY(-2px);

    box-shadow:0 8px 18px rgba(0,0,0,.08);

}

.wizard-cancel-btn:active{

    transform:scale(.97);

}

.wizard-submit-btn{

    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;

    min-width:220px;
    height:48px;

    border:none;
    border-radius:12px;

    background:#062c52;

    color:#fff;

    font-weight:600;

    transition:all .25s ease;

    box-shadow:0 10px 24px rgba(13,110,253,.25);

}

.wizard-submit-btn:hover{

    transform:translateY(-3px);

    box-shadow:0 16px 30px rgba(13,110,253,.35);

}

.wizard-submit-btn:hover i{

    transform:translateX(4px);

}

.wizard-submit-btn:active{

    transform:scale(.97);

}

.wizard-submit-btn i{

    transition:.25s;

}

.wizard-cancel-btn{

    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;

    min-width:130px;
    height:48px;

    border:1px solid #d6dbe3;
    border-radius:12px;

    background:#fff;
    color:#6c757d;

    font-weight:600;

    transition:all .25s ease;

}

.wizard-cancel-btn:hover{

    background:#f8f9fa;

    color:#343a40;

    border-color:#adb5bd;

    transform:translateY(-2px);

    box-shadow:0 8px 18px rgba(0,0,0,.08);

}

.wizard-cancel-btn:active{

    transform:scale(.97);

}

.wizard-next-btn{

    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;

    min-width:230px;
    height:48px;

    border:none;
    border-radius:12px;

    background: #062c52;

    color:#fff;

    font-weight:600;

    transition:all .25s ease;

    box-shadow:0 10px 24px rgba(13,110,253,.25);

}

.wizard-next-btn i{

    transition:all .25s ease;

}

.wizard-next-btn:hover{

    transform:translateY(-3px);

    box-shadow:0 16px 30px rgba(13,110,253,.35);

}

.wizard-next-btn:hover i{

    transform:translateX(6px);

}

.wizard-next-btn:active{

    transform:scale(.97);

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
                Welcome to the iSTaksyon! We make it easy for you to request assistance or get information.
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
                                    <button
                                        type="button"
                                        id="new_ticket"
                                        data-bs-toggle="modal"
                                        data-bs-target="#createTicketModal"
                                        class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center"
                                        style="height: 60px; font-size: 1rem;">
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
                            Sign in to your account to continue to the iSTakyson.
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
        <input type="hidden" name="_method" id="ticketFormMethod" value="POST">
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
                <!-- OTP modal moved out to be sibling of ticket modal to ensure proper stacking -->

                {{-- Body --}}
                
                    <div class="m-3">
                        <div class="row mx-5">
                                <div class="col-md-6 py-2">
                                    <div class= "card shadow-sm cursor-pointer step-card" id ="card1" style="background-color: #ddecff; border-color:#062c52; cursor: pointer;">
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
                                    <div class= "card shadow-sm step-card" id="card2" style="background-color:#e4e4e4; cursor:pointer;">
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
                                                    <label class="form-label">
                                                        Position (Optional)
                                                    </label>
                                                    <div class="input-group">
                                                        <input id="requestor_position_title" name="requestor_position_title" type="text" class="form-control" placeholder="Input your position (optional)">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 py-2">
                                                    <label class="form-label">
                                                        Mobile Number (Optional)
                                                    </label>
                                                    <div class="input-group">
                                                        <input id="requestor_mobile_number" name="requestor_mobile_number" type="text" class="form-control" placeholder="Input your mobile number (optional)">
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="col-md-4 py-2">
                                                    <label class="form-label">Organization Type <i class="text-danger">*</i></label>
                                                    <select class="form-select" id="organization_type" name="organization_type" required>
                                                        <option value="">Select Organization...</option>
                                                        <option value="field_office">DSWD Field Office</option>
                                                        <option value="offices">DSWD Offices, Bureaus, Services Units</option>
                                                        <option value="lgu">Local Government Unit</option>
                                                        <option value="cso">Civil Society Organization</option>
                                                        <option value="ngo">Non-government Organization</option>
                                                        <option value="po">People's Organization</option>
                                                        <option value="academe">Academe</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 py-2" id="region_col">
                                                    <label id="region_label" class="form-label">Region <i style="color:red">*</i></label>
                                                    <select id="region" name="requestor_region" class="form-select">
                                                        <option value="">Select your Region</option>
                                                        @foreach($regions as $region)
                                                            <option value="{{$region->region_code}}">{{$region->name}}</option>
                                                        @endforeach
                                                    </select>

                                                    <select id="directorate" name="requestor_region" class="form-select d-none py-2">
                                                        <option value="">Select Directorate</option>
                                                        @foreach($regions as $region)
                                                            <option value="{{$region->region_code}}">{{$region->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-4 py-2 organization-section d-none" id="field_office_fields">
                                                    <label class="form-label">Select Office/Bureau/Section/Unit: <i class="text-danger">*</i></label>
                                                    <select id="requestor_office_field" class="form-select" name="requestor_office">
                                                        <option value="">Select Office</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-4 py-2">
                                                    <label class="form-label">Province <i style="color:red">*</i></label>
                                                    <select id="province" name="requestor_province" class="form-select">
                                                        <option value="">Select Province</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-4 py-2">
                                                    <label class="form-label">City/Municipality <i style="color:red">*</i></label>
                                                    <select id="city" class="form-select" name="requestor_city">
                                                        <option value="">Select City</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-12 py-2 organization-section d-none" id="offices_fields">
                                                    <label class="form-label">Select Office/Bureau/Section/Unit: <i class="text-danger">*</i></label>
                                                    <select id="requestor_office_offices" class="form-select" name="requestor_office">
                                                        <option value="">Select Office</option>
                                                        @foreach($agencies as $agency)
                                                            <option value="{{ $agency->group_code }}">{{ $agency->group_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-12 py-2 organization-section d-none" id="cso_fields">
                                                    <label class="form-label">Civil Society Organization - Please specify <i class="text-danger">*</i></label>
                                                    <input id="cso_input" type="text" class="form-control" name="requestor_specific_office" placeholder="Specify CSO">
                                                </div>

                                                <div class="col-md-12 py-2 organization-section d-none" id="ngo_fields">
                                                    <label class="form-label">Non-government Organization - Please specify <i class="text-danger">*</i></label>
                                                    <input id="ngo_input" type="text" class="form-control" name="requestor_specific_office" placeholder="Specify NGO">
                                                </div>

                                                <div class="col-md-12 py-2 organization-section d-none" id="po_fields">
                                                    <label class="form-label">People's Organization - Please specify <i class="text-danger">*</i></label>
                                                    <input id="po_input" type="text" class="form-control" name="requestor_specific_office" placeholder="Specify People's Organization">
                                                </div>

                                                <div class="col-md-12 py-2 organization-section d-none" id="academe_fields">
                                                    <label class="form-label">Academe - Please specify <i class="text-danger">*</i></label>
                                                    <input id="academe_input" type="text" class="form-control" name="requestor_specific_office" placeholder="Specify Academe">
                                                </div>

                                                <div class="col-md-4 py-2">
                                                    <label class="form-label">
                                                        Office Address (Optional)
                                                    </label>
                                                    <div class="input-group">
                                                        <input id="requestor_office_address" name="requestor_office_address" type="text" class="form-control" placeholder="Input your office address (optional)">
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                                <div class="mt-3">
                                    <div id="whyInfo" class="card p-3" style="background-color:#ddecff; border-color:#4d7cff">
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
                                <div id="stepFooter1" class="d-flex justify-content-between align-items-center mt-4 mb-4">
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
                                    <div class="d-flex flex-column flex-sm-row justify-content-end gap-3 mt-3">

                                        <button type="button"
                                                class="wizard-cancel-btn"
                                                data-bs-dismiss="modal">
                                            <i class="bi bi-x-circle me-2"></i>
                                            Cancel
                                        </button>

                                        <button type="button"
                                                id="nextBtn"
                                                class="wizard-next-btn">
                                            <span>Next: Request Details</span>
                                            <i class="bi bi-arrow-right-circle-fill"></i>
                                        </button>

                                    </div>
                                </div>
                            </div>

                    {{-- Step 2 Body--}}
                            <div id="step2" class="d-none">
                                <div class="row g-3 mt-3">
                                    <div class="col-md-12">
                                        <div class="receiving-office-panel">
                                            <div class="row g-3 align-items-end">
                                                <div class="col-12 col-md-6" id="receiveToColumn">
                                                    <label for="receiveToSelect" class="form-label fw-semibold mb-1">Where should this request be sent? <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="receiveToSelect" name="received_ticket_to" required>
                                                        <option value="">Select a receiving office</option>
                                                        <option value="CO">DSWD Central Office</option>
                                                        <option value="FO">DSWD Field Office</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-6 d-none" id="fieldOfficeSelection">
                                                    <label for="receivedTicketToOffice" class="form-label fw-semibold mb-1">Select Field Office <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="receivedTicketToOffice" name="received_ticket_to_office" disabled>
                                                        <option value="">Select a Field Office</option>
                                                        @foreach($regions as $region)
                                                            <option value="{{$region->region_code}}">{{$region->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
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
                                    <div id="stepFooter2" class="d-flex justify-content-between align-items-center mt-4 mb-4">
                                        <div style="width:320px;"> 
                                            <small class="text-muted" id="stepText2">Step 2 of 2</small>
                                            
                                            <div class="progress mt-2" style="height:8px;"> 
                                                <div 
                                                    class="progress-bar"
                                                    id="progressBar2"
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
                                                    maxlength="200"
                                                    placeholder="Input purpose of your request..."
                                                    style="height:30px;"></textarea>
                                                <div class="text-end small text-muted mt-1">
                                                    <span id="reasonRequestTACP_count">0/200</span>
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
                                                            <span class="text-muted">
                                                                Select a program you want for this request
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <select class="form-select" id="programSelectTACP" name="program">
                                                        <option value="">Select a program</option>
                                                        @foreach($programs as $program)
                                                        <option value="{{$program->program_id}}">{{$program->program}}</option>
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
                                                <div class="mt-3">
                                                    <div>
                                                        <h6 class="me-2">
                                                            Priority <i style="color:red">*</i>
                                                        </h6>
                                                        <span class="text-muted">
                                                            Select priority of this request.
                                                        </span>
                                                    </div>
                                                    <select class="form-select" name="ticket_priority" id="prioritySelectTACP" required>
                                                        <option value="">Select priority</option>
                                                        <option value="low">Low</option>
                                                        <option value="medium">Medium</option>
                                                        <option value="high">High</option>
                                                        <option value="urgent">Urgent</option>
                                                    </select>
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
                                                    maxlength="200"
                                                    placeholder="Input purpose of your request..."
                                                    style="height:30px;"></textarea>
                                                <div class="text-end small text-muted mt-1">
                                                    <span id="reasonRequestTAPD_count">0/200</span>
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
                                                            <span class="text-muted">
                                                                Select a program you want for this request
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <select class="form-select" id="programSelectTAPD" name="program">
                                                        <option value="">Select a program</option>
                                                        @foreach($programs as $program)
                                                        <option value="{{$program->program_id}}">{{$program->program}}</option>
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
                                             {{-- <div class="col-md-6"> 
                                                <div class="p-2">
                                                    <div>
                                                        <h6 class="me-2">
                                                            Priority <i style="color:red">*</i>
                                                        </h6>
                                                        <span class="text-muted">
                                                            Select priority of this request.
                                                        </span>
                                                    </div>
                                                    <select class="form-select" name="priority" id="prioritySelectTAPD">
                                                        <option value="">Select priority</option>
                                                        <option value="low">Low</option>
                                                        <option value="medium">Medium</option>
                                                        <option value="urgent">Urgent</option>
                                                    </select>
                                                </div>
                                             </div> --}}
                                             <div class="col-md-6">
                                                <div id="otherProgramFieldTAPD" class="mt-3 d-none">
                                                        <label class="form-label">Specify Program <span style="color:red">*</span></label>
                                                        <input type="text" class="form-control" id="otherProgramInputTAPD" name="program_others">
                                                </div>
                                                <div class="mt-3">
                                                    <div>
                                                        <h6 class="me-2">
                                                            Priority <i style="color:red">*</i>
                                                        </h6>
                                                        <span class="text-muted">
                                                            Select priority of this request.
                                                        </span>
                                                    </div>
                                                    <select class="form-select" name="ticket_priority" id="prioritySelectTADP" required>
                                                        <option value="">Select priority</option>
                                                        <option value="low">Low</option>
                                                        <option value="medium">Medium</option>
                                                        <option value="high">High</option>
                                                        <option value="urgent">Urgent</option>
                                                    </select>
                                                </div>
                                             </div>
                                             
                                        </div>
                                    </div>                                
                                </div>
                        {{-- Resource Person --}}
                                <div id="rpBody" class="d-none">
                                    <div class="mb-3 mt-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="p-2">
                                                    <div class="d-flex align-items-start p-3">
                                                        <div class="rounded-circle d-flex p-1 align-items-center justify-content-center flex-shrink-0 me-3" style="background-color: #cfe0ff; width:50px; height:50px">
                                                            <i class="bi bi-card-heading fs-5 text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="me-1">Title of the activity <i class="text-danger">*</i></h6>
                                                            <small class="text-muted">Input the title of the acitvity of this request.</small>
                                                        </div>
                                                    </div>
                                                    <textarea
                                                        id="titleOfActivity"
                                                        name="title_of_activity"
                                                        class="form-control"
                                                        placeholder="Input the title of the activity"
                                                        required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-2">
                                                    <div class="d-flex align-items-start p-3">
                                                        <div class="rounded-circle d-flex p-1 align-items-center justify-content-center flex-shrink-0 me-3" style="background-color: #cfe0ff; width:50px; height:50px">
                                                            <i class="bi bi-person-fill fs-5 text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="me-1">Target participants <i class="text-danger">*</i></h6>
                                                            <small class="text-muted">Input the participants needed for this activity.</small>
                                                        </div>
                                                    </div>
                                                    <textarea
                                                        id="targetParticipants"
                                                        name="target_participants"
                                                        class="form-control"
                                                        placeholder="Input the target participants"
                                                        required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                                            maxlength="200"
                                                            placeholder="Input purpose of your request..."
                                                            style="height:30px;"></textarea>
                                                        <div class="text-end small text-muted mt-1">
                                                            <span id="reasonRequestRP_count">0/200</span>
                                                        </div>
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
                                                                <option value="{{$program->program_id}}">{{$program->program}}</option>
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
                                                            <div class="p-3">
                                                                <div>
                                                                    <h6 class="me-2">
                                                                        Priority <i style="color:red">*</i>
                                                                    </h6>
                                                                    <span class="text-muted">
                                                                        Select priority of this request.
                                                                    </span>
                                                                </div>
                                                                <select class="form-select" name="ticket_priority" id="prioritySelectRP" required>
                                                                    <option value="">Select priority</option>
                                                                    <option value="low">Low</option>
                                                                    <option value="medium">Medium</option>
                                                                    <option value="high">High</option>
                                                                    <option value="urgent">Urgent</option>
                                                                </select>
                                                            </div>
                                                          </div>

                                                        <div class='col-md-4 d-flex flex-column'>
                                                            <div class="d-flex align-items-center ps-3"> 
                                                                <div class="pt-3">
                                                                    <div class="mb-3">
                                                                        <div class="mb-2">
                                                                            <h6 class="mb-0">
                                                                                Activity Schedule <span class="text-danger">*</span>
                                                                            </h6>
                                                                            <small class="text-muted">
                                                                                Select the start and end date of the activity.
                                                                            </small>
                                                                        </div>

                                                                        <div class="row g-3">
                                                                            <div class="col-md-6">
                                                                                <label for="dateOfActivity" class="form-label small text-muted">
                                                                                    Start Date
                                                                                </label>
                                                                                <input
                                                                                    type="date"
                                                                                    class="form-control"
                                                                                    id="dateOfActivity"
                                                                                    name="date_of_activity"
                                                                                    required>
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <label for="dateOfActivityEnd" class="form-label small text-muted">
                                                                                    End Date
                                                                                </label>
                                                                                <input
                                                                                    type="date"
                                                                                    class="form-control"
                                                                                    id="dateOfActivityEnd"
                                                                                    name="date_of_activity_end"
                                                                                    required>
                                                                            </div>
                                                                        </div>
                                                                    </div>

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
                        {{-- Knowledge Product --}}
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
                                                                maxlength="200"
                                                                placeholder="Input purpose of your request..."
                                                                style="height:30px;"></textarea>
                                                                <div class="text-end small text-muted mt-1">
                                                                    <span id="reasonRequestKP_count">0/200</span>
                                                                </div>
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
                                                                    <div class="mt-3">
                                                                        <div>
                                                                            <h6 class="me-2">
                                                                                Priority <i style="color:red">*</i>
                                                                            </h6>
                                                                            <span class="text-muted">
                                                                                Select priority of this request.
                                                                            </span>
                                                                        </div>
                                                                        <select class="form-select" name="ticket_priority" id="prioritySelectKP" required>
                                                                            <option value="">Select priority</option>
                                                                            <option value="low">Low</option>
                                                                            <option value="medium">Medium</option>
                                                                            <option value="high">High</option>
                                                                            <option value="urgent">Urgent</option>
                                                                        </select>
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
                                                                <option value="{{$program->program_id}}">{{$program->program}}</option>
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
                                    <button type="button" id="back" class="btn btn-light wizard-back-btn">
                                        <i class="bi bi-arrow-left-short fs-5"></i>
                                        <span>Back</span>
                                    </button>

  
                                        <div class="d-flex justify-content-end gap-3 mt-3">

                                            <button type="button"
                                                    class="wizard-cancel-btn"
                                                    data-bs-dismiss="modal">
                                                <i class="bi bi-x-circle me-2"></i>
                                                Cancel
                                            </button>

                                            <button type="submit"
                                                    id="submitBtn"
                                                    class="wizard-submit-btn">
                                                <i class="bi bi-send-check-fill me-2"></i>
                                                Submit Request
                                            </button>

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

<!-- OTP modal !-->
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

</style>

<!-- Processing modal shown when submitting until OTP is sent -->
<div class="modal fade" id="processingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body text-center p-5">
                <div class="loader-circle mb-4">
                    <div class="spinner-border text-primary" style="width:70px;height:70px;" role="status"></div>
                </div>

                <h4 class="fw-bold mb-2">Processing Your Request</h4>
                <p class="text-muted mb-4">Please wait while we securely process your request. This may take a few moments.</p>

                <div class="progress mb-4" style="height:8px;">
                    <div id="processProgress" class="progress-bar progress-bar-striped progress-bar-animated" style="width:10%;"></div>
                </div>

                <div class="text-start">
                    <div id="procStep1" class="process-step"><span class="step-icon"></span> Validating your information</div>
                    <div id="procStep2" class="process-step"><span class="step-icon"></span> Preparing request details</div>
                    <div id="procStep3" class="process-step"><span class="step-icon"></span> Generating verification code</div>
                    <div id="procStep4" class="process-step"><span class="step-icon"></span> Sending OTP to your email</div>
                    <div id="procStep5" class="process-step"><span class="step-icon"></span> Finalizing Progress</div>
                </div>

                <small class="text-muted d-block mt-4">Please do not refresh or close this window.</small>
            </div>
        </div>
    </div>
</div>

<style>
    .process-step{ padding:8px 0; color:#6b7280; display:flex; align-items:center; gap:8px; }
    .step-icon{ width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center; flex:0 0 28px; }
    .step-icon i{ font-size:1rem; color:#9ca3af; }
    .step-icon svg{ width:24px; height:24px; }
    .check-svg{ transform-origin:center; transform:scale(.92); transition: transform 220ms cubic-bezier(.2,.9,.2,1); }
    .check-svg.animate{ transform:scale(1); }
    .check-svg .check-mark{ stroke-dasharray: 40; stroke-dashoffset: 40; transition: stroke-dashoffset 360ms cubic-bezier(.2,.9,.2,1); stroke-linecap:round; stroke-linejoin:round; }
    .check-svg.animate .check-mark{ stroke-dashoffset: 0; transition-delay: 160ms; }
    .check-svg circle{ stroke-dasharray: 80; stroke-dashoffset: 80; transition: stroke-dashoffset 380ms cubic-bezier(.2,.9,.2,1); }
    .check-svg.animate circle{ stroke-dashoffset: 0; }
    @keyframes popIn {
        0% { transform: scale(.92); }
        60% { transform: scale(1.08); }
        100% { transform: scale(1); }
    }
    .check-svg.animate{ animation: popIn 260ms cubic-bezier(.2,.9,.2,1); }
    .process-step .bi{ margin-right:6px; }
    .process-step.completed{ color:#16a34a; font-weight:600; }
    .process-step.active{ color:#0b3ea9; font-weight:600; }
</style>

<!-- Success processing modal shown after OTP verification before final submission -->
<div class="modal fade" id="successProcessingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body text-center p-5">
                <div class="loader-circle mb-4">
                    <div class="spinner-border text-success" style="width:70px;height:70px;" role="status"></div>
                </div>

                <h4 class="fw-bold mb-2 text-success">Finishing Up</h4>
                <p class="text-muted mb-4">We are finalizing and submitting your request. This should only take a moment.</p>

                <div class="progress mb-4" style="height:8px;">
                    <div id="successProcessProgress" class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width:0%;"></div>
                </div>

                <div class="text-start">
                    <div id="successStep1" class="process-step"><span class="step-icon"></span> Finalizing your request</div>
                </div>

                <small class="text-muted d-block mt-4">Please do not refresh or close this window.</small>
            </div>
        </div>
    </div>
</div>

<!-- Ticket success modal shown after submission -->
<div class="modal fade" id="ticketSuccessModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius:12px;">
            <div class="modal-body text-center p-4">
                <div style="width:72px;height:72px;margin:0 auto;border-radius:18px;background:#e6fff0;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-check2-circle" style="color:#16a34a;font-size:36px;"></i>
                </div>
                <p class="mb-2 text-muted">your request!</p>

                <div class="d-flex align-items-center justify-content-center gap-2 mt-2">
                    <div style="font-weight:700;">Ticket Number:</div>
                    <div id="createdTicketNumber" style="font-weight:700;color:#0b3ea9"></div>
                    <span id="swalCopyBtn" style="cursor:pointer;">
                        <i class="bi bi-clipboard"></i>
                    </span>                
                </div>

                <div class="mt-3">
                    <button class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Review Inputs --}}
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-primary text-white">
                <div>
                    <h5 class="mb-1">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Review Your Request
                    </h5>
                    <small>Please review all information before proceeding with OTP verification.</small>
                </div>
            </div>

            <div class="modal-body">

                <!-- Requestor Information -->
                <div class="review-section">
                    <h6>
                        <i class="bi bi-person-circle me-2"></i>
                        Requestor Information
                    </h6>

                    <div class="review-item">
                        <span>Full Name</span>
                        <strong id="reviewName"></strong>
                    </div>

                    <div class="review-item">
                        <span>Email Address</span>
                        <strong id="reviewEmail"></strong>
                    </div>

                    <div class="review-item">
                        <span>Sex</span>
                        <strong id="reviewSex"></strong>
                    </div>

                    <div class="review-item">
                        <span>Organization Type</span>
                        <strong id="reviewOrganization"></strong>
                    </div>

                    <div class="review-item d-none" id="regionBody">
                        <span>Region</span>
                        <strong id="reviewRegion"></strong>
                    </div>

                    <div class="review-item d-none" id="provinceBody">
                        <span>Province</span>
                        <strong id="reviewProvince"></strong>
                    </div>

                    <div class="review-item d-none" id="cityBody">
                        <span>City / Municipality</span>
                        <strong id="reviewCity"></strong>
                    </div>

                    <div class="review-item d-none" id="directorateBody">
                        <span>Directorate</span>
                        <strong id="reviewDirectorate"></strong>
                    </div>

                    <div class="review-item d-none" id="agencyBody">
                        <span>Office/Bureau/Section/Unit</span>
                        <strong id="reviewAgency"></strong>
                    </div>

                    <div class="review-item d-none" id="specificBody">
                        <span>Specific Organization</span>
                        <strong id="reviewSpecific"></strong>
                    </div>

                </div>

                <!-- Service Details -->
                <div class="review-section mt-4">

                    <h6>
                        <i class="bi bi-briefcase me-2"></i>
                        Service Details
                    </h6>
                    
                    <div class="review-item">
                        <span>Service Category</span>
                        <strong id="reviewCategory"></strong>
                    </div>

                    <div class="review-item">
                        <span>Program</span>
                        <strong id="reviewProgram"></strong>
                    </div>

                    <div class="review-item">
                        <span>Priority</span>
                        <strong id="reviewPriority"></strong>
                    </div>

                    <div class="review-item">
                        <span>Purpose of Request</span>
                        <strong id="reviewPurpose"></strong>
                    </div>

                </div>

                <!-- Resource Person Only -->
                <div class="review-section mt-4" id="reviewRPSection">

                    <h6>
                        <i class="bi bi-calendar-event me-2"></i>
                        Activity Details
                    </h6>

                    <div class="review-item">
                        <span>Venue</span>
                        <strong id="reviewVenue"></strong>
                    </div>

                    <div class="review-item">
                        <span>Type of Activity</span>
                        <strong id="reviewActivityType"></strong>
                    </div>

                    <div class="review-item">
                        <span>Date of Activity</span>
                        <strong id="reviewDate"></strong>
                    </div>

                </div>

                <!-- Knowledge Product Only -->
                <div class="review-section mt-4" id="reviewKPSection">

                    <h6>
                        <i class="bi bi-journal-bookmark me-2"></i>
                        Knowledge Product
                    </h6>

                    <div id="reviewKnowledgeProduct"></div>

                </div>

                <!-- Attachment -->
                <div class="review-section mt-4">

                    <h6>
                        <i class="bi bi-paperclip me-2"></i>
                        Supporting Attachment
                    </h6>

                    <div id="reviewAttachment"></div>

                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light border"
                    data-bs-dismiss="modal">

                    <i class="bi bi-pencil-square me-2"></i>
                    Back & Edit

                </button>

                <button
                    type="button"
                    id="proceedOtpBtn"
                    class="btn btn-primary">

                    <i class="bi bi-shield-lock me-2"></i>
                    Proceed to OTP

                </button>

            </div>

        </div>
    </div>
</div>
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

    function animateCard(cardId, e = null){

    const card = document.getElementById(cardId);
    const rect = card.getBoundingClientRect();

    let x, y;

    if(e){
        x = e.clientX - rect.left;
        y = e.clientY - rect.top;
    }else{
        x = rect.width / 2;
        y = rect.height / 2;
    }

    card.style.setProperty('--x', x + 'px');
    card.style.setProperty('--y', y + 'px');

    card.classList.remove('clicked');
    void card.offsetWidth;
    card.classList.add('clicked');
}

        
    (function(){
        const pre = "{{ session('created_ticket_number') ?? '' }}";
        if(pre && pre.length){
            const ticketNum = pre;
            const swalHtml = `
                <div style="text-align:center">
                    <div style="font-size:14px;color:#16a34a;font-weight:600;margin-bottom:8px">Successfully Submitted</div>
                    <div style="color:#374151">Your request was submitted successfully.</div>
                    <div style="margin-top:12px;font-weight:700">Ticket Number</div>
                    <div style="display:flex;align-items:center;justify-content:center;gap:8px;margin-top:6px;">
                        <div id="swalTicketNum" style="color:#0b3ea9;font-size:16px;font-weight:700">${ticketNum}</div>
                        <button id="swalCopyBtn" type="button" role="button" style="color:#0b3ea9;font-size:16px;text-decoration:none;padding:6px;border-radius:6px;border:1px solid transparent;background:#fff"><i class="bi bi-clipboard"></i></button>
                    </div>
                </div>`;

            Swal.fire({
                icon:'success',
                title:'Request submitted',
                html: swalHtml,
                confirmButtonColor:'#062c52',
                confirmButtonText: 'OK',
                focusConfirm: false,
                allowEnterKey: false,
                didOpen: ()=>{
                const copyBtn = document.getElementById('swalCopyBtn');
                if(copyBtn) copyBtn.addEventListener('click', (e)=>{
                    e.preventDefault(); e.stopPropagation();
                    navigator.clipboard.writeText(ticketNum).then(()=>{
                        Swal.fire({ toast:true, position:'top-end', icon:'success', title:'Copied', showConfirmButton:false, timer:1200 });
                    });
                });
            }}).then((result)=>{ if (result && result.isConfirmed) { window.location.reload(); } });
        }
    })();

document.addEventListener('click', function (e) {
    const copyBtn = e.target.closest('#swalCopyBtn');
    if (!copyBtn) return;

    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();

    const ticketNum = document.getElementById('swalTicketNum')?.textContent.trim();

    if (!ticketNum) return;

    navigator.clipboard.writeText(ticketNum).then(() => {
        copyBtn.innerHTML = '<i class="bi bi-check-lg text-success"></i>';

        setTimeout(() => {
            copyBtn.innerHTML = '<i class="bi bi-clipboard"></i>';
        }, 1200);
    });
}, true);

window._preventAutoReload = false;
(function(){
    (function(){
        const _origReload = window.location.reload.bind(window.location);
        window.__forceReload = function(){ return _origReload(); };

        window.location.reload = function(){
            if (window._preventAutoReload) {
                console.warn('Blocked reload due to active flow');
                return;
            }
            if (window._reloadPromptShown) return;
            window._reloadPromptShown = true;

            Swal.fire({
                title: 'Refresh page?',
                text: 'Click OK to refresh the page.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#062c52'
            }).then(result => {
                window._reloadPromptShown = false;
                if (result && result.isConfirmed) {
                    _origReload();
                } else {
                    console.log('Reload cancelled by user');
                }
            });
        };
    })();
})();

(function(){
    const el = document.getElementById('otpModal');
    if(!el) return;
    el.addEventListener('shown.bs.modal', function(){
        // The backdrop is appended to body; pick the last one
        const backdrops = document.querySelectorAll('.modal-backdrop');
        const last = backdrops[backdrops.length - 1];
        if(last) last.classList.add('otp-backdrop');
    });
    el.addEventListener('hidden.bs.modal', function(){
        document.querySelectorAll('.modal-backdrop.otp-backdrop').forEach(b => b.classList.remove('otp-backdrop'));
    });
})();

       function showAttachment(fileInputId){

    const attachment = document.getElementById('reviewAttachment');
    attachment.innerHTML = '';

    const fileInput = document.getElementById(fileInputId);

    if(fileInput.files.length){

        attachment.innerHTML = `
            <i class="bi bi-paperclip me-2"></i>
            ${fileInput.files[0].name}
        `;

    }else{

        attachment.innerHTML = '-';

    }

}
const proceedOtpBtn = document.getElementById('proceedOtpBtn');

if (proceedOtpBtn) {
    proceedOtpBtn.addEventListener('click', function () {

        const reviewModalEl = document.getElementById('reviewModal');
        const reviewModal = bootstrap.Modal.getInstance(reviewModalEl);

        reviewModal.hide();

        reviewModalEl.addEventListener('hidden.bs.modal', function () {
            const email = document.getElementById('email').value.trim();
            startOtpFlow(email);
        }, { once: true });

    });
}

        function populateReviewSlip() {
            const program = document.getElementById('programSelectKP');
            document.getElementById('reviewRPSection').style.display = 'none';
            document.getElementById('reviewKPSection').style.display = 'none';
            

    document.getElementById('reviewName').textContent =
        `${document.getElementById('first_name').value}
         ${document.getElementById('middle_name').value}
         ${document.getElementById('last_name').value}`;

    document.getElementById('reviewEmail').textContent =
    document.getElementById('email').value;
        
    document.getElementById('reviewSex').textContent =
    document.getElementById('sex').selectedOptions?.[0]?.text || '-';


if(document.getElementById('organization_type').value === 'lgu'){
    document.getElementById('reviewOrganization').textContent = 'Local Government';
    document.getElementById('regionBody').classList.remove('d-none');
    document.getElementById('provinceBody').classList.remove('d-none');
    document.getElementById('cityBody').classList.remove('d-none');
    document.getElementById('directorateBody').classList.add('d-none');
    document.getElementById('agencyBody').classList.add('d-none');


    document.getElementById('reviewRegion').textContent =
    document.getElementById('region').selectedOptions?.[0]?.text || '-';
    

    document.getElementById('reviewProvince').textContent =
    document.getElementById('province').selectedOptions?.[0]?.text || '-';

    document.getElementById('reviewCity').textContent =
    document.getElementById('city').selectedOptions?.[0]?.text || '-';
}

const organization = document.getElementById('organization_type').value;

const organizationConfig = {
    cso: {
        label: 'Civil Society Organization',
        input: 'cso_input'
    },
    ngo: {
        label: 'Non-government Organization',
        input: 'ngo_input'
    },
    po: {
        label: "People's Organization",
        input: 'po_input'
    },
    academe: {
        label: 'Academe',
        input: 'academe_input'
    }
};

if(organization === 'field_office'){
    document.getElementById('reviewOrganization').textContent = 'DSWD Field Office';
    document.getElementById('regionBody').classList.add('d-none');
    document.getElementById('provinceBody').classList.add('d-none');
    document.getElementById('cityBody').classList.add('d-none');
    document.getElementById('directorateBody').classList.remove('d-none');
    document.getElementById('agencyBody').classList.remove('d-none');
     document.getElementById('specificBody').classList.add('d-none');

    document.getElementById('reviewDirectorate').textContent = 
    document.getElementById('directorate').selectedOptions?.[0]?.text || '-';

    document.getElementById('reviewAgency').textContent = 
    document.getElementById('requestor_office_field').selectedOptions?.[0]?.text || '-';

}

if(organization === 'offices'){
    document.getElementById('reviewOrganization').textContent = 'DSWD Offices, Bureaus, Services Units';
    document.getElementById('regionBody').classList.add('d-none');
    document.getElementById('provinceBody').classList.add('d-none');
    document.getElementById('cityBody').classList.add('d-none');
    document.getElementById('directorateBody').classList.add('d-none');
    document.getElementById('agencyBody').classList.remove('d-none');
    document.getElementById('specificBody').classList.add('d-none');


    document.getElementById('reviewAgency').textContent = 
    document.getElementById('requestor_office_offices').selectedOptions?.[0]?.text || '-';

}

if(organization === 'offices'){
    document.getElementById('reviewOrganization').textContent = 'DSWD Offices, Bureaus, Services Units';
    document.getElementById('regionBody').classList.add('d-none');
    document.getElementById('provinceBody').classList.add('d-none');
    document.getElementById('cityBody').classList.add('d-none');
    document.getElementById('directorateBody').classList.add('d-none');
    document.getElementById('agencyBody').classList.remove('d-none');
    document.getElementById('specificBody').classList.add('d-none');


    document.getElementById('reviewAgency').textContent = 
    document.getElementById('requestor_office_offices').selectedOptions?.[0]?.text || '-';

}

if (organizationConfig[organization]) {

    document.getElementById('regionBody').classList.add('d-none');
    document.getElementById('provinceBody').classList.add('d-none');
    document.getElementById('cityBody').classList.add('d-none');
    document.getElementById('directorateBody').classList.add('d-none');
    document.getElementById('agencyBody').classList.add('d-none');
    document.getElementById('specificBody').classList.remove('d-none');

    const config = organizationConfig[organization];
    const input = document.getElementById(config.input);

    document.getElementById('reviewOrganization').textContent = config.label;

    document.getElementById('reviewSpecific').textContent =
        input?.selectedOptions?.[0]?.text || input?.value || '-';

}

    const category = document.getElementById('ticket_category').value;

        let categoryText = '';

        switch (category) {
            case 'completed':
                categoryText = 'Technical Assistance on Completed Program';
                break;

            case 'enhancement':
                categoryText = 'Technical Assistance on Program Development';
                break;

            case 'resource':
                categoryText = 'Resource Person';
                break;

            case 'knowledge':
                categoryText = 'Knowledge Product';
                break;

            default:
                categoryText = category;
        }

        document.getElementById('reviewCategory').textContent = categoryText;
            
    const categoryNames = {
    tacp: "Technical Assistance Completed Program",
    tapd: "Technical Assistance Program Development",
    rp: "Resource Person",
    kp: "Knowledge Product"
};

    document.getElementById('reviewProgram').textContent = '-';
    document.getElementById('reviewPurpose').textContent = '-';
    document.getElementById('reviewVenue').textContent = '-';
    document.getElementById('reviewActivityType').textContent = '-';
    document.getElementById('reviewDate').textContent = '-';
    document.getElementById('reviewKnowledgeProduct').innerHTML = '-';
    document.getElementById('reviewAttachment').innerHTML = '-';
    document.getElementById('reviewPriority').textContent = '-';

    if(category === 'completed'){
        const program = document.getElementById('programSelectTACP');

        document.getElementById('reviewProgram').textContent =
            program.value === 'others'
            ? document.getElementById('otherProgramInputTACP').value
            : program.selectedOptions?.[0]?.text || '-';

        document.getElementById('reviewPurpose').textContent =
            document.getElementById('reasonRequestTACP').value;

        showAttachment('supportFileTACP');

        // Priority for TACP
        const prTACP = document.getElementById('prioritySelectTACP');
        document.getElementById('reviewPriority').textContent = prTACP?.selectedOptions?.[0]?.text || '-';

    }

    else if(category === 'enhancement'){

        const program = document.getElementById('programSelectTAPD');

        document.getElementById('reviewProgram').textContent =
            program.value === 'others'
            ? document.getElementById('otherProgramInputTAPD').value
            : program.selectedOptions?.[0]?.text || '-';

        document.getElementById('reviewPurpose').textContent =
            document.getElementById('reasonRequestTAPD').value;

        showAttachment('supportFileTAPD');

        // Priority for TAPD
        const prTAPD = document.getElementById('prioritySelectTADP');
        document.getElementById('reviewPriority').textContent = prTAPD?.selectedOptions?.[0]?.text || '-';

    }

    else if(category === 'resource'){
        document.getElementById('reviewRPSection').style.display = 'block';

        const program = document.getElementById('programSelectRP');

        document.getElementById('reviewProgram').textContent =
            program.value === 'others'
            ? document.getElementById('otherProgramInputRP').value
            : program.selectedOptions?.[0]?.text || '-';

        document.getElementById('reviewPurpose').textContent =
            document.getElementById('reasonRequestRP').value;

        document.getElementById('reviewVenue').textContent =
            document.getElementById('venue').value;

        document.getElementById('reviewActivityType').textContent =
            document.getElementById('type_of_activity').value;

        const startDate = document.getElementById('dateOfActivity').value;
        const endDate = document.getElementById('dateOfActivityEnd').value;

        if (startDate && endDate) {
            if (startDate === endDate) {
                document.getElementById('reviewDate').textContent = startDate;
            } else {
                document.getElementById('reviewDate').textContent = `${startDate} to ${endDate}`;
            }
        } else if (startDate) {
            document.getElementById('reviewDate').textContent = startDate;
        } else {
            document.getElementById('reviewDate').textContent = '-';
}

        showAttachment('supportFileRP');

     
        const prRP = document.getElementById('prioritySelectRP');
        document.getElementById('reviewPriority').textContent = prRP?.selectedOptions?.[0]?.text || '-';

    }

    else if(category === 'knowledge'){
    document.getElementById('reviewKPSection').style.display = 'block';

        const program = document.getElementById('programSelectKP');

        document.getElementById('reviewProgram').textContent =
            program.value === 'others'
            ? document.getElementById('otherProgramInputKP').value
            : program.selectedOptions?.[0]?.text || '-';

        document.getElementById('reviewPurpose').textContent =
            document.getElementById('reasonRequestKP').value;

        const kpContainer = document.getElementById('reviewKnowledgeProduct');
        kpContainer.innerHTML = '';

        document.querySelectorAll('input[name="type_of_knowledge_product[]"]:checked')
            .forEach(cb => {

                let value = cb.value;

                if(value === 'Others'){
                    value = document.getElementById('otherKnowledgeProduct').value;
                }

                kpContainer.innerHTML += `
                    <div class="mb-1">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        ${value}
                    </div>
                `;
            });

            // Priority for KP
            const prKP = document.getElementById('prioritySelectKP');
            document.getElementById('reviewPriority').textContent = prKP?.selectedOptions?.[0]?.text || '-';

    }

        }

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

        document.addEventListener('DOMContentLoaded', function () {
                    const today = new Date().toISOString().split('T')[0];

                    const startDate = document.getElementById('dateOfActivity');
                    const endDate = document.getElementById('dateOfActivityEnd');

                    startDate.min = today;
                    endDate.min = today;

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
            
            
            function validateStep1(){
                const missing = [];
                const first = document.getElementById('first_name')?.value.trim() || '';
                const last = document.getElementById('last_name')?.value.trim() || '';
                const email = document.getElementById('email')?.value.trim() || '';
                const sex = document.getElementById('sex')?.value.trim() || '';
                const org = (document.getElementById('organization_type') || document.getElementById('organization_type'))?.value || '';

                if(!first) missing.push('First name');
                if(!last) missing.push('Last name');
                if(!email) missing.push('Email address');
                if(!sex) missing.push('Sex');
                if(!org) missing.push('Organization Type');

                if(org === 'lgu'){
                    const region = document.getElementById('region')?.value.trim() || '';
                    const province = document.getElementById('province')?.value.trim() || '';
                    const city = document.getElementById('city')?.value.trim() || '';
                    if(!region) missing.push('Region');
                    if(!province) missing.push('Province');
                    if(!city) missing.push('City/Municipality');
                } else if(org === 'field_office'){
                    const directorate = document.getElementById('directorate')?.value.trim() || document.getElementById('region')?.value.trim() || '';
                    let agency = '';
                    Array.from(document.querySelectorAll('select[name="requestor_office"]')).some(s => {
                        if (!s.disabled && s.offsetParent !== null) { agency = s.value || ''; return true; }
                        return false;
                    });
                    if(!directorate) missing.push('Directorate/Region');
                    if(!agency) missing.push('Select Office/Bureau/Section/Unit');
                } else if(org === 'offices'){
                    let agency = '';
                    Array.from(document.querySelectorAll('select[name="requestor_office"]')).some(s => {
                        if (!s.disabled && s.offsetParent !== null) { agency = s.value || ''; return true; }
                        return false;
                    });
                    if(!agency) missing.push('Select Office/Bureau/Section/Unit');
                } else if(['cso','ngo','po','academe'].includes(org)){
                    // find the visible/enabled specific-office input
                    let spec = '';
                    Array.from(document.querySelectorAll('input[name="requestor_specific_office"]')).some(i => {
                        if (!i.disabled && i.offsetParent !== null) { spec = i.value.trim() || ''; return true; }
                        return false;
                    });
                    if(!spec) {
                        const lbl = {
                            'cso':'Civil Society Organization - specify',
                            'ngo':'Non-government Organization - specify',
                            'po':"People's Organization - specify",
                            'academe':'Academe - specify'
                        }[org] || 'Specify organization';
                        missing.push(lbl);
                    }
                }

                return { ok: missing.length === 0, missing };
            }

            //Next Button
            document.getElementById('nextBtn').addEventListener('click', function () {
            const check = validateStep1();
            if(!check.ok){
                const html = '<p>Please complete the following fields:</p><ul style="text-align:left">' + check.missing.map(m=>`<li>${m}</li>`).join('') + '</ul>';
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Information',
                    html,
                    confirmButtonColor: '#062c52',
                    confirmButtonText: 'OK'
                });
                return;
            }
            step2Unlocked = true;
            animateCard('card2');
            //Step 1
            document.getElementById('step1').classList.add('d-none');
            //Step 2
            document.getElementById('step2').classList.remove('d-none');
            //step 3
            document.getElementById('step3').classList.add('d-none');
            // footers: hide footer1, show footer2
            const f1 = document.getElementById('stepFooter1'); if(f1) f1.classList.add('d-none');
            const f2 = document.getElementById('stepFooter2'); if(f2) f2.classList.remove('d-none');
            
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

            // hide the Step 1 info box when moving to Step 2
            const why = document.getElementById('whyInfo'); if(why) why.classList.add('d-none');

            });
            //Card 1 Body
            document.getElementById('card1').addEventListener('click', function(e){
                animateCard('card1',e);
            //Step 1
            document.getElementById('step1').classList.remove('d-none');
            //Step 2
            document.getElementById('step2').classList.add('d-none');
            //Step3
            document.getElementById('step3').classList.add('d-none');
            // footers: show footer1, hide footer2
            const f1s = document.getElementById('stepFooter1'); if(f1s) f1s.classList.remove('d-none');
            const f2s = document.getElementById('stepFooter2'); if(f2s) f2s.classList.add('d-none');
            
            document.getElementById('card1').style.backgroundColor = '#ddecff';
            document.getElementById('card1').style.borderColor = '#062c52';
            document.getElementById('card1Number').style.color = "#fff";
            document.getElementById('card1Rounded').style.backgroundColor = "#062c52";

            document.getElementById('card2').style.backgroundColor = '#e4e4e4';
            document.getElementById('card2').style.borderColor = '#dee2e6';
            document.getElementById('card2Number').style.color = "black";
            document.getElementById('card2Rounded').style.backgroundColor = "#fff";

            // show the Step 1 info box when returning to Step 1
            const whyShow = document.getElementById('whyInfo'); if(whyShow) whyShow.classList.remove('d-none');

            })

            //Card 2 Body
            document.getElementById('card2').addEventListener('click', function(e){
                if (!step2Unlocked) {
                    const check = validateStep1();
                    if(!check.ok){
                        const html = '<p>Please complete the following fields:</p><ul style="text-align:left">' + check.missing.map(m => `<li>${m}</li>`).join('') + '</ul>';
                        Swal.fire({
                            icon: 'warning',
                            title: 'Incomplete Information',
                            html,
                            confirmButtonColor: '#062c52',
                            confirmButtonText: 'OK'
                        });

                        return;
                    }

                    step2Unlocked = true;
                }

                if(step2Unlocked){
                    animateCard('card2',e);
            //Step 1
            document.getElementById('step1').classList.add('d-none');
            //Step 2
            document.getElementById('step2').classList.remove('d-none');
            //Step 3
            document.getElementById('step3').classList.add('d-none');
            // footers: hide footer1, show footer2
            const f1c = document.getElementById('stepFooter1'); if(f1c) f1c.classList.add('d-none');
            const f2c = document.getElementById('stepFooter2'); if(f2c) f2c.classList.remove('d-none');
            
            document.getElementById('card1').style.backgroundColor = '#e4e4e4';
            document.getElementById('card1').style.borderColor = '#dee2e6';
            document.getElementById('card1Number').style.color = "black";
            document.getElementById('card1Rounded').style.backgroundColor = "#fff";

            document.getElementById('card2').style.backgroundColor = '#ddecff';
            document.getElementById('card2').style.borderColor = '#062c52';
            document.getElementById('card2Number').style.color = "#fff";
            document.getElementById('card2Rounded').style.backgroundColor = "#062c52";
            document.getElementById('card2Label').style.color = "#062c52";

            // hide the Step 1 info box when showing Step 2
            const whyHide2 = document.getElementById('whyInfo'); if(whyHide2) whyHide2.classList.add('d-none');
                }
            
            })

            const receiveToSelect = document.getElementById('receiveToSelect');
            const fieldOfficeSelection = document.getElementById('fieldOfficeSelection');
            const receivedTicketToOffice = document.getElementById('receivedTicketToOffice');

            receiveToSelect?.addEventListener('change', function () {
                const isFieldOffice = this.value === 'FO';
                fieldOfficeSelection?.classList.toggle('d-none', !isFieldOffice);
                if (receivedTicketToOffice) {
                    receivedTicketToOffice.disabled = !isFieldOffice;
                    receivedTicketToOffice.required = isFieldOffice;
                    if (!isFieldOffice) receivedTicketToOffice.value = '';
                }
            });

            // Service Cards body
        serviceCards.forEach(service => {

        document.getElementById(service).addEventListener('click', function () {

                const receivedTicketTo = receiveToSelect?.value || '';
                const receivingFieldOffice = receivedTicketToOffice?.value || '';

                if (!receivedTicketTo || (receivedTicketTo === 'FO' && !receivingFieldOffice)) {
                    const field = !receivedTicketTo ? receiveToSelect : receivedTicketToOffice;
                    const message = !receivedTicketTo
                        ? 'Please select where this request should be sent before choosing a service.'
                        : 'Please select the receiving Field Office before choosing a service.';

                    Swal.fire({
                        icon: 'warning',
                        title: 'Receiving Office Required',
                        text: message,
                        confirmButtonColor: '#062c52',
                        confirmButtonText: 'OK'
                    }).then(() => field?.focus());

                    return;
                }

                // Hide previous steps
                document.getElementById('step1').classList.add('d-none');
                document.getElementById('step2').classList.add('d-none');
                document.getElementById('step3').classList.remove('d-none');
                // footers: hide both footers when showing step3
                const f1Hide = document.getElementById('stepFooter1'); if(f1Hide) f1Hide.classList.add('d-none');
                const f2Hide = document.getElementById('stepFooter2'); if(f2Hide) f2Hide.classList.add('d-none');

                // Hide all service bodies
                document.getElementById('tacpBody').classList.add('d-none');
                document.getElementById('tapdBody').classList.add('d-none');
                document.getElementById('rpBody').classList.add('d-none');
                document.getElementById('kpBody').classList.add('d-none');

                // Show only the selected one
                document.getElementById(service + 'Body').classList.remove('d-none');
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

                const resourcePersonFields = [
                    document.getElementById('titleOfActivity'),
                    document.getElementById('targetParticipants')
                ];
                resourcePersonFields.forEach(field => {
                    if (!field) return;
                    field.required = service === 'rp';
                });

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

                // Priority selects: only the active service's priority should be submitted;
                // clear values for others when switching category.
                const priorityMap = {
                    tacp: 'prioritySelectTACP',
                    tapd: 'prioritySelectTADP',
                    rp: 'prioritySelectRP',
                    kp: 'prioritySelectKP'
                };
                Object.keys(priorityMap).forEach(key => {
                    const sel = document.getElementById(priorityMap[key]);
                    if (!sel) return;
                    if (key === service) {
                        sel.setAttribute('name', 'ticket_priority');
                    } else {
                        sel.removeAttribute('name');
                        try { sel.value = ''; } catch(e){}
                    }
                });

                const activePurpose = document.querySelector('textarea[name="purpose_of_request"]');
                if (activePurpose) {
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
            // footers: show footer2, hide footer1 when going back to step2
            const f1b = document.getElementById('stepFooter1'); if(f1b) f1b.classList.add('d-none');
            const f2b = document.getElementById('stepFooter2'); if(f2b) f2b.classList.remove('d-none');
        })
    startDate.addEventListener('change', function () {
    endDate.min = this.value;

    if (endDate.value && endDate.value < this.value) {
        endDate.value = '';
    }
});
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

function renderCheckSVG(){
    return `
        <svg class="check-svg" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="11" stroke="#16a34a" stroke-width="2" fill="transparent" />
            <path class="check-mark" d="M7 12.5 L10 15.5 L17 8.5" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
        </svg>`;
}

function markStepCompleted(el){
    if(!el) return;
    el.classList.remove('active');
    el.classList.add('completed');
    const icon = el.querySelector('.step-icon');
    if(icon){
        icon.innerHTML = renderCheckSVG();
        // trigger animation by reflow
        const svg = icon.querySelector('.check-svg');
        if(svg){
            svg.classList.remove('animate');
            void svg.offsetWidth;
            svg.classList.add('animate');
        }
    }
}

function setStepActive(el){
    if(!el) return;
    el.classList.add('active');
    el.classList.remove('completed');
    const icon = el.querySelector('.step-icon');
    if(icon){
        icon.innerHTML = '<i class="bi bi-circle-fill"></i>';
    }
}

function showSuccessProcessing() {
    const el = document.getElementById('successProcessingModal');
    if (!el) return null;
    const bs = new bootstrap.Modal(el, { backdrop: 'static', keyboard: false });
    const progress = document.getElementById('successProcessProgress');
    const step = document.getElementById('successStep1');
    // reset
    if (progress) progress.style.width = '0%';
    if (step) { step.classList.remove('completed','active'); const si = step.querySelector('.step-icon'); if (si) si.innerHTML = '<i class="bi bi-circle"></i>'; }
    bs.show();
    window._preventAutoReload = true;

    let pct = 0;
    const iv = setInterval(() => {
        pct = Math.min(90, pct + Math.floor(Math.random() * 20) + 10);
        if (progress) progress.style.width = pct + '%';
        if (pct >= 90) {
            clearInterval(iv);
        }
    }, 160);

        return {
        finish: () => new Promise((resolve) => {
            clearInterval(iv);
            if (progress) progress.style.width = '100%';
            if (step) markStepCompleted(step);
            setTimeout(() => { bs.hide();
                // allow reloads after processing finished
                window._preventAutoReload = false;
                resolve();
            }, 450);
        })
    };
}

async function startOtpFlow(email) {
        console.debug('startOtpFlow called with email:', email);
        if (!email) {
            Swal.fire({ icon: 'warning', title: 'Email required', text: 'Please enter your email first.', confirmButtonColor: '#062c52' });
            return;
        }
    window._preventAutoReload = true;
    const procModalEl = document.getElementById('processingModal');
    let procBs = null;
    let procInterval = null;
    try {
        if (procModalEl) {
            procBs = new bootstrap.Modal(procModalEl, { backdrop: 'static', keyboard: false });
            procBs.show();

            const progressEl = document.getElementById('processProgress');
            const steps = [
                document.getElementById('procStep1'),
                document.getElementById('procStep2'),
                document.getElementById('procStep3'),
                document.getElementById('procStep4'),
                document.getElementById('procStep5')
            ];
            steps.forEach((s, i) => {
                if (!s) return;
                s.classList.remove('active', 'completed');
                if (i === 0) {
                    markStepCompleted(s);
                } else if (i === 1) {
                    setStepActive(s);
                } else {
                    const icon = s.querySelector('.step-icon');
                    if (icon) icon.innerHTML = '<i class="bi bi-circle"></i>';
                }
            });

            let pct = 10;
            let idx = 1;
            procInterval = setInterval(() => {
                pct = Math.min(80, pct + Math.floor(Math.random() * 10) + 5);
                if (progressEl) progressEl.style.width = pct + '%';
                steps.forEach((s, i) => {
                    if (!s) return;
                    if (i < idx) {
                        markStepCompleted(s);
                    } else if (i === idx) {
                        setStepActive(s);
                    } else {
                        const icon = s.querySelector('.step-icon');
                        if (icon) icon.innerHTML = '<i class="bi bi-circle"></i>';
                        s.classList.remove('active','completed');
                    }
                });
                idx = Math.min(steps.length - 1, idx + 1);
            }, 700);
        }

        const res = await fetch('{{ route('tickets.sendOtp') }}', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email })
        });

        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Failed to send OTP');

            if (procInterval) clearInterval(procInterval);
            const progressEl2 = document.getElementById('processProgress');
            if (progressEl2) progressEl2.style.width = '100%';
        ['procStep1','procStep2','procStep3','procStep4','procStep5'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                markStepCompleted(el);
            }
        });

        await new Promise(r => setTimeout(r, 400));
        if (procBs) procBs.hide();
        window._preventAutoReload = false;

        const otpModalEl = document.getElementById('otpModal');
        if (!otpModalEl) {
            console.error('OTP modal element not found');
            Swal.fire({ icon: 'error', title: 'OTP unavailable', text: 'Could not open OTP modal. Please try again or refresh the page.', confirmButtonColor: '#062c52' });
            return;
        }
        const otpEmailMasked = document.getElementById('otpEmailMasked');
        const otpInputs = otpModalEl.querySelectorAll('.otp-input');
        if (!otpInputs || !otpInputs.length) {
            console.error('OTP inputs not found');
            Swal.fire({ icon: 'error', title: 'OTP inputs missing', text: 'OTP inputs are not available on this page.', confirmButtonColor: '#062c52' });
            return;
        }
        otpEmailMasked.innerText = email.replace(/(.).*(.@)/, '$1***$2');
        try {
            const ticketModalEl = document.getElementById('createTicketModal');
            if (ticketModalEl) {
                const inst = bootstrap.Modal.getInstance(ticketModalEl) || new bootstrap.Modal(ticketModalEl);
                inst.hide();
            }
        } catch (e) { console.warn('Could not hide other modal', e); }

        const bsOtpModal = new bootstrap.Modal(otpModalEl, { backdrop: 'static', keyboard: false });
        // if user closes/cancels OTP modal, remove any pending otp:verified handler to prevent duplicate submissions
        otpModalEl.addEventListener('hidden.bs.modal', function () {
            if (ticketForm && ticketForm._otpVerifiedHandler) {
                try { ticketForm.removeEventListener('otp:verified', ticketForm._otpVerifiedHandler); } catch (e) {}
                ticketForm._otpVerifiedHandler = null;
                console.debug('Cleared otp verified handler due to OTP modal close');
            }
        }, { once: true });
        otpInputs.forEach(i => { i.value = ''; i.disabled = false; });
        // small delay before showing to let previous modal teardown finish
        setTimeout(() => {
            bsOtpModal.show();
            // ensure reloads remain blocked while OTP modal is open
            window._preventAutoReload = true;
            // delay focus slightly to avoid focusin reentrancy with Bootstrap focus trap
            setTimeout(() => { try { otpInputs[0].focus(); } catch (e) {} }, 220);
        }, 60);

        const gatherCode = () => Array.from(otpInputs).map(i => i.value.trim()).join('');

        // simple input navigation & paste
        otpInputs.forEach((input, idx) => {
            input.addEventListener('input', (e) => {
                const v = input.value.trim();
                if (v.length > 1) {
                    // handle paste of full code
                    const paste = v.split('');
                    for (let j = 0; j < otpInputs.length; j++) {
                        otpInputs[j].value = paste[j] || '';
                    }
                    otpInputs[Math.min(otpInputs.length-1, paste.length-1)].focus();
                } else if (v.length === 1) {
                    if (idx < otpInputs.length - 1) otpInputs[idx + 1].focus();
                }
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && idx > 0) {
                    otpInputs[idx - 1].focus();
                }
            });
        });

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

        console.debug('Showing OTP modal');
        const verifyBtn = document.getElementById('verifyOtpBtn');
        if (!verifyBtn) {
            console.error('Verify button not found');
            Swal.fire({ icon: 'error', title: 'OTP verify unavailable', text: 'Verify button missing.', confirmButtonColor: '#062c52' });
            return;
        }
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
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email, otp })
                });
                const verifyData = await verifyRes.json();
                if (!verifyRes.ok) throw new Error(verifyData.message || 'OTP verification failed');

                ticketForm.dataset.otpVerified = 'true';
                try { ticketForm.dispatchEvent(new Event('otp:verified')); console.debug('Dispatched otp:verified'); } catch (e) { console.error('dispatch error', e); }
                bsOtpModal.hide();
                window._preventAutoReload = false;
                verifyBtn.removeEventListener('click', onVerify);

                (async () => {
                    let confirmed = false;
                    for (let attempt = 0; attempt < 6; attempt++) {
                        await new Promise(r => setTimeout(r, 200));
                        try {
                            const statusRes = await fetch('{{ route('tickets.otpStatus') }}', { method: 'GET', credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                            if (!statusRes.ok) continue;
                            const statusJson = await statusRes.json();
                            if (statusJson.verified && statusJson.verifiedEmail === email) { confirmed = true; break; }
                        } catch (e) { /* ignore */ }
                    }
                })();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'OTP Error', text: err.message || 'Could not complete OTP flow', confirmButtonColor: '#062c52' });
                try { otpInputs[0].focus(); } catch (e) {}
                verifyBtn.disabled = false;
                verifyBtn.innerText = 'Verify';
            }
        };

        verifyBtn.removeEventListener('click', onVerify);
        verifyBtn.addEventListener('click', onVerify);

    } catch (err) {
        if (procInterval) clearInterval(procInterval);
        if (procBs) procBs.hide();
        Swal.fire({ icon: 'error', title: 'OTP Error', text: err.message || 'Could not complete OTP flow', confirmButtonColor: '#062c52' });
    }
}

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
        });
    
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

const ticketForm = document.getElementById('ticketForm');
const ticketEmailInput = document.getElementById('email');
const createTicketModalEl = document.getElementById('createTicketModal');

function resetOtpVerificationState() {
    if (!ticketForm) return;
    ticketForm.dataset.otpVerified = 'false';
}

if (ticketEmailInput) {
    ticketEmailInput.addEventListener('input', resetOtpVerificationState);
    ticketEmailInput.addEventListener('change', resetOtpVerificationState);
}

if (createTicketModalEl) {
    createTicketModalEl.addEventListener('show.bs.modal', function () {
        resetOtpVerificationState();
        // default to create mode when opening modal
        resetTicketFormToCreateMode();
    });
}

// store create URL for resetting
const ticketCreateAction = '{{ route('tickets.store') }}';

function setTicketEditMode(ticketId) {
    if (!ticketForm) return;
    ticketForm.action = ticketCreateAction.replace(/\/tickets$/, '/tickets/' + ticketId);
    const methodInput = document.getElementById('ticketFormMethod');
    if (methodInput) methodInput.value = 'PUT';
    const modalTitle = document.querySelector('#createTicketModal .modal-title h5');
    if (modalTitle) modalTitle.textContent = 'Edit Request';
}

function resetTicketFormToCreateMode() {
    if (!ticketForm) return;
    ticketForm.action = ticketCreateAction;
    const methodInput = document.getElementById('ticketFormMethod');
    if (methodInput) methodInput.value = 'POST';
    const modalTitle = document.querySelector('#createTicketModal .modal-title h5');
    if (modalTitle) modalTitle.textContent = 'Request Ticket';
}

if (ticketForm) {
    ticketForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const ticketCat = document.getElementById('ticket_category')?.value || '';
        const first = document.getElementById('first_name')?.value.trim() || '';
        const last = document.getElementById('last_name')?.value.trim() || '';
        const email = document.getElementById('email')?.value.trim() || '';
        const sex = document.getElementById('sex')?.value || '';
        const region = document.getElementById('region')?.value || '';
        const province = document.getElementById('province')?.value || '';
        const city = document.getElementById('city')?.value || '';
        const org = (document.getElementById('organization_type') || document.getElementById('organization_type'))?.value || '';

        const missing = [];
        if (!first) missing.push('First name');
        if (!last) missing.push('Last name');
        if (!email) missing.push('Email');
        if (!sex) missing.push('Sex');
        if (!ticketCat) missing.push('Service selection');

        const activeProgram = document.querySelector('select[name="program"]');
        if (activeProgram && (!activeProgram.value || activeProgram.value === '')) {
            missing.push('Program selection');
        }

        // Organization-specific requirements (match validateStep1)
        if (org === 'lgu') {
            if (!region) missing.push('Region');
            if (!province) missing.push('Province');
            if (!city) missing.push('City/Municipality');
        } else if (org === 'field_office') {
            const directorate = document.getElementById('directorate')?.value.trim() || document.getElementById('region')?.value.trim() || '';
            let agency = '';
            // accept a visible, enabled select OR any enabled select that already has a value (filled earlier)
            Array.from(document.querySelectorAll('select[name="requestor_office"]')).some(s => {
                if (s.disabled) return false;
                if (s.offsetParent !== null || (s.value && s.value !== '')) { agency = s.value || ''; return true; }
                return false;
            });
            if (!directorate) missing.push('Directorate/Region');
            if (!agency) missing.push('Select Office/Bureau/Section/Unit');
        } else if (org === 'offices') {
            let agency = '';
            Array.from(document.querySelectorAll('select[name="requestor_office"]')).some(s => {
                if (s.disabled) return false;
                if (s.offsetParent !== null || (s.value && s.value !== '')) { agency = s.value || ''; return true; }
                return false;
            });
            if (!agency) missing.push('Select Office/Bureau/Section/Unit');
        } else if (['cso','ngo','po','academe'].includes(org)) {
            let spec = '';
            Array.from(document.querySelectorAll('input[name="requestor_specific_office"]')).some(i => {
                if (i.disabled) return false;
                // accept if visible or if it contains a value filled earlier on step1
                if (i.offsetParent !== null || (i.value && i.value.trim() !== '')) { spec = i.value.trim() || ''; return true; }
                return false;
            });
            if (!spec) {
                const lbl = {
                    'cso':'Civil Society Organization - specify',
                    'ngo':'Non-government Organization - specify',
                    'po':"People's Organization - specify",
                    'academe':'Academe - specify'
                }[org] || 'Specify organization';
                missing.push(lbl);
            }
        }

        if (missing.length) {
                // if office missing, focus the visible office select
                if (missing.includes('Select Office/Bureau/Section/Unit')) {
                    const visOffice = Array.from(document.querySelectorAll('select[name="requestor_office"]')).find(s => !s.disabled && s.offsetParent !== null);
                    if (visOffice) { try { visOffice.focus(); visOffice.scrollIntoView({behavior:'smooth', block:'center'}); } catch(e){} }
                }

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

        if (ticketCat === 'knowledge') {
            const selectedProducts = ticketForm.querySelectorAll('input[name="type_of_knowledge_product[]"]:checked');
            if (!selectedProducts || selectedProducts.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Select Knowledge Product',
                    text: 'Please select at least one Type of knowledge product.',
                    confirmButtonColor: '#062c52'
                });
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

        if (ticketCat === 'resource') {

    const startDate = document.getElementById('dateOfActivity').value;
    const endDate = document.getElementById('dateOfActivityEnd').value;

    if (!startDate) {
        Swal.fire({
            icon: 'warning',
            title: 'Start Date Required',
            text: 'Please select the activity start date.',
            confirmButtonColor: '#062c52'
        });

        document.getElementById('dateOfActivity').focus();
        return false;
    }

    if (!endDate) {
        Swal.fire({
            icon: 'warning',
            title: 'End Date Required',
            text: 'Please select the activity end date.',
            confirmButtonColor: '#062c52'
        });

        document.getElementById('dateOfActivityEnd').focus();
        return false;
    }

    if (new Date(endDate) < new Date(startDate)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Date Range',
            text: 'The activity end date cannot be earlier than the start date.',
            confirmButtonColor: '#062c52'
        });

        document.getElementById('dateOfActivityEnd').focus();
        return false;
    }
    }

        const fd = new FormData(ticketForm);

        const fileInputs = Array.from(ticketForm.querySelectorAll('input[type="file"]'));
        for (const fi of fileInputs) {
            if (fi.files && fi.files.length) {
                fd.set('attachment', fi.files[0], fi.files[0].name);
                break;
            }
        }

        const submitBtn = document.getElementById('submitBtn');

        const doSubmit = async () => {
            if (submitBtn) submitBtn.disabled = true;
            try {
                const response = await fetch(ticketForm.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: fd,
                    credentials: 'same-origin'
                });

                const text = await response.text();
                let data = null;
                try { data = text ? JSON.parse(text) : null; } catch(e) { data = null; }

                if (!response.ok) {
                    const errMsg = (data && data.message) ? data.message : text || 'Unknown server error';
                    throw new Error(errMsg);
                }

                return data;
            } catch (err) {
                if (submitBtn) submitBtn.disabled = false;
                throw err;
            }
        };

        const submitAndShowResult = async () => {
            const proc = showSuccessProcessing();
            try {
                const data = await doSubmit();
                if (proc && proc.finish) await proc.finish();

                const title = (data && data.title) ? data.title : 'Request submitted';
                const message = (data && data.message) ? data.message : 'Your ticket was submitted successfully.';

                if (data && data.ticket_number) {
                    const ticketNum = data.ticket_number;
                    const swalHtml = `
                        <div style="text-align:center">
                            <div style="color:#374151">${message}</div>
                            <div style="margin-top:12px;font-weight:700">Ticket Number</div>
                            <div style="display:flex;align-items:center;justify-content:center;gap:8px;margin-top:6px;">
                                <div id="swalTicketNum" style="color:#0b3ea9;font-size:16px;font-weight:700">${ticketNum}</div>
                                <button id="swalCopyBtn" type="button" role="button" style="color:#0b3ea9;font-size:16px;text-decoration:none;padding:6px;border-radius:6px;border:1px solid transparent;background:#fff"><i class="bi bi-clipboard"></i></button>
                            </div>
                        </div>`;

                    Swal.fire({
                        icon: 'success',
                        title: title,
                        html: swalHtml,
                        showConfirmButton: true,
                        confirmButtonColor: '#062c52',
                        confirmButtonText: 'OK',
                        focusConfirm: false,
                        allowEnterKey: false,
                        didOpen: () => {
                            const copyBtn = document.getElementById('swalCopyBtn');
                            if (copyBtn) copyBtn.addEventListener('click', (e) => {
                                e.preventDefault();
                                e.stopPropagation();
                                navigator.clipboard.writeText(ticketNum).then(() => {
                                    Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Copied to clipboard', showConfirmButton: false, timer: 1200 });
                                }).catch(() => {
                                    Swal.fire({ icon: 'info', title: 'Copy', text: ticketNum });
                                });
                            });
                        }
                    }).then((result) => {
                        if (result && result.isConfirmed) {
                            if (data && data.redirect) {
                                window.location.href = data.redirect;
                            } else {
                                window.location.reload();
                            }
                        }
                    });

                    return;
                }

                const swalRes = await Swal.fire({
                    icon: 'success',
                    title: title,
                    text: message,
                    confirmButtonColor: '#062c52',
                    confirmButtonText: 'OK',
                    focusConfirm: false,
                    allowEnterKey: false
                });
                if (swalRes && swalRes.isConfirmed) {
                    if (data && data.redirect) { window.location.href = data.redirect; } else { window.location.reload(); }
                }
                resetOtpVerificationState();
                return;
            } catch (err) {
                if (proc && proc.finish) {
                    try { await proc.finish(); } catch (e) {}
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Submission failed',
                    text: err.message || 'An error occurred while submitting your request.',
                    confirmButtonColor: '#062c52'
                });
                if (submitBtn) submitBtn.disabled = false;
            }
        };

        if (ticketForm.dataset.otpVerified !== 'true') {
            ticketForm.dataset.otpVerified = 'false';

            // ensure a single otp:verified listener exists (avoid duplicates when cancelling OTP and retrying)
            if (ticketForm._otpVerifiedHandler) {
                try { ticketForm.removeEventListener('otp:verified', ticketForm._otpVerifiedHandler); } catch (e) {}
                ticketForm._otpVerifiedHandler = null;
            }

            ticketForm._otpVerifiedHandler = async function onOtpVerified() {
                try {
                    await submitAndShowResult();
                } catch (e) {
                    console.error('Post-OTP submission failed', e);
                } finally {
                    ticketForm._otpVerifiedHandler = null;
                }
            };

            ticketForm.addEventListener('otp:verified', ticketForm._otpVerifiedHandler, { once: true });

            const reviewModalEl = document.getElementById('reviewModal');
            const reviewModal = new bootstrap.Modal(reviewModalEl);

            populateReviewSlip();
            reviewModal.show();
            return;
        }

        await submitAndShowResult();
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

function clearFileUpload(inputId) {

    const input = document.getElementById(inputId);

    if (!input) return;

    // Clear selected file
    input.value = '';

    // Hide filename
    const card = input.closest('.card');
    const fileName = card?.querySelector('.file-name');

    if (fileName) {
        fileName.classList.add('d-none');
        fileName.innerHTML = '';
    }
}

function clearTACPFields(){
    document.querySelectorAll('#tacpBody input').forEach(input =>{
        if(input.type === 'checkbox' || input.type === 'radio'){
            input.checked = false;
        } else if(input.type !== 'hidden'){
            input.value = '';
        }
    });

    document.querySelectorAll('#tacpBody textarea').forEach(textarea => {
        textarea.value = '';
    });

    document.querySelectorAll('#tacpBody select').forEach(select =>{
        select.selectedIndex = 0;
    });

    document.getElementById('otherProgramFieldTACP').classList.add('d-none');
    document.getElementById('otherProgramInputTACP').value = '';
    clearFileUpload('supportFileTACP');
}

function clearTAPDFields(){
    document.querySelectorAll('#tapdBody input').forEach(input =>{
        if(input.type === 'checkbox' || input.type === 'radio'){
            input.checked = false;
        } else if(input.type !== 'hidden'){
            input.value = '';
        }
    });

    document.querySelectorAll('#tapdBody textarea').forEach(textarea => {
        textarea.value = '';
    });

    document.querySelectorAll('#tapdBody select').forEach(select =>{
        select.selectedIndex = 0;
    });

    document.getElementById('otherProgramFieldTAPD').classList.add('d-none');
    document.getElementById('otherProgramInputTAPD').value = '';
        clearFileUpload('supportFileTAPD');

}

function clearRPFields(){
    document.querySelectorAll('#rpBody input').forEach(input =>{
        if(input.type === 'checkbox' || input.type === 'radio'){
            input.checked = false;
        } else if(input.type !== 'hidden'){
            input.value = '';
        }
    });

    document.querySelectorAll('#rpBody textarea').forEach(textarea => {
        textarea.value = '';
    });

    document.querySelectorAll('#rpBody select').forEach(select =>{
        select.selectedIndex = 0;
    });

    document.getElementById('otherProgramFieldRP').classList.add('d-none');
    document.getElementById('otherProgramInputRP').value = '';
        clearFileUpload('supportFileRP');

}

function clearKPFields(){
    document.querySelectorAll('#kpBody input').forEach(input =>{
        if(input.type === 'checkbox' || input.type === 'radio'){
            input.checked = false;
        } else if(input.type !== 'hidden'){
            input.value = '';
        }
    });

    document.querySelectorAll('#kpBody textarea').forEach(textarea => {
        textarea.value = '';
    });

    document.querySelectorAll('#kpBody select').forEach(select =>{
        select.selectedIndex = 0;
    });

    document.getElementById('otherProgramFieldKP').classList.add('d-none');
    document.getElementById('otherProgramInputKP').value = '';

    document.querySelectorAll('#kpBody .kp-input').forEach(input => {
    input.checked = false;

    const icon = input.nextElementSibling.querySelector('.kp-check');

    icon.classList.remove('bi-check-square-fill');
    icon.classList.add('bi-square');
        clearFileUpload('supportFileKP');

});
};

document.getElementById('tacp').addEventListener('click', function() {
    clearTAPDFields();
    clearRPFields();
    clearKPFields();
});

document.getElementById('tapd').addEventListener('click', function() {
    clearTACPFields();
    clearRPFields();
    clearKPFields();
});

document.getElementById('rp').addEventListener('click', function() {
    clearTACPFields();
    clearTAPDFields();
    clearKPFields();
});

document.getElementById('kp').addEventListener('click', function() {
    clearTACPFields();
    clearTAPDFields();
    clearRPFields();
});



document.addEventListener('DOMContentLoaded', function(){
    function showInvalid(el, msg){
        el.classList.add('is-invalid');
        var next = el.nextElementSibling;
        if(!next || !next.classList || !next.classList.contains('invalid-feedback')){
            var fb = document.createElement('div');
            fb.className = 'invalid-feedback';
            fb.textContent = msg || 'Please select priority.';
            el.parentNode.insertBefore(fb, el.nextSibling);
        }
        el.focus();
    }

    function clearInvalid(el){
        if(!el) return;
        el.classList.remove('is-invalid');
        var next = el.nextElementSibling;
        if(next && next.classList && next.classList.contains('invalid-feedback')){
            next.remove();
        }
    }

    var submitBtn = document.getElementById('submitBtn');
    if(!submitBtn) return;

    submitBtn.addEventListener('click', function(e){
        var bodies = [
            {id:'tacpBody', select:'prioritySelectTACP'},
            {id:'tapdBody', select:'prioritySelectTADP'},
            {id:'rpBody', select:'prioritySelectRP'},
            {id:'kpBody', select:'prioritySelectKP'}
        ];

        // clear previous invalid states
        bodies.forEach(function(b){ var s=document.getElementById(b.select); if(s) clearInvalid(s); });

        for(var i=0;i<bodies.length;i++){
            var body = document.getElementById(bodies[i].id);
            if(body && body.classList && !body.classList.contains('d-none')){
                if (bodies[i].id === 'rpBody') {
                    var resourcePersonFields = [
                        {element: document.getElementById('titleOfActivity'), label: 'the title of the activity'},
                        {element: document.getElementById('targetParticipants'), label: 'the target participants'}
                    ];

                    for (var fieldIndex = 0; fieldIndex < resourcePersonFields.length; fieldIndex++) {
                        var field = resourcePersonFields[fieldIndex];
                        if (field.element && !field.element.value.trim()) {
                            e.preventDefault();
                            showInvalid(field.element, 'This field is required.');
                            Swal.fire({
                                icon: 'warning',
                                title: 'Incomplete Information',
                                text: 'Please enter ' + field.label + ' before proceeding.',
                                confirmButtonColor: '#062c52',
                                confirmButtonText: 'OK'
                            });
                            return false;
                        }
                    }
                }

                var select = document.getElementById(bodies[i].select);
                if(select && (!select.value || select.value.trim() === '')){
                    e.preventDefault();
                    showInvalid(select, 'Please select a priority for this request.');
                    
                    Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Information',
                    text: 'Please complete all required fields before proceeding.',
                    confirmButtonColor: '#062c52',
                    confirmButtonText: 'OK'
                });

                return;

                    return false;
                }
            }
        }

        return true;
    });
});

    (function(){
        const MAX = 200;
        document.querySelectorAll('textarea[name="purpose_of_request"]').forEach(function(el){
            // ensure maxlength set (in case added dynamically)
            if(!el.getAttribute('maxlength')) el.setAttribute('maxlength', MAX);

            const countEl = document.getElementById(el.id + '_count');
            if(!countEl) return;

            const update = function(){
                const len = el.value.length;
                const remaining = MAX - len;
                countEl.textContent = len + '/' + MAX;
                if(remaining <= 20){
                    countEl.classList.add('text-danger');
                } else {
                    countEl.classList.remove('text-danger');
                }
            };

            el.addEventListener('input', update);
            update();
        });
    })();

    (function () {
        const orgSelect = document.getElementById('organization_type') || document.getElementById('organization_type');
        if (!orgSelect) return;

        const clearOrgSections = () => {
            document.querySelectorAll('.organization-section').forEach(section => {
                section.classList.add('d-none');
                section.style.opacity = '';
                section.querySelectorAll('input, select, textarea').forEach(i => {
                    i.disabled = true;
                    i.required = false;
                });
            });
        };

        function clearOrgInputs(){
            // clear any specific office text inputs (visible or hidden)
            document.querySelectorAll('input[name="requestor_specific_office"]').forEach(i=>{
                try{
                    i.value = '';
                    if(i.removeAttribute) i.removeAttribute('value');
                    i.required = false;
                    i.disabled = true;
                    i.readOnly = false;
                    i.dispatchEvent(new Event('input', { bubbles: true }));
                }catch(e){console.warn('clear specific input failed', e)}
            });
            // clear agency selects (any matching name)
            document.querySelectorAll('select[name="requestor_office"]').forEach(s=>{
                try{
                    s.selectedIndex = 0;
                    s.value = '';
                    if(s.removeAttribute) s.removeAttribute('value');
                    s.required = false;
                    s.disabled = true;
                    s.dispatchEvent(new Event('change', { bubbles: true }));
                }catch(e){console.warn('clear office select failed', e)}
            });
            // clear directorate select
            const dir = document.getElementById('directorate'); if(dir){ try{ dir.value = ''; if(dir.removeAttribute) dir.removeAttribute('value'); dir.disabled = true; dir.required = false; dir.classList.add('d-none'); dir.dispatchEvent(new Event('change', { bubbles: true })); }catch(e){console.warn(e)} }
        }

        async function populateAgenciesForRegion(regionCode, targetSelectId) {
            const sel = document.getElementById(targetSelectId);
            if (!sel) return;
            sel.innerHTML = '<option value="">Loading...</option>';
            try {
                const url = regionCode ? `/agencies/${regionCode}` : '/agencies';
                const res = await fetch(url);
                if (!res.ok) throw new Error('Failed to load agencies');
                const list = await res.json();
                sel.innerHTML = '<option value="">Select agency</option>' + list.map(a => `<option value="${a.group_code}">${a.group_name}</option>`).join('');
                sel.disabled = false;
                sel.required = true;
                // auto-select if only one agency returned
                if (Array.isArray(list) && list.length === 1) {
                    sel.selectedIndex = 1;
                    sel.dispatchEvent(new Event('change', { bubbles: true }));
                }
            } catch (e) {
                sel.innerHTML = '<option value="">(failed to load agencies)</option>';
                console.error(e);
            }
        }

        function setFieldOfficeState(enabled, message) {
            const sel = document.getElementById('requestor_office_field');
            if (!sel) return;
            if (!enabled) {
                sel.innerHTML = `<option value="">${message || 'Select Region/Directorate first'}</option>`;
                sel.disabled = true;
                sel.required = false;
            } else {
                sel.disabled = false;
                sel.required = true;
            }
        }

        // initialize visibility for location fields based on current org selection
        (function initLocationVisibility(){
            const regionCol = document.getElementById('region_col');
            const provinceEl = document.getElementById('province');
            const cityEl = document.getElementById('city');
            const provinceCol = provinceEl ? provinceEl.closest('.col-md-4') : null;
            const cityCol = cityEl ? cityEl.closest('.col-md-4') : null;
            const dir = document.getElementById('directorate');

            const hasOrg = !!(orgSelect.value);
            if (!hasOrg) {
                if (regionCol) regionCol.classList.add('d-none');
                if (provinceCol) provinceCol.classList.add('d-none');
                if (cityCol) cityCol.classList.add('d-none');
                if (document.getElementById('region')) { document.getElementById('region').disabled = true; document.getElementById('region').required = false; }
                if (provinceEl) { provinceEl.disabled = true; provinceEl.required = false; }
                if (cityEl) { cityEl.disabled = true; cityEl.required = false; }
                if (dir) { dir.classList.add('d-none'); dir.disabled = true; dir.required = false; }
            } else {
                // if org already selected, trigger change to setup proper visibility
                const ev = new Event('change', { bubbles: true });
                orgSelect.dispatchEvent(ev);
            }
        })();

        orgSelect.addEventListener('change', function () {
            clearOrgSections();
            clearOrgInputs();

            const selected = this.value;

            // DOM elements for location columns
            const regionCol = document.getElementById('region_col');
            const provinceCol = document.getElementById('province')?.closest('.col-md-4');
            const cityCol = document.getElementById('city')?.closest('.col-md-4');

            // hide all location cols by default
            if (regionCol) regionCol.classList.add('d-none');
            if (provinceCol) provinceCol.classList.add('d-none');
            if (cityCol) cityCol.classList.add('d-none');

            // ensure organization-specific section is shown
            if (selected) {
                const target = document.getElementById(selected + '_fields');
                if (target) {
                    target.classList.remove('d-none');
                    target.style.opacity = 0;
                    target.querySelectorAll('input, select, textarea').forEach(i => { i.disabled = false; if (i.name === 'requestor_office' || i.name === 'requestor_specific_office') i.required = true; });
                    let op = 0; const iv = setInterval(() => { op += 0.08; target.style.opacity = op; if (op >= 1) clearInterval(iv); }, 16);
                }
            }

            // Behavior per org type
            if (!selected) {
                // nothing selected — keep all location inputs hidden and disabled
                ['region','province','city'].forEach(id => { const el = document.getElementById(id); if (el) { el.value = ''; el.disabled = true; el.required = false; } });
                // hide directorate if present
                const dir = document.getElementById('directorate'); if (dir) { dir.classList.add('d-none'); dir.disabled = true; dir.required = false; }
                return;
            }

            if (selected === 'lgu') {
                // show region/province/city
                if (regionCol) regionCol.classList.remove('d-none');
                if (provinceCol) provinceCol.classList.remove('d-none');
                if (cityCol) cityCol.classList.remove('d-none');
                ['region','province','city'].forEach(id => { const el = document.getElementById(id); if (el) { el.disabled = false; el.required = true; } });
                // ensure directorate hidden
                const dir = document.getElementById('directorate'); if (dir) { dir.classList.add('d-none'); dir.disabled = true; dir.required = false; }
            }

                if (selected === 'field_office') {
                // show region column but display directorate select instead of region
                if (regionCol) regionCol.classList.remove('d-none');
                // hide province/city
                if (provinceCol) provinceCol.classList.add('d-none');
                if (cityCol) cityCol.classList.add('d-none');

                // swap: hide region select and show directorate
                const regionSel = document.getElementById('region');
                const dirSel = document.getElementById('directorate');
                if (regionSel) { regionSel.classList.add('d-none'); regionSel.disabled = true; }
                if (dirSel) { dirSel.classList.remove('d-none'); dirSel.disabled = false; dirSel.required = true; }

                // change label to Directorate
                const regionLabel = document.getElementById('region_label');
                if (regionLabel) regionLabel.innerHTML = 'Directorate <i style="color:red">*</i>';

                // If no directorate/region selected yet, keep Field Office select disabled with hint
                const dirCode = dirSel?.value || '';
                if (!dirCode) {
                    setFieldOfficeState(false, 'Select Directorate first');
                } else {
                    populateAgenciesForRegion(dirCode, 'requestor_office_field');
                }
                } else {
                    // ensure region select visible when not field_office
                    const regionSel = document.getElementById('region');
                    const dirSel = document.getElementById('directorate');
                    if (regionSel) { regionSel.classList.remove('d-none'); regionSel.disabled = false; }
                    if (dirSel) dirSel.classList.add('d-none');

                    // restore label to Region
                    const regionLabel = document.getElementById('region_label');
                    if (regionLabel) regionLabel.innerHTML = 'Region <i style="color:red">*</i>';
            }

            if (selected === 'offices') {
                // show offices agency select (unfiltered)
                populateAgenciesForRegion('', 'requestor_office_offices');
            }
        });

        // When region/directorate changes and field_office is active, reload filtered agencies
        const regionSelect = document.getElementById('region');
        const directorateSelect = document.getElementById('directorate');
        const reloadIfField = (val) => {
            const current = (orgSelect.value || '');
            if (current === 'field_office') {
                if (!val) {
                    setFieldOfficeState(false, 'Select Directorate first');
                } else {
                    populateAgenciesForRegion(val || '', 'requestor_office_field');
                }
            }
        };

        if (regionSelect) regionSelect.addEventListener('change', function () { reloadIfField(this.value); });
        if (directorateSelect) directorateSelect.addEventListener('change', function () { reloadIfField(this.value); });
    })();
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