<!DOCTYPE html>
<html>
<head>
    <title>Students & Courses</title>
</head>
<body>
<h2>Add Student</h2>
<form action="{{ route('students.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Student Name" required>
    <select name="courses[]" multiple>
        @foreach($courses as $course)
            <option value="{{ $course->id }}">{{ $course->name }}</option>
        @endforeach
    </select>
    <button type="submit">Add Student</button>
</form>

<h2>All Students</h2>
<ul>
@foreach($students as $student)
    <li>
        {{ $student->name }} -
        Courses: 
        @foreach($student->courses as $course)
            {{ $course->name }},
        @endforeach
    </li>
@endforeach
</ul>
</body>
</html>
