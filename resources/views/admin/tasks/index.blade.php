@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-5 animate-slide">
        <div>
            <h3 class="fw-bold text-dark mb-1">Task <span class="text-primary-gradient">Management</span></h3>
            <p class="text-muted mb-0">Assign and track student tasks</p>
        </div>
        <a href="{{ route('admin.tasks.create') }}" class="btn btn-gradient shadow-sm hover-lift">
            <i class="fas fa-plus-circle me-2"></i> Assign New Task
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <table id="tasksTable" class="table table-hover align-middle" style="width:100%">
                <thead class="bg-light">
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Task Title</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Assigned To</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                    <tr class="border-bottom border-light">
                        <td class="ps-3">
                            <div class="d-flex flex-column">
                                <h6 class="mb-0 text-sm fw-bold text-dark">{{ $task->title }}</h6>
                                <p class="text-xs text-muted mb-0 text-truncate" style="max-width: 250px;">{{ $task->description }}</p>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-primary-soft rounded-circle text-primary d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 35px; height: 35px;">
                                    {{ substr($task->user->name, 0, 1) }}
                                </div>
                                <span class="text-sm fw-bold text-dark">{{ $task->user->name }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($task->status == 'completed')
                                <span class="badge bg-success-soft text-success rounded-pill px-3">Completed</span>
                            @else
                                <span class="badge bg-warning-soft text-warning rounded-pill px-3">Pending</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="text-secondary text-xs fw-bold">{{ $task->created_at->format('M d, Y') }}</span>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this task?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-light text-danger shadow-sm rounded-circle p-2" data-bs-toggle="tooltip" title="Delete Task">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#tasksTable').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search tasks..."
            }
        });
    });
</script>
<style>
    .bg-primary-soft { background-color: rgba(108, 92, 231, 0.1); color: #6c5ce7; }
    .bg-success-soft { background-color: rgba(0, 184, 148, 0.1); color: #00b894; }
    .bg-warning-soft { background-color: rgba(253, 203, 110, 0.1); color: #fdcb6e; }
    
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 20px;
        padding: 5px 15px;
        border: 1px solid #dee2e6;
    }
</style>
@endpush
@endsection
