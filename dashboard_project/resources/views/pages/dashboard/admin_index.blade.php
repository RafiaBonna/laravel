@extends('master')

@section('content')
<section class="content">
    <div class="container-fluid">
        <h1 class="text-center mt-5" style="color: blue;">ADMINISTRATOR DASHBOARD</h1>
        <p class="text-center lead">স্বাগতম, {{ Auth::user()->name }}। আপনি একজন অ্যাডমিন। আপনার পূর্ণ নিয়ন্ত্রণ রয়েছে।</p>
        
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ \App\Models\User::count() }}</h3>
                        <p>Total Users</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            </div>

    </div>
</section>
@endsection