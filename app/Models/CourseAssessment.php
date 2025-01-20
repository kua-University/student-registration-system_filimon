<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAssessment extends Model
{
    /** @use HasFactory<\Database\Factories\CourseAssessmentFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'course_id',
        'assessment_name',
        'max_score',
        'weight',
    ];

    /**
     * Get the course associated with the course assessment.
     */
    public function course()
    {
        // Each course assessment belongs to one course
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Get the scores associated with the course assessment.
     */
    public function scores()
    {
        // A course assessment can have many scores (AssessmentScore)
        return $this->hasMany(AssessmentScore::class);
    }
}
