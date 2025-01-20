<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourseEnrollment extends Model
{
    /** @use HasFactory<\Database\Factories\StudentCourseEnrollmentFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'course_id',
        'status',
    ];

    /**
     * Get the student associated with the enrollment.
     */
    public function student()
    {
        // An enrollment belongs to one student (User)
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the course associated with the enrollment.
     */
    public function course()
    {
        // An enrollment belongs to one course
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Get the average grade for the student in this course.
     */
    public function getAverageGradeForStudent()
    {
        return $this->course->getAverageGradeForStudent($this->student);
    }
    

    /**
     * Get the completion percentage for the student in this course.
     */
    public function getCompletionPercentageForStudent()
    {
        return $this->course->getCompletionPercentageForStudent($this->student);
    }

    

}
