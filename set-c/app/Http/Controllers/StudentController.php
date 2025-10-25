<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject; 
use App\Models\Student; 

class StudentController extends Controller
{
   public function index () 
   {
        // Eager Loading এর মাধ্যমে সব Subject এবং তাদের Student-দের Fetch করা
        $subjects = Subject::with('students')->get();
        
        // $subjects ভ্যারিয়েবলটি 'subject_list' view-তে পাঠানো
        return view('subject_list', compact('subjects'));
   }
}