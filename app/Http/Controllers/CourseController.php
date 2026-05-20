<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Performance Optimization: Eager Load 'teacher' and their 'user' details.
        // This prevents the "N+1 Problem" where Laravel runs a new query for every single row.
        $courses = Course::with('teacher.user')->latest()->get();
        
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch teachers so the Admin can select one from a dropdown
        $teachers = Teacher::with('user')->get();
        return view('admin.courses.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'course_code' => 'required|string|unique:courses,course_code|max:20', // e.g., PHY-101
            'description' => 'nullable|string',
            'teacher_id'  => 'required|exists:teachers,id', // Ensures the teacher actually exists
        ]);

        Course::create($validated);

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Course created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.courses.edit', compact('course', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            // Unique rule ignores the current course ID during updates
            'course_code' => 'required|string|max:20|unique:courses,course_code,' . $course->id,
            'description' => 'nullable|string',
            'teacher_id'  => 'required|exists:teachers,id',
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        // Optional: Check if students are enrolled before deleting?
        // For now, we will allow deletion which cascades (as set in migration)
        $course->delete();

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Course deleted successfully.');
    }
}