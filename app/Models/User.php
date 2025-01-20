<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',  // Automatically cast email_verified_at as a date
            'password' => 'hashed',  // Ensure that password is always treated as hashed
        ];
    }

    /**
     * Get the course assignments for the teacher.
     */
    public function courseAssignments()
    {
        return $this->hasMany(TeacherCourseAssignment::class, 'teacher_id');
    }

    /**
     * Get the courses assigned to the teacher.
     */
    public function courses()
    {
        return $this->hasManyThrough(Course::class, TeacherCourseAssignment::class, 'teacher_id', 'id', 'id', 'course_id');
    }

    /**
     * Get the enrollments for the student.
     */
    public function enrollments()
    {
        return $this->hasMany(StudentCourseEnrollment::class, 'student_id');
    }

    /**
     * Get the payments a student made
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_id');
    }

    /**
     * Get the overall weighted average grade for all courses
     */
    public function getOverallAverageGrade()
    {
        $totalWeightedGrade = 0;
        $totalCredits = 0;
    
        // Get all enrolled courses (approved or completed)
        $enrolledCourses = $this->enrollments()->whereIn('status', ['approved', 'completed'])->with('course')->get();
    
        foreach ($enrolledCourses as $enrollment) {
            $course = $enrollment->course;
    
            // Get the weighted average grade for the student in this course
            $courseAverageGrade = $course->getWeightedAverageGrade($this->id);
    
            if ($courseAverageGrade !== null) {
                // Assuming course has a 'credit' attribute
                $courseCredit = $course->credit;
    
                // Calculate the weighted grade for this course (average grade * credit)
                $totalWeightedGrade += ($courseAverageGrade * $courseCredit);
                $totalCredits += $courseCredit;
            }
        }
    
        // Calculate the overall weighted average grade
        return $totalCredits > 0 ? $totalWeightedGrade / $totalCredits : null;
    }
    

}
