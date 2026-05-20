<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Enrollment;

class StudentController extends Controller
{
    /**
     * Student Dashboard
     * Shows list of enrolled courses and recent activity.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Ensure the User has a Student profile linked
        if (!$user->studentProfile) {
            abort(403, 'Student profile not found. Contact Admin.');
        }

        // Fetch courses through the Student profile
        // We Eager Load 'teacher.user' to show the Teacher's name on the card
        $enrollments = $user->studentProfile->enrollments()
                            ->with(['course.teacher.user', 'attendances']) // Eager load attendances
                            ->latest()
                            ->get();
        
        $stats = [
            'enrollments' => $enrollments->count(),
            'tasks' => 0, // Placeholder for Tasks
            'leaves' => $user->studentProfile->leaveRequests->count() // Assuming relationship exists
        ];
        
        return view('student.dashboard', compact('enrollments', 'stats'));
    }

    /**
     * Show Course Details
     * Includes Attendance history and Grades for this specific student.
     */
    public function showCourse(Course $course)
    {
        $user = Auth::user();
        $studentId = $user->studentProfile->id;

        // Security Check: Verify enrollment using student_id
        $enrollment = Enrollment::where('student_id', $studentId)
                                ->where('course_id', $course->id)
                                ->with(['attendances' => function($query) {
                                    $query->latest(); // Show recent attendance first
                                }, 'grades'])
                                ->firstOrFail(); 

        // Calculate a summary (e.g., Attendance Percentage)
        $totalClasses = $enrollment->attendances->count();
        $presentClasses = $enrollment->attendances->where('status', 'present')->count();
        $attendancePercentage = $totalClasses > 0 ? round(($presentClasses / $totalClasses) * 100) : 0;

        return view('student.courses.show', compact('course', 'enrollment', 'attendancePercentage'));
    }

    /**
     * Student Profile View
     * Allows them to see their registered details.
     */
    public function profile()
    {
        $student = Auth::user()->studentProfile;
        return view('student.profile', compact('student'));
    }

    public function editProfile()
    {
        $student = Auth::user()->studentProfile;
        return view('student.edit_profile', compact('student'));
    }

    public function updateProfile(Request $request)
    {
        $student = Auth::user()->studentProfile;
        
        $validated = $request->validate([
            'phone' => 'required|string',
            'registration_no' => 'required|string|unique:students,registration_no,' . $student->id,
            'department' => 'required|string',
        ]);

        $student->update([
            'phone' => $validated['phone'],
            'registration_no' => $validated['registration_no'],
            'department' => $validated['department'],
        ]);

        return redirect()->route('student.profile')->with('success', 'Profile updated successfully.');
    }
}