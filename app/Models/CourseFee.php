<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseFee extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFeeFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'course_id',
        'amount',
    ];

    /**
     * Get the course associated with the course fee.
     */
    public function course()
    {
        // Each course fee belongs to one course
        return $this->belongsTo(Course::class);
    }
}
