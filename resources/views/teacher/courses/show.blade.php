@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}" class="text-decoration-none fw-bold text-primary">Dashboard</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">{{ $course->course_code }}</li>
        </ol>
    </nav>

    <!-- Header Card -->
    <div class="card shadow-lg border-0 rounded-4 mb-5 overflow-hidden position-relative">
        <div class="card-body p-5 bg-white position-relative z-1">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <span class="badge bg-primary-soft text-primary fw-bold px-3 py-2 rounded-pill mb-3">
                        <i class="fas fa-layer-group me-2"></i> {{ $course->course_code ?? 'CLASS' }}
                    </span>
                    <h2 class="fw-bold text-dark mb-2 display-6">{{ $course->name }}</h2>
                    <p class="text-muted mb-0 lead" style="max-width: 700px;">{{ $course->description }}</p>
                </div>
                <div class="col-md-4 text-md-end mt-4 mt-md-0">
                    <div class="d-inline-block p-4 bg-light rounded-4 text-center border border-light shadow-sm">
                        <i class="fas fa-users text-primary mb-2 display-6"></i>
                        <h3 class="fw-bold text-dark mb-0">{{ $course->enrollments->count() }}</h3>
                        <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Students Enrolled</small>
                    </div>
                </div>
            </div>
        </div>
        <!-- Decorative Background Circle -->
        <div class="position-absolute top-0 end-0 bg-primary opacity-10 rounded-circle" style="width: 300px; height: 300px; transform: translate(30%, -30%); z-index: 0;"></div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4 rounded-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-3 fs-4"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4 rounded-3" role="alert">
            <ul class="mb-0 small list-unstyled">
                @foreach($errors->all() as $error) 
                    <li><i class="fas fa-exclamation-circle me-2"></i> {{ $error }}</li> 
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content Tabs -->
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-white border-bottom border-light pt-4 px-4 pb-0">
            <ul class="nav nav-tabs nav-fill border-0" id="courseTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold position-relative pb-3" id="students-tab" data-bs-toggle="tab" data-bs-target="#students" type="button" role="tab">
                        <i class="fas fa-users me-2"></i> Class List
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold position-relative pb-3" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab">
                        <i class="fas fa-clipboard-check me-2"></i> Take Attendance
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold position-relative pb-3" id="grades-tab" data-bs-toggle="tab" data-bs-target="#grades" type="button" role="tab">
                        <i class="fas fa-star-half-alt me-2"></i> Enter Grades
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4 bg-white rounded-bottom-4">
            <div class="tab-content" id="courseTabContent">
                
                <!-- Students Tab -->
                <div class="tab-pane fade show active" id="students" role="tabpanel">
                    @if($course->enrollments->isEmpty())
                        <div class="text-center py-5">
                            <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                                <i class="fas fa-user-slash text-muted fa-2x"></i>
                            </div>
                            <h5 class="fw-bold text-dark">No Students Enrolled</h5>
                            <p class="text-muted">Wait for administrators to enroll students in this course.</p>
                        </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle custom-table">
                            <thead class="bg-light text-uppercase small text-muted">
                                <tr>
                                    <th class="ps-4 border-0 rounded-start">Student Name</th>
                                    <th class="border-0">Email Contact</th>
                                    <th class="border-0">Enrolled Date</th>
                                    <th class="text-center border-0 rounded-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($course->enrollments as $enrollment)
                                <tr class="border-bottom border-light">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <span class="fw-bold">{{ substr($enrollment->user->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $enrollment->user->name }}</div>
                                                <small class="text-muted" style="font-size: 0.75rem;">ID: #{{ $enrollment->student->registration_no ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ $enrollment->user->email }}</td>
                                    <td class="text-muted small">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $enrollment->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="text-center"><span class="badge bg-success-soft text-success px-3 py-1 rounded-pill small fw-bold">Active</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>

                <!-- Attendance Tab -->
                <div class="tab-pane fade" id="attendance" role="tabpanel">
                    @if($course->enrollments->isEmpty())
                        <div class="alert alert-warning border-0 shadow-sm rounded-3 mt-3">
                            <i class="fas fa-exclamation-triangle me-2"></i> 
                            Cannot take attendance because no students are enrolled.
                        </div>
                    @else
                    <form action="{{ route('teacher.courses.attendance', $course->id) }}" method="POST">
                        @csrf
                        
                        <div class="row mb-5 justify-content-center">
                            <div class="col-md-5">
                                <label class="form-label fw-bold text-dark small text-uppercase">Select Attendance Date</label>
                                <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-calendar-alt text-primary"></i></span>
                                    <input type="date" name="date" class="form-control border-start-0 ps-0" value="{{ date('Y-m-d') }}" required style="height: 50px;">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive rounded-4 border border-light mb-4">
                            <table class="table align-middle mb-0">
                                <thead class="bg-light text-uppercase small text-muted">
                                    <tr>
                                        <th class="ps-4 py-3 border-0">Student</th>
                                        <th class="py-3 border-0">Mark Attendance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($course->enrollments as $enrollment)
                                    <tr class="border-bottom border-light">
                                        <td class="ps-4 py-3 fw-bold text-dark">{{ $enrollment->user->name }}</td>
                                        <td class="py-3">
                                            <div class="btn-group w-auto shadow-sm" role="group" aria-label="Attendance for {{ $enrollment->user->name }}">
                                                <input type="radio" class="btn-check" name="attendances[{{ $enrollment->id }}]" id="present_{{ $enrollment->id }}" value="present" checked>
                                                <label class="btn btn-outline-success px-4" for="present_{{ $enrollment->id }}">Present</label>

                                                <input type="radio" class="btn-check" name="attendances[{{ $enrollment->id }}]" id="absent_{{ $enrollment->id }}" value="absent">
                                                <label class="btn btn-outline-danger px-4" for="absent_{{ $enrollment->id }}">Absent</label>

                                                <input type="radio" class="btn-check" name="attendances[{{ $enrollment->id }}]" id="late_{{ $enrollment->id }}" value="late">
                                                <label class="btn btn-outline-warning px-4" for="late_{{ $enrollment->id }}">Late</label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-lg shadow-lg hover-lift px-5 rounded-pill">
                                <i class="fas fa-save me-2"></i> Save Record
                            </button>
                        </div>
                    </form>
                    @endif
                </div>

                <!-- Grades Tab -->
                <div class="tab-pane fade" id="grades" role="tabpanel">
                    @if($course->enrollments->isEmpty())
                        <div class="alert alert-warning border-0 shadow-sm rounded-3 mt-3">
                            <i class="fas fa-exclamation-triangle me-2"></i> 
                            Cannot enter grades because no students are enrolled.
                        </div>
                    @else
                    <form action="{{ route('teacher.courses.grades', $course->id) }}" method="POST">
                        @csrf
                        
                        <div class="card bg-light border-0 mb-4 p-4 rounded-4">
                            <h6 class="text-uppercase text-dark fw-bold small mb-3"><i class="fas fa-pen-fancy me-2"></i> New Assessment</h6>
                            <div class="row g-3">
                                <div class="col-md-9">
                                    <div class="form-floating">
                                        <input type="text" name="assessment_name" id="assessmentName" class="form-control border-0 shadow-sm" placeholder="Assessment Name" required>
                                        <label for="assessmentName">Assessment Title (e.g. Midterm Exam)</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="number" name="max_score" id="maxScore" class="form-control border-0 shadow-sm" value="100" required>
                                        <label for="maxScore">Max Score</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive rounded-4 border border-light mb-4">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-uppercase small text-muted">
                                    <tr>
                                        <th class="ps-4 py-3 border-0">Student</th>
                                        <th class="py-3 border-0" style="width: 250px;">Score Obtained</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($course->enrollments as $enrollment)
                                    <tr class="border-bottom border-light">
                                        <td class="ps-4 py-3 fw-bold text-dark">{{ $enrollment->user->name }}</td>
                                        <td class="py-3">
                                            <div class="input-group">
                                                <input type="number" name="grades[{{ $enrollment->id }}]" class="form-control" min="0" step="0.5" placeholder="0">
                                                <span class="input-group-text bg-white text-muted">/ <span class="max-score-display">100</span></span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success btn-lg shadow-lg hover-lift px-5 rounded-pill">
                                <i class="fas fa-check-circle me-2"></i> Publish Grades
                            </button>
                        </div>
                    </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    // Simple script to update the max score display in the table when the input changes
    document.getElementById('maxScore')?.addEventListener('input', function(e) {
        let val = e.target.value;
        document.querySelectorAll('.max-score-display').forEach(el => el.textContent = val);
    });
</script>

<style>
    /* Styling Tabs */
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

    /* Soft Badge */
    .bg-primary-soft { background-color: rgba(108, 92, 231, 0.1); color: #6c5ce7 !important; }
    .bg-success-soft { background-color: rgba(0, 184, 148, 0.1); color: #00b894 !important; }

    /* Button Lift */
    .hover-lift { transition: transform 0.2s; }
    .hover-lift:hover { transform: translateY(-3px); }
</style>
@endsection