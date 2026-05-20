@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-5 animate-slide">
        <div>
            <h3 class="fw-bold text-dark mb-1">Manage <span class="text-primary-gradient">Leave Requests</span></h3>
            <p class="text-muted mb-0">Review and approve student leaves</p>
        </div>
        <div class="text-end">
            <span class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill border">
                <i class="fas fa-envelope-open-text me-2 text-primary"></i> Total: {{ $leaves->count() }}
            </span>
        </div>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="border-bottom border-light">
                            <th class="ps-4 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Student</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Reason</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dates</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaves as $leave)
                        <tr class="border-bottom border-light">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-info-soft rounded-circle text-info d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 40px; height: 40px;">
                                        {{ substr($leave->student->user->name, 0, 1) }}
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $leave->student->user->name }}</span>
                                        <small class="text-muted">{{ $leave->student->class }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs text-muted mb-0 text-truncate" style="max-width: 200px;">
                                    {{ Str::limit($leave->reason, 40) }}
                                </p>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border fw-normal">
                                    {{ $leave->start_date->format('M d') }} - {{ $leave->end_date->format('M d') }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($leave->status == 'approved')
                                    <span class="badge bg-success-soft text-success rounded-pill px-3 py-2">Approved</span>
                                @elseif($leave->status == 'rejected')
                                    <span class="badge bg-danger-soft text-danger rounded-pill px-3 py-2">Rejected</span>
                                @else
                                    <span class="badge bg-warning-soft text-warning rounded-pill px-3 py-2">Pending</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($leave->status == 'pending')
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="{{ route('admin.leaves.updateStatus', $leave->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <button class="btn btn-sm btn-success-soft text-success shadow-none rounded-circle" data-bs-toggle="tooltip" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.leaves.updateStatus', $leave->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button class="btn btn-sm btn-danger-soft text-danger shadow-none rounded-circle" data-bs-toggle="tooltip" title="Reject">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small"><i class="fas fa-check-double me-1"></i> Processed</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-info-soft { background-color: rgba(0, 206, 201, 0.1); color: #00cec9; }
    .bg-success-soft { background-color: rgba(0, 184, 148, 0.1); color: #00b894; }
    .bg-danger-soft { background-color: rgba(214, 48, 49, 0.1); color: #d63031; }
    .bg-warning-soft { background-color: rgba(253, 203, 110, 0.1); color: #fdcb6e; }
    
    .btn-success-soft { background-color: rgba(0, 184, 148, 0.1); border:none; }
    .btn-success-soft:hover { background-color: rgba(0, 184, 148, 0.2); color: #00b894; }

    .btn-danger-soft { background-color: rgba(214, 48, 49, 0.1); border:none; }
    .btn-danger-soft:hover { background-color: rgba(214, 48, 49, 0.2); color: #d63031; }
</style>
@endsection
