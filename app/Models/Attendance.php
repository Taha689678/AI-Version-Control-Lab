<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    // Professional touch: Define constants for status
    const STATUS_PRESENT = 'present';
    const STATUS_ABSENT = 'absent';
    const STATUS_LATE = 'late';

    protected $fillable = [
        'student_id', // Changed from enrollment_id for direct student tracking
        'course_id', 
        'date', 
        'status'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // --- Relationships ---

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // --- Scopes (Professional Logic) ---

    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }
}