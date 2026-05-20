@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <h4 class="mb-0 fw-bold"><i class="fas fa-tasks me-2 text-primary"></i> Assign New Task</h4>
            </div>
            
            <div class="card-body p-4 pt-0">
                <form action="{{ route('admin.tasks.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Select Student</label>
                        <select name="user_id" class="form-select form-select-lg bg-light border-0" required>
                            <option value="">-- Choose a Student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Task Title</label>
                        <input type="text" name="title" class="form-control form-control-lg bg-light border-0" placeholder="e.g. Submit Final Year Project Proposal" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control bg-light border-0" rows="5" placeholder="Detailed instructions..." required></textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.tasks.index') }}" class="btn btn-light btn-lg px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-lg px-4 shadow-sm">Assign Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
