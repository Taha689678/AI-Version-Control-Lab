@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-edit me-2 text-primary"></i> Edit Class Details</h4>
                    
                    <!-- Delete Button -->
                    <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure? This will delete all student enrollments and grades for this course.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-trash-alt me-1"></i> Delete Class
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="card-body p-4 pt-0">
                <form action="{{ route('teacher.courses.update', $course->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Course Name</label>
                        <input type="text" name="name" class="form-control form-control-lg bg-light border-0" value="{{ old('name', $course->name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Course Code</label>
                        <input type="text" name="course_code" class="form-control bg-light border-0" value="{{ old('course_code', $course->course_code) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control bg-light border-0" rows="5">{{ old('description', $course->description) }}</textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('teacher.dashboard') }}" class="btn btn-light btn-lg px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-lg px-4 shadow-sm">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
