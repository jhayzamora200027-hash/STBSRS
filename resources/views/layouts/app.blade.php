<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'iSTaksyon')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        #loginModal .login-input-wrap {
            position: relative;
        }

        #loginModal .login-input {
            height: 50px;
            padding-left: 45px;
            padding-right: 45px;
            border-radius: 10px;
        }

        #loginModal .login-input-icon,
        #loginModal .login-password-toggle {
            position: absolute;
            top: 50%;
            z-index: 2;
            color: #6c757d;
            transform: translateY(-50%);
        }

        #loginModal .login-input-icon {
            left: 15px;
            pointer-events: none;
        }

        #loginModal .login-password-toggle {
            right: 15px;
            cursor: pointer;
        }
    </style>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body>


@guest

<nav class="navbar navbar-expand-lg shadow-sm sticky-top guest-navbar" style="background:#062c52;">

    <div class="container-fluid flex-nowrap">

        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            

            <div class="bg-white rounded-circle p-1 guest-logo-wrap flex-shrink-0">

                <img src="{{ asset('images/logo/social technology bureau innovating solution logo.png') }}"
                     width="45" class="guest-logo">

            </div>

            <div class="ms-3 guest-brand-text">

                <h5 class="mb-0 text-white">
                    iSTaksyon
                </h5>

                <small class="text-white">
                    Social Technology Bureau
                </small>

            </div>

        </a>

        <button class="btn btn-outline-light flex-shrink-0"
                data-bs-toggle="modal"
                data-bs-target="#loginModal">

            <i class="bi bi-person-fill me-md-2"></i>

            <span class="guest-login-text">Login</span>

        </button>

    </div>

</nav>

<main>
    @yield('content')
</main>

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

                                            <div class="login-input-wrap">
                                                <i class="bi bi-envelope login-input-icon" aria-hidden="true"></i>
                                                <input type="email" name="email" class="form-control login-input" placeholder="Enter your email address" required value="{{old('email')}}">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            
                                            <div class="login-input-wrap">
                                            <i class="bi bi-lock login-input-icon" aria-hidden="true"></i>
                                            <input type="password" name="password" id="password" class="form-control login-input"  placeholder="Enter your password"  required>
                                            
                                            <i class="bi bi-eye login-password-toggle" id="togglePassword" role="button" aria-label="Show password" tabindex="0"></i>

                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <div class="text-start mt-2">
                                                    <a href="#registrationModal" class="forgot-link" data-bs-toggle="modal" data-bs-target="#registrationModal" data-bs-dismiss="modal">Don't have account?</a>
                                                </div>
                                                <div class="text-end mt-2">
                                                    <a href="#forgotPasswordModal" class="forgot-link" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" data-bs-dismiss="modal">Forgot Password?</a>
                                                </div>
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
                                        <a class="btn w-100 d-submit-white-button" href="{{ route('google.redirect') }}" onclick="return openGoogleLoginPopup(event, this, this.href);">
                                            <i class="bi bi-person-circle google-login-icon"></i>
                                            <span class="google-login-label">Sign-In with Google</span>
                                            <span class="google-login-loading d-none"><span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Opening Google...</span>
                                        </a>

                                        <div class="text-center mt-3">
                                           <span style="font-size:0.8rem;"> Need help? </span> <a href="#" class="forgot-link"> Contact your system administator.</a>
                                        </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="row g-0">
                <div class="col-12 col-lg-5 register-brand-panel p-5">
                    <div class="brand-content">

                        <img src="{{ asset('images/logo/DSWD STB Bagong Pil logo.png') }}" 
                            class="img-fluid brand-logo mb-4">

                        <h2 class="brand-title">
                            Welcome to <span>iSTaksyon</span>
                        </h2>

                        <p class="brand-description">
                            Your digital service request platform for the 
                            Social Technology Bureau.
                        </p>

                        <div class="brand-feature mt-4">
                            <div class="feature-item">
                                <i class="bi bi-ticket-perforated"></i>
                                <div>
                                    <strong>Submit Requests Easily</strong>
                                    <small>Create and track your service requests anytime.</small>
                                </div>
                            </div>

                            <div class="feature-item">
                                <i class="bi bi-shield-check"></i>
                                <div>
                                    <strong>Secure Access</strong>
                                    <small>Your account is protected and verified.</small>
                                </div>
                            </div>

                            <div class="feature-item">
                                <i class="bi bi-person-check"></i>
                                <div>
                                    <strong>Administrator Approval</strong>
                                    <small>Accounts are reviewed before activation.</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 col-lg-7">
                    <div class="registration-container">
                        <div class="modal-body px-0">
                            <!-- Information -->
                            <div class="registration-notice">
                                    <i class="bi bi-shield-check"></i>

                                <div>
                                    <strong>DSWD Staff Registration</strong>
                                    <small>
                                        Only users with an official 
                                        <b>@dswd.gov.ph</b> email can register.
                                        Your account requires administrator approval.
                                    </small>
                                </div>
                            </div>


                            @if ($errors->any())
                                <div class="registration-error">
                                    <i class="bi bi-exclamation-circle"></i>

                                    <div>
                                        <strong>Registration failed</strong>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif



                            <form method="POST" action="{{ route('register') }}" id="registrationForm">

                                @csrf

                                <input type="hidden" name="registration_form" value="1">


                                <!-- Personal Information -->
                                <div class="form-section-title">
                                    <i class="bi bi-person"></i>
                                    Personal Information
                                </div>


                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label>First name</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-person"></i>
                                            <input 
                                                type="text"
                                                name="first_name"
                                                placeholder="Juan"
                                                value="{{ old('first_name') }}"
                                                required>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <label>Last name</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-person"></i>
                                            <input 
                                                type="text"
                                                name="last_name"
                                                placeholder="Dela Cruz"
                                                value="{{ old('last_name') }}"
                                                required>
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <label>
                                            Middle name 
                                            <span>(optional)</span>
                                        </label>

                                        <div class="input-group-custom">
                                            <i class="bi bi-person-lines-fill"></i>
                                            <input 
                                                type="text"
                                                name="middle_name"
                                                placeholder="Middle name"
                                                value="{{ old('middle_name') }}">
                                        </div>
                                    </div>

                                </div>



                                <!-- Account Information -->
                                <div class="form-section-title mt-4">
                                    <i class="bi bi-envelope"></i>
                                    Account Information
                                </div>


                                <div class="mb-3">

                                    <label>
                                        Official DSWD Email
                                    </label>

                                    <div class="input-group-custom">

                                        <i class="bi bi-envelope"></i>

                                        <input 
                                            type="email"
                                            name="email"
                                            id="registrationEmail"
                                            placeholder="name@dswd.gov.ph"
                                            value="{{ old('email') }}"
                                            required>

                                    </div>

                                </div>



                                <div class="row g-3">

                                    <div class="col-md-6">

                                        <label>Password</label>

                                        <div class="input-group-custom">

                                            <i class="bi bi-lock"></i>

                                            <input 
                                                type="password"
                                                name="password"
                                                placeholder="Enter password"
                                                minlength="8"
                                                pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}"
                                                title="Use at least 8 characters, including an uppercase letter, a lowercase letter, a number, and a symbol."
                                                required>

                                        </div>
                                    </div>



                                    <div class="col-md-6">

                                        <label>Confirm password</label>

                                        <div class="input-group-custom">

                                            <i class="bi bi-lock-fill"></i>

                                            <input 
                                                type="password"
                                                name="password_confirmation"
                                                placeholder="Confirm password"
                                                minlength="8"
                                                pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}"
                                                title="Use at least 8 characters, including an uppercase letter, a lowercase letter, a number, and a symbol."
                                                required>

                                        </div>

                                    </div>

                                </div>
                                <small class="text-muted p-2" style="font-size: 0.7rem;">At least 8 characters with uppercase, lowercase, number, and symbol.</small>



                                <button 
                                    class="register-button w-100 mt-4"
                                    type="submit"
                                    id="registrationSubmit"
                                    disabled>

                                    <i class="bi bi-person-check"></i>

                                    Submit Registration

                                </button>


                            </form>


                            <div class="login-link">

                                Already have an account?

                                <a href="#loginModal"
                                    data-bs-toggle="modal"
                                    data-bs-target="#loginModal"
                                    data-bs-dismiss="modal">

                                    Sign in

                                </a>

                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="forgotPasswordModal" tabindex="-1"
    aria-labelledby="forgotPasswordModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content forgot-password-card border-0">

            <div class="modal-body p-4 p-md-5">

                <!-- Header -->
                <div class="text-center mb-4">

                    <div class="forgot-icon mb-3">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>

                    <h4 class="fw-bold mb-2" id="forgotPasswordModalLabel">
                        Forgot your password?
                    </h4>

                    <p class="text-muted small mb-0">
                        No worries. Enter your email address and we'll send you a secure
                        password reset link.
                    </p>

                </div>


                <form method="POST"
                    action="{{ route('password.email') }}"
                    id="loginForgotPasswordForm">

                    @csrf


                    <!-- Email -->
                    <div class="mb-4">

                        <label for="loginForgotPasswordEmail"
                            class="form-label fw-semibold small">
                            Email Address
                        </label>


                        <div class="input-group forgot-input">

                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>

                            <input 
                                id="loginForgotPasswordEmail"
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email') }}"
                                placeholder="Enter your registered email"
                                required
                                autofocus>

                        </div>

                    </div>


                    <!-- Submit -->
                    <button type="submit"
                        class="btn btn-primary w-100 py-2 fw-semibold"
                        id="loginForgotPasswordSubmit">

                        <i class="bi bi-send me-2"></i>
                        Send Reset Link

                    </button>


                    <!-- Security Notice -->
                    <div class="reset-info mt-4">

                        <i class="bi bi-info-circle me-2"></i>

                        <span>
                            The reset link will expire for your security.
                        </span>

                    </div>


                </form>


                <!-- Back -->
                <div class="text-center mt-4">

                    <button type="button"
                        class="btn btn-link text-decoration-none text-muted small"
                        data-bs-dismiss="modal">

                        <i class="bi bi-arrow-left me-1"></i>
                        Back to login

                    </button>

                </div>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="loginPasswordResetLoadingModal" tabindex="-1" aria-labelledby="loginPasswordResetLoadingLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content password-loading-card border-0">
            <div class="modal-body text-center p-5">
                <div class="loading-icon-wrapper mb-4">
                    <div class="loading-ring"></div>
                    <i class="bi bi-envelope-check-fill"></i>
                </div>
                <h5 class="fw-semibold mb-2" id="loginPasswordResetLoadingLabel">Sending password reset link</h5>
                <p class="text-muted small mb-4">We're preparing your email notification. Please wait a moment.</p>
                <div class="progress loading-progress">
                    <div id="loginPasswordResetProgress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="10" style="width: 10%"></div>
                </div>
                <small id="loginPasswordResetProgressText" class="text-secondary d-block mt-3" aria-live="polite">Do not close this window</small>
            </div>
        </div>
    </div>
