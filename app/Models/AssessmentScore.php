<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentScore extends Model
{
    /** @use HasFactory<\Database\Factories\AssessmentScoreFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'course_assessment_id',
        'score',
    ];

    /**
     * Get the student associated with the assessment score.
     */
    public function student()
    {
        // Each assessment score belongs to one student (user)
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the course assessment associated with the assessment score.
     */
    public function courseAssessment()
    {
        // Each assessment score belongs to one course assessment
        return $this->belongsTo(CourseAssessment::class, 'course_assessment_id');
    }
}
