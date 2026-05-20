@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h3 class="fw-bold text-dark mb-1">My Assignments</h3>
            <p class="text-muted mb-0">Track and manage your assigned tasks.</p>
        </div>
        <div class="text-end">
            <span class="badge bg-white text-primary shadow-sm p-3 rounded-pill fs-6 border border-light">
                <i class="fas fa-tasks me-2"></i> {{ $tasks->count() }} Tasks
            </span>
        </div>
    </div>

    @if($tasks->isEmpty())
        <div class="row justify-content-center mt-5 animate-up">
            <div class="col-md-6 text-center bg-white p-5 rounded-4 shadow-sm border border-light">
                <div class="mb-4 text-warning opacity-25">
                    <i class="fas fa-clipboard-check fa-5x"></i>
                </div>
                <h4 class="fw-bold text-dark">No Pending Tasks</h4>
                <p class="text-muted mb-3">You are all caught up! No tasks have been assigned to you.</p>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($tasks as $index => $task)
            <div class="col-md-6 col-lg-4 animate-up" style="animation-delay: {{ 0.1 * ($index + 1) }}s;">
                <div class="card h-100 border-0 shadow-hover rounded-4 overflow-hidden task-card">
                    <div class="card-body p-4 position-relative">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-square bg-primary-soft text-primary rounded-3 p-3">
                                <i class="fas fa-clipboard-list fa-lg"></i>
                            </div>
                            @if($task->status == 'completed')
                                <span class="badge bg-success-soft text-success rounded-pill px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i> Completed
                                </span>
                            @else
                                <span class="badge bg-warning-soft text-warning rounded-pill px-3 py-2">
                                    <i class="fas fa-clock me-1"></i> Pending
                                </span>
                            @endif
                        </div>

                        <h5 class="fw-bold text-dark mb-2">{{ $task->title }}</h5>
                        <p class="text-muted small mb-4" style="line-height: 1.6;">
                            {{ $task->description }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top border-light mt-auto">
                            <small class="text-muted fw-bold">
                                <i class="far fa-calendar-alt me-1"></i> {{ $task->created_at->format('M d, Y') }}
                            </small>
                            <!-- Placeholder for future action -->
                            <button class="btn btn-sm btn-light text-muted rounded-pill px-3" disabled>
                                View Details
                            </button>
                        </div>
                    </div>
                    <div class="progress h-1 rounded-0 bg-light">
                        <div class="progress-bar {{ $task->status == 'completed' ? 'bg-success' : 'bg-warning' }}" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .animate-up {
        animation: fadeInUp 0.5s ease-out forwards;
        opacity: 0;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .task-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05) !important;
    }
    .shadow-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important;
    }
    .bg-primary-soft { background-color: rgba(108, 92, 231, 0.1); color: #6c5ce7; }
    .bg-success-soft { background-color: rgba(0, 184, 148, 0.1); color: #00b894; }
    .bg-warning-soft { background-color: rgba(253, 203, 110, 0.1); color: #fdcb6e; }
    .h-1 { height: 4px; }
</style>
@endsection
