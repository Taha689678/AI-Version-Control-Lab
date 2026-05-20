@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h3 class="fw-bold text-dark mb-4">Edit Profile</h3>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="mb-0 fw-bold">Update Academic Information</h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('student.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- Registration No -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Registration No</label>
                                <input type="text" name="registration_no" class="form-control bg-light" value="{{ old('registration_no', $student->registration_no) }}" placeholder="e.g. FA19-BCS-001" required>
                                @error('registration_no') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <!-- Department -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Department</label>
                                <input type="text" name="department" class="form-control bg-light" value="{{ old('department', $student->department) }}" placeholder="e.g. Computer Science" required>
                                @error('department') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Phone Number</label>
                                <input type="text" name="phone" class="form-control bg-light" value="{{ old('phone', $student->phone) }}" required>
                                @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <!-- Read Only Fields -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Class / Degree</label>
                                <input type="text" class="form-control-plaintext ps-2" value="{{ $student->class }}" readonly>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <a href="{{ route('student.profile') }}" class="btn btn-light me-2">Cancel</a>
                            <button type="submit" class="btn btn-success shadow-sm">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
