<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - Ali Academy</title>
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
            padding: 20px;
            overflow: hidden;
        }

        /* Wrapper (Container) */
        .wrapper {
            width: 450px;
            background: rgba(48, 0, 48, 0.9); /* deep purple glass effect */
            color: #fff;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .wrapper h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .wrapper p {
            font-size: 14px;
            color: #ccc;
            margin-bottom: 30px;
        }

        /* Input boxes */
        .input-box {
            position: relative;
            width: 100%;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            margin: 20px 0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            padding: 0 15px;
        }

        .input-box input {
            width: 100%;
            height: 45px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 24px;
            color: #fff;
            text-align: center;
            letter-spacing: 5px;
            font-weight: 600;
        }

        .input-box input::placeholder {
            color: #aaa;
            font-size: 16px;
            letter-spacing: 1px;
            font-weight: 400;
        }

        .input-box i {
            position: absolute;
            right: 15px;
            font-size: 24px;
            color: #ccc;
        }

        /* Button */
        .btn {
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
            margin-bottom: 20px;
        }

        .btn:hover {
            transform: scale(1.03);
            box-shadow: 0 0 15px rgba(255, 0, 150, 0.5);
        }

        /* Links & Utility */
        .resend-link {
            font-size: 14.5px;
            margin-bottom: 15px;
        }
        
        .resend-link button {
            background: none;
            border: none;
            color: #ffd700;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            font-family: inherit;
            padding: 0;
            font-size: inherit;
        }
        
        .resend-link button:hover {
            text-decoration: underline;
        }

        .back-link a {
            color: #ccc;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link a:hover {
            color: #fff;
        }

        /* Alerts */
        .alert {
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: left;
        }
        .alert-error {
            background: rgba(255, 0, 0, 0.1);
            color: #ff4d4d;
            border: 1px solid rgba(255, 0, 0, 0.2);
        }
        .alert-info {
            background: rgba(0, 123, 255, 0.1);
            color: #80bfff;
            border: 1px solid rgba(0, 123, 255, 0.2);
        }
        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            color: #75ef95;
            border: 1px solid rgba(40, 167, 69, 0.2);
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div style="font-size: 50px; color: #ffd700; margin-bottom: 10px;">
            <i class='bx bxs-envelope'></i>
        </div>
        <h1>Verify Email</h1>
        <p>Enter the 6-digit code sent to <strong>{{ $email }}</strong></p>

        @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="list-style: none; padding: 0; margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('guest.verification.verify') }}" method="POST">
            @csrf
            
            <div class="input-box">
                <input type="text" name="code" placeholder="------" maxlength="6" required autocomplete="off">
            </div>

            <button type="submit" class="btn">Verify</button>
        </form>
        
        <div class="resend-link">
            Didn't receive code? 
            <form action="{{ route('guest.verification.resend') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit">Resend</button>
            </form>
        </div>

        <div class="back-link">
            <a href="{{ route('login') }}"><i class='bx bx-arrow-back'></i> Back to Login</a>
        </div>
    </div>
</body>
</html>
