@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="col-md-10">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark">
                <i class="fas fa-edit me-2 text-warning"></i> Edit Teacher Profile
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

                {{-- Note: We route to update the Teacher ID --}}
                <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 border-end pe-md-4">
                            <h6 class="text-uppercase text-muted fw-bold mb-3 small">
                                <i class="fas fa-lock me-1"></i> Account Credentials
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                                    {{-- Logic Fix: Access name via relationship --}}
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $teacher->user->name) }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $teacher->user->email) }}" required>
                                </div>
                            </div>

                            <div class="alert alert-light border mt-4">
                                <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Passwords should be reset by the Admin manually if requested.</small>
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
                                        @php
                                            $subjects = ['Mathematics', 'Physics', 'Chemistry', 'Biology', 'English', 'Computer Science'];
                                        @endphp
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject }}" {{ $teacher->subject == $subject ? 'selected' : '' }}>
                                                {{ $subject }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Contact Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-phone text-muted"></i></span>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $teacher->phone) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-warning btn-lg shadow-sm hover-effect text-white">
                            <i class="fas fa-save me-2"></i> Update Teacher Profile
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Consistent Warning/Edit Theme */
    .form-control:focus, .form-select:focus {
        border-color: #f1c40f;
        box-shadow: none;
    }
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .hover-effect:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(241, 196, 15, 0.4);
    }
    .input-group-text { border-color: #ced4da; }
</style>
@endsection