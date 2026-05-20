<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Ali Academy</title>
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
            overflow: hidden; /* Prevent scrolling */
        }

        /* Wrapper (Register container) */
        .wrapper {
            width: 500px; /* Slightly wider for registration */
            background: rgba(48, 0, 48, 0.9); /* deep purple glass effect */
            color: #fff;
            border-radius: 12px;
            padding: 30px 40px;
            text-align: center;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            border: 2px solid rgba(255, 255, 255, 0.2); /* Improved bordering */
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
        .input-box input.has-val ~ label,
        .input-box select:focus ~ label,
        .input-box select:valid ~ label {
            top: -8px;
            font-size: 0.8em;
            color: #ffd700;
        }

        /* Inputs & Selects */
        .input-box input, .input-box select {
            width: 100%;
            height: 45px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 1em;
            color: #fff;
            padding: 0 40px 0 10px;
        }
        
        .input-box select {
             padding-right: 30px;
             cursor: pointer;
        }
        
        .input-box select option {
            background-color: #333;
            color: #fff;
        }

        .input-box input::placeholder {
            color: transparent;
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

        /* Button */
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
            margin-top: 20px;
        }

        .wrapper .btn:hover {
            transform: scale(1.03);
            box-shadow: 0 0 15px rgba(255, 0, 150, 0.5);
        }

        /* Links */
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
            text-align: left;
        }
        
        .section-split {
            display: flex; 
            gap: 15px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <h1>Register</h1>
            
            @if($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Full Name -->
            <div class="input-box">
                <input type="text" name="name" required value="{{ old('name') }}" class="{{ old('name') ? 'has-val' : '' }}">
                <label>Full Name</label>
                <i class='bx bxs-user'></i>
            </div>

            <!-- Email -->
            <div class="input-box">
                <input type="email" name="email" id="email" required value="{{ old('email') }}" class="{{ old('email') ? 'has-val' : '' }}" autocomplete="email">
                <label for="email">Email Address</label>
                <i class='bx bxs-envelope'></i>
            </div>
            
            <!-- Phone -->
            <div class="input-box">
                <input type="text" name="phone" id="phone" required value="{{ old('phone') }}" class="{{ old('phone') ? 'has-val' : '' }}" autocomplete="tel">
                <label for="phone">Phone Number</label>
                <i class='bx bxs-phone'></i>
            </div>

            <div class="section-split">
                <!-- Password -->
                <div class="input-box">
                    <input type="password" name="password" id="password" required autocomplete="new-password">
                    <label for="password">Password</label>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <!-- Confirm Password -->
                <div class="input-box">
                    <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password">
                    <label for="password_confirmation">Confirm</label>
                    <i class='bx bxs-lock-alt'></i>
                </div>
            </div>

            <!-- Role Selection -->
            <div class="input-box">
                <select name="role" id="roleSelect" required onchange="toggleFields()">
                    <option value="" disabled selected></option>
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
                <label>Select Role</label>
                <i class='bx bxs-user-detail'></i>
            </div>

            <!-- Dynamic Fields -->
            <div id="studentFields" style="display:none;">
                <div class="input-box">
                    <select name="class" id="classSelect">
                        <option value="" disabled selected></option>
                        <option value="9th Grade" {{ old('class') == '9th Grade' ? 'selected' : '' }}>9th Grade</option>
                        <option value="10th Grade" {{ old('class') == '10th Grade' ? 'selected' : '' }}>10th Grade</option>
                        <option value="FSC Part-I" {{ old('class') == 'FSC Part-I' ? 'selected' : '' }}>FSC Part-I</option>
                        <option value="FSC Part-II" {{ old('class') == 'FSC Part-II' ? 'selected' : '' }}>FSC Part-II</option>
                    </select>
                    <label>Select Class</label>
                    <i class='bx bxs-graduation'></i>
                </div>
            </div>

            <div id="teacherFields" style="display:none;">
               <div class="input-box">
                    <input type="text" name="subject" value="{{ old('subject') }}">
                    <label>Subject (e.g. Physics)</label>
                    <i class='bx bxs-book'></i>
                </div>
            </div>

            <button type="submit" class="btn">Register</button>

            <div class="register-link">
                <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
            </div>
        </form>
    </div>

    <script>
        // Floating label logic
        const inputs = document.querySelectorAll('.input-box input');
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                input.classList.toggle('has-val', input.value.length > 0);
            });
        });

        // Dynamic Role Logic
        function toggleFields() {
            var role = document.getElementById('roleSelect').value;
            var studentFields = document.getElementById('studentFields');
            var teacherFields = document.getElementById('teacherFields');
            var classSelect = document.getElementById('classSelect');
            var subjectInput = document.querySelector('[name="subject"]');
            
            // Hide all first
            studentFields.style.display = 'none';
            teacherFields.style.display = 'none';

            // Reset requirements
            classSelect.required = false;
            subjectInput.required = false;

            if (role === 'student') {
                studentFields.style.display = 'block';
                classSelect.required = true;
            } else if (role === 'teacher') {
                teacherFields.style.display = 'block';
                subjectInput.required = true;
            }
        }
        
        // Run on load to handle old input recovery
        document.addEventListener('DOMContentLoaded', toggleFields);
    </script>
</body>
</html>
