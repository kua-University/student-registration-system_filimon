<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherCourseAssignment extends Model
{
    /** @use HasFactory<\Database\Factories\TeacherCourseAssignmentFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'teacher_id',
        'course_id',
    ];

    /**
     * Get the teacher associated with the course assignment.
     */
    public function teacher()
    {
        // A course assignment belongs to one teacher (User)
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the course associated with the course assignment.
     */
    public function course()
    {
        // A course assignment belongs to one course
        return $this->belongsTo(Course::class, 'course_id');
    }
}