</div>

<style>
    .password-loading-card { border-radius: 20px; background: #fff; opacity: 1; box-shadow: 0 20px 50px rgba(0,0,0,.15); animation: modalFade .3s ease; }
    .loading-icon-wrapper { width: 90px; height: 90px; margin: auto; position: relative; display: flex; align-items: center; justify-content: center; }
    .loading-icon-wrapper i { font-size: 2.2rem; color: #0d6efd; z-index: 2; }
    .loading-ring { position: absolute; width: 90px; height: 90px; border-radius: 50%; border: 4px solid #e9f2ff; border-top-color: #0d6efd; animation: spin 1s linear infinite; }
    .loading-progress { height: 6px; border-radius: 20px; overflow: hidden; background: #eef3f8; }
    .loading-progress .progress-bar { border-radius: 20px; }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    @keyframes modalFade { from { opacity: 0; transform: translateY(15px) scale(.96); } to { opacity: 1; transform: translateY(0) scale(1); } }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const forgotPasswordForm = document.getElementById('loginForgotPasswordForm');

        if (forgotPasswordForm) {
            forgotPasswordForm.addEventListener('submit', function (event) {
                if (!this.checkValidity()) return;

                event.preventDefault();

                const submitButton = document.getElementById('loginForgotPasswordSubmit');
                const loadingModal = document.getElementById('loginPasswordResetLoadingModal');
                const progressBar = document.getElementById('loginPasswordResetProgress');
                const progressText = document.getElementById('loginPasswordResetProgressText');
                let progress = 10;

                submitButton.disabled = true;
                loadingModal.addEventListener('shown.bs.modal', function () {
                    window.setTimeout(function () {
                        forgotPasswordForm.submit();
                    }, 500);
                }, { once: true });

                bootstrap.Modal.getOrCreateInstance(loadingModal).show();

                window.setInterval(function () {
                    if (progress >= 90) return;

                    progress += 5;
                    progressBar.style.width = progress + '%';
                    progressBar.setAttribute('aria-valuenow', progress);
                    progressText.textContent = 'Processing your request (' + progress + '%)';
                }, 500);
            });
        }
    });
</script>

<script>
    function openGoogleLoginPopup(event, button, url) {
        event.preventDefault();

        if (button.classList.contains('disabled')) {
            return false;
        }

        button.classList.add('disabled');
        button.setAttribute('aria-busy', 'true');
        button.setAttribute('aria-disabled', 'true');
        button.querySelector('.google-login-icon').classList.add('d-none');
        button.querySelector('.google-login-label').classList.add('d-none');
        button.querySelector('.google-login-loading').classList.remove('d-none');

        const popupWidth = 520;
        const popupHeight = 700;
        const popupLeft = Math.max(0, (window.screen.availWidth - popupWidth) / 2);
        const popupTop = Math.max(0, (window.screen.availHeight - popupHeight) / 2);

        const popup = window.open(
            'about:blank',
            'googleLoginPopup',
            `width=${popupWidth},height=${popupHeight},left=${popupLeft},top=${popupTop},menubar=no,toolbar=no,location=yes,status=no,resizable=yes,scrollbars=yes`
        );

        if (!popup) {
            button.classList.remove('disabled');
            button.removeAttribute('aria-busy');
            button.removeAttribute('aria-disabled');
            button.querySelector('.google-login-icon').classList.remove('d-none');
            button.querySelector('.google-login-label').classList.remove('d-none');
            button.querySelector('.google-login-loading').classList.add('d-none');
            window.alert('Please allow popups for this site to sign in with Google.');
            return false;
        }

        popup.location.href = url;
        popup.focus();
        return false;
    }

    if (window.opener && window.opener !== window) {
        window.opener.location.reload();
        window.close();
    }
</script>

<div class="modal fade" id="accountApprovalModal" tabindex="-1" aria-labelledby="accountApprovalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered approval-dialog">
        <div class="modal-content approval-modal border-0">

            <div class="modal-body text-center">

                <div class="approval-icon">
                    <i class="bi {{ session('google_rejected') ? 'bi-x-circle' : 'bi-shield-lock' }}"></i>
                </div>

                <h5 id="accountApprovalModalLabel" class="approval-title">
                    @if(session('google_rejected'))
                        Google Sign-In Not Allowed
                    @elseif(session('registration_pending'))
                        Registration Submitted
                    @else
                        Account Pending Approval
                    @endif
                </h5>

                <p class="approval-message">
                    @if(session('google_rejected'))
                        You cannot proceed with these Google credentials. This login is for STB Staff with a <strong>dswd.gov.ph</strong> account only.
                    @elseif(session('registration_pending'))
                        Your registration was submitted successfully. Access will be granted once a system administrator approves your account.
                    @else
                        Your Google account has been successfully verified.
                        Access will be granted once a system administrator approves your account.
                    @endif
                </p>

                @if(!session('google_rejected'))
                    <div class="approval-info">
                        <i class="bi bi-info-circle"></i>
                        <span>
                            You will receive access automatically after approval.
                        </span>
                    </div>
                @endif

                <button type="button" 
                        class="btn approval-btn w-100" 
                        data-bs-dismiss="modal">
                    <i class="bi bi-check-circle me-2"></i>
                    Understood
                </button>

            </div>

        </div>
    </div>
</div>

@if(session('google_pending') || session('google_rejected') || session('registration_pending'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const approvalModal = document.getElementById('accountApprovalModal');

            if (approvalModal && window.bootstrap) {
                bootstrap.Modal.getOrCreateInstance(approvalModal).show();
            }
        });
    </script>
@endif

@if($errors->any() && old('registration_form'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const registrationModal = document.getElementById('registrationModal');

            if (registrationModal && window.bootstrap) {
                bootstrap.Modal.getOrCreateInstance(registrationModal).show();
            }
        });
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const registrationForm = document.getElementById('registrationForm');
        const registrationEmail = document.getElementById('registrationEmail');
        const registrationSubmit = document.getElementById('registrationSubmit');

        if (!registrationForm || !registrationEmail || !registrationSubmit) return;

        function isDswdEmail(email) {
            return /^[^@\s]+@dswd\.gov\.ph$/i.test(email.trim());
        }

        function updateRegistrationButton() {
            registrationSubmit.disabled = !isDswdEmail(registrationEmail.value);
        }

        registrationEmail.addEventListener('input', updateRegistrationButton);
        registrationForm.addEventListener('submit', function (event) {
            if (!isDswdEmail(registrationEmail.value)) {
                event.preventDefault();
                updateRegistrationButton();
            }
        });

        updateRegistrationButton();
    });
