@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark m-0">Manage Courses</h3>
            <small class="text-muted">Overview of all academic courses</small>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-lg shadow-sm hover-effect">
            <i class="fas fa-plus-circle me-2"></i> Add New Course
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="card-body p-4">
            
            <table id="coursesTable" class="table table-hover align-middle" style="width:100%">
                <thead class="bg-light">
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Code</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Course Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Instructor</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-primary rounded-pill px-3 py-2 shadow-sm">
                                {{ $course->course_code ?? 'N/A' }}
                            </span>
                        </td>

                        <td>
                            <h6 class="mb-0 fw-bold text-dark">{{ $course->name }}</h6>
                            <small class="text-muted">{{ $course->created_at->format('d M, Y') }}</small>
                        </td>

                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-light text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-sm fw-semibold">{{ $course->teacher->user->name }}</h6>
                                    <small class="text-xs text-muted">{{ $course->teacher->subject }} Department</small>
                                </div>
                            </div>
                        </td>

                        <td>
                            <p class="text-sm text-secondary mb-0 text-truncate" style="max-width: 200px;">
                                {{ Str::limit($course->description, 50) }}
                            </p>
                        </td>

                        <td class="text-center">
                            <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-sm btn-warning text-white me-1" data-bs-toggle="tooltip" title="Edit Course">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this course? All associated data will be removed.')" data-bs-toggle="tooltip" title="Delete Course">
                                    <i class="fas fa-trash-alt"></i>
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
        $('#coursesTable').DataTable({
            "language": {
                "search": "<i class='fas fa-search text-muted'></i>",
                "searchPlaceholder": "Search courses, codes...",
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>"
                }
            },
            "dom": '<"d-flex justify-content-between align-items-center mb-3"f>t<"d-flex justify-content-between align-items-center mt-3"ip>',
            "pageLength": 8,
            "columnDefs": [{ "orderable": false, "targets": 4 }] // Disable sorting on Actions column
        });

        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush

<style>
    /* Custom DataTables Styling */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #dee2e6;
        border-radius: 20px;
        padding: 5px 15px;
        margin-left: 10px;
        outline: none;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #6c5ce7 !important;
        color: white !important;
        border: none;
        border-radius: 50%;
    }
    .hover-effect:hover {
        transform: translateY(-2px);
    }
</style>
@endsection