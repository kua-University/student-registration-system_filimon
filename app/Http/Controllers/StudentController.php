<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudentCourseEnrollment;
use App\Models\CourseAssessment;
use App\Models\Payment;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Show the student dashboard.
     */
    public function index()
    {
        // Get the logged-in student
        $student = auth()->user();

        // Get enrolled courses
        $enrolledCourses = $student->enrollments()->whereIn('status', ['approved', 'completed'])->with('course')->get();

        // Calculate the overall average grade for all courses
        $overallAverageGrade = $student->getOverallAverageGrade();

        // Get available courses
        $availableCourses = Course::whereNotIn('id', $enrolledCourses->pluck('course_id'))->get();

        // Return view with the necessary data
        return view('student.dashboard', [
            'student' => $student,
            'enrolledCourses' => $enrolledCourses,
            'availableCourses' => $availableCourses,
            'averageGrade' => $overallAverageGrade,
        ]);
    }

    public function enrolledCourses()
    {
        // Get the logged-in student
        $student = auth()->user();
    
        // Get the student's enrollments (approved or completed)
        $enrolledCourses = $student->enrollments()->whereIn('status', ['approved', 'completed'])->with('course')->get();
    
        // Return the view with the necessary data
        return view('student.enrolled-courses', [
            'enrolledCourses' => $enrolledCourses
        ]);
    }

    // Controller method to fetch available courses for the student
    public function availableCourses()
    {
        // Get the logged-in student
        $student = auth()->user();

        // Retrieve all courses that the student is not enrolled in and eager load courseFee
        $availableCourses = Course::with('courseFee')
            ->whereNotIn('id', $student->enrollments()->pluck('course_id')) // Exclude enrolled courses
            ->get();

        // Pass the available courses to the view
        return view('student.available-courses', compact('availableCourses'));
    }

    
    public function enrollInCourse($courseId)
    {
        $student = auth()->user();
        
        // Check if the student is already enrolled in the course
        $existingEnrollment = $student->enrollments()->where('course_id', $courseId)->first();
        
        if ($existingEnrollment) {
            return back()->with('error', 'You are already enrolled in this course.');
        }
    
        // Retrieve the course fee
        $course = Course::with('courseFee')->findOrFail($courseId);
    
        // Redirect to the payment page (where Stripe or other payment methods can be processed)
        return redirect()->route('student.course.payment', ['course' => $courseId]);
    }

    // Show the profile edit form
    public function editProfile()
    {
        // Get the currently authenticated student
        $student = auth()->user();

        return view('student.edit-profile', compact('student'));
    }

    // Handle the profile update
    public function updateProfile(Request $request)
    {
        $student = auth()->user();

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update the student's name and email
        $student->name = $request->input('name');
        $student->email = $request->input('email');

        // If a new password is provided, update it
        if ($request->filled('password')) {
            $student->password = Hash::make($request->input('password'));
        }

        // Save the changes to the student's profile
        $student->save();

        return redirect()->route('student.dashboard')->with('success', 'Profile updated successfully.');
    }
    
    
    
}
