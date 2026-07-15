<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>STBSRS</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg shadow-sm sticky-top" style= "background-color: #062c52 ">
    <div class="container-fluid d-flex align-items-center justify-content-start">

        <a class="navbar-brand d-flex align-items-center me-auto" href="{{ url('/') }}" >
            <div class="bg-white rounded-circle d-flex">
                <img src="{{ asset('images/logo/social technology bureau innovating solution logo.png') }}" width="45" alt="STBSRS logo">
            </div>
            <div class="ms-3">
                <h5 style="color:azure;">
                    STB Service Request
                </h5>

                <small style="color: azure">
                    Department of Social Welfare and Development
                </small>
            </div>
        </a>
    </div>

    <div class="container-fluid d-flex align-items-end justify-content-end">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="true" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
        </button>
            <div class="ms-auto d-flex align-items-center justify-content-end">
                <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 100-6 3 3 0 000 6z"/>
                    </svg>
                    <span>Login</span>
                </button>
            </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<!-- Bootstrap JS bundle fallback -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>