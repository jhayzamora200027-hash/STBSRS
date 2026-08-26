@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<style>
    .password-loading-card {
    border-radius: 20px;
    background: #fff;
    opacity: 1;
    box-shadow: 0 20px 50px rgba(0,0,0,.15);
    animation: modalFade .3s ease;
}


.loading-icon-wrapper {
    width: 90px;
    height: 90px;
    margin: auto;
    position: relative;
    display:flex;
    align-items:center;
    justify-content:center;
}


.loading-icon-wrapper i {
    font-size: 2.2rem;
    color:#0d6efd;
    z-index:2;
}


.loading-ring {
    position:absolute;
    width:90px;
    height:90px;
    border-radius:50%;
    border:4px solid #e9f2ff;
    border-top-color:#0d6efd;
    animation: spin 1s linear infinite;
}


.loading-progress {
    height:6px;
    border-radius:20px;
    overflow:hidden;
    background:#eef3f8;
}


.loading-progress .progress-bar {
    border-radius:20px;
}


@keyframes spin {
    from {
        transform:rotate(0deg);
    }
    to {
        transform:rotate(360deg);
    }
}


@keyframes modalFade {
    from {
        opacity:0;
        transform:translateY(15px) scale(.96);
    }
    to {
        opacity:1;
        transform:translateY(0) scale(1);
    }
}

</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">
            <div class="bg-white border rounded-3 shadow-sm p-4 p-md-5">
                <div class="text-center mb-4">
                    <i class="bi bi-shield-lock fs-1 text-primary"></i>
                    <h1 class="h4 mt-3">Forgot your password?</h1>
                    <p class="text-muted mb-0">Enter your account email and we will send you a link to create a new password.</p>
                </div>

                <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100" id="forgotPasswordSubmit">Email password reset link</button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="forgot-link">Back to sign in</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="passwordResetLoadingModal" tabindex="-1"
    aria-labelledby="passwordResetLoadingLabel"
    aria-hidden="true"
    data-bs-backdrop="static"
    data-bs-keyboard="false">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content password-loading-card border-0">

            <div class="modal-body text-center p-5">

                <div class="loading-icon-wrapper mb-4">
                    <div class="loading-ring"></div>
                    <i class="bi bi-envelope-check-fill"></i>
                </div>

                <h5 class="fw-semibold mb-2" id="passwordResetLoadingLabel">
                    Sending password reset link
                </h5>

                <p class="text-muted small mb-4">
                    We're preparing your email notification.
                    Please wait a moment.
                </p>


                <div class="progress loading-progress">
                    <div id="passwordResetProgress" class="progress-bar progress-bar-striped progress-bar-animated"
                        role="progressbar"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        aria-valuenow="10"
                        style="width: 10%">
                    </div>
                </div>

                <small id="passwordResetProgressText" class="text-secondary d-block mt-3" aria-live="polite">
                    Do not close this window
                </small>

            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('status'))
            Swal.fire({
                icon: 'success',
                title: 'Email sent successfully',
                text: @json(session('status')),
                confirmButtonColor: '#0d6efd'
            });
        @endif
    });

    document.getElementById('forgotPasswordForm').addEventListener('submit', function (event) {
        if (!this.checkValidity()) {
            return;
        }

        const submitButton = document.getElementById('forgotPasswordSubmit');
        const progressBar = document.getElementById('passwordResetProgress');
        const progressText = document.getElementById('passwordResetProgressText');
        let progress = 10;

        submitButton.disabled = true;
        bootstrap.Modal.getOrCreateInstance(document.getElementById('passwordResetLoadingModal')).show();

        window.setInterval(function () {
            if (progress >= 90) {
                return;
            }

            progress += 5;
            progressBar.style.width = progress + '%';
            progressBar.setAttribute('aria-valuenow', progress);
            progressText.textContent = 'Processing your request (' + progress + '%)';
        }, 500);
    });
</script>
@endsection