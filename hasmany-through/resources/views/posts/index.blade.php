<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts & HasManyThrough Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        body { background-color: #f8f9fa; }
        .container { 
            max-width: 900px; 
            margin-top: 30px; 
            margin-bottom: 30px; 
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container bg-white shadow-sm border rounded">
    
    <div class="my-4 p-4 border rounded">
        <h2 class="mb-4 text-primary">Create New Post</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf
            
            <div class="mb-3">
                <label for="user_id" class="form-label">Select User (Intermediate Model):</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <option value="">Select User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} (ID: {{ $user->id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Post Title:</label>
                <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}">
            </div>

            <div class="mb-4">
                <label for="body" class="form-label">Post Content:</label>
                <textarea name="body" id="body" class="form-control" rows="3" required>{{ old('body') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit Post</button>
        </form>
    </div>

    <hr class="my-5">

    <div class="my-4">
        <h2 class="mb-4 text-secondary">All Posts (Has Many Through Demo)</h2>
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Posted By (User)</th>
                        <th scope="col">User's Country</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <th scope="row">{{ $post->id }}</th>
                            <td>{{ $post->title }}</td>
                            
                            <td>{{ $post->user->name ?? 'N/A' }}</td> 
                            
                            <td>
                                @if ($post->user && $post->user->country)
                                    <span class="badge bg-success">{{ $post->user->country->name }}</span>
                                @else
                                    <span class="badge bg-danger">Not Assigned</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No posts found. Create one above!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>