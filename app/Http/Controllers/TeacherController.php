<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Enrollment;

class TeacherController extends Controller
{
    /**
     * Teacher Dashboard
     * Displays only the courses assigned to this specific teacher.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Ensure the User has a Teacher profile
        if (!$user->teacherProfile) {
            abort(403, 'Teacher profile not found. Contact Admin.');
        }

        // Fetch courses linked to the Teacher Profile ID
        $courses = $user->teacherProfile->courses()->withCount('enrollments')->get();
        
        // Calculate Stats for Admin-like Dashboard
        $stats = [
            'courses' => $courses->count(),
            'students' => $courses->sum('enrollments_count'),
            'tasks' => 0 // Future: $courses->flatMap->tasks->count()
        ];
        
        return view('teacher.dashboard', compact('courses', 'stats'));
    }

    /**
     * Show Course Details (Classroom View)
     * Lists students for taking attendance or grading.
     */
    public function showCourse(Course $course)
    {
        // Security Check: Does this course belong to the logged-in teacher?
        if ($course->teacher_id !== Auth::user()->teacherProfile->id) {
            abort(403, 'Unauthorized access to this course.');
        }

        // Eager load relationships deeply to get student names
        // Course -> Enrollments -> Student -> User (Name/Email)
        $course->load(['enrollments.student.user', 'enrollments.attendances' => function($q) {
            $q->whereDate('date', today()); // Load today's attendance if exists
        }]);

        return view('teacher.courses.show', compact('course'));
    }

    /**
     * Store Attendance
     * Updates or Creates attendance records for the specific date.
     */
    public function storeAttendance(Request $request, Course $course)
    {
        // Security Check
        if ($course->teacher_id !== Auth::user()->teacherProfile->id) {
            abort(403);
        }

        $data = $request->validate([
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*' => 'required|in:' . implode(',', [
                Attendance::STATUS_PRESENT, 
                Attendance::STATUS_ABSENT, 
                Attendance::STATUS_LATE
            ]),
        ]);

        foreach ($data['attendances'] as $enrollmentId => $status) {
            // Using updateOrCreate ensures we don't create duplicate records for the same day
            Attendance::updateOrCreate(
                [
                    'enrollment_id' => $enrollmentId, 
                    'date' => $data['date']
                ],
                [
                    // Professional: Use constants for reliability
                    'status' => $status, // The input validation ensures this matches our allowed values
                    'course_id' => $course->id,
                    'student_id' => Enrollment::find($enrollmentId)->student_id 
                ]
            );
        }

        return back()->with('success', 'Attendance recorded successfully.');
    }

    /**
     * Store Grades
     * Records assessment scores for the class.
     */
    public function storeGrade(Request $request, Course $course)
    {
        if ($course->teacher_id !== Auth::user()->teacherProfile->id) {
            abort(403);
        }

        $data = $request->validate([
            'assessment_name' => 'required|string|max:255',
            'max_score' => 'required|numeric|min:1',
            'grades' => 'required|array',
            'grades.*' => 'required|numeric|min:0|lte:max_score', // Ensure score isn't higher than max
        ]);

        foreach ($data['grades'] as $enrollmentId => $score) {
            // Check if score is provided (ignore empty inputs)
            if ($score !== null) {
                // Logic Improvement: Use updateOrCreate to allow editing grades for the same assessment
                Grade::updateOrCreate(
                    [
                        'enrollment_id'   => $enrollmentId,
                        'assessment_name' => $data['assessment_name'],
                    ],
                    [
                        'score'     => $score,
                        'max_score' => $data['max_score'],
                        'feedback'  => $request->input("feedback.$enrollmentId"),
                    ]
                );
            }
        }

        return back()->with('success', 'Grades recorded successfully.');
    }

    // ==========================================
    // COURSE MANAGEMENT CRUD (New Feature)
    // ==========================================

    public function create()
    {
        return view('teacher.courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'course_code' => 'required|string|unique:courses,course_code|max:20',
            'description' => 'nullable|string',
        ]);

        Auth::user()->teacherProfile->courses()->create($validated);

        return redirect()->route('teacher.dashboard')->with('success', 'Class created successfully.');
    }

    public function edit(Course $course)
    {
        if ($course->teacher_id !== Auth::user()->teacherProfile->id) {
            abort(403);
        }
        return view('teacher.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        if ($course->teacher_id !== Auth::user()->teacherProfile->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'course_code' => 'required|string|max:20|unique:courses,course_code,' . $course->id,
            'description' => 'nullable|string',
        ]);

        $course->update($validated);

        return redirect()->route('teacher.dashboard')->with('success', 'Class details updated.');
    }

    public function destroy(Course $course)
    {
        if ($course->teacher_id !== Auth::user()->teacherProfile->id) {
            abort(403);
        }

        $course->delete();

        return redirect()->route('teacher.dashboard')->with('success', 'Class has been deleted.');
    }
}