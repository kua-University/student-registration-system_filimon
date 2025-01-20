<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\StudentCourseEnrollment;
use App\Models\TeacherCourseAssignment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function index()
    {
        // Get the authenticated teacher
        $teacher = Auth::user();
        
        // Fetch the assigned course for the teacher
        $course = $teacher->courses->first();

        // Fetch the number of pending enrollment requests for the teacher's course
        $pendingEnrollmentRequests = StudentCourseEnrollment::where('course_id', $course->id)
                                                      ->where('status', 'pending')
                                                      ->count();

        // Fetch the list of enrolled students for the teacher's course
        $enrolledStudents = StudentCourseEnrollment::where('course_id', $course->id)
                                                ->where('status', 'approved' || 'completed')
                                                ->count();

        // Fetch the teacher's grades (assuming GPA is calculated based on grades)
        //$grades = Grade::where('course_id', $course->id)
                       ///->where('teacher_id', $teacher->id)
                       //->get();

        // Calculate the teacher's average GPA (if grades exist)
        $averageGPA = 3.4;

        // Pass the data to the view
        return view('teacher.dashboard', [
            'course' => $course,
            'pendingEnrollmentRequests' => $pendingEnrollmentRequests,
            'enrolledStudents' => $enrolledStudents,
            'averageGPA' => $averageGPA,
        ]);
    }
}
