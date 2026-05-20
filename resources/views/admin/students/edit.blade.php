@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="col-md-10">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark">
                <i class="fas fa-user-edit me-2 text-warning"></i> Edit Student Profile
            </h3>
            <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary btn-sm hover-shadow">
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

                {{-- Note: We are updating the Student Model ID --}}
                <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 border-end pe-md-4">
                            <h6 class="text-uppercase text-muted fw-bold mb-3 small">
                                <i class="fas fa-lock me-1"></i> Account Details
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                                    {{-- Fix: Access name via the relationship --}}
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $student->user->name) }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $student->user->email) }}" required>
                                </div>
                            </div>

                            <div class="alert alert-light border mt-4">
                                <small class="text-muted"><i class="fas fa-info-circle me-1"></i> To change the password, ask the student to use the "Forgot Password" feature.</small>
                            </div>
                        </div>

                        <div class="col-md-6 ps-md-4 mt-4 mt-md-0">
                            <h6 class="text-uppercase text-muted fw-bold mb-3 small">
                                <i class="fas fa-id-card me-1"></i> Academic Profile
                            </h6>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Class / Grade</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-graduation-cap text-muted"></i></span>
                                    <select name="class" class="form-select" required>
                                        <option value="">-- Select Class --</option>
                                        @php
                                            $classes = ['9th Grade', '10th Grade', 'FSC Part-I', 'FSC Part-II', 'Cadet Prep'];
                                        @endphp
                                        @foreach($classes as $class)
                                            <option value="{{ $class }}" {{ $student->class == $class ? 'selected' : '' }}>
                                                {{ $class }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-phone text-muted"></i></span>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Enrollment Date</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-calendar-alt text-muted"></i></span>
                                    <input type="date" name="enrollment_date" class="form-control" value="{{ old('enrollment_date', $student->enrollment_date->format('Y-m-d')) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
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
    /* Yellow/Warning Theme for Edit Mode */
    .form-control:focus, .form-select:focus {
        border-color: #f1c40f; 
        box-shadow: none;
    }
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .hover-effect { transition: all 0.3s ease; }
    .hover-effect:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(241, 196, 15, 0.4);
    }
    .input-group-text { border-color: #ced4da; }
</style>
@endsection