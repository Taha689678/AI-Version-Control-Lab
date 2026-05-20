@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Hero Section -->
    <div class="row mb-4 animate-slide">
        <div class="col-12">
            <div class="card bg-gradient-info text-white border-0 shadow-lg overflow-hidden position-relative p-0 rounded-4">
                <div class="background-pattern-overlay"></div>
                <div class="card-body p-4 p-lg-5 position-relative z-1">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <h2 class="fw-bold mb-1 display-6">Learning Dashboard</h2>
                            <p class="mb-0 opacity-75 lead">Track your progress and access your course materials.</p>
                        </div>
                        <div class="text-end d-none d-md-block">
                            <div class="glass-badge py-2 px-4 rounded-pill">
                                <i class="far fa-clock me-2"></i> {{ now()->format('l, d F Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row g-4 mb-5">
        <!-- Active Courses -->
        <div class="col-xl-4 col-md-6 animate-up" style="animation-delay: 0.1s;">
            <div class="stat-card card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-book-reader fa-lg"></i>
                        </div>
                        <span class="badge bg-soft-primary text-primary rounded-pill small fw-bold">Enrolled</span>
                    </div>
                    <div class="mb-1">
                        <h2 class="fw-bold text-dark display-5 mb-0">{{ $stats['enrollments'] }}</h2>
                        <span class="text-muted small text-uppercase fw-bold ls-1">My Courses</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Assignments -->
        <div class="col-xl-4 col-md-6 animate-up" style="animation-delay: 0.2s;">
            <div class="stat-card card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-clipboard-list fa-lg"></i>
                        </div>
                        <span class="badge bg-soft-warning text-warning rounded-pill small fw-bold">Due Soon</span>
                    </div>
                    <div class="mb-1">
                        <h2 class="fw-bold text-dark display-5 mb-0">{{ $stats['tasks'] }}</h2>
                        <span class="text-muted small text-uppercase fw-bold ls-1">Assignments</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leave Requests -->
        <div class="col-xl-4 col-md-6 animate-up" style="animation-delay: 0.3s;">
            <div class="stat-card card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stat-icon bg-info bg-opacity-10 text-info rounded-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-envelope-open-text fa-lg"></i>
                        </div>
                        <span class="badge bg-soft-info text-info rounded-pill small fw-bold">Status</span>
                    </div>
                    <div class="mb-1">
                        <h2 class="fw-bold text-dark display-5 mb-0">{{ $stats['leaves'] }}</h2>
                        <span class="text-muted small text-uppercase fw-bold ls-1">Leave Requests</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-5 animate-up" style="animation-delay: 0.4s;">
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
                            <a href="{{ route('student.tasks.index') }}" class="quick-action-card d-block p-4 rounded-4 text-decoration-none border transition-all h-100 bg-light hover-shadow">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <div class="mb-3 p-3 rounded-circle bg-white text-warning shadow-sm">
                                        <i class="fas fa-tasks fa-lg"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">View Assignments</h6>
                                    <span class="text-muted small">Check pending work</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('student.leaves.create') }}" class="quick-action-card d-block p-4 rounded-4 text-decoration-none border transition-all h-100 bg-light hover-shadow">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <div class="mb-3 p-3 rounded-circle bg-white text-info shadow-sm">
                                        <i class="fas fa-paper-plane fa-lg"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">Request Leave</h6>
                                    <span class="text-muted small">Apply for time off</span>
                                </div>
                            </a>
                        </div>
                         <div class="col-md-3">
                            <a href="{{ route('student.profile') }}" class="quick-action-card d-block p-4 rounded-4 text-decoration-none border transition-all h-100 bg-light hover-shadow">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <div class="mb-3 p-3 rounded-circle bg-white text-primary shadow-sm">
                                        <i class="fas fa-user-circle fa-lg"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">My Profile</h6>
                                    <span class="text-muted small">Update your details</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content: Course Grid -->
    <div class="row g-4 animate-up" style="animation-delay: 0.5s;">
        <div class="col-12 d-flex justify-content-between align-items-end mb-2">
            <div>
                 <h4 class="fw-bold text-dark mb-1">My Courses</h4>
                 <p class="text-muted small mb-0">Classes you are enrolled in</p>
            </div>
            <a href="#" class="text-decoration-none small fw-bold"></a>
        </div>

        @if($enrollments->isEmpty())
             <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 text-center p-5">
                    <div class="card-body">
                        <div class="mb-4 text-muted opacity-25">
                            <i class="fas fa-book-open fa-4x"></i>
                        </div>
                        <h4 class="fw-bold text-dark">No Enrollments Found</h4>
                        <p class="text-muted mb-0">You are not enrolled in any courses yet.</p>
                    </div>
                </div>
            </div>
        @else
            @foreach($enrollments as $index => $enrollment)
            @php
                $total = $enrollment->attendances->count();
                $present = $enrollment->attendances->where('status', 'present')->count();
                $percent = $total > 0 ? round(($present / $total) * 100) : 0;
            @endphp
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 shadow-sm border-0 rounded-4 course-card overflow-hidden">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-start">
                        <span class="badge bg-soft-primary text-primary fw-bold px-3 py-2 rounded-pill">
                            {{ $enrollment->course->course_code ?? 'CODE' }}
                        </span>
                        @if($percent > 0)
                        <span class="badge {{ $percent >= 75 ? 'bg-soft-success text-success' : 'bg-soft-warning text-warning' }} rounded-pill small fw-bold">
                            {{ $percent }}% Att.
                        </span>
                        @endif
                    </div>
                    
                    <div class="card-body px-4 pt-2">
                        <h5 class="card-title fw-bold text-dark mt-2 mb-3 text-truncate" title="{{ $enrollment->course->name }}">
                            {{ $enrollment->course->name }}
                        </h5>
                        <p class="card-text text-muted small mb-4 line-clamp-3" style="min-height: 48px;">
                            {{ Str::limit($enrollment->course->description, 80) }}
                        </p>
                        
                        <div class="d-flex align-items-center mb-3">
                             <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-2 overflow-hidden border" style="width: 32px; height: 32px;">
                                <i class="fas fa-chalkboard-teacher text-secondary small"></i>
                            </div>
                            <small class="text-dark fw-bold">{{ $enrollment->course->teacher->user->name }}</small>
                        </div>
                    </div>

                    <div class="card-footer bg-light border-0 px-4 py-3">
                        <a href="{{ route('student.courses.show', $enrollment->course->id) }}" class="btn btn-outline-primary w-100 fw-bold shadow-sm rounded-3 py-2 border-0 bg-white text-primary hover-primary-bg transition-all">
                            View Classroom <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>

<style>
    .bg-gradient-info { background: linear-gradient(135deg, #0984e3 0%, #74b9ff 100%); }
    .stat-icon { width: 48px; height: 48px; }
    .ls-1 { letter-spacing: 1px; }
    .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .course-card { transition: transform 0.3s, box-shadow 0.3s; }
    .course-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
    .bg-soft-primary { background-color: rgba(108, 92, 231, 0.1); color: #6c5ce7 !important; }
    .bg-soft-success { background-color: rgba(0, 184, 148, 0.1); color: #00b894 !important; }
    .bg-soft-warning { background-color: rgba(253, 203, 110, 0.1); color: #fdcb6e !important; }
    .bg-soft-info { background-color: rgba(9, 132, 227, 0.1); color: #0984e3 !important; }
    .hover-primary-bg:hover { background-color: #6c5ce7 !important; color: white !important; }
    .glass-badge { background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); }
</style>
@endsection