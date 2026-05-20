@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    
    <div class="d-flex justify-content-between align-items-center mb-5 animate-slide">
        <div>
            <h3 class="fw-bold text-dark mb-1">Manage <span class="text-primary-gradient">Students</span></h3>
            <p class="text-muted mb-0">Total Enrolled: <span class="fw-bold text-primary">{{ $students->count() }}</span></p>
        </div>
        <a href="{{ route('admin.students.create') }}" class="btn btn-gradient shadow-sm hover-lift">
            <i class="fas fa-user-plus me-2"></i> Register New Student
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="card-body p-4">
            
            <table id="studentsTable" class="table table-hover align-middle" style="width:100%">
                <thead class="bg-light">
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">ID</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Student Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Class / Grade</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Contact</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td class="ps-4">
                            <span class="text-secondary text-xs font-weight-bold">#{{ $student->id }}</span>
                        </td>

                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-light text-primary rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px;">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm fw-bold text-dark">{{ $student->user->name }}</h6>
                                    <p class="text-xs text-secondary mb-0">{{ $student->user->email }}</p>
                                </div>
                            </div>
                        </td>

                        <td>
                            @php
                                $badgeColor = match($student->class) {
                                    '9th Grade' => 'bg-info',
                                    '10th Grade' => 'bg-primary',
                                    'FSC Part-I' => 'bg-warning text-dark',
                                    'FSC Part-II' => 'bg-danger',
                                    'Cadet Prep' => 'bg-success',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badgeColor }} rounded-pill px-3 py-2 shadow-sm text-uppercase" style="font-size: 0.7rem;">
                                {{ $student->class }}
                            </span>
                        </td>

                        <td>
                            <span class="text-secondary text-sm font-weight-bold">
                                <i class="fas fa-phone-alt me-1 text-muted"></i> {{ $student->phone }}
                            </span>
                        </td>

                        <td class="text-center">
                            <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-sm btn-warning text-white me-1 shadow-sm" data-bs-toggle="tooltip" title="Edit Profile">
                                <i class="fas fa-user-edit"></i>
                            </a>
                            
                            <a href="{{ route('admin.students.enroll', $student->id) }}" class="btn btn-sm btn-success text-white me-1 shadow-sm" data-bs-toggle="tooltip" title="Enroll in Course">
                                <i class="fas fa-book-reader"></i>
                            </a>
                            
                            <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger shadow-sm" onclick="return confirm('Are you sure you want to expel this student? This action cannot be undone.')" data-bs-toggle="tooltip" title="Delete Student">
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
        $('#studentsTable').DataTable({
            "language": {
                "search": "<i class='fas fa-search text-muted'></i>",
                "searchPlaceholder": "Search by name, class...",
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>"
                }
            },
            "dom": '<"d-flex justify-content-between align-items-center mb-3"f>t<"d-flex justify-content-between align-items-center mt-3"ip>',
            "pageLength": 10,
            "columnDefs": [{ "orderable": false, "targets": 4 }]
        });
        
        // Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush

<style>
    /* Table Styling */
    .table > :not(caption) > * > * {
        padding: 1rem 1rem;
        border-bottom-color: #f0f2f5;
    }
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
    .hover-effect:hover { transform: translateY(-2px); }
</style>
@endsection