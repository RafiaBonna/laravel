<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('courses')->get();
        $courses = Course::all();
        return view('students.index', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $student = Student::create(['name' => $request->name]);
        $student->courses()->attach($request->courses);
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        $student->update(['name' => $request->name]);
        $student->courses()->sync($request->courses);
        return redirect()->back();
    }
}

