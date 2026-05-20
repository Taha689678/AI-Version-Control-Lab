@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <h4 class="mb-0 fw-bold"><i class="fas fa-paper-plane me-2 text-primary"></i> Apply for Leave</h4>
            </div>
            
            <div class="card-body p-4 pt-0">
                <form action="{{ route('student.leaves.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Start Date</label>
                            <input type="date" name="start_date" class="form-control bg-light border-0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">End Date</label>
                            <input type="date" name="end_date" class="form-control bg-light border-0" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Reason for Leave</label>
                        <textarea name="reason" class="form-control bg-light border-0" rows="4" placeholder="e.g. Attending sister's wedding..." required></textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('student.leaves.index') }}" class="btn btn-light btn-lg px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-lg px-4 shadow-sm">Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
