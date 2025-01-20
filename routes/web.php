<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PaymentController;

// Public Pages Route Group
Route::controller(PageController::class)->group(function () {
    // Index (Homepage)
    Route::get('/', 'index')->name('home');
    
    // Privacy Policy
    Route::get('/privacy-policy', 'privacyPolicy')->name('privacy-policy');
    
    // Terms and Conditions
    Route::get('/terms-and-conditions', 'termsAndConditions')->name('terms-and-conditions');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Payment Routes
Route::get('/register-payment', [PaymentController::class, 'showRegistrationPaymentForm'])->name('show.registration.payment');
Route::post('/process-registration-payment', [PaymentController::class, 'processRegistrationPayment'])->name('process.registration.payment');
Route::get('/receipt/{paymentId}', [PaymentController::class, 'showReceipt'])->name('receipt.show');
Route::get('/receipt/{receiptId}/download', [PaymentController::class, 'downloadReceipt'])->name('receipt.download');


// Admin routes
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Courses
    Route::get('/admin/courses', [AdminController::class, 'showCourses'])->name('admin.courses');
    Route::get('/admin/create-course', [AdminController::class, 'createCourse'])->name('admin.create-course');
    Route::post('/admin/store-course', [AdminController::class, 'storeCourse'])->name('admin.store-course');
    Route::get('/admin/edit-course/{id}', [AdminController::class, 'editCourse'])->name('admin.edit-course');
    Route::post('/admin/update-course/{id}', [AdminController::class, 'updateCourse'])->name('admin.update-course');
    Route::get('/admin/destroy-course/{id}', [AdminController::class, 'destroyCourse'])->name('admin.destroy-course');
    Route::post('/admin/delete-course/{id}', [AdminController::class, 'deleteCourse'])->name('admin.delete-course');

    // Teachers
    Route::get('/admin/teachers', [AdminController::class, 'showTeachers'])->name('admin.teachers');
    Route::get('/admin/create-teacher', [AdminController::class, 'createTeacher'])->name('admin.create-teacher');
    Route::post('/admin/store-teacher', [AdminController::class, 'storeTeacher'])->name('admin.store-teacher');
    Route::get('/admin/edit-teacher/{id}', [AdminController::class, 'editTeacher'])->name('admin.edit-teacher');
    Route::put('/admin/update-teacher/{id}', [AdminController::class, 'updateTeacher'])->name('admin.update-teacher');
    Route::get('/admin/destroy-teacher/{id}', [AdminController::class, 'destroyTeacher'])->name('admin.destroy-teacher');
    Route::post('/admin/delete-teacher/{id}', [AdminController::class, 'deleteTeacher'])->name('admin.delete-teacher');

    // Students
    Route::get('/admin/students', [AdminController::class, 'showStudents'])->name('admin.students');

    // Revenue
    Route::get('/admin/revenue', [AdminController::class, 'showRevenue'])->name('admin.revenue');
    Route::get('admin/update-registration-fee', [AdminController::class, 'showRegistrationFeeForm'])->name('admin.update-registration-fee');
    Route::post('admin/update-registration-fee', [AdminController::class, 'updateRegistrationFee'])->name('admin.update-registration-fee.store');

});


// Teacher routes
Route::middleware('auth')->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');
});

// Student routes
Route::middleware('auth')->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
    Route::get('/student/edit-profile', [StudentController::class, 'editProfile'])->name('student.edit-profile');
    Route::put('/student/update-profile', [StudentController::class, 'updateProfile'])->name('student.update-profile');
    Route::get('/student/enrolled-courses', [StudentController::class, 'enrolledCourses'])->name('student.enrolled-courses');
    Route::get('/student/available-courses', [StudentController::class, 'availableCourses'])->name('student.available-courses');
    Route::post('/student/enroll/{courseId}', [StudentController::class, 'enrollInCourse'])->name('student.enroll');
    Route::get('/student/course/{course}/payment', [PaymentController::class, 'showCoursePaymentForm'])->name('student.course.payment');
    Route::post('/student/course/{course}/payment', [PaymentController::class, 'processCoursePayment'])->name('process.course.payment');

});

