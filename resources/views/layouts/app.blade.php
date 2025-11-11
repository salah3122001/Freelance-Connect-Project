<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Freelance Platform') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
            background: #f8f9fa;
        }

        /* Navbar */
        .navbar {
            background-color: #0d6efd !important;
            padding: 10px 0;
        }

        .navbar-brand {
            color: #fff !important;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .nav-link,
        #navbarDropdown {
            color: #fff !important;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .nav-link:hover,
        #navbarDropdown:hover {
            color: #dce7ff !important;
        }

        .btn-auth {
            border-radius: 6px;
            padding: 6px 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-login {
            border: 1px solid #fff;
            color: #fff !important;
        }

        .btn-login:hover {
            background: #fff;
            color: #0d6efd !important;
        }

        .btn-register {
            background: #fff;
            color: #0d6efd !important;
            margin-left: 10px;
        }

        .btn-register:hover {
            background: #dce7ff;
        }

        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        main {
            padding-top: 90px;
        }

        /* Search Area */
        .search-area {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(13, 110, 253, 0.95);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .search-area.active {
            display: flex;
        }

        .search-bar {
            text-align: center;
            color: #fff;
        }

        .search-bar h3 {
            margin-bottom: 20px;
            font-weight: 500;
        }

        .search-bar input[type="text"] {
            width: 300px;
            padding: 10px 15px;
            border-radius: 6px;
            border: none;
            outline: none;
            margin-right: 10px;
        }

        .search-bar button {
            padding: 10px 20px;
            background: #fff;
            border: none;
            color: #0d6efd;
            font-weight: 500;
            border-radius: 6px;
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 24px;
            color: #fff;
            cursor: pointer;
        }

        .btn-light.btn-sm {
            background: #fff;
            color: #0d6efd !important;
            border-radius: 6px;
            padding: 6px 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-light.btn-sm:hover {
            background: #dce7ff;
            color: #0a58ca !important;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    FreelanceHub
                </a>

                <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        @if (Auth::check() && Auth::user()->role == 'admin')
                            <li class="nav-item me-2">
                                <a href="{{ route('admin.dashboard') }}"
                                    class="btn btn-light btn-sm fw-semibold shadow-sm">
                                    <i class="fas fa-chart-line me-1 text-primary"></i> Go To Dashboard
                                </a>
                            </li>
                        @endif
                    </ul>

                    <ul class="navbar-nav ms-auto align-items-center">
                        <!-- Search Button -->
                        <li class="nav-item me-3">
                            <a href="javascript:void(0)" class="nav-link" onclick="toggleSearch()">
                                <i class="fas fa-search"></i>
                            </a>
                        </li>

                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('orders.index') }}">My Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('services.index') }}">Services</a>
                            </li>

                            @if (auth()->check() && (auth()->user()->role == 'freelancer' || auth()->user()->role == 'admin'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('services.create') }}">Create Service</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('orders.freelancerStatistics') }}">Your Stats</a>
                                </li>
                            @endif

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                                    data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @else
                            <a class="btn-auth btn-login nav-link" href="{{ route('login') }}">Login</a>
                            <a class="btn-auth btn-register nav-link" href="{{ route('register') }}">Register</a>
                        @endauth

                    </ul>
                </div>
            </div>
        </nav>

        <!-- Search Area -->
        <div class="search-area" id="searchArea">
            <span class="close-btn" onclick="toggleSearch()"><i class="fas fa-times"></i></span>
            <div class="search-bar">
                <h3>Search for services:</h3>
                <form action="{{ route('search') }}" method="post">
                    @csrf
                    <input type="text" name="searchkey" placeholder="Write here...">
                    <button type="submit">Search <i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>



        <main>
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSearch() {
            document.getElementById('searchArea').classList.toggle('active');
        }
    </script>
</body>

</html>
