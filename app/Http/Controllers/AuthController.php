<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone'    => 'required|string',
            'role'     => 'required|in:student,teacher,admin',
            // Conditional Validation
            'class'    => 'required_if:role,student',
            'subject'  => 'required_if:role,teacher',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($validated) {
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
                'role'     => $validated['role'],
                'verification_code' => random_int(100000, 999999),
                'verification_code_expires_at' => now()->addMinutes(10),
            ]);

            // Create Profiles based on Role
            if ($validated['role'] === 'student') {
                $user->studentProfile()->create([
                    'phone'           => $validated['phone'],
                    'class'           => $validated['class'],
                    'enrollment_date' => now(),
                ]);
            } elseif ($validated['role'] === 'teacher') {
                $user->teacherProfile()->create([
                    'phone'   => $validated['phone'],
                    'subject' => $validated['subject'],
                ]);
            }
            // Admin role doesn't need extra profile currently
            
            // Send Verification Email
            try {
                Mail::to($user)->send(new VerificationCodeMail($user, $user->verification_code));
            } catch (\Exception $e) {
                // Log error but allow registration to proceed
                 \Illuminate\Support\Facades\Log::error('Mail sending failed: ' . $e->getMessage());
            }
            
            // Auth::login($user); // Disable auto-login for email verification
        });

        // Store email in session for guest verification
        session(['verify_email' => $validated['email']]);

        return redirect()->route('guest.verification.notice');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (is_null($user->email_verified_at)) {
                
                // Check if code is missing or expired
                if (is_null($user->verification_code) || 
                   ($user->verification_code_expires_at && now()->greaterThan($user->verification_code_expires_at))) {
                    
                    $user->forceFill([
                        'verification_code' => random_int(100000, 999999),
                        'verification_code_expires_at' => now()->addMinutes(10),
                    ])->save();
        
                    try {
                        Mail::to($user)->send(new VerificationCodeMail($user, $user->verification_code));
                        session()->flash('success', 'A new verification code has been sent to your email.');
                    } catch (\Exception $e) {
                        // Log error
                    }
                }

                Auth::logout(); // Force logout
                session(['verify_email' => $user->email]);
                return redirect()->route('guest.verification.notice')
                    ->with('info', 'Please verify your email to continue.');
            }

            $request->session()->regenerate();
            return $this->authenticated($request, $user);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showGuestVerification()
    {
        if (! session('verify_email')) {
            return redirect()->route('login');
        }

        $email = session('verify_email');
        $user = User::where('email', $email)->first();

        if ($user && $user->hasVerifiedEmail()) {
            session()->forget('verify_email');
            return redirect()->route('login')->with('info', 'Your email is already verified. Please login.');
        }

        return view('auth.verify_guest', ['email' => $email]);
    }

    public function verifyGuestCode(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);

        $email = session('verify_email');
        if (! $email) {
            return redirect()->route('login')->withErrors(['email' => 'Session expired. Please login.']);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            return redirect()->route('register')->withErrors(['email' => 'User not found.']);
        }

        if ($request->code == $user->verification_code) {

            // Expiry Check
            if ($user->verification_code_expires_at && now()->greaterThan($user->verification_code_expires_at)) {
                return back()->withErrors(['code' => 'The verification code has expired. Please request a new one.']);
            }

            $user->forceFill([
                'email_verified_at' => now(),
                'verification_code' => null,
                'verification_code_expires_at' => null,
            ])->save();

            // Now login the user
            Auth::login($user);
            $request->session()->forget('verify_email');
            $request->session()->regenerate();

            return $this->authenticated($request, $user);
        }

        return back()->withErrors(['code' => 'The verification code is incorrect.']);
    }

    public function resendGuestCode(Request $request)
    {
        $email = session('verify_email');
        if (! $email) {
            return redirect()->route('login');
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            if ($user->hasVerifiedEmail()) {
                 return redirect()->route('login')->with('info', 'Your email is already verified. Please login.');
            }

            $user->forceFill([
                'verification_code' => random_int(100000, 999999),
                'verification_code_expires_at' => now()->addMinutes(10),
            ])->save();

            try {
                Mail::to($user)->send(new VerificationCodeMail($user, $user->verification_code));
                return back()->with('success', 'A new verification code has been sent.');
            } catch (\Exception $e) {
                return back()->withErrors(['email' => 'Failed to send email.']);
            }
        }
        
        return back();
    }

    protected function authenticated(Request $request, $user)
    {
        // Professional switch/match logic for role redirection
        return match ($user->role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            default   => redirect('/'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
