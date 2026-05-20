<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ali Academy - Excellence in Education</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #6c5ce7, #a29bfe);
                height: 100vh;
                display: flex;
                flex-direction: column;
                color: white;
            }
            .navbar {
                background: transparent !important;
            }
            .hero {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
            }
            .hero h1 {
                font-size: 4rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }
            .hero p {
                font-size: 1.5rem;
                margin-bottom: 2rem;
                opacity: 0.9;
            }
            .btn-cta {
                padding: 1rem 3rem;
                font-size: 1.25rem;
                border-radius: 50px;
                background: white;
                color: #6c5ce7;
                font-weight: bold;
                transition: transform 0.2s;
            }
            .btn-cta:hover {
                transform: scale(1.05);
                color: #6c5ce7;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark container">
            <a class="navbar-brand fw-bold" href="#">Ali Academy</a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item"><a href="{{ url('/login') }}" class="nav-link">Dashboard</a></li>
                    @else
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                    @endauth
                </ul>
            </div>
        </nav>

        <div class="hero">
            <div class="container">
                <h1>Welcome to Ali Academy</h1>
                <p>Empowering Students, Enabling Teachers, Managing Excellence.</p>
                
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-cta">Go to Dashboard</a>
                    @elseif(Auth::user()->isTeacher())
                        <a href="{{ route('teacher.dashboard') }}" class="btn btn-cta">Go to Dashboard</a>
                    @else
                        <a href="{{ route('student.dashboard') }}" class="btn btn-cta">Go to Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-cta">Get Started</a>
                @endauth
            </div>
        </div>

        <footer class="text-center py-4">
            <p>&copy; {{ date('Y') }} Ali Academy. All rights reserved.</p>
        </footer>
    </body>
</html>
