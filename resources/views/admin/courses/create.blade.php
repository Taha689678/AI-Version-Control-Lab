@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="col-md-8">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark"><i class="fas fa-book-open me-2 text-primary"></i> Create New Course</h3>
            <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary btn-sm hover-shadow">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><small>{{ $error }}</small></li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.courses.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8 mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Course Title</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-heading text-muted"></i></span>
                                <input type="text" name="name" class="form-control bg-light border-start-0 ps-0" placeholder="e.g. Advanced Mathematics" required>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Course Code</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-barcode text-muted"></i></span>
                                <input type="text" name="course_code" class="form-control bg-light border-start-0 ps-0" placeholder="e.g. MAT-101" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase">Description</label>
                        <textarea name="description" class="form-control bg-light" rows="4" placeholder="Enter a brief summary of what this course covers..."></textarea>
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-bold text-muted small text-uppercase">Assign Teacher</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-chalkboard-teacher text-muted"></i></span>
                            <select name="teacher_id" class="form-select bg-light border-start-0 ps-0 cursor-pointer" required>
                                <option value="">-- Select a Teacher --</option>
                                @foreach($teachers as $teacher)
                                    {{-- Notice the fix: $teacher->user->name --}}
                                    <option value="{{ $teacher->id }}">
                                        {{ $teacher->user->name }} ({{ $teacher->subject }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm hover-effect">
                            <i class="fas fa-save me-2"></i> Save Course
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom CSS for this page */
    .form-control:focus, .form-select:focus {
        border-color: #6c5ce7;
        box-shadow: none;
        background-color: #fff !important;
    }
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        transition: all 0.3s ease;
    }
    .hover-effect {
        transition: all 0.3s ease;
    }
    .hover-effect:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(108, 92, 231, 0.4);
    }
    .input-group-text {
        border-color: #ced4da;
    }
</style>
@endsection