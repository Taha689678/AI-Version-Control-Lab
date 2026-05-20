<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ali Academy') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #6c5ce7;
            --secondary-color: #a29bfe;
            --success-color: #00b894;
            --warning-color: #fdcb6e;
            --info-color: #0984e3;
            --dark-color: #2d3436;
            --light-color: #dfe6e9;
            --glass-bg: rgba(255, 255, 255, 0.95);
            --shadow-sm: 0 5px 15px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        body {
            background-color: #eef1f5;
            background-image: 
                radial-gradient(at 0% 0%, rgba(108, 92, 231, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(0, 184, 148, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(9, 132, 227, 0.05) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(253, 203, 110, 0.05) 0px, transparent 50%);
            background-attachment: fixed;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark-color);
            overflow-x: hidden;
            padding-top: 80px; /* Offset for fixed navbar */
        }

        /* Navbar Styling */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            height: 80px;
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.4rem;
            color: var(--dark-color) !important;
            display: flex;
            align-items: center;
        }

        /* Top Navigation Links */
        .nav-link {
            color: #636e72 !important;
            padding: 10px 18px !important;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 50px;
            margin: 0 4px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
        }

        .nav-link i {
            margin-right: 8px;
            font-size: 1.1em;
            transition: transform 0.3s;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            background: rgba(108, 92, 231, 0.08);
            transform: translateY(-2px);
        }
        
        .nav-link.active {
            background: var(--primary-color);
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(108, 92, 231, 0.3);
        }
        
        /* Dropdown Menu */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border-radius: 16px;
            padding: 10px;
        }
        
        .dropdown-item {
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 500;
        }
        .dropdown-item:hover {
            background: rgba(108, 92, 231, 0.05);
            color: var(--primary-color);
        }

        /* Main Content */
        .main-content {
            padding: 2rem 0;
            min-height: calc(100vh - 80px);
        }
        
        /* Card Styles */
        .card {
            border: none;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }
        
        /* Background Pattern */
        .background-pattern-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            opacity: 0.1;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 0;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.2); }
        
        /* Animations */
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-slide { animation: fadeIn 0.6s ease-out forwards; }
        .animate-up { animation: fadeIn 0.8s ease-out forwards; opacity: 0; }
    </style>
</head>
<body>
    <div id="app">
        <!-- Top Navigation Bar -->
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container px-4">
                <!-- Brand -->
                <a class="navbar-brand me-5" href="{{ url('/') }}">
                    <div class="rounded-3 bg-primary text-white p-2 me-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    Ali Academy
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Center Navigation Links -->
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        @auth
                            @if(Auth::user()->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-home"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}" href="{{ route('admin.students.index') }}">
                                        <i class="fas fa-user-graduate"></i> Students
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}" href="{{ route('admin.teachers.index') }}">
                                        <i class="fas fa-chalkboard-teacher"></i> Teachers
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}">
                                        <i class="fas fa-book"></i> Courses
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.tasks.*') || request()->routeIs('admin.leaves.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-layer-group"></i> Requests
                                    </a>
                                    <ul class="dropdown-menu shadow-lg border-0 animate-slide">
                                        <li><a class="dropdown-item" href="{{ route('admin.tasks.index') }}"><i class="fas fa-tasks me-2 text-primary"></i> Student Tasks</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.leaves.index') }}"><i class="fas fa-envelope-open-text me-2 text-success"></i> Leave Requests</a></li>
                                    </ul>
                                </li>

                            @elseif(Auth::user()->isTeacher())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}" href="{{ route('teacher.dashboard') }}">
                                        <i class="fas fa-chart-pie"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('teacher.courses.*') ? 'active' : '' }}" href="{{ route('teacher.courses.create') }}">
                                        <i class="fas fa-plus-circle"></i> Create Class
                                    </a>
                                </li>

                            @elseif(Auth::user()->isStudent())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">
                                        <i class="fas fa-home"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('student.tasks.*') ? 'active' : '' }}" href="{{ route('student.tasks.index') }}">
                                        <i class="fas fa-clipboard-list"></i> Assignments
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('student.leaves.*') ? 'active' : '' }}" href="{{ route('student.leaves.index') }}">
                                        <i class="fas fa-calendar-minus"></i> My Leaves
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        @endauth
                    </ul>

                    <!-- User Profile (Right) -->
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                        @auth
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-dark fw-bold bg-white border shadow-sm rounded-pill px-3 py-2" href="#" role="button" data-bs-toggle="dropdown">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-light text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                            <i class="fas fa-user mb-0"></i>
                                        </div>
                                        <div>
                                            <span class="d-none d-md-block">{{ Auth::user()->name }}</span>
                                        </div>
                                    </div>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2 animate-slide" style="min-width: 200px;">
                                    <div class="px-3 py-2 border-bottom mb-2">
                                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                                        <div class="small text-muted text-uppercase" style="font-size: 0.7rem;">{{ Auth::user()->role }}</div>
                                    </div>
                                    
                                    @if(Auth::user()->isStudent())
                                    <a class="dropdown-item rounded-3 py-2" href="{{ route('student.profile') }}">
                                        <i class="fas fa-user-circle me-2 text-primary"></i> My Profile
                                    </a>
                                    @endif
                                    
                                    <a class="dropdown-item rounded-3 py-2 text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container px-4">
            <main class="main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2 fs-5"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle me-2 fs-5"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    @stack('scripts')
</body>
</html>