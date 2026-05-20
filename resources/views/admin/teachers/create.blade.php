@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="col-md-10">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark">
                <i class="fas fa-chalkboard-teacher me-2 text-primary"></i> Register New Teacher
            </h3>
            <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary btn-sm hover-shadow">
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

                <form action="{{ route('admin.teachers.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 border-end pe-md-4">
                            <h6 class="text-uppercase text-muted fw-bold mb-3 small">
                                <i class="fas fa-lock me-1"></i> Account Credentials
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="e.g. Sir Ahmed" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="teacher@aliacademy.com" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-key text-muted"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Min 8 characters" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 ps-md-4 mt-4 mt-md-0">
                            <h6 class="text-uppercase text-muted fw-bold mb-3 small">
                                <i class="fas fa-briefcase me-1"></i> Professional Profile
                            </h6>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Subject Specialization</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-book text-muted"></i></span>
                                    <select name="subject" class="form-select" required>
                                        <option value="">-- Select Subject --</option>
                                        <option value="Mathematics">Mathematics</option>
                                        <option value="Physics">Physics</option>
                                        <option value="Chemistry">Chemistry</option>
                                        <option value="Biology">Biology</option>
                                        <option value="English">English</option>
                                        <option value="Computer Science">Computer Science</option>
                                    </select>
                                </div>
                                <small class="text-muted text-xs">Primary subject they will teach.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Contact Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-phone text-muted"></i></span>
                                    <input type="text" name="phone" class="form-control" placeholder="0300-9876543" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm hover-effect">
                            <i class="fas fa-user-plus me-2"></i> Register Teacher
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #6c5ce7;
        box-shadow: none;
    }
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .input-group-text { border-color: #ced4da; }
</style>
@endsection