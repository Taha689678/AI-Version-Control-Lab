<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LeaveRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes - Ali Academy
|--------------------------------------------------------------------------
*/

// 1. PUBLIC ROUTES
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 2. AUTHENTICATION ROUTES (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    
    // Guest Verification Routes
    Route::get('/register/verify', [AuthController::class, 'showGuestVerification'])->name('guest.verification.notice');
    Route::post('/register/verify', [AuthController::class, 'verifyGuestCode'])->name('guest.verification.verify');
    Route::post('/register/resend', [AuthController::class, 'resendGuestCode'])->name('guest.verification.resend');
});

// Logout (Protected)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| PROTECTED DASHBOARD ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // ===========================
    // ADMIN PANEL ROUTES
    // ===========================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // --- Student Management ---
        Route::get('/students', [AdminController::class, 'students'])->name('students.index');
        Route::get('/students/create', [AdminController::class, 'createStudent'])->name('students.create');
        Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
        Route::get('/students/{id}/edit', [AdminController::class, 'editStudent'])->name('students.edit');
        Route::put('/students/{id}', [AdminController::class, 'updateStudent'])->name('students.update');
        Route::get('/students/{id}/enroll', [AdminController::class, 'enrollStudent'])->name('students.enroll');
        Route::post('/students/{id}/enroll', [AdminController::class, 'storeEnrollment'])->name('students.enroll.store');
        Route::delete('/students/{id}', [AdminController::class, 'destroyStudent'])->name('students.destroy');

        // --- Teacher Management ---
        Route::get('/teachers', [AdminController::class, 'teachers'])->name('teachers.index');
        Route::get('/teachers/create', [AdminController::class, 'createTeacher'])->name('teachers.create');
        Route::post('/teachers', [AdminController::class, 'storeTeacher'])->name('teachers.store');
        Route::get('/teachers/{id}/edit', [AdminController::class, 'editTeacher'])->name('teachers.edit');
        Route::put('/teachers/{id}', [AdminController::class, 'updateTeacher'])->name('teachers.update');
        Route::delete('/teachers/{id}', [AdminController::class, 'destroyTeacher'])->name('teachers.destroy');

        // --- Course Management (Using Resource Controller) ---
        Route::resource('courses', CourseController::class);

        // --- Task Management ---
        Route::resource('tasks', TaskController::class);

        // --- Leave Requests ---
        Route::get('/leaves', [LeaveRequestController::class, 'adminIndex'])->name('leaves.index');
        Route::put('/leaves/{leaveRequest}', [LeaveRequestController::class, 'updateStatus'])->name('leaves.updateStatus');
    });

    // ===========================
    // TEACHER PANEL ROUTES
    // ===========================
    Route::middleware(['role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
        
        // Dashboard (My Classes)
        Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
        
        // Course CRUD (New Feature) - Must be defined BEFORE the generic 'show' route with wildcard
        Route::resource('courses', TeacherController::class)->except(['index', 'show']);

        // Classroom Management
        Route::get('/courses/{course}', [TeacherController::class, 'showCourse'])->name('courses.show');

        // Actions
        Route::post('/courses/{course}/attendance', [TeacherController::class, 'storeAttendance'])->name('courses.attendance');
        Route::post('/courses/{course}/grades', [TeacherController::class, 'storeGrade'])->name('courses.grades');
    });

    // ===========================
    // STUDENT PANEL ROUTES
    // ===========================
    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
        
        // Dashboard (My Enrollments)
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        
        // Course View (Grades & Attendance)
        Route::get('/courses/{course}', [StudentController::class, 'showCourse'])->name('courses.show');
        
        // Task View
        Route::get('/my-tasks', [TaskController::class, 'studentIndex'])->name('tasks.index');

        // Leave Requests
        Route::get('/my-leaves', [LeaveRequestController::class, 'studentIndex'])->name('leaves.index');
        Route::get('/my-leaves/create', [LeaveRequestController::class, 'create'])->name('leaves.create');
        Route::post('/my-leaves', [LeaveRequestController::class, 'store'])->name('leaves.store');
        Route::delete('/my-leaves/{leaveRequest}', [LeaveRequestController::class, 'destroy'])->name('leaves.destroy');
        
        // Profile
        Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
        Route::get('/profile/edit', [StudentController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');
    });

});