@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')

<div class="reset-page">
    <div class="reset-card">
        <!-- Logo / Icon -->
        <div class="reset-header">

            <div class="reset-icon">
                <i class="bi bi-lock-fill"></i>
            </div>
            <h2>
                Reset your password
            </h2>
            <p>
                Create a new password to secure your account.
            </p>
        </div>
        @if ($tokenExpired)
            <div class="reset-expired">
    <div class="reset-expired-icon">
        <i class="bi bi-clock-history"></i>
    </div>
    <h3>
        Reset link unavailable
    </h3>
    <p>
        This password reset link is no longer valid.
        It may have expired or has already been used.
        Please request a new link to continue resetting your password.
    </p>
    <a href="{{ route('home') }}" 
        class="btn reset-btn w-100">
        <i class="bi bi-envelope-arrow-up me-2"></i>
        Request New Reset Link
    </a>
    <div class="reset-help">
        <i class="bi bi-shield-check me-2"></i>
        For your security, password reset links can only be used once.
    </div>
</div>
        @else
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">


            <!-- Email -->
            <div class="form-floating mb-3">

                <input 
                    type="email"
                    class="form-control bg-light"
                    id="email"
                    value="{{ old('email', $email) }}"
                    disabled>

                <label for="email">
                    Email address
                </label>

                <input type="hidden"
                    name="email"
                    value="{{ old('email', $email) }}">

            </div>



            <!-- Password -->
            <div class="form-floating mb-3 password-field">

                <input 
                    type="password"
                    id="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="New password"
                    minlength="8"
                    pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}"
                    title="Use at least 8 characters, including an uppercase letter, a lowercase letter, a number, and a symbol."
                    required>

                <label>
                    New password
                </label>

                <div class="form-text">At least 8 characters with uppercase, lowercase, number, and symbol.</div>


                <button type="button"
                    class="password-eye"
                    onclick="togglePassword('password',this)">

                    <i class="bi bi-eye"></i>

                </button>


            </div>


            @error('password')
                <div class="text-danger small mb-3">
                    {{ $message }}
                </div>
            @enderror



            <!-- Confirm -->
            <div class="form-floating mb-4 password-field">

                <input 
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Confirm password"
                    minlength="8"
                    required>

                <label>
                    Confirm password
                </label>


                <button type="button"
                    class="password-eye"
                    onclick="togglePassword('password_confirmation',this)">

                    <i class="bi bi-eye"></i>

                </button>


            </div>



            <button class="btn reset-btn w-100">

                <i class="bi bi-shield-check me-2"></i>

                Update Password

            </button>


        </form>
        @endif


    </div>

</div>

<style>
    .reset-page {

    min-height:80vh;

    display:flex;

    align-items:center;

    justify-content:center;

    padding:30px;

}



.reset-card {

    width:100%;

    max-width:430px;

    background:#fff;

    padding:40px;

    border-radius:22px;

    box-shadow:
    0 15px 45px rgba(0,0,0,.12);

}



.reset-header {

    text-align:center;

    margin-bottom:35px;

}



.reset-icon {

    width:72px;

    height:72px;

    display:flex;

    align-items:center;

    justify-content:center;

    margin:auto;

    border-radius:20px;

    background:#eef5ff;

    color:#0d6efd;

}



.reset-icon i {

    font-size:32px;

}



.reset-header h2 {

    margin-top:20px;

    font-size:1.45rem;

    font-weight:700;

}



.reset-header p {

    color:#6c757d;

    font-size:.9rem;

}



.form-floating input {

    border-radius:12px;

    height:58px;

}



.form-floating input:focus {

    box-shadow:0 0 0 .2rem rgba(13,110,253,.12);

}



.password-field {

    position:relative;

}



.password-eye {

    position:absolute;

    right:12px;

    top:17px;

    border:0;

    background:none;

    color:#6c757d;

    z-index:5;

}



.password-eye:hover {

    color:#0d6efd;

}


.reset-btn {

    height:55px;

    border-radius:14px;

    background:#0d6efd;

    color:white;

    font-weight:600;

    transition:.25s;

}



.reset-btn:hover {

    background:#0b5ed7;

    color:white;

    transform:translateY(-1px);

}



.reset-footer {

    margin-top:25px;

    padding:12px;

    border-radius:12px;

    background:#f8fafc;

    text-align:center;

    font-size:.8rem;

    color:#6c757d;

}

.reset-expired {

    max-width:430px;

    margin:auto;

    background:#fff;

    padding:40px;

    border-radius:24px;

    text-align:center;

    box-shadow:
        0 15px 45px rgba(0,0,0,.12);

}



.reset-expired-icon {

    width:85px;

    height:85px;

    margin:0 auto 25px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:22px;

    background:#fff4e5;

    color:#f59f00;

}



.reset-expired-icon i {

    font-size:2.5rem;

}



.reset-expired h3 {

    font-size:1.35rem;

    font-weight:700;

    margin-bottom:12px;

}



.reset-expired p {

    color:#6c757d;

    font-size:.92rem;

    line-height:1.6;

    margin-bottom:28px;

}



.reset-btn {

    height:54px;

    border-radius:14px;

    font-weight:600;

    transition:.25s ease;

}



.reset-btn:hover {

    transform:translateY(-2px);

    box-shadow:
    0 8px 20px rgba(13,110,253,.25);

}



.reset-help {

    margin-top:25px;

    padding:12px 15px;

    background:#f8fafc;

    border-radius:12px;

    font-size:.8rem;

    color:#6c757d;

    display:flex;

    align-items:center;

    justify-content:center;

}
</style>

<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');

        if (!input || !icon) return;

        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('bi-eye', !isPassword);
        icon.classList.toggle('bi-eye-slash', isPassword);
        button.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
    }
</script>
@endsection