</script>

@if (session('status'))
    <script>
        window.addEventListener('load', function () {
            if (window.Swal && Swal.fire) {
                Swal.fire({
                    icon: 'success',
                    title: 'Email sent successfully',
                    text: @json(session('status')),
                    confirmButtonColor: '#062c52'
                });
            }
        });
    </script>
@endif

@endguest



@auth


<aside class="sidebar">

    <div class="sidebar-logo">
            

        <img src="{{ asset('images/logo/social technology bureau innovating solution logo.png') }}">

        <div>

            <h6>iSTaksyon</h6>

            <small>
                Social Technology Bureau
            </small>

        </div>

    </div>

    <span class="sidebar-title">Reports</span>

    <a href="{{ route('dashboard') }}"
       class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }} justify-content-start">

        <i class="bi bi-grid"></i>
        Dashboard & Reports

    </a>

    <a href="{{ route('feedback') }}" class="justify-content-start">

        <i class="bi bi-clipboard-data"></i>

        Feedback Report

    </a>

    <span class="sidebar-title mt-4">

        TICKETS

    </span>

    <a href="{{route('tickets')}}" class="justify-content-start">

        <i class="bi bi-file-earmark-text"></i>

        All Tickets

    </a>
    @if(Auth::user()->usergroup === 'sysadmin')
    <span class="sidebar-title mt-4">

        ADMIN

    </span>

    <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }} justify-content-start">

        <i class="bi bi-people"></i>

        Users

    </a>

    <a href="{{ route('programs.index') }}"
   class="sidebar-link {{ request()->routeIs('programs.*') ? 'active' : '' }} justify-content-start">

    <i class="bi bi-grid"></i>

    Programs

    </a>

    <a href="{{ route('audit-logs.index') }}"
       class="sidebar-link {{ request()->routeIs('audit-logs.*') ? 'active' : '' }} justify-content-start">
        <i class="bi bi-shield-check"></i>
        Audit Log
    </a>
    @endif

</aside>
<div id="sidebarOverlay" class="sidebar-overlay"></div>


<nav class="top-navbar">
    <button class="btn btn-light d-lg-none me-3" id="sidebarToggle">
                <i class="bi bi-list fs-3"></i>
    </button>
    @php

        $pageTitles = [

            'dashboard'       => 'Dashboard & Reports',
            'feedback'  => 'Feedback Report',
            'tickets'   => 'All Tickets',
            'tickets.review'  => 'Review Tickets',
            'users.index'     => 'User Management',
            'users.approvals' => 'User Management',
            'programs.index'  => 'Programs',

        ];

        $title = $pageTitles[Route::currentRouteName()] ?? 'Dashboard';

    @endphp


    <div class="d-flex align-items-center gap-4 navbar-title-group">

        <h4 class="mb-0 navbar-title">

            {{ $title }}

        </h4>

        <div class="search-box position-relative" id="navbarSearch">

            <i class="bi bi-search"></i>
            <div>
                <input
                    type="text"
                    class="form-control border-0"
                    id="navbarSearchInput"
                    placeholder="Search tickets or user..."
                    autocomplete="off">
            </div>

            <div class="search-suggestions" id="navbarSearchSuggestions"></div>

        </div>

    </div>


    <div class="d-flex align-items-center gap-3 navbar-actions-group">

        <div class="dropdown notification-dropdown">

            <button class="btn btn-light nav-icon position-relative"
                    type="button"
                    id="notificationButton"
                    aria-expanded="false"
                    aria-label="Notifications">

                <i class="bi bi-bell"></i>

                <span class="notification-dot d-none" id="notificationDot"></span>
                <span class="notification-count d-none" id="notificationCount"></span>

            </button>

            <div class="dropdown-menu dropdown-menu-end notification-menu shadow border-0"
                 aria-labelledby="notificationButton">
                <div class="notification-menu-header">
                    <strong>Notifications</strong>
                    <span class="text-muted" id="notificationSummary">Recent activity</span>
                </div>
                <div id="notificationList" class="notification-list">
                    <div class="notification-empty">Loading notifications...</div>
                </div>
            </div>

        </div>

        <div class="dropdown">

            <button
                class="btn user-button dropdown-toggle"
                type="button"
                id="userDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false">

                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0B2A72&color=fff">

                <div class="text-start ms-2 user-button-text">

                    <div class="fw-semibold">

                        {{ Auth::user()->name }}

                    </div>

                    <small class="text-muted">

                        {{ ucfirst(Auth::user()->usergroup) }}

                    </small>

                </div>

            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4"
                aria-labelledby="userDropdown">

                <li>

                          <a class="dropdown-item" href="#profileModal"
                              data-bs-toggle="modal"
                              data-bs-target="#profileModal">

                        <i class="bi bi-person me-2"></i>

                        Profile

                    </a>

                </li>

                <li>

                    <hr class="dropdown-divider">

                </li>

                <li>

                    <form method="POST"
                          action="{{ route('logout') }}">

                        @csrf

                        <button
                            type="submit"
                            class="dropdown-item text-danger">

                            <i class="bi bi-box-arrow-right me-2"></i>

                            Logout

                        </button>

                    </form>

                </li>

            </ul>

        </div>

    </div>

