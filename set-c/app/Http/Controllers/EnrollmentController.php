<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * নতুন Student এবং Subject তৈরি করে তাদের মধ্যে সম্পর্ক স্থাপন (Attach/Sync) করে।
     */
    public function enroll()
    {
        // 1. নতুন Student তৈরি করা
        $student1 = Student::firstOrCreate([
            'first_name' => 'Aditya',
            'last_name' => 'Roy'
        ]);

        $student2 = Student::firstOrCreate([
            'first_name' => 'Sujata',
            'last_name' => 'Das'
        ]);

        // 2. নতুন Subject তৈরি করা
        $math = Subject::firstOrCreate(['name' => 'Higher Math', 'code' => 'MATH301']);
        $chem = Subject::firstOrCreate(['name' => 'Chemistry', 'code' => 'CHEM302']);
        $bio = Subject::firstOrCreate(['name' => 'Biology', 'code' => 'BIO303']);

        
        // 3. Many-to-Many সম্পর্ক স্থাপন
        
        // **পরিবর্তন: attach() এর পরিবর্তে sync() ব্যবহার করা হলো ডুপ্লিকেট এরর এড়াতে।**
        $student1->subjects()->sync([$math->id, $chem->id]); 
        
        // Student 2 এর জন্য sync() আগে থেকেই ঠিক ছিল।
        $student2->subjects()->sync([$bio->id, $math->id]);

        return response()->json([
            'message' => 'Enrollment successful!',
            'student1_subjects' => $student1->subjects()->pluck('name'),
            'student2_subjects' => $student2->subjects()->pluck('name'),
        ]);
    }

    /**
     * Student-দের এবং তাদের Subject-গুলোকে Eager Loading-এর মাধ্যমে Fetch করে।
     */
    public function getEnrollments()
    {
        // N+1 query সমস্যা এড়াতে with('subjects') ব্যবহার করা হলো (Eager Loading)
        $students = Student::with('subjects')->get();

        return response()->json($students);
    }

    /**
     * একটি নির্দিষ্ট সম্পর্ক (Pivot Entry) ডিলিট করা।
     */
    public function dropEnrollment()
    {
        $studentId = 1; 
        $subjectIdToRemove = 3; 

        $student = Student::find($studentId);
        if ($student) {
            $student->subjects()->detach($subjectIdToRemove);

            return response()->json([
                'message' => 'Subject detached successfully from student ' . $studentId
            ]);
        }
        
        return response()->json(['message' => 'Student not found.'], 404);
    }
}