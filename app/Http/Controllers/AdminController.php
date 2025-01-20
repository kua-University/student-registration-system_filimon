<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Course;
use App\Models\CourseFee;
use App\Models\User;
use App\Models\Payment;
use App\Models\RegistrationFee;
use App\Models\StudentCourseEnrollment;
use App\Models\TeacherCourseAssignment;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        // Get total number of courses
        $totalCourses = Course::count();

        // Get total number of teachers (role = 'teacher')
        $totalTeachers = User::where('role', 'teacher')->count();

        // Get total number of students (role = 'student')
        $totalStudents = User::where('role', 'student')->count();

        // Get total revenue (sum of the 'amount' field from the payments table)
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');

        // Pass the data to the view
        return view('admin.dashboard', [
            'totalCourses' => $totalCourses,
            'totalTeachers' => $totalTeachers,
            'totalStudents' => $totalStudents,
            'totalRevenue' => $totalRevenue,
        ]);
    }

    /**
     * Show all courses
     */
    public function showCourses()
    {
        // Retrieve all courses with their associated fees (eager load courseFee)
        $courses = Course::with('courseFee')->get();

        // Pass courses data to the view
        return view('admin.courses', compact('courses'));
    }

    /**
     * Show the create course form.
     */
    public function createCourse()
    {
        return view('admin.create-course');
    }

    /**
     * Store a newly created course.
     */
    public function storeCourse(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10',
            'category' => 'required|string|max:100',
            'credits' => 'required|integer|min:1',
            'description' => 'required|string',
            'fee' => 'required|numeric|min:0',
        ]);

        // Store the course
        $course = Course::create([
            'name' => $request->name,
            'code' => $request->code,
            'category' => $request->category,
            'credits' => $request->credits,
            'description' => $request->description,
        ]);

        // Store the fee for the course
        CourseFee::create([
            'course_id' => $course->id,
            'amount' => $request->fee,
        ]);

        return redirect()->route('admin.courses')->with('success', 'Course created successfully!');
    }

    /**
     * Show the edit course form.
     */
    public function editCourse($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.edit-course', compact('course'));
    }

    /**
     * Update the course.
     */
    public function updateCourse(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10',
            'category' => 'required|string|max:100',
            'credits' => 'required|integer|min:1',
            'description' => 'required|string',
            'fee' => 'required|numeric|min:0',
        ]);

        // Find the course
        $course = Course::findOrFail($id);

        // Update course details
        $course->update([
            'name' => $request->name,
            'code' => $request->code,
            'category' => $request->category,
            'credits' => $request->credits,
            'description' => $request->description,
        ]);

        // Check if fee is provided and create/update the course fee
        if ($request->has('fee') && $request->fee !== null) {
            $courseFee = $course->courseFee;

            if ($courseFee) {
                $courseFee->update([
                    'amount' => $request->fee,
                ]);
            } else {
                CourseFee::create([
                    'course_id' => $course->id,
                    'amount' => $request->fee,
                ]);
            }
        }

        return redirect()->route('admin.courses')->with('success', 'Course updated successfully!');
    }

    /**
     * Show the confirmation form for course deletion.
     */
    public function destroyCourse($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.confirm-delete-course', compact('course'));
    }

    /**
     * Delete the course.
     */
    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.courses')->with('success', 'Course deleted successfully!');
    }

    /**
     * Show all teachers with the courses they are assigned to.
     */
    public function showTeachers()
    {
        // Retrieve all teachers and their courses
        $teachers = User::where('role', 'teacher')->with('courses')->get();
        
        // Pass data to the view
        return view('admin.teachers', compact('teachers'));
    }

    /**
     * Show the form for creating a new teacher.
     */
    public function createTeacher()
    {
        $unassignedCourses = Course::doesntHave('teacherAssignments')->get(); // Get courses without a teacher assigned
        return view('admin.create-teacher', compact('unassignedCourses'));
    }


    /**
     * Store a newly created teacher in storage.
     */
    public function storeTeacher(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'course_id' => 'required|exists:courses,id',  // Make sure the course ID exists in the courses table
        ]);
    
        // Create the teacher
        $teacher = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
        ]);
    
        // Assign the selected course to the teacher
        TeacherCourseAssignment::create([
            'teacher_id' => $teacher->id,
            'course_id' => $request->course_id,
        ]);
    
        return redirect()->route('admin.teachers')->with('success', 'Teacher created and course assigned successfully!');
    }
      

    /**
     * Show the form for editing the specified teacher.
     */
    public function editTeacher($id)
    {
        $teacher = User::findOrFail($id);
        $courses = Course::doesntHave('teacherAssignments')->get()->merge($teacher->courses);
        
        return view('admin.edit-teacher', compact('teacher', 'courses'));
    }

    /**
     * Update the specified teacher in storage.
     */
    public function updateTeacher(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'course_id' => 'required|exists:courses,id',
        ]);
    
        // Find the teacher and update details
        $teacher = User::findOrFail($id);
        $teacher->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
    
        // Remove old course assignments and add new ones
        TeacherCourseAssignment::where('teacher_id', $teacher->id)->delete(); // Remove existing assignments
    
        TeacherCourseAssignment::create([
                'teacher_id' => $teacher->id,
                'course_id' => $request->course_id,
        ]);
    
        return redirect()->route('admin.teachers')->with('success', 'Teacher details and course assignments updated successfully!');
    }

    /**
     * Show the confirmation page for teacher deletion.
     */
    public function destroyTeacher($id)
    {
        $teacher = User::findOrFail($id);
        $courses = Course::all();
        $assignedCourses = $teacher->courses; // Get courses already assigned
    
        return view('admin.confirm-delete-teacher', compact('teacher', 'assignedCourses'));
    }

    /**
     * Delete the teacher after confirmation.
     */
    public function deleteTeacher(Request $request, $id)
    {
        $teacher = User::findOrFail($id);
        
        // Delete course assignments first
        TeacherCourseAssignment::where('teacher_id', $teacher->id)->delete();
    
        // Now delete the teacher
        $teacher->delete();
    
        return redirect()->route('admin.teachers')->with('success', 'Teacher and their course assignments deleted successfully!');
    }

    /**
     * Show all the students with approved/completed courses and completed payments
     */
    public function showStudents()
    {
        $students = User::where('role', 'student')
            ->with([
                'enrollments' => function($query) {
                    $query->whereIn('status', ['approved', 'completed']);
                },
                'enrollments.course',  // Eager load the related courses
                'payments' => function($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->get();
    
        return view('admin.students', compact('students'));
    }

    /**
     * Show the revenue page
     */
    public function showRevenue()
    {
        // Total Course Payments
        $totalCoursePayments = Payment::where('payment_type', 'course_enrollment')
                                       ->where('status', 'completed')
                                       ->sum('amount');
    
        // Total Registration Payments
        $totalRegistrationPayments = Payment::where('payment_type', 'registration')
                                            ->where('status', 'completed')
                                            ->sum('amount');
    
        // Fetch the individual registration payment amount
        $registrationFee = RegistrationFee::first(); // Assuming only one registration fee record
    
        return view('admin.revenue', compact('totalCoursePayments', 'totalRegistrationPayments', 'registrationFee'));
    }
    
    /**
     * Show the registration fee form
     */
    public function showRegistrationFeeForm()
    {
        // Get the current registration fee
        $registrationFee = RegistrationFee::first(); // Assuming you have only one entry for the registration fee
        return view('admin.update-registration-fee', compact('registrationFee'));
    }    

    /**
     * Update the registration fee
     */
    public function updateRegistrationFee(Request $request)
    {
        // Validate the new registration fee
        $request->validate([
            'registration_fee' => 'required|numeric|min:0',
        ]);
    
        // Update the registration fee
        $registrationFee = RegistrationFee::first(); // Assuming you have only one entry
        $registrationFee->amount = $request->registration_fee;
        $registrationFee->save();
    
        return redirect()->route('admin.revenue')->with('success', 'Registration Fee updated successfully!');
    }    

}