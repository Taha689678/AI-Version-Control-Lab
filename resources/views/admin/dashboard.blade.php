@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Hero Section -->
    <div class="row mb-4 animate-slide">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white border-0 shadow-lg overflow-hidden position-relative p-0 rounded-4">
                <div class="background-pattern-overlay"></div>
                <div class="card-body p-4 p-lg-5 position-relative z-1">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <h2 class="fw-bold mb-1 display-6">Admin Dashboard</h2>
                            <p class="mb-0 opacity-75 lead">Overview of your academy's performance and quick management stats.</p>
                        </div>
                        <div class="text-end d-none d-md-block">
                            <div class="glass-badge py-2 px-4 rounded-pill">
                                <i class="far fa-calendar-alt me-2"></i> {{ now()->format('l, d F Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row g-4 mb-5">
        <!-- Students Card -->
        <div class="col-xl-3 col-md-6 animate-up" style="animation-delay: 0.1s;">
            <div class="stat-card card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-user-graduate fa-lg"></i>
                        </div>
                        <span class="badge bg-soft-primary text-primary rounded-pill small fw-bold">Active</span>
                    </div>
                    <div class="mb-1">
                        <h2 class="fw-bold text-dark display-5 mb-0">{{ $stats['students'] }}</h2>
                        <span class="text-muted small text-uppercase fw-bold ls-1">Total Students</span>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">
                    <a href="{{ route('admin.students.index') }}" class="btn btn-outline-light text-primary w-100 fw-bold border-0 bg-primary bg-opacity-10 hover-primary-bg transition-all">
                        Manage Students <i class="fas fa-arrow-right ms-2 small"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Teachers Card -->
        <div class="col-xl-3 col-md-6 animate-up" style="animation-delay: 0.2s;">
            <div class="stat-card card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stat-icon bg-success bg-opacity-10 text-success rounded-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-chalkboard-teacher fa-lg"></i>
                        </div>
                        <span class="badge bg-soft-success text-success rounded-pill small fw-bold">Faculty</span>
                    </div>
                    <div class="mb-1">
                        <h2 class="fw-bold text-dark display-5 mb-0">{{ $stats['teachers'] }}</h2>
                        <span class="text-muted small text-uppercase fw-bold ls-1">Total Teachers</span>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-light text-success w-100 fw-bold border-0 bg-success bg-opacity-10 hover-success-bg transition-all">
                        Manage Faculty <i class="fas fa-arrow-right ms-2 small"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Courses Card -->
        <div class="col-xl-3 col-md-6 animate-up" style="animation-delay: 0.3s;">
            <div class="stat-card card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-book-open fa-lg"></i>
                        </div>
                        <span class="badge bg-soft-warning text-warning rounded-pill small fw-bold">Ongoing</span>
                    </div>
                    <div class="mb-1">
                        <h2 class="fw-bold text-dark display-5 mb-0">{{ $stats['courses'] }}</h2>
                        <span class="text-muted small text-uppercase fw-bold ls-1">Active Courses</span>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-light text-warning w-100 fw-bold border-0 bg-warning bg-opacity-10 hover-warning-bg transition-all">
                        View Courses <i class="fas fa-arrow-right ms-2 small"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Tasks Card -->
        <div class="col-xl-3 col-md-6 animate-up" style="animation-delay: 0.4s;">
            <div class="stat-card card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stat-icon bg-info bg-opacity-10 text-info rounded-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-tasks fa-lg"></i>
                        </div>
                        <span class="badge bg-soft-info text-info rounded-pill small fw-bold">Assignment</span>
                    </div>
                    <div class="mb-1">
                        <h2 class="fw-bold text-dark display-5 mb-0">{{ \App\Models\Task::count() }}</h2>
                        <span class="text-muted small text-uppercase fw-bold ls-1">Total Tasks</span>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">
                    <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-light text-info w-100 fw-bold border-0 bg-info bg-opacity-10 hover-info-bg transition-all">
                        Check Tasks <i class="fas fa-arrow-right ms-2 small"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions Section -->
    <div class="row animate-up" style="animation-delay: 0.5s;">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-bolt text-warning me-2"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('admin.students.create') }}" class="quick-action-card d-block p-4 rounded-4 text-decoration-none border transition-all h-100 bg-light hover-shadow">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <div class="mb-3 p-3 rounded-circle bg-white text-primary shadow-sm">
                                        <i class="fas fa-user-plus fa-lg"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">Add Student</h6>
                                    <span class="text-muted small">Register a new student</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.teachers.create') }}" class="quick-action-card d-block p-4 rounded-4 text-decoration-none border transition-all h-100 bg-light hover-shadow">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <div class="mb-3 p-3 rounded-circle bg-white text-success shadow-sm">
                                        <i class="fas fa-chalkboard-teacher fa-lg"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">Add Faculty</h6>
                                    <span class="text-muted small">Onboard new teacher</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.courses.create') }}" class="quick-action-card d-block p-4 rounded-4 text-decoration-none border transition-all h-100 bg-light hover-shadow">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <div class="mb-3 p-3 rounded-circle bg-white text-warning shadow-sm">
                                        <i class="fas fa-book fa-lg"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">Create Course</h6>
                                    <span class="text-muted small">Add a new subject</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.tasks.create') }}" class="quick-action-card d-block p-4 rounded-4 text-decoration-none border transition-all h-100 bg-light hover-shadow">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <div class="mb-3 p-3 rounded-circle bg-white text-info shadow-sm">
                                        <i class="fas fa-clipboard-check fa-lg"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">Assign Task</h6>
                                    <span class="text-muted small">Create new assignment</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary { background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%); }
    .stat-item { padding: 10px; border-radius: 10px; background: rgba(0,0,0,0.03); }
    .stat-icon { width: 48px; height: 48px; }
    .ls-1 { letter-spacing: 1px; }
    .hover-shadow:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; background: white !important; border-color: transparent !important; }
    .bg-soft-primary { background-color: rgba(108, 92, 231, 0.1); color: #6c5ce7; }
    .bg-soft-success { background-color: rgba(0, 184, 148, 0.1); color: #00b894; }
    .bg-soft-warning { background-color: rgba(253, 203, 110, 0.1); color: #fdcb6e; }
    .bg-soft-info { background-color: rgba(9, 132, 227, 0.1); color: #0984e3; }
    .glass-badge { background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); }
</style>
@endsection