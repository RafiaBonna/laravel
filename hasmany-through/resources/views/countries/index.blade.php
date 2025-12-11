<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> HasManyThrough</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        body { background-color: #f4f6f9; }
        .container { 
            max-width: 800px; 
            margin-top: 40px; 
        }
    </style>
</head>
<body>

<div class="container bg-white shadow-sm border rounded p-4">
    <h1 class="mb-4 text-center text-primary">All Countries and Their Posts (Has Many Through)</h1>
    <p class="text-muted text-center">
        This page demonstrates how to fetch all posts belonging to a Country, 
        passing through the User model. (Country &rarr; User &rarr; Post)
    </p>
    
    <hr class="my-4">

    @foreach ($countries as $country)
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0">Country: {{ $country->name }} (ID: {{ $country->id }})</h3>
            </div>
            <div class="card-body">
                <h5 class="card-title text-secondary">Posts from This Country:</h5>
                
                @forelse ($country->posts as $post)
                    <div class="alert alert-info py-2 my-2 d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $post->title }}</strong>
                        </div>
                        <span class="badge bg-dark">
                            Posted by: {{ $post->user->name ?? 'Unknown User' }}
                        </span>
                    </div>
                @empty
                    <div class="alert alert-warning">
                        No posts found from users in {{ $country->name }}.
                    </div>
                @endforelse
            </div>
        </div>
    @endforeach
    
    <div class="text-center mt-4">
        <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">Go to Post Creation Page</a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>