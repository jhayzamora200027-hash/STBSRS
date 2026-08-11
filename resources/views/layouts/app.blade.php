<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'STBSRS')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body>


@guest

<nav class="navbar navbar-expand-lg shadow-sm sticky-top" style="background:#062c52;">

    <div class="container-fluid">

        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            

            <div class="bg-white rounded-circle p-1">

                <img src="{{ asset('images/logo/social technology bureau innovating solution logo.png') }}"
                     width="45">

            </div>

            <div class="ms-3">

                <h5 class="mb-0 text-white">
                    STB Service Request
                </h5>

                <small class="text-white">
                    Department of Social Welfare and Development
                </small>

            </div>

        </a>

        <button class="btn btn-outline-light"
                data-bs-toggle="modal"
                data-bs-target="#loginModal">

            <i class="bi bi-person-fill me-2"></i>

            Login

        </button>

    </div>

</nav>

<main>
    @yield('content')
</main>

@endguest



@auth


<aside class="sidebar">

    <div class="sidebar-logo">
            

        <img src="{{ asset('images/logo/social technology bureau innovating solution logo.png') }}">

        <div>

            <h6>iSTaksyon</h6>

            <small>
                Department of Social Welfare and Development
            </small>

        </div>

    </div>

    <span class="sidebar-title">MAIN</span>

    <a href="{{ route('dashboard') }}"
       class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }} justify-content-start">

        <i class="bi bi-grid"></i>

        Dashboard & Reports

    </a>

    <a href="#" class="justify-content-start">

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

    <a href="#" class="justify-content-start">

        <i class="bi bi-file-earmark-medical"></i>

        For Review Tickets

    </a>

    <span class="sidebar-title mt-4">

        SETTINGS

    </span>

    <a href="#" class="justify-content-start">

        <i class="bi bi-people"></i>

        Users

    </a>

</aside>
<div id="sidebarOverlay" class="sidebar-overlay"></div>


<nav class="top-navbar">
    <button class="btn btn-light d-lg-none me-3" id="sidebarToggle">
                <i class="bi bi-list fs-3"></i>
    </button>
    @php

        $pageTitles = [

            'dashboard'       => 'Dashboard & Reports',
            'feedback.index'  => 'Feedback Report',
            'tickets'   => 'All Tickets',
            'tickets.review'  => 'Review Tickets',
            'users.index'     => 'User Management',

        ];

        $title = $pageTitles[Route::currentRouteName()] ?? 'Dashboard';

    @endphp


    <div class="d-flex align-items-center gap-4">

        <h4 class="mb-0">

            {{ $title }}

        </h4>

        <div class="search-box">

            <i class="bi bi-search"></i>

            <input
                class="form-control border-0"
                placeholder="Search tickets or user...">

        </div>

    </div>


    <div class="d-flex align-items-center gap-3">

        <button class="btn btn-light nav-icon position-relative">

            <i class="bi bi-bell"></i>

            <span class="notification-dot"></span>

        </button>

        <div class="dropdown">

            <button
                class="btn user-button dropdown-toggle"
                type="button"
                id="userDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false">

                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0B2A72&color=fff">

                <div class="text-start ms-2">

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

                    <a class="dropdown-item" href="#">

                        <i class="bi bi-person me-2"></i>

                        Profile

                    </a>

                </li>

                <li>

                    <a class="dropdown-item" href="#">

                        <i class="bi bi-gear me-2"></i>

                        Settings

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



<main class="main-content">

    @yield('content')

</main>

@endauth




@stack('scripts')

<style>
    /* =====================================================
   STBSRS APP LAYOUT
===================================================== */

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

.search-box{

    display:flex;

    align-items:center;

    width:360px;
    max-width:100%;

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

}

.search-box input:focus{

    box-shadow:none;

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

/* =====================================================
   MAIN CONTENT
===================================================== */

.main-content{

    margin-left:var(--sidebar-width);

    min-height:calc(100vh - var(--navbar-height));

    padding:25px;

    background:var(--body-bg);

}

/* =====================================================
   TABLET
===================================================== */

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

        padding:15px;

        flex-wrap:wrap;

        gap:15px;

    }

    .main-content{

        margin-left:0;

        padding:15px;

    }

    .search-box{

        width:100%;

    }

}
/* ===============================
   Mobile Sidebar
================================ */

.sidebar-overlay{

    position:fixed;

    inset:0;

    background:rgba(0,0,0,.45);

    opacity:0;

    visibility:hidden;

    transition:.25s;

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

        transition:.3s ease;

    }

    .sidebar.show{

        transform:translateX(0);

    }

    .top-navbar{

        margin-left:0;

    }

    .main-content{

        margin-left:0;

    }

}

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

    .top-navbar{

        margin-left:0;

        padding:0 15px;

    }

    .main-content{

        margin-left:0;

        padding:20px;

    }

    .search-box{

        width:100%;

        max-width:280px;

    }

}
    
</style>

<!-- Bootstrap JS bundle fallback -->
@stack('modals')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
</script>
</body>
</html>