<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// --- 1. Enrollment Routes (Data Creation and Manipulation) ---
// এই রুটটি ডেটাবেসে Student, Subject তৈরি করবে এবং তাদের মধ্যে সম্পর্ক (Pivot) স্থাপন করবে।
Route::get('/enroll', [EnrollmentController::class, 'enroll']);

// এই রুটটি নির্দিষ্ট Student-এর জন্য একটি সম্পর্ক (Pivot Entry) ডিলিট করবে।
Route::get('/drop-enrollment', [EnrollmentController::class, 'dropEnrollment']);

// --- 2. Viewing Routes (Data Retrieval) ---

// এই রুটটি EnrollmentController থেকে Eager Loading ব্যবহার করে সব Student এবং তাদের Subject-এর তালিকা JSON আকারে দেখাবে।
Route::get('/view-enrollments', [EnrollmentController::class, 'getEnrollments']);

// এই রুটটি StudentController থেকে সব Subject এবং তাদের এনরোল করা Student-দের তালিকা 
// আপনার blade View (subject_list.blade.php)-তে টেবিল আকারে দেখাবে।
Route::get('/subject-list', [StudentController::class, 'index']);
Route::get('/category/{id}/first-order', [CategoryController::class, 'showFirstOrder']);