</nav>


<div class="modal fade profile-modal" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="profile-modal-hero">
                <button type="button" class="btn-close btn-close-white profile-modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="profile-modal-identity">
                    <img class="profile-modal-avatar"
                         src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=ffffff&color=0B2A72&bold=true"
                         alt="{{ Auth::user()->name }}">
                    <div>
                        <span class="profile-modal-eyebrow">Account overview</span>
                        <h4 class="mb-1" id="profileModalLabel">{{ Auth::user()->name }}</h4>
                        <span class="profile-modal-role"><i class="bi bi-shield-check me-1"></i>{{ ucfirst(Auth::user()->usergroup) }}</span>
                    </div>
                </div>
            </div>

            <div class="modal-body p-0">
                <div class="profile-modal-section">
                    <div class="profile-modal-section-heading">
                        <div class="profile-modal-section-icon"><i class="bi bi-person-vcard"></i></div>
                        <div>
                            <h6 class="mb-1">Personal information</h6>
                            <p class="mb-0">Your account details at a glance</p>
                        </div>
                    </div>
                    <div class="profile-modal-details">
                        <div><span class="profile-modal-label">First name</span><strong>{{ Auth::user()->first_name ?: 'Not provided' }}</strong></div>
                        <div><span class="profile-modal-label">Middle name</span><strong>{{ Auth::user()->middle_name ?: 'Not provided' }}</strong></div>
                        <div><span class="profile-modal-label">Last name</span><strong>{{ Auth::user()->last_name ?: 'Not provided' }}</strong></div>
                        <div><span class="profile-modal-label">Email address</span><strong class="text-break">{{ Auth::user()->email }}</strong></div>
                    </div>
                </div>

                <div class="profile-modal-section profile-security-section">
                    <div class="profile-modal-section-heading">
                        <div class="profile-modal-section-icon security"><i class="bi bi-lock"></i></div>
                        <div>
                            <h6 class="mb-1">Password and security</h6>
                            <p class="mb-0">Keep your account protected with a strong password</p>
                        </div>
                    </div>

                    @if (session('password_success'))
                        <div class="alert alert-success d-flex align-items-center gap-2 py-2" role="alert">
                            <i class="bi bi-check-circle-fill"></i>{{ session('password_success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.password.update') }}" class="password-form">
                        @csrf
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Current password</label>
                            <input type="password" id="currentPassword" name="current_password" class="form-control" required autocomplete="current-password">
                            @error('current_password', 'passwordUpdate')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="newPassword" class="form-label">New password</label>
                                <input type="password" id="newPassword" name="password" class="form-control" required minlength="8" pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}" title="Use at least 8 characters, including an uppercase letter, a lowercase letter, a number, and a symbol." autocomplete="new-password">
                                @error('password', 'passwordUpdate')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="confirmPassword" class="form-label">Confirm new password</label>
                                <input type="password" id="confirmPassword" name="password_confirmation" class="form-control" required minlength="8" pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}" title="Use at least 8 characters, including an uppercase letter, a lowercase letter, a number, and a symbol." autocomplete="new-password">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn profile-save-button"><i class="bi bi-shield-lock me-2"></i>Update password</button>
                        </div>
                    </form>
                    <div class="text-end mt-3">
                        <a href="#forgotPasswordModal" class="forgot-link" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" data-bs-dismiss="modal">
                            Forgot password?
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="dashboardForgotPasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="dashboardForgotPasswordLabel">
                    <i class="bi bi-envelope-lock me-2 text-primary"></i>Reset password by email
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small">Enter your account email and we will send you a link to create a new password.</p>

                <form method="POST" action="{{ route('password.email') }}" id="dashboardForgotPasswordForm">
                    @csrf
                    <div class="mb-3">
                        <label for="dashboardForgotPasswordEmail" class="form-label">Email address</label>
                        <input id="dashboardForgotPasswordEmail" type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                    </div>
                    <button type="submit" class="btn profile-save-button w-100" id="dashboardForgotPasswordSubmit">
                        <i class="bi bi-send me-2"></i>Send reset link
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dashboardPasswordResetLoadingModal" tabindex="-1" aria-labelledby="dashboardPasswordResetLoadingLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content password-loading-card border-0">
            <div class="modal-body text-center p-5">
                <div class="loading-icon-wrapper mb-4">
                    <div class="loading-ring"></div>
                    <i class="bi bi-envelope-check-fill"></i>
                </div>
                <h5 class="fw-semibold mb-2" id="dashboardPasswordResetLoadingLabel">Sending password reset link</h5>
                <p class="text-muted small mb-4">We're preparing your email notification. Please wait a moment.</p>
                <div class="progress loading-progress">
                    <div id="dashboardPasswordResetProgress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="10" style="width: 10%"></div>
                </div>
                <small id="dashboardPasswordResetProgressText" class="text-secondary d-block mt-3" aria-live="polite">Do not close this window</small>
            </div>
        </div>
    </div>
</div>

