<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
        'category',
        'credits',
        'description',
    ];

    /**
     * Get the enrollments associated with the course.
     */
    public function enrollments()
    {
        // A course can have many enrollments (StudentCourseEnrollments)
        return $this->hasMany(StudentCourseEnrollment::class, 'course_id');
    }

    /**
     * Get the assessments associated with the course.
     */
    public function assessments()
    {
        // A course can have many assessments (CourseAssessments)
        return $this->hasMany(CourseAssessment::class);
    }

    /**
     * Get the course assignments for the course.
     */
    public function teacherAssignments()
    {
        return $this->hasMany(TeacherCourseAssignment::class, 'course_id');
    }

    /**
     * Get the teachers assigned to the course.
     */
    public function teachers()
    {
        return $this->hasManyThrough(User::class, TeacherCourseAssignment::class, 'course_id', 'id', 'id', 'teacher_id');
    }

    /**
     * Get the course fees associated with the course.
     */
    public function courseFee()
    {
        // A course can has one course fees (CourseFee)
        return $this->hasOne(CourseFee::class);
    }

    /**
     * Get the payments associated with the course.
     */
    public function payments()
    {
        // A course can have many payments (Payment)
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the average grade for this course for a specific student
     * Calculated using the assessment scores and their weights
     */
    public function getAverageGradeForStudent($studentId)
    {
        // Ensure the course is loaded properly
        if (!$this->course) {
            return null;  // Return null if the course is not found
        }
        
        // Get all assessments for the course, or return an empty collection if there are none
        $courseAssessments = $this->assessments;
        
        // Check if the course has no assessments
        if ($courseAssessments->isEmpty()) {
            return null; // No assessments available
        }
        
        $totalWeightedScore = 0;
        $totalMaxScore = 0;
        
        foreach ($courseAssessments as $assessment) {
            // Get the student's score for this assessment
            $assessmentScore = $assessment->scores()->where('student_id', $studentId)->first();
        
            // If the student has a score for this assessment
            if ($assessmentScore) {
                // Weighted score = student's score / max score * weight
                $totalWeightedScore += ($assessmentScore->score / $assessment->max_score) * $assessment->weight;
                $totalMaxScore += $assessment->weight;
            }
        }
        
        // If there were no valid assessments with scores, return null or a default value
        if ($totalMaxScore === 0) {
            return null; // Or return 0 or any other default value
        }
        
        // Return the weighted average grade as a percentage
        return $totalMaxScore > 0 ? $totalWeightedScore * 100 : null; // Return percentage
    }
    
    
    

    /**
     * Get the completion percentage for a student in this course.
     */
    public function getCompletionPercentageForStudent($student)
    {
        // Get all assessments for this course
        $assessments = $this->assessments;

        $completedAssessments = 0;
        $totalAssessments = count($assessments);

        // Check how many assessments the student has scores for
        foreach ($assessments as $assessment) {
            $score = AssessmentScore::where('student_id', $student->id)
                ->where('assessment_id', $assessment->id)
                ->first();

            if ($score) {
                $completedAssessments++;
            }
        }

        // Return the completion percentage
        return $totalAssessments > 0 ? ($completedAssessments / $totalAssessments) * 100 : 0;
    }

    /**
     * Get the weighted average grade for a specific course
     * considering all assessments and their weights
     */
    public function getWeightedAverageGrade($studentId)
    {
        // Get the student's enrollment for this course (approved or completed)
        $enrollment = $this->enrollments()->where('student_id', $studentId)->whereIn('status', ['approved', 'completed'])->first();
    
        if ($enrollment) {
            // Use the enrollment's method to calculate the student's grade in this course
            return $enrollment->getAverageGradeForStudent($studentId);
        }
    
        return null;
    }
    

}
