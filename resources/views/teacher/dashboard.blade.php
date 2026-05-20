@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Hero Section -->
    <div class="row mb-4 animate-slide">
        <div class="col-12">
            <div class="card bg-gradient-success text-white border-0 shadow-lg overflow-hidden position-relative p-0 rounded-4">
                <div class="background-pattern-overlay"></div>
                <div class="card-body p-4 p-lg-5 position-relative z-1">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <h2 class="fw-bold mb-1 display-6">Instructor Dashboard</h2>
                            <p class="mb-0 opacity-75 lead">Manage your classes, students, and tasks from one place.</p>
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
        <!-- Active Classes -->
        <div class="col-xl-4 col-md-6 animate-up" style="animation-delay: 0.1s;">
            <div class="stat-card card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-chalkboard fa-lg"></i>
                        </div>
                        <span class="badge bg-soft-primary text-primary rounded-pill small fw-bold">Active</span>
                    </div>
                    <div class="mb-1">
                        <h2 class="fw-bold text-dark display-5 mb-0">{{ $stats['courses'] }}</h2>
                        <span class="text-muted small text-uppercase fw-bold ls-1">Active Classes</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Students -->
        <div class="col-xl-4 col-md-6 animate-up" style="animation-delay: 0.2s;">
            <div class="stat-card card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stat-icon bg-success bg-opacity-10 text-success rounded-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-user-graduate fa-lg"></i>
                        </div>
                        <span class="badge bg-soft-success text-success rounded-pill small fw-bold">Overall</span>
                    </div>
                    <div class="mb-1">
                        <h2 class="fw-bold text-dark display-5 mb-0">{{ $stats['students'] }}</h2>
                        <span class="text-muted small text-uppercase fw-bold ls-1">Total Students</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Tasks -->
        <div class="col-xl-4 col-md-6 animate-up" style="animation-delay: 0.3s;">
            <div class="stat-card card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-tasks fa-lg"></i>
                        </div>
                        <span class="badge bg-soft-warning text-warning rounded-pill small fw-bold">Pending</span>
                    </div>
                    <div class="mb-1">
                        <h2 class="fw-bold text-dark display-5 mb-0">{{ $stats['tasks'] }}</h2>
                        <span class="text-muted small text-uppercase fw-bold ls-1">Upcoming Tasks</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions (Simplified for Teacher) -->
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
                            <a href="{{ route('teacher.courses.create') }}" class="quick-action-card d-block p-4 rounded-4 text-decoration-none border transition-all h-100 bg-light hover-shadow">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <div class="mb-3 p-3 rounded-circle bg-white text-primary shadow-sm">
                                        <i class="fas fa-plus fa-lg"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">Create Class</h6>
                                    <span class="text-muted small">Start new course</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
             </div>
        </div>
    </div>

    <!-- Main Content: My Classes -->
    <div class="row g-4 animate-up" style="animation-delay: 0.5s;">
        <div class="col-12 d-flex justify-content-between align-items-end mb-2">
            <div>
                 <h4 class="fw-bold text-dark mb-1">My Classes</h4>
                 <p class="text-muted small mb-0">Courses you are currently managing</p>
            </div>
            <a href="#" class="text-decoration-none small fw-bold"></a>
        </div>
        
        @if($courses->isEmpty())
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 text-center p-5">
                    <div class="card-body">
                        <div class="mb-4 text-muted opacity-25">
                            <i class="fas fa-chalkboard fa-4x"></i>
                        </div>
                        <h4 class="fw-bold text-dark">No Classes Found</h4>
                        <p class="text-muted mb-4">You haven't created any classes yet.</p>
                        <a href="{{ route('teacher.courses.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold">
                            Create Your First Class
                        </a>
                    </div>
                </div>
            </div>
        @else
            @foreach($courses as $course)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 shadow-sm border-0 rounded-4 course-card overflow-hidden">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-start">
                        <span class="badge bg-soft-primary text-primary fw-bold px-3 py-2 rounded-pill">
                            {{ $course->course_code }}
                        </span>
                        <div class="dropdown">
                            <button class="btn btn-icon btn-light rounded-circle btn-sm" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v text-muted"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3">
                                <li><a class="dropdown-item py-2" href="{{ route('teacher.courses.edit', $course->id) }}"><i class="fas fa-edit me-2 text-info"></i> Edit Details</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Delete this class?');">
                                        @csrf @method('DELETE')
                                        <button class="dropdown-item text-danger py-2"><i class="fas fa-trash me-2"></i> Delete Class</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body px-4 pt-2">
                        <h5 class="card-title fw-bold text-dark mb-2 text-truncate">{{ $course->name }}</h5>
                        <p class="text-muted small mb-4 line-clamp-2">{{ Str::limit($course->description, 60) }}</p>
                        
                        <div class="d-flex align-items-center mb-0">
                            <div class="avatar-group me-2">
                                <!-- Placeholder avatars if we had student images -->
                                <div class="avatar avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center border border-white" style="width: 32px; height: 32px; font-size: 12px;">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="small text-muted"><b>{{ $course->enrollments_count }}</b> Students Enrolled</div>
                        </div>
                    </div>
                    <div class="card-footer bg-light border-0 px-4 py-3">
                        <a href="{{ route('teacher.courses.show', $course->id) }}" class="btn btn-primary w-100 fw-bold shadow-sm rounded-3 py-2">
                            Manage Class <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>

<style>
    .bg-gradient-success { background: linear-gradient(135deg, #00b894 0%, #55efc4 100%); }
    .stat-icon { width: 48px; height: 48px; }
    .ls-1 { letter-spacing: 1px; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .course-card { transition: transform 0.3s, box-shadow 0.3s; }
    .course-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
    .btn-icon { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; }
    .bg-soft-primary { background-color: rgba(108, 92, 231, 0.1); color: #6c5ce7 !important; }
    .bg-soft-success { background-color: rgba(0, 184, 148, 0.1); color: #00b894 !important; }
    .bg-soft-warning { background-color: rgba(253, 203, 110, 0.1); color: #fdcb6e !important; }
    .glass-badge { background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); }
</style>
@endsection