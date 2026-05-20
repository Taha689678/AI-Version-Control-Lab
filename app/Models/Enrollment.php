<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Enrollment extends Pivot
{
    // Important for Pivot models if you want to use them like regular models
    public $incrementing = true;
    protected $table = 'enrollments';

    protected $fillable = [
        'student_id', // Changed from user_id to student_id for better normalization
        'course_id', 
        'enrolled_at',
        'status'      // Added status (active/completed) for better tracking
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
    ];

    /**
     * Relationship: The student who is enrolled.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relationship: The course being taken.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Relationship: Attendance records for this specific enrollment.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'enrollment_id');
    }

    /**
     * Relationship: Academic grades for this specific enrollment.
     */
    public function grades()
    {
        return $this->hasMany(Grade::class, 'enrollment_id');
    }
}