@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 text-center">
                <div class="mb-3">
                    <div class="avatar-lg bg-light text-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-envelope-open-text fa-3x"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark">Verify Your Email</h3>
                <p class="text-muted">We sent a verification code to your email.</p>
            </div>
            
            <div class="card-body p-4 pt-2">
                @if (session('info'))
                    <div class="alert alert-info border-0 shadow-sm rounded-3">
                        <i class="fas fa-info-circle me-2"></i> {{ session('info') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-3">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('verification.verify') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Verification Code</label>
                        <input type="text" name="code" class="form-control form-control-lg text-center fw-bold letter-spacing-2" placeholder="123456" maxlength="6" required style="letter-spacing: 5px; font-size: 1.5rem;">
                        <div class="form-text text-center">Enter the 6-digit code sent to {{ Auth::user()->email }}</div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                            Verify Email
                        </button>
                    </div>
                </form>
                
                <div class="text-center mt-4">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link text-muted text-decoration-none">
                            <i class="fas fa-sign-out-alt me-1"></i> Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