<style>
    .password-loading-card { border-radius: 20px; background: #fff; opacity: 1; box-shadow: 0 20px 50px rgba(0,0,0,.15); animation: modalFade .3s ease; }
    .loading-icon-wrapper { width: 90px; height: 90px; margin: auto; position: relative; display: flex; align-items: center; justify-content: center; }
    .loading-icon-wrapper i { font-size: 2.2rem; color: #0d6efd; z-index: 2; }
    .loading-ring { position: absolute; width: 90px; height: 90px; border-radius: 50%; border: 4px solid #e9f2ff; border-top-color: #0d6efd; animation: spin 1s linear infinite; }
    .loading-progress { height: 6px; border-radius: 20px; overflow: hidden; background: #eef3f8; }
    .loading-progress .progress-bar { border-radius: 20px; }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    @keyframes modalFade { from { opacity: 0; transform: translateY(15px) scale(.96); } to { opacity: 1; transform: translateY(0) scale(1); } }
</style>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const forgotPasswordForm = document.getElementById('dashboardForgotPasswordForm');

        if (!forgotPasswordForm) return;

        forgotPasswordForm.addEventListener('submit', function (event) {
            if (!this.checkValidity()) return;

            event.preventDefault();

            const submitButton = document.getElementById('dashboardForgotPasswordSubmit');
            const progressBar = document.getElementById('dashboardPasswordResetProgress');
            const progressText = document.getElementById('dashboardPasswordResetProgressText');
            let progress = 10;

            submitButton.disabled = true;
            const loadingModal = document.getElementById('dashboardPasswordResetLoadingModal');
            const loadingModalInstance = bootstrap.Modal.getOrCreateInstance(loadingModal);

            loadingModal.addEventListener('shown.bs.modal', function () {
                window.setTimeout(function () {
                    forgotPasswordForm.submit();
                }, 500);
            }, { once: true });

            loadingModalInstance.show();

            window.setInterval(function () {
                if (progress >= 90) return;

                progress += 5;
                progressBar.style.width = progress + '%';
                progressBar.setAttribute('aria-valuenow', progress);
                progressText.textContent = 'Processing your request (' + progress + '%)';
            }, 500);

        });
    });
</script>



<main class="main-content">

    @yield('content')

</main>

@endauth




@stack('scripts')

@if (session('error'))
<script>
    window.addEventListener('load', function () {
        if (window.Swal && Swal.fire) {
            Swal.fire({
                icon: 'error',
                title: 'Access denied',
                text: @json(session('error')),
                confirmButtonColor: '#062c52'
            });
        }
    });
</script>
@endif

@if (session('status'))
<script>
    window.addEventListener('load', function () {
        if (window.Swal && Swal.fire) {
            Swal.fire({
                icon: 'success',
                title: 'Email sent successfully',
                text: @json(session('status')),
                confirmButtonColor: '#062c52'
            });
        }
    });
</script>
@endif

<style>

:root{

    --primary:#062c52;
    --sidebar-bg:#0B2A72;
    --body-bg:#F5F7FB;
    --card-bg:#FFFFFF;
    --border:#EEF2F7;

    --sidebar-width:280px;
    --navbar-height:72px;

    --radius:12px;
    --transition:.25s ease;
}

/* =====================================================
   GLOBAL
===================================================== */

*{
    box-sizing:border-box;
}

html,
body{
    margin:0;
    padding:0;
    width:100%;
    overflow-x:hidden;
}

body{
    font-family:'Poppins',sans-serif;
    background:var(--body-bg);
    color:#1E293B;
}

/* =====================================================
   BUTTONS
===================================================== */

.d-submit-button{
    background:var(--primary);
    color:#fff;
    height:50px;
    border:1px solid var(--primary);
    transition:var(--transition);
}

.d-submit-button:hover{
    background:#fff;
    color:var(--primary);
}

.d-submit-white-button{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    background:#fff;
    color:var(--primary);
    border:1px solid var(--primary);
    height:50px;
    transition:var(--transition);
}

.d-submit-white-button:hover{
    background:var(--primary);
    color:#fff;
}

.login-button{
    color:#fff;
    border-color:#fff;
}

.login-button:hover{
    background:#fff;
    color:var(--primary);
}

/* =====================================================
   SIDEBAR
===================================================== */

.sidebar{

    position:fixed;

    top:0;
    left:0;

    width:var(--sidebar-width);
    height:100vh;

    background:var(--sidebar-bg);

    display:flex;
    flex-direction:column;

    padding:20px;

    overflow-y:auto;

    z-index:1040;

}

/* =====================================================
   SIDEBAR LOGO
===================================================== */

.sidebar-logo{

    display:flex;
    align-items:flex-start;

    gap:14px;

    margin-bottom:30px;

}

.sidebar-logo img{

    width:48px;
    height:48px;

    background:#fff;

    border-radius:50%;

    padding:5px;

}

.sidebar-logo h6{

    color:#fff;

    margin:0;

    font-size:15px;

    font-weight:600;

}

.sidebar-logo small{

    color:#D9E3FF;

    font-size:11px;

    line-height:1.4;

}

/* =====================================================
   SIDEBAR MENU
===================================================== */

.sidebar-title{

    color:#9BB5E7;

    font-size:11px;

    font-weight:600;

    letter-spacing:1px;

    margin:18px 0 10px;

}

.sidebar a{

    display:flex;

    align-items:center;

    gap:12px;

    text-decoration:none;

    color:#fff;

    padding:12px 14px;

    border-radius:12px;

    margin-bottom:5px;

    transition:var(--transition);

    font-size:14px;

}

.sidebar a i{

    font-size:18px;

}

.sidebar a:hover{

    background:rgba(255,255,255,.08);

}

.sidebar a.active{

    background:#163F99;

    font-weight:600;

}

.logout-btn{

    width:100%;

    margin-top:auto;

    border:none;

    border-radius:10px;

    background:#8D8D8D;

    color:#fff;

    padding:12px;

    transition:var(--transition);

}

.logout-btn:hover{

    background:#727272;

}

/* =====================================================
   TOP NAVBAR
===================================================== */

.top-navbar{

    position:sticky;

    top:0;

    height:var(--navbar-height);

    margin-left:var(--sidebar-width);

    background:#fff;

    display:flex;

    align-items:center;

    justify-content:space-between;

    padding:0 25px;

    border-bottom:1px solid var(--border);

    z-index:1030;

}

/* =====================================================
   SEARCH BOX
===================================================== */

.navbar-title-group{

    flex:1;

    min-width:0;

}

.navbar-title{

    flex-shrink:0;

}

.search-box{

    display:flex;

    align-items:center;

    flex:1;

    width:auto;
    min-width:0;
    max-width:520px;

    background:#F8FAFC;

    border:1px solid #E2E8F0;

    border-radius:12px;

    padding:0 14px;

}

.search-box i{

    color:#94A3B8;

}

.search-box input{

    border:none;

    background:transparent;

    box-shadow:none;

    padding:11px 12px;

    width:100%;

}

.search-box input:focus{

    box-shadow:none;

}

.search-suggestions{

    display:none;

    position:absolute;

    top:calc(100% + 8px);

    left:0;

    right:0;

    background:#fff;

    border:1px solid var(--border);

    border-radius:12px;

    box-shadow:0 12px 30px rgba(15,23,42,.12);

    max-height:360px;

    overflow-y:auto;

    z-index:1050;

    padding:8px;

}

.search-suggestions.show{

    display:block;

}

.search-suggestions .suggestion-group-title{

    font-size:.72rem;

    font-weight:700;

    color:#94A3B8;

    letter-spacing:.03em;

    text-transform:uppercase;

    padding:8px 10px 4px;

}

.search-suggestions .suggestion-item{

    display:flex;

    align-items:center;

    gap:10px;

    padding:10px;

    border-radius:10px;

    cursor:pointer;

    color:#1E293B;

    text-decoration:none;

}

.search-suggestions .suggestion-item:hover,
.search-suggestions .suggestion-item.active{

    background:#F1F5FB;

}

.search-suggestions .suggestion-icon{

    width:34px;

    height:34px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    flex-shrink:0;

    background:#E8EEFF;

    color:#000099;

}

.search-suggestions .suggestion-title{

    font-size:.85rem;

    font-weight:600;

    overflow:hidden;

    text-overflow:ellipsis;

    white-space:nowrap;

}

.search-suggestions .suggestion-subtitle{

    font-size:.75rem;

    color:#6B7280;

    overflow:hidden;

    text-overflow:ellipsis;

    white-space:nowrap;

}

.search-suggestions .suggestion-empty{

    padding:14px 10px;

    color:#9CA3AF;

    font-size:.85rem;

    text-align:center;

}

/* =====================================================
   NAVBAR BUTTONS
===================================================== */

.nav-icon{

    width:44px;

    height:44px;

    border:none;

    border-radius:12px;

    display:flex;

    align-items:center;

    justify-content:center;

}

.nav-icon i{

    font-size:20px;

}

.notification-dot{

    width:10px;

    height:10px;

    border-radius:50%;

    background:#EF4444;

    border:2px solid #fff;

    position:absolute;

    top:10px;

    right:10px;

}

.notification-count{
    position:absolute;
    top:3px;
    right:3px;
    min-width:18px;
    height:18px;
    padding:0 3px;
    border-radius:9px;
    background:#EF4444;
    color:#fff;
    font-size:10px;
    font-weight:700;
    display:flex;
    align-items:center;
    justify-content:center;
    line-height:1;
    border:2px solid #fff;
}

.notification-menu{
    width:360px;
    max-width:calc(100vw - 24px);
    padding:0;
    overflow:hidden;
}

.notification-menu-header{
    display:flex;
    align-items:baseline;
    justify-content:space-between;
    gap:12px;
    padding:16px 18px 12px;
    border-bottom:1px solid var(--border);
}

.notification-menu-header strong{ font-size:.95rem; }
.notification-menu-header span{ font-size:.72rem; }

.notification-list{
    max-height:390px;
    overflow-y:auto;
}

.notification-item{
    display:flex;
    gap:12px;
    padding:13px 18px;
    color:#1E293B;
    text-decoration:none;
    border-bottom:1px solid #F1F5F9;
}

.notification-item:hover{ background:#F8FAFC; }

.notification-item-icon{
    width:34px;
    height:34px;
    flex:0 0 34px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    background:#E8EEFF;
    color:#0B2A72;
}

.notification-item-title{
    display:block;
    font-size:.8rem;
    font-weight:600;
    line-height:1.3;
}

.notification-item-description{
    display:block;
    margin-top:3px;
    color:#64748B;
    font-size:.72rem;
    line-height:1.35;
}

.notification-item-time{
    display:block;
    margin-top:5px;
    color:#94A3B8;
    font-size:.68rem;
}

.notification-empty{
    padding:28px 18px;
    color:#94A3B8;
    font-size:.8rem;
    text-align:center;
}

.user-button{

    display:flex;

    align-items:center;

    gap:12px;

    background:none;

    border:none;

}

.user-button img{

    width:45px;

    height:45px;

    border-radius:50%;

}

.dropdown-menu{

    width:230px;

}

.dropdown-item{

    padding:11px 18px;

}

.profile-modal-avatar{
    width:64px;
    height:64px;
    border-radius:50%;
    border:3px solid rgba(255,255,255,.55);
    box-shadow:0 8px 20px rgba(2,12,35,.18);
}

.profile-modal .modal-content{
    overflow:hidden;
    border-radius:20px;
}

.profile-modal-hero{
    position:relative;
    padding:30px 32px;
    color:#fff;
    background:#062c52;
}

.profile-modal-identity{
    display:flex;
    align-items:center;
    gap:18px;
}

.profile-modal-identity h4{
    color:#fff;
    font-weight:600;
}

.profile-modal-eyebrow{
    display:block;
    margin-bottom:5px;
    color:#b9d9f4;
    font-size:.7rem;
    font-weight:600;
    letter-spacing:.08em;
    text-transform:uppercase;
}

.profile-modal-role{
    color:#e0effc;
    font-size:.8rem;
}

.profile-modal-close{
    position:absolute;
    top:20px;
    right:22px;
    opacity:.9;
}

.profile-modal-section{
    padding:26px 32px;
}

.profile-modal-section + .profile-modal-section{
    border-top:1px solid #E8EEF5;
}

.profile-modal-section-heading{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:20px;
}

.profile-modal-section-heading h6{
    color:#172B4D;
    font-size:.95rem;
    font-weight:700;
}

.profile-modal-section-heading p{
    color:#8492A6;
    font-size:.75rem;
}

.profile-modal-section-icon{
    width:38px;
    height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex:0 0 38px;
    border-radius:11px;
    color:#0B2A72;
    background:#E8F1FC;
    font-size:1.1rem;
}

.profile-modal-section-icon.security{
    color:#087f5b;
    background:#e4f7ef;
}

.profile-modal-details{
    display:grid;
    grid-template-columns:repeat(2, minmax(0, 1fr));
    gap:16px;
    padding:18px;
    border:1px solid var(--border);
    border-radius:12px;
    background:#F8FAFC;
}

.profile-modal-details > div{
    min-width:0;
}

.profile-modal-label{
    display:block;
    margin-bottom:4px;
    color:#64748B;
    font-size:.72rem;
}

.profile-modal-details strong{
    display:block;
    font-size:.85rem;
    font-weight:600;
}

.password-form .form-label{
    color:#344563;
    font-size:.78rem;
    font-weight:600;
}

.password-form .form-control{
    min-height:44px;
    border-color:#D9E2EC;
    border-radius:10px;
    font-size:.85rem;
}

.password-form .form-control:focus{
    border-color:#438ac1;
    box-shadow:0 0 0 3px rgba(67,138,193,.14);
}

.profile-save-button{
    min-height:44px;
    padding:0 20px;
    border:0;
    border-radius:10px;
    color:#fff;
    background:#062c52;
    font-size:.82rem;
    font-weight:600;
    transition:var(--transition);
}

.profile-save-button:hover{
    color:#fff;
    background:#0B2A72;
    transform:translateY(-1px);
}

@media (max-width:575.98px){
    .profile-modal-hero,
    .profile-modal-section{
        padding:22px 20px;
    }

    .profile-modal-details{
        grid-template-columns:1fr;
    }

    .profile-modal-identity{
        align-items:flex-start;
    }
}


.main-content{

    margin-left:var(--sidebar-width);

    min-height:calc(100vh - var(--navbar-height));

    padding:25px;

    background:var(--body-bg);

}


@media (max-width:991.98px){

    :root{
        --sidebar-width:90px;
    }

    .sidebar{
        padding:18px 10px;
    }

    .sidebar-logo h6,
    .sidebar-logo small,
    .sidebar-title,
    .sidebar a span{
        display:none;
    }

    .sidebar-logo{
        justify-content:center;
    }

    .sidebar a{
        justify-content:center;
    }

    .top-navbar{
        margin-left:var(--sidebar-width);
        padding:0 18px;
    }

    .main-content{
        margin-left:var(--sidebar-width);
        padding:20px;
    }

    .search-box{
        width:240px;
    }

}

/* =====================================================
   MOBILE
===================================================== */

@media (max-width:767.98px){

    .sidebar{

        transform:translateX(-100%);

    }

    .top-navbar{

        margin-left:0;

        height:auto;

        padding:12px 15px;

        flex-wrap:wrap;

        row-gap:12px;

    }

    .navbar-actions-group{

        order:1;

        margin-left:auto;

    }

    .navbar-title-group{

        order:2;

        flex-basis:100%;

        flex-wrap:wrap;

        gap:10px !important;

    }

    .navbar-title{

        font-size:1.05rem;

    }

    .main-content{

        margin-left:0;

        padding:15px;

    }

    .search-box{

        width:100%;

    }

}

/* =====================================================
   SMALL MOBILE
===================================================== */

@media (max-width:575.98px){

    .guest-brand-text small{

        display:none;

    }

    .guest-logo{

        width:36px;

    }

    .guest-login-text{

        display:none;

    }

    .top-navbar{

        padding:10px 12px;

    }

    .navbar-actions-group{

        gap:8px !important;

    }

    .user-button-text{

        display:none;

    }

    .user-button img{

        width:38px;

        height:38px;

    }

    .nav-icon{

        width:38px;

        height:38px;

    }

    .nav-icon i{

        font-size:18px;

    }

    .notification-menu{
        position:fixed !important;
        top:58px !important;
        right:12px !important;
        left:auto !important;
        transform:none !important;
    }

}
/* ===============================
   Mobile Sidebar
================================ */

.sidebar{
    transition:transform .3s ease;
}

.sidebar-overlay{

    position:fixed;

    inset:0;

    background:rgba(0,0,0,.45);

    opacity:0;

    visibility:hidden;

    transition:.3s;

    z-index:1035;

}

.sidebar-overlay.show{

    opacity:1;

    visibility:visible;

}

@media (max-width:991.98px){

    .sidebar{

        width:280px;

        transform:translateX(-100%);

        z-index:1040;

    }

    .sidebar.show{

        transform:translateX(0);

    }

}
    

    .approval-dialog {
    max-width: 390px;
}

.approval-modal {
    border-radius: 24px;
    background: #ffffff;
    box-shadow: 0 20px 60px rgba(0,0,0,.15);
    overflow: hidden;
}


.approval-modal .modal-body {
    padding: 35px 32px;
}


/* Icon */
.approval-icon {
    width: 85px;
    height: 85px;
    margin: 0 auto;
    border-radius: 50%;
    background: linear-gradient(135deg,#fff3cd,#ffe69c);
    display: flex;
    align-items: center;
    justify-content: center;
    animation: pulseApproval 2s infinite;
}

.approval-icon i {
    font-size: 42px;
    color: #b88600;
}


/* Text */
.approval-title {
    margin-top: 22px;
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
}


.approval-message {
    margin-top: 12px;
    color: #6b7280;
    font-size: .9rem;
    line-height: 1.6;
}


/* Info box */
.approval-info {
    display: flex;
    gap: 10px;
    align-items: center;
    text-align: left;
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    padding: 12px 14px;
    border-radius: 14px;
    margin: 22px 0;
    font-size: .82rem;
    color: #64748b;
}

.approval-info i {
    color: #2563eb;
    font-size: 1rem;
}


/* Button */
.approval-btn {
    border-radius: 14px;
    padding: 12px;
    background: #2563eb;
    color: white;
    font-weight: 600;
    border: none;
    transition: .25s ease;
}


.approval-btn:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
}


@keyframes pulseApproval {

    0% {
        box-shadow: 0 0 0 0 rgba(234,179,8,.25);
    }

    70% {
        box-shadow: 0 0 0 15px rgba(234,179,8,0);
    }

    100% {
        box-shadow: 0 0 0 0 rgba(234,179,8,0);
    }

}

.registration-container {
    padding: 25px;
}


.registration-header {
    text-align:center;
    margin-bottom:25px;
}


.register-icon {
    width:70px;
    height:70px;
    margin:auto;
    border-radius:50%;
    background:#eef4ff;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:15px;
}


.register-icon i {
    font-size:32px;
    color:#2563eb;
}


.registration-header h4 {
    font-weight:700;
    color:#111827;
}


.registration-header p {
    color:#6b7280;
    font-size:.85rem;
}



/* Notice */

.registration-notice {

    display:flex;
    gap:14px;
    padding:16px;
    border-radius:16px;

    background:#f8fafc;
    border:1px solid #e2e8f0;

    margin-bottom:25px;

}


.notice-icon {

    width:38px;
    height:38px;
    border-radius:12px;

    background:#dbeafe;

    display:flex;
    align-items:center;
    justify-content:center;

    color:#2563eb;

}


.registration-notice small {

    display:block;
    color:#64748b;
    margin-top:4px;
    line-height:1.5;

}



/* Sections */

.form-section-title {

    font-size:.85rem;
    font-weight:700;
    color:#334155;

    display:flex;
    gap:8px;
    align-items:center;

    margin-bottom:15px;

}



/* Inputs */

label {

    font-size:.8rem;
    font-weight:600;
    color:#374151;
    margin-bottom:7px;

}


label span {

    color:#94a3b8;
    font-weight:400;

}


.input-group-custom {

    display:flex;
    align-items:center;

    border:1px solid #d1d5db;

    border-radius:14px;

    padding:0 14px;

    background:white;

    transition:.2s;

}


.input-group-custom:focus-within {

    border-color:#2563eb;

    box-shadow:0 0 0 4px rgba(37,99,235,.1);

}


.input-group-custom i {

    color:#94a3b8;

    margin-right:10px;

}


.input-group-custom input {

    width:100%;
    border:0;
    outline:0;

    padding:13px 0;

    font-size:.9rem;

}



/* Button */

.register-button {

    border:none;

    padding:14px;

    border-radius:14px;

    background:#2563eb;

    color:white;

    font-weight:600;

    transition:.25s;

}


.register-button:hover:not(:disabled){

    background:#1d4ed8;

    transform:translateY(-1px);

}


.register-button:disabled {

    opacity:.5;

    cursor:not-allowed;

}



/* Login */

.login-link {

    text-align:center;

    margin-top:22px;

    font-size:.85rem;

    color:#64748b;

}


.login-link a {

    color:#2563eb;

    font-weight:600;

    text-decoration:none;

}

.register-brand-panel {
    background: linear-gradient(
        145deg,
        #ecf4fe,
        #f8fbff
    );
    min-height: 100%;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.brand-content {
    position: relative;
    z-index: 1;
}

.brand-logo {
    max-width: 280px;
}

.brand-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1b2a41;
    line-height: 1.3;
}

.brand-title span {
    color: #0d6efd;
}

.brand-description {
    color: #6c757d;
    font-size: 0.95rem;
    max-width: 380px;
    line-height: 1.6;
}

.brand-feature {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 15px;
}

.feature-item i {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border-radius: 12px;
    color: #0d6efd;
    font-size: 1.2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
}

.feature-item strong {
    display: block;
    color: #1b2a41;
    font-size: 0.9rem;
}

.feature-item small {
    color: #6c757d;
    font-size: 0.8rem;
}

.forgot-password-card {
    border-radius: 24px;
    overflow:hidden;
    box-shadow:0 20px 60px rgba(0,0,0,.15);
}


.forgot-icon {

    width:80px;
    height:80px;
    margin:auto;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:50%;

    background:#eaf3ff;
    color:#0d6efd;

}


.forgot-icon i {
    font-size:2.4rem;
}



.forgot-input .input-group-text {

    background:#f8fafc;
    border-right:0;
    color:#6c757d;

}


.forgot-input .form-control {

    border-left:0;
    padding:12px;

}


.forgot-input:focus-within {

    box-shadow:0 0 0 .2rem rgba(13,110,253,.15);
    border-radius:10px;

}


.forgot-input .form-control:focus {

    box-shadow:none;

}



#loginForgotPasswordSubmit {

    border-radius:12px;
    transition:.25s ease;

}


#loginForgotPasswordSubmit:hover {

    transform:translateY(-1px);
    box-shadow:0 8px 20px rgba(13,110,253,.25);

}



.reset-info {

    background:#f8f9fa;

    border-radius:12px;

    padding:12px 15px;

    font-size:.8rem;

    color:#6c757d;

    display:flex;
    align-items:center;

}



.modal.fade .modal-dialog {

    transform:scale(.95);

    transition:transform .25s ease;

}


.modal.show .modal-dialog {

    transform:scale(1);

}
</style>

<!-- Bootstrap JS bundle fallback -->
@stack('modals')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-funnel"></script>
<script>

document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.querySelector('.sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggle = document.getElementById('sidebarToggle');

    if (!sidebar || !overlay || !toggle) return;

    toggle.addEventListener('click', function () {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    });

    overlay.addEventListener('click', function () {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    });

});

