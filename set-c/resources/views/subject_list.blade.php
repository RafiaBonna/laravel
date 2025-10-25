<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Many to Many: Subjects and Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="text-center mt-5">
    <h1>Relationship -> Many to Many (Subject & Students)</h1>
    <br>
    <a href="/enroll"> 
      <button class="btn btn-md btn-success"> Create</button>
    </a>
</div>

<div class="container mt-4">
    <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Subject Name (Code)</th>
            <th>Enrolled Students</th>
          </tr>
        </thead>
        <tbody>
            {{-- Controller থেকে $subjects ভ্যারিয়েবলটি আসছে --}}
            @foreach( $subjects as $data)
          <tr class="table-primary">
            <th scope="row">{{ $loop->iteration }}</th>
            {{-- Subject-এর নাম এবং কোড দেখানো --}}
            <td>{{ $data->name}} ({{ $data->code}})</td> 
            <td>
                {{-- এই Subject-এর সাথে সম্পর্কিত সব Student-দের লুপ করা হচ্ছে --}}
                @forelse( $data->students as $student)
                    <span class="badge bg-info text-dark">{{ $student->first_name}} {{ $student->last_name}}</span> 
                @empty
                    No student enrolled.
                @endforelse
            </td>
          </tr>
           @endforeach
        </tbody>
      </table>
</div>
<script src="https://cdn.jsdelivr/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>