@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h3 class="fw-bold text-dark mb-1">My Leave Requests</h3>
            <p class="text-muted mb-0">Track the status of your leave applications.</p>
        </div>
        <a href="{{ route('student.leaves.create') }}" class="btn btn-primary shadow-sm hover-scale rounded-pill px-4">
            <i class="fas fa-plus me-2"></i> Apply for Leave
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="border-bottom border-light">
                            <th class="ps-4 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Reason</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dates</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-end pe-4 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Applied On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $leave)
                        <tr class="border-bottom border-light">
                            <td class="ps-4">
                                <span class="fw-bold d-block text-dark">{{ Str::limit($leave->reason, 50) }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-secondary border fw-normal px-3 py-2">
                                    {{ $leave->start_date->format('M d') }} - {{ $leave->end_date->format('M d, Y') }}
                                </span>
                                <div class="small text-muted mt-1 fw-bold">{{ $leave->duration }} days</div>
                            </td>
                            <td class="text-center">
                                @if($leave->status == 'approved')
                                    <span class="badge bg-success-soft text-success rounded-pill px-3 py-2">Approved</span>
                                @elseif($leave->status == 'rejected')
                                    <span class="badge bg-danger-soft text-danger rounded-pill px-3 py-2">Rejected</span>
                                @else
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="badge bg-warning-soft text-warning rounded-pill px-3 py-2 me-2">Pending</span>
                                        <form action="{{ route('student.leaves.destroy', $leave->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Cancel this leave request?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-link text-muted p-0 border-0 hover-danger" title="Cancel Request">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                            <td class="text-end pe-4 text-muted small fw-bold">
                                {{ $leave->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <div class="mb-3 opacity-25 text-secondary">
                                    <i class="fas fa-mug-hot fa-3x"></i>
                                </div>
                                <h5 class="fw-bold text-dark">No leave requests found</h5>
                                <p class="small">You haven't applied for any leaves yet.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-success-soft { background-color: rgba(0, 184, 148, 0.1); color: #00b894; }
    .bg-danger-soft { background-color: rgba(214, 48, 49, 0.1); color: #d63031; }
    .bg-warning-soft { background-color: rgba(253, 203, 110, 0.1); color: #fdcb6e; }
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.05); }
    .hover-danger:hover { color: #d63031 !important; transform: scale(1.1); transition: all 0.2s; }
</style>
@endsection
