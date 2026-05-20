<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ali Academy</title>
    <!-- Boxicons CDN -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box; 
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            /* Full-screen background */
            background: url("{{ asset('img.jpg') }}") no-repeat center center/cover;
        }

        /* Wrapper (Login container) */
        .wrapper {
            width: 420px;
            background: rgba(48, 0, 48, 0.9); /* deep purple glass effect */
            color: #fff;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px); /* nice glass effect */
        }

        .wrapper h1 {
            font-size: 36px;
            margin-bottom: 25px;
        }

        /* Input boxes */
        .wrapper .input-box {
            position: relative;
            width: 100%;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            margin: 15px 0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            padding: 0 15px;
        }

        /* Floating label style */
        .input-box label {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            font-size: 1em;
            color: #ccc;
            pointer-events: none;
            transition: 0.3s;
        }

        /* Active field styles */
        .input-box input:focus ~ label,
        .input-box input:valid ~ label,
        .input-box input.has-val ~ label {
            top: -8px;
            font-size: 0.8em;
            color: #ffd700;
        }

        /* Inputs */
        .input-box input {
            width: 100%;
            height: 45px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 1em;
            color: #fff;
            padding: 0 40px 0 10px;
        }

        .input-box input::placeholder {
            color: transparent; /* Hide default placeholder for floating label effect */
        }

        /* Input icons */
        .input-box i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #ccc;
        }

        /* Remember + Forgot section */
        .wrapper .remember-forget {
            display: flex;
            justify-content: space-between;
            font-size: 14.5px;
            margin: -10px 0 20px;
        }

        .remember-forget label input {
            accent-color: #ffd700;
            margin-right: 5px;
        }

        .remember-forget a {
            color: #ffd700;
            text-decoration: none;
        }

        .remember-forget a:hover {
            text-decoration: underline;
        }

        /* Login button */
        .wrapper .btn {
            width: 100%;
            height: 45px;
            background: linear-gradient(135deg, #ff0080, #8000ff);
            border: none;
            outline: none;
            border-radius: 40px;
            cursor: pointer;
            font-size: 16px;
            color: #fff;
            font-weight: 600;
            transition: 0.3s;
        }

        .wrapper .btn:hover {
            transform: scale(1.03);
            box-shadow: 0 0 15px rgba(255, 0, 150, 0.5);
        }

        /* Register link */
        .wrapper .register-link {
            font-size: 14.5px;
            text-align: center;
            margin: 20px 0 10px;
        }

        .register-link p a {
            color: #ffd700;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link p a:hover {
            text-decoration: underline;
        }
        
        .alert-error {
            color: #ff4d4d;
            font-size: 14px;
            margin-bottom: 20px;
            background: rgba(255, 0, 0, 0.1);
            padding: 10px;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            
            <h1>Login</h1>
            
            @if(session('info'))
                <div class="alert-error" style="color: #ffd700; background: rgba(255, 215, 0, 0.1);">{{ session('info') }}</div>
            @endif

            @if($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="input-box">
                <input type="email" name="email" id="email" required value="{{ old('email') }}" class="{{ old('email') ? 'has-val' : '' }}" autocomplete="email">
                <label for="email">Email Address</label>
                <i class='bx bxs-user'></i>
            </div>

            <div class="input-box">
                <input type="password" name="password" id="password" required autocomplete="current-password">
                <label for="password">Password</label>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="remember-forget">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <!-- <a href="#">Forgot Password?</a> -->
            </div>

            <button type="submit" class="btn">Login</button>

            <div class="register-link">
                <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
            </div>
        </form>
    </div>
    
    <script>
        // Simple script to handle floating label for auto-filled inputs
        const inputs = document.querySelectorAll('.input-box input');
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                if(input.value.length > 0) {
                    input.classList.add('has-val');
                } else {
                    input.classList.remove('has-val');
                }
            });
        });
    </script>
</body>
</html>