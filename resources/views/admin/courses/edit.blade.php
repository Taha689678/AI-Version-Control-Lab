@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="col-md-8">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark">
                <i class="fas fa-edit me-2 text-warning"></i> Edit Course
            </h3>
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

                <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8 mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Course Title</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-heading text-muted"></i></span>
                                {{-- logic fix: name="name" matches your database column --}}
                                <input type="text" name="name" class="form-control bg-light border-start-0 ps-0" value="{{ old('name', $course->name) }}" required>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Course Code</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-barcode text-muted"></i></span>
                                <input type="text" name="course_code" class="form-control bg-light border-start-0 ps-0" value="{{ old('course_code', $course->course_code) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase">Description</label>
                        <textarea name="description" class="form-control bg-light" rows="4">{{ old('description', $course->description) }}</textarea>
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-bold text-muted small text-uppercase">Assign Teacher</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-chalkboard-teacher text-muted"></i></span>
                            <select name="teacher_id" class="form-select bg-light border-start-0 ps-0 cursor-pointer" required>
                                <option value="">-- Select a Teacher --</option>
                                @foreach($teachers as $teacher)
                                    {{-- logic fix: $teacher->user->name to access user details --}}
                                    <option value="{{ $teacher->id }}" {{ $course->teacher_id == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->user->name }} ({{ $teacher->subject }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning btn-lg shadow-sm hover-effect text-white">
                            <i class="fas fa-save me-2"></i> Update Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Consistent Styling */
    .form-control:focus, .form-select:focus {
        border-color: #f1c40f; /* Yellow border for Edit mode */
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
        box-shadow: 0 4px 15px rgba(241, 196, 15, 0.4);
    }
</style>
@endsection