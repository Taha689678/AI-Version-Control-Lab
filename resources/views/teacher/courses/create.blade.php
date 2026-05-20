@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <h4 class="mb-0 fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i> Create New Class</h4>
            </div>
            
            <div class="card-body p-4 pt-0">
                <form action="{{ route('teacher.courses.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Course Name</label>
                        <input type="text" name="name" class="form-control form-control-lg bg-light border-0" placeholder="e.g. Introduction to Physics" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Course Code</label>
                        <input type="text" name="course_code" class="form-control bg-light border-0" placeholder="e.g. PHY-101" required>
                        <div class="form-text">Must be unique (e.g. ENG-101, MATH-202)</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control bg-light border-0" rows="5" placeholder="Brief detailed overview of what students will learn..."></textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('teacher.dashboard') }}" class="btn btn-light btn-lg px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-lg px-4 shadow-sm">Create Class</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
