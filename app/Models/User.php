<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * Professional setup: Fillable now includes 'verification_code' 
     * to support your specific requirement.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'verification_code', 
        'verification_code_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'verification_code_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Role Helper Methods
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships (Professional Linked Profile Approach)
    |--------------------------------------------------------------------------
    */

    // Direct link to the specialized profiles
    public function teacherProfile()
    {
        return $this->hasOne(Teacher::class);
    }

    public function studentProfile()
    {
        return $this->hasOne(Student::class);
    }

    // Access courses based on role automatically
    public function getMyCoursesAttribute()
    {
        if ($this->isTeacher()) {
            return Course::where('teacher_id', $this->teacherProfile->id)->get();
        }
        
        if ($this->isStudent()) {
            return $this->studentProfile->courses;
        }

        return collect(); // Return empty for Admin
    }

    /**
     * COMSATS Feature: Tasks assigned to this user
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}