<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard with Statistics.
     */
    public function dashboard()
    {
        $stats = [
            'students' => Student::count(),
            'teachers' => Teacher::count(),
            'courses'  => Course::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    // =========================================================================
    // STUDENT MANAGEMENT
    // =========================================================================

    public function students()
    {
        // Eager load 'user' to avoid N+1 query performance issues
        $students = Student::with('user')->latest()->get();
        return view('admin.students.index', compact('students'));
    }

    public function createStudent()
    {
        return view('admin.students.create');
    }

    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone'    => 'required|string',
            'class'    => 'required|string',
        ]);

        DB::transaction(function () use ($validated) {
            // 1. Create the User Login Account
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'student',
            ]);

            // 2. Create the Student Profile linked to that User
            $user->studentProfile()->create([
                'phone'           => $validated['phone'],
                'class'           => $validated['class'],
                'enrollment_date' => now(),
            ]);
        });

        return redirect()->route('admin.students.index')->with('success', 'Student registered successfully.');
    }

    public function editStudent($id)
    {
        $student = Student::with('user')->findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $user = $student->user; // Get related User model

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)], // Ignore current user for unique check
            'phone' => 'required|string',
            'class' => 'required|string',
        ]);

        DB::transaction(function () use ($validated, $user, $student) {
            // Update User Table
            $user->update([
                'name'  => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Update Student Table
            $student->update([
                'phone' => $validated['phone'],
                'class' => $validated['class'],
            ]);
        });

        return redirect()->route('admin.students.index')->with('success', 'Student record updated.');
    }

    public function destroyStudent($id)
    {
        $student = Student::findOrFail($id);
        $user = $student->user;

        DB::transaction(function () use ($student, $user) {
            // Delete Student Profile first
            $student->delete();
            // Then Delete Login Account
            $user->delete();
        });

        return redirect()->route('admin.students.index')->with('success', 'Student has been removed.');
    }

    public function enrollStudent($id)
    {
        $student = Student::with('user')->findOrFail($id);
        $courses = Course::all();
        return view('admin.students.enroll', compact('student', 'courses'));
    }

    public function storeEnrollment(Request $request, $id)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $student = Student::findOrFail($id);
        
        // Check if already enrolled to avoid duplicates (though DB unique constraint handles this too)
        if ($student->enrollments()->where('course_id', $request->course_id)->exists()) {
            return back()->withErrors(['course_id' => 'Student is already enrolled in this course.']);
        }

        $student->enrollments()->create([
            'course_id' => $request->course_id,
            'status' => 'active',
            'enrolled_at' => now(),
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student enrolled successfully.');
    }


    // =========================================================================
    // TEACHER MANAGEMENT
    // =========================================================================

    public function teachers()
    {
        $teachers = Teacher::with('user')->latest()->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function createTeacher()
    {
        return view('admin.teachers.create');
    }

    public function storeTeacher(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone'    => 'required|string',
            'subject'  => 'required|string',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'teacher',
            ]);

            $user->teacherProfile()->create([
                'phone'   => $validated['phone'],
                'subject' => $validated['subject'],
            ]);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher registered successfully.');
    }

    public function editTeacher($id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $user = $teacher->user;

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone'   => 'required|string',
            'subject' => 'required|string',
        ]);

        DB::transaction(function () use ($validated, $user, $teacher) {
            $user->update([
                'name'  => $validated['name'],
                'email' => $validated['email'],
            ]);

            $teacher->update([
                'phone'   => $validated['phone'],
                'subject' => $validated['subject'],
            ]);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher profile updated.');
    }

    public function destroyTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
        $user = $teacher->user;

        DB::transaction(function () use ($teacher, $user) {
            $teacher->delete();
            $user->delete();
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher removed from system.');
    }
}