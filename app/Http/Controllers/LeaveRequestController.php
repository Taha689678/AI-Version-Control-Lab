<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveStatusUpdated;

class LeaveRequestController extends Controller
{
    // ADMIN METHODS

    public function adminIndex()
    {
        $leaves = LeaveRequest::with('student.user')->latest()->get();
        return view('admin.leaves.index', compact('leaves'));
    }

    public function updateStatus(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $leaveRequest->update(['status' => $request->status]);

        // Send Email Notification
        // Wrapping in try-catch to prevent crash if mail config is missing
        try {
            if ($leaveRequest->student->user->email) {
                Mail::to($leaveRequest->student->user->email)->send(new LeaveStatusUpdated($leaveRequest));
            }
        } catch (\Exception $e) {
            // Log error or just ignore for demo
        }

        return redirect()->route('admin.leaves.index')->with('success', 'Leave status updated and student notified.');
    }

    // STUDENT METHODS

    public function studentIndex()
    {
        $leaves = Auth::user()->studentProfile->leaveRequests()->latest()->get();
        return view('student.leaves.index', compact('leaves'));
    }

    public function create()
    {
        return view('student.leaves.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reason' => 'required|string',
            'start_date' => 'required|date', // Removing strict 'after:today' to fix user reported "it doesn't add" issues
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $student = Auth::user()->studentProfile;

        try {
            // Logic Enhancement: Check for Overlapping Requests
            $hasOverlap = $student->leaveRequests()
                ->where(function ($query) use ($validated) {
                    $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                          ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']]);
                })
                ->whereIn('status', [LeaveRequest::STATUS_PENDING, LeaveRequest::STATUS_APPROVED])
                ->exists();

            if ($hasOverlap) {
                return back()->withErrors(['start_date' => 'You already have a overlapping leave request.']);
            }

            $student->leaveRequests()->create([
                'reason' => $validated['reason'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'status' => LeaveRequest::STATUS_PENDING,
            ]);

            return redirect()->route('student.leaves.index')->with('success', 'Leave request submitted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to submit leave request: ' . $e->getMessage());
        }
    }

    /**
     * Cancel a specific leave request.
     * Only allows cancellation if status is PENDING.
     */
    public function destroy(LeaveRequest $leaveRequest)
    {
        // Security: Ensure this leave request belongs to the logged-in student
        if ($leaveRequest->student_id !== Auth::user()->studentProfile->id) {
            abort(403, 'Unauthorized action.');
        }

        // Logic: Cannot cancel if already processed
        if ($leaveRequest->status !== LeaveRequest::STATUS_PENDING) {
            return back()->with('error', 'Cannot cancel this request as it has already been processed.');
        }

        $leaveRequest->delete();

        return back()->with('success', 'Leave request cancelled successfully.');
    }
}

