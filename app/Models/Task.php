<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status'
    ];

    /**
     * The user (student) assigned to this task.
     */
    /**
     * The user (student) assigned to this task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Logic Enhancements
    |--------------------------------------------------------------------------
    */

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }
}
