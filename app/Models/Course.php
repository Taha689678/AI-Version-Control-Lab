<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    // We use 'name' to match your initial requirement, but 'title' works too.
    // I added 'code' because professional academy systems usually have course codes (e.g., FSC-PHY-101)
    protected $fillable = [
        'name', 
        'course_code', 
        'description', 
        'teacher_id'
    ];

    /**
     * Relationship: A course belongs to a specific Teacher.
     */
    public function teacher()
    {
        // Linking to the Teacher model instead of User model for better data separation
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Relationship: Many-to-Many with Students.
     * This allows us to see all students enrolled in "FSC Physics".
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments')
                    ->withPivot('enrolled_at')
                    ->withTimestamps();
    }

    /**
     * Relationship: One-to-Many with Attendance.
     * Useful for teachers to view the attendance history of this specific course.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Relationship: A course has many enrollments.
     * Needed for retrieving specific enrollment records (grades, etc).
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}