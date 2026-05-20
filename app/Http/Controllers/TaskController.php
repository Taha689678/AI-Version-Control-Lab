<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     * Admin: See all tasks.
     */
    public function index()
    {
        $tasks = Task::with('user')->latest()->get();
        return view('admin.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        // Fetch all users who are students
        $students = User::where('role', 'student')->get();
        return view('admin.tasks.create', compact('students'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Task::create($validated);

        return redirect()->route('admin.tasks.index')->with('success', 'Task assigned successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks.index')->with('success', 'Task deleted.');
    }

    // ==========================================
    // STUDENT METHODS
    // ==========================================

    public function studentIndex()
    {
        $tasks = Auth::user()->tasks()->latest()->get();
        return view('student.tasks.index', compact('tasks'));
    }
}
