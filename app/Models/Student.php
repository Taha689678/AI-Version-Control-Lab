<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    /**
     * Fields specific to the student profile.
     */
    protected $fillable = [
        'user_id',
        'phone',
        'class',
        'registration_no', // New
        'department',      // New
        'enrollment_date',
        'guardian_name',
    ];

    protected $casts = [
        'enrollment_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Link back to the User account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all courses this student is enrolled in.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
                    ->withPivot('id', 'enrolled_at')
                    ->withTimestamps();
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * COMSATS Feature: Leave Requests
     */
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    /**
     * Access all grades through the enrollment pivot.
     */
    public function grades()
    {
        return $this->hasManyThrough(Grade::class, Enrollment::class, 'student_id', 'enrollment_id');
    }
}