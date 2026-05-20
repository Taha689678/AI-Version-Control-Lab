<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;

    /**
     * Fields specific to the teacher profile.
     */
    protected $fillable = [
        'user_id',
        'phone',
        'subject',      // Specialized subject (e.g., Physics, Math, English)
        'qualification' // Added for professional record keeping
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Link back to the User account (for Login/Email/Name).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: A teacher can be assigned many courses.
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}