document.addEventListener('DOMContentLoaded', function () {

    const passwordToggle = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const loginForm = document.getElementById('loginForm');

    if (passwordToggle && passwordInput) {
        passwordToggle.addEventListener('click', function () {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                this.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    }

    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);
            const loginError = document.getElementById('loginError');

            loginError.innerHTML = '';

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    loginError.replaceChildren();
                    const error = document.createElement('div');
                    error.className = 'alert alert-danger';
                    error.textContent = data.message || 'Unable to sign in.';
                    loginError.appendChild(error);
                }
            })
            .catch(error => {
                console.log(error);
            });
        });
    }

});
</script>

@auth
<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchWrapper = document.getElementById('navbarSearch');
    const searchInput = document.getElementById('navbarSearchInput');
    const suggestionsBox = document.getElementById('navbarSearchSuggestions');

    if (!searchWrapper || !searchInput || !suggestionsBox) return;

    const searchUrl = @json(route('search.suggestions', [], false));
    let debounceTimer = null;
    let activeIndex = -1;
    let currentItems = [];

    function safeSearchUrl(value) {
        try {
            const url = new URL(value, window.location.origin);
            return url.origin === window.location.origin ? url.href : '#';
        } catch (error) {
            return '#';
        }
    }

    function escapeSearchText(value) {
        return String(value || '').replace(/[&<>"']/g, function (character) {
            return {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'}[character];
        });
    }

    function closeSuggestions() {
        suggestionsBox.classList.remove('show');
        suggestionsBox.innerHTML = '';
        currentItems = [];
        activeIndex = -1;
    }

    function renderSuggestions(data) {
        const tickets = data.tickets || [];
        const users = data.users || [];

        if (!tickets.length && !users.length) {
            suggestionsBox.innerHTML = '<div class="suggestion-empty">No matching tickets or users found.</div>';
            suggestionsBox.classList.add('show');
            currentItems = [];
            activeIndex = -1;
            return;
        }

        let html = '';

        if (tickets.length) {
            html += '<div class="suggestion-group-title">Tickets</div>';
            tickets.forEach(function (ticket) {
                html += `
                    <a href="${safeSearchUrl(ticket.url)}" class="suggestion-item" data-url="${safeSearchUrl(ticket.url)}">
                        <span class="suggestion-icon"><i class="bi bi-file-earmark-text"></i></span>
                        <span class="flex-grow-1 min-width-0">
                            <span class="suggestion-title d-block">${escapeSearchText(ticket.ticket_id)}</span>
                            <span class="suggestion-subtitle d-block">${escapeSearchText(ticket.requestor)}${ticket.purpose ? ' • ' + escapeSearchText(ticket.purpose) : ''}</span>
                        </span>
                    </a>
                `;
            });
        }

        if (users.length) {
            html += '<div class="suggestion-group-title">Users</div>';
            users.forEach(function (user) {
                html += `
                    <div class="suggestion-item" data-static="true">
                        <span class="suggestion-icon"><i class="bi bi-person"></i></span>
                        <span class="flex-grow-1 min-width-0">
                            <span class="suggestion-title d-block">${escapeSearchText(user.name)}</span>
                            <span class="suggestion-subtitle d-block">${escapeSearchText(user.email)}</span>
                        </span>
                    </div>
                `;
            });
        }

        suggestionsBox.innerHTML = html;
        suggestionsBox.classList.add('show');
        currentItems = Array.from(suggestionsBox.querySelectorAll('.suggestion-item[data-url]'));
        activeIndex = -1;
    }

    function fetchSuggestions(query) {
        fetch(`${searchUrl}?q=${encodeURIComponent(query)}`, {
            headers: { 'Accept': 'application/json' }
        })
            .then(function (response) { return response.json(); })
            .then(renderSuggestions)
            .catch(function () { closeSuggestions(); });
    }

    searchInput.addEventListener('input', function () {
        const query = this.value.trim();

        clearTimeout(debounceTimer);

        if (query.length < 2) {
            closeSuggestions();
            return;
        }

        debounceTimer = setTimeout(function () {
            fetchSuggestions(query);
        }, 250);
    });

    searchInput.addEventListener('keydown', function (e) {
        if (!currentItems.length) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            activeIndex = Math.min(activeIndex + 1, currentItems.length - 1);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            activeIndex = Math.max(activeIndex - 1, 0);
        } else if (e.key === 'Enter') {
            if (activeIndex >= 0 && currentItems[activeIndex]) {
                e.preventDefault();
                window.location.href = currentItems[activeIndex].dataset.url;
            }
            return;
        } else {
            return;
        }

        currentItems.forEach(function (item, index) {
            item.classList.toggle('active', index === activeIndex);
        });
    });

    document.addEventListener('click', function (e) {
        if (!searchWrapper.contains(e.target)) {
            closeSuggestions();
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const notificationButton = document.getElementById('notificationButton');
    const notificationList = document.getElementById('notificationList');
    const notificationDot = document.getElementById('notificationDot');
    const notificationCount = document.getElementById('notificationCount');
    const notificationSummary = document.getElementById('notificationSummary');

    if (!notificationButton || !notificationList) return;

    const notificationDropdown = window.bootstrap?.Dropdown
        ? window.bootstrap.Dropdown.getOrCreateInstance(notificationButton)
        : null;

    const notificationUrl = @json(route('notifications.index', [], false));
    const lastSeenKey = 'istaksyon.notifications.last_seen_id';

    function iconFor(event) {
        if (event === 'ticket_created') return 'bi-plus-circle';
        if (event === 'ticket_returned') return 'bi-arrow-counterclockwise';
        if (event === 'comment_added' || event === 'comment_reply') return 'bi-chat-dots';
        return 'bi-check-circle';
    }

    function setUnreadCount(count) {
        const unread = Number(count) || 0;
        notificationDot.classList.toggle('d-none', unread === 0);
        notificationCount.classList.toggle('d-none', unread === 0);
        notificationCount.textContent = unread > 99 ? '99+' : String(unread);
    }

    function renderNotifications(notifications) {
        notificationList.innerHTML = '';

        if (!notifications.length) {
            const empty = document.createElement('div');
            empty.className = 'notification-empty';
            empty.textContent = 'No ticket notifications yet.';
            notificationList.appendChild(empty);
            return;
        }

        notifications.forEach(function (notification) {
            const item = document.createElement(notification.url ? 'a' : 'div');
            item.className = 'notification-item';
            if (notification.url) item.href = notification.url;

            const icon = document.createElement('span');
            icon.className = 'notification-item-icon';
            const iconElement = document.createElement('i');
            iconElement.className = 'bi ' + iconFor(notification.event);
            icon.appendChild(iconElement);

            const content = document.createElement('span');
            content.className = 'min-width-0';

            const title = document.createElement('span');
            title.className = 'notification-item-title';
            title.textContent = notification.ticket_id
                ? notification.title + ' #' + notification.ticket_id
                : notification.title;

            const description = document.createElement('span');
            description.className = 'notification-item-description';
            description.textContent = notification.description || '';

            const time = document.createElement('span');
            time.className = 'notification-item-time';
            time.textContent = notification.created_at || '';

            content.appendChild(title);
            content.appendChild(description);
            content.appendChild(time);
            item.appendChild(icon);
            item.appendChild(content);
            notificationList.appendChild(item);
        });
    }

    function loadNotifications() {
        const lastSeenId = Number(window.localStorage.getItem(lastSeenKey) || 0);

        fetch(notificationUrl + '?since=' + encodeURIComponent(lastSeenId), {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(function (response) {
                if (!response.ok) throw new Error('Unable to load notifications');
                return response.json();
            })
            .then(function (data) {
                renderNotifications(data.notifications || []);
                setUnreadCount(data.unread_count || 0);
                notificationSummary.textContent = (data.notifications || []).length + ' recent';
                notificationButton.dataset.latestNotificationId = data.latest_id || lastSeenId;
            })
            .catch(function () {
                notificationList.innerHTML = '';
                const error = document.createElement('div');
                error.className = 'notification-empty';
                error.textContent = 'Notifications are unavailable right now.';
                notificationList.appendChild(error);
            });
    }

    notificationButton.addEventListener('click', function () {
        const latestId = Number(this.dataset.latestNotificationId || 0);
        if (latestId > 0) {
            try {
                window.localStorage.setItem(lastSeenKey, String(latestId));
            } catch (error) {
                // Notifications should still open when browser storage is unavailable.
            }
            setUnreadCount(0);
        }

        if (notificationDropdown) notificationDropdown.toggle();
    });

    loadNotifications();
    window.setInterval(loadNotifications, 60000);
});
</script>
@if ($errors->getBag('passwordUpdate')->any() || session('password_success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const profileModal = document.getElementById('profileModal');

    if (profileModal && window.bootstrap) {
        bootstrap.Modal.getOrCreateInstance(profileModal).show();
    }
});
</script>
@endif
@endauth
</body>
</html>