<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'assessment_name', // e.g., "Midterm", "FSC Mock Exam"
        'score',
        'max_score',
        'feedback'
    ];

    /**
     * Relationship: A grade belongs to a specific student enrollment.
     */
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    /**
     * Get the flexible grading scale. 
     * In the future, this can be moved to config('academy.grading_scale').
     */
    public static function getGradingScale(): array
    {
        return [
            ['min' => 85, 'grade' => 'A+', 'gpa' => 4.0, 'remark' => 'Excellent performance! Keep it up.'],
            ['min' => 80, 'grade' => 'A',  'gpa' => 3.7, 'remark' => 'Very good work.'],
            ['min' => 70, 'grade' => 'B',  'gpa' => 3.0, 'remark' => 'Good effort, but room for improvement.'],
            ['min' => 60, 'grade' => 'C',  'gpa' => 2.0, 'remark' => 'Average performance. Needs more focus.'],
            ['min' => 50, 'grade' => 'D',  'gpa' => 1.0, 'remark' => 'Below average. Please work harder.'],
            ['min' => 0,  'grade' => 'F',  'gpa' => 0.0, 'remark' => 'Failed. Immediate attention required.'],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Booting Methods
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::saving(function ($grade) {
            // Ensure no negative values
            $grade->score = max(0, (float) $grade->score);
            $grade->max_score = max(0, (float) $grade->max_score);
            
            // Prevent invalid scores where score > max_score
            if ($grade->max_score > 0 && $grade->score > $grade->max_score) {
                throw new \InvalidArgumentException("Score ({$grade->score}) cannot exceed maximum score ({$grade->max_score}).");
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Logic Enhancements
    |--------------------------------------------------------------------------
    */

    /**
     * Get the percentage for the grade.
     */
    public function getPercentageAttribute(): float
    {
        if (empty($this->max_score) || $this->max_score <= 0) {
            return 0.0; // Prevent division by zero
        }
        
        $score = max(0, min((float)$this->score, (float)$this->max_score));
        return round(($score / $this->max_score) * 100, 2);
    }

    /**
     * Helper to retrieve grade details based on percentage.
     */
    protected function getGradeData(string $key)
    {
        $percentage = $this->percentage;
        foreach (self::getGradingScale() as $scale) {
            if ($percentage >= $scale['min']) {
                return $scale[$key] ?? null;
            }
        }
        return null;
    }

    /**
     * Determine a letter grade based on the score.
     */
    public function getLetterGradeAttribute(): string
    {
        return $this->getGradeData('grade') ?? 'N/A';
    }

    /**
     * Get GPA based on the score.
     */
    public function getGpaAttribute(): float
    {
        return (float) $this->getGradeData('gpa') ?? 0.0;
    }

    /**
     * Get smart remarks based on performance.
     */
    public function getSmartRemarkAttribute(): string
    {
        return $this->getGradeData('remark') ?? 'No remarks available.';
    }

    /**
     * Check if the student has passed.
     */
    public function getIsPassedAttribute(): bool
    {
        // 50% is the default passing criteria, can be changed as needed.
        return $this->percentage >= 50.0;
    }
}