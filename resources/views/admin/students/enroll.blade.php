@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg border-0 rounded-4 p-4" style="width: 100%; max-width: 500px;">
        <div class="card-header bg-transparent border-0 text-center">
            <h3 class="fw-bold text-primary"><i class="fas fa-user-graduate me-2"></i>Enroll Student</h3>
            <p class="text-muted">Enroll <strong>{{ $student->user->name }}</strong> in a course.</p>
        </div>
        
        <div class="card-body">
            <form action="{{ route('admin.students.enroll.store', $student->id) }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="course_id" class="form-label fw-bold">Select Course</label>
                    <select name="course_id" id="course_id" class="form-select form-select-lg shadow-sm" required>
                        <option value="" disabled selected>Choose a course...</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">
                                {{ $course->name }} ({{ $course->course_code ?? 'No Code' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm hover-effect">Enroll Now</button>
                    <a href="{{ route('admin.students.index') }}" class="btn btn-light btn-lg text-muted">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
