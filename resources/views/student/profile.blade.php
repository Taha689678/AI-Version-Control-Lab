@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h3 class="fw-bold text-dark mb-4">My Profile</h3>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white p-4 text-center" style="background: linear-gradient(135deg, #6c5ce7, #a29bfe);">
                    <div class="avatar-circle bg-white text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow" style="width: 100px; height: 100px; font-size: 3rem;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h2 class="mb-0 fw-bold text-white">{{ Auth::user()->name }}</h2>
                    <p class="mb-0 text-white-50">{{ Auth::user()->email }}</p>
                </div>
                
                <div class="card-body p-5">
                    <h5 class="text-uppercase text-muted fw-bold mb-4 small">Academic Information</h5>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label text-secondary fw-bold">Class</label>
                            <div class="p-3 bg-light rounded-3 border">
                                <i class="fas fa-layer-group text-primary me-2"></i> {{ $student->class ?? 'Not Assigned' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-secondary fw-bold">Contact Number</label>
                            <div class="p-3 bg-light rounded-3 border">
                                <i class="fas fa-phone text-success me-2"></i> {{ $student->phone ?? 'Not Provided' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-secondary fw-bold">Enrollment Date</label>
                            <div class="p-3 bg-light rounded-3 border">
                                <i class="fas fa-calendar-alt text-info me-2"></i> {{ $student->enrollment_date->format('F d, Y') ?? 'N/A' }}
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-secondary fw-bold">Student ID</label>
                            <div class="p-3 bg-light rounded-3 border">
                                <i class="fas fa-id-card text-warning me-2"></i> ST-{{ $student->id }}
                            </div>
                        </div>

                        <!-- COMSATS Fields -->
                        <div class="col-md-6">
                            <label class="form-label text-secondary fw-bold">Registration No</label>
                            <div class="p-3 bg-light rounded-3 border">
                                <i class="fas fa-fingerprint text-dark me-2"></i> {{ $student->registration_no ?? 'Not Set' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-secondary fw-bold">Department</label>
                            <div class="p-3 bg-light rounded-3 border">
                                <i class="fas fa-university text-danger me-2"></i> {{ $student->department ?? 'Not Set' }}
                            </div>
                        </div>
                    </div>

                    <hr class="my-5">

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('student.profile.edit') }}" class="btn btn-primary shadow-sm">
                            <i class="fas fa-edit me-2"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
