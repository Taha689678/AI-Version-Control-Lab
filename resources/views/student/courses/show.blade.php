@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}" class="text-decoration-none fw-bold text-primary">Dashboard</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">{{ $course->course_code }}</li>
        </ol>
    </nav>

    <!-- Header Card -->
    <div class="card shadow-lg border-0 rounded-4 mb-5 overflow-hidden position-relative">
        <div class="card-body p-5 bg-white position-relative z-1">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-primary-soft text-primary fw-bold px-3 py-2 rounded-pill mb-3">
                        <i class="fas fa-layer-group me-2"></i> {{ $course->course_code }}
                    </span>
                    <h2 class="fw-bold text-dark mb-2 display-6">{{ $course->name }}</h2> 
                    <p class="text-muted mb-4 lead">
                        <i class="fas fa-chalkboard-teacher me-2 text-primary"></i> 
                        Instructor: <span class="fw-bold text-dark">{{ $course->teacher->user->name }}</span>
                    </p>
                    <p class="text-secondary mb-0" style="max-width: 650px; line-height: 1.7;">{{ $course->description }}</p>
                </div>
                
                <div class="col-lg-4 mt-5 mt-lg-0 text-lg-end">
                    <div class="d-inline-block p-4 bg-light rounded-4 text-start border border-light shadow-sm position-relative overflow-hidden" style="min-width: 280px;">
                        <div class="d-flex justify-content-between align-items-end mb-2 position-relative z-1">
                            <span class="small fw-bold text-uppercase text-muted">Attendance</span>
                            <span class="h3 fw-bold {{ $attendancePercentage >= 75 ? 'text-success' : 'text-warning' }} mb-0">{{ $attendancePercentage }}%</span>
                        </div>
                        <div class="progress rounded-pill bg-white mb-3" style="height: 12px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);">
                            <div class="progress-bar rounded-pill {{ $attendancePercentage >= 75 ? 'bg-success' : 'bg-warning' }}" role="progressbar" 
                                 style="width: {{ $attendancePercentage }}%;" 
                                 aria-valuenow="{{ $attendancePercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between text-muted small position-relative z-1">
                            <span>Present: <b class="text-dark">{{ $enrollment->attendances->where('status', 'present')->count() }}</b></span>
                            <span>Total: <b class="text-dark">{{ $enrollment->attendances->count() }}</b></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Decorative Circle -->
        <div class="position-absolute top-0 end-0 bg-primary opacity-10 rounded-circle" style="width: 400px; height: 400px; transform: translate(30%, -40%); z-index: 0;"></div>
    </div>

    <!-- Main Content Tabs -->
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-white border-bottom border-light pt-4 px-4 pb-0">
            <ul class="nav nav-tabs nav-fill border-0" id="courseTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold position-relative pb-3" id="grades-tab" data-bs-toggle="tab" data-bs-target="#grades" type="button" role="tab">
                        <i class="fas fa-star me-2"></i> Performance & Grades
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold position-relative pb-3" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab">
                        <i class="fas fa-calendar-check me-2"></i> Attendance History
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4 bg-white rounded-bottom-4">
            <div class="tab-content" id="courseTabsContent">
                
                <!-- Grades Tab -->
                <div class="tab-pane fade show active" id="grades" role="tabpanel">
                    @if($enrollment->grades->isEmpty())
                        <div class="text-center py-5">
                            <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                                <i class="fas fa-book-open text-muted fa-2x"></i>
                            </div>
                            <h5 class="fw-bold text-dark">No Grades Yet</h5>
                            <p class="text-muted">Assignments and exam scores will appear here once published.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle custom-table">
                                <thead class="bg-light text-uppercase small text-muted">
                                    <tr>
                                        <th class="ps-4 border-0 rounded-start">Assessment Title</th>
                                        <th class="text-center border-0">Score Obtained</th>
                                        <th class="text-center border-0">Max Possible</th>
                                        <th class="text-center border-0">Performance</th>
                                        <th class="border-0 rounded-end">Teacher Feedback</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($enrollment->grades as $grade)
                                    @php
                                        $percentage = $grade->max_score > 0 ? ($grade->score / $grade->max_score) * 100 : 0;
                                        $color = $percentage >= 80 ? 'success' : ($percentage >= 50 ? 'warning' : 'danger');
                                        $icon = $percentage >= 80 ? 'check-circle' : ($percentage >= 50 ? 'minus-circle' : 'exclamation-circle');
                                    @endphp
                                    <tr class="border-bottom border-light">
                                        <td class="fw-bold ps-4 py-3 text-dark">{{ $grade->assessment_name }}</td>
                                        <td class="text-center py-3 fs-5 fw-bold text-dark">{{ $grade->score }}</td>
                                        <td class="text-center py-3 text-muted">{{ $grade->max_score }}</td>
                                        <td class="text-center py-3">
                                            <span class="badge bg-{{ $color }}-soft text-{{ $color }} rounded-pill px-3 py-2">
                                                <i class="fas fa-{{ $icon }} me-1"></i> {{ round($percentage) }}%
                                            </span>
                                        </td>
                                        <td class="py-3 text-secondary small fst-italic">
                                            @if($grade->feedback)
                                                "{{ $grade->feedback }}"
                                            @else
                                                <span class="text-muted opacity-50">No feedback provided</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Attendance Tab -->
                <div class="tab-pane fade" id="attendance" role="tabpanel">
                    @if($enrollment->attendances->isEmpty())
                         <div class="text-center py-5">
                            <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                                <i class="far fa-calendar text-muted fa-2x"></i>
                            </div>
                            <h5 class="fw-bold text-dark">No Attendance Records</h5>
                            <p class="text-muted">Attendance history will be tracked here.</p>
                        </div>
                    @else
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <div class="table-responsive rounded-4 border border-light">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light text-uppercase small text-muted">
                                            <tr>
                                                <th class="ps-4 border-0 py-3">Date</th>
                                                <th class="border-0 py-3">Day</th>
                                                <th class="text-end pe-4 border-0 py-3">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($enrollment->attendances as $attendance)
                                            <tr class="border-bottom border-light">
                                                <td class="ps-4 py-3 fw-bold text-dark">
                                                    <i class="far fa-calendar-alt text-primary me-2"></i>
                                                    {{ $attendance->date->format('M d, Y') }}
                                                </td>
                                                <td class="py-3 text-muted small">{{ $attendance->date->format('l') }}</td>
                                                <td class="text-end pe-4 py-3">
                                                    @if($attendance->status == 'present')
                                                        <span class="badge bg-success-soft text-success border border-success-subtle px-3 py-2 rounded-pill shadow-sm">
                                                            <i class="fas fa-check me-2"></i> Present
                                                        </span>
                                                    @elseif($attendance->status == 'absent')
                                                        <span class="badge bg-danger-soft text-danger border border-danger-subtle px-3 py-2 rounded-pill shadow-sm">
                                                            <i class="fas fa-times me-2"></i> Absent
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning-soft text-warning border border-warning-subtle px-3 py-2 rounded-pill shadow-sm">
                                                            <i class="fas fa-clock me-2"></i> {{ ucfirst($attendance->status) }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Soft Badges */
    .bg-success-soft { background-color: rgba(0, 184, 148, 0.1); color: #00b894 !important; }
    .bg-danger-soft { background-color: rgba(255, 118, 117, 0.1); color: #d63031 !important; }
    .bg-warning-soft { background-color: rgba(253, 203, 110, 0.1); color: #fdcb6e !important; }
    .bg-primary-soft { background-color: rgba(108, 92, 231, 0.1); color: #6c5ce7 !important; }

    /* Tabs Styling */
    .nav-tabs .nav-link {
        color: #6c757d;
        border: none;
        background: transparent;
        transition: color 0.3s;
    }
    .nav-tabs .nav-link:hover {
        color: #6c5ce7;
    }
    .nav-tabs .nav-link.active {
        color: #6c5ce7;
        background: transparent;
    }
    .nav-tabs .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 3px;
        background-color: #6c5ce7;
        border-radius: 3px 3px 0 0;
    }
    
    /* Hover Effects */
    .custom-table tr:hover {
        background-color: rgba(108, 92, 231, 0.02);
    }
</style>
@endsection