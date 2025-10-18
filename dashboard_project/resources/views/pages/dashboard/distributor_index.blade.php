@extends('master')

@section('content')
<section class="content">
    <div class="container-fluid">
        <h1 class="text-center mt-5" style="color: green;">DISTRIBUTOR DASHBOARD</h1>
        <p class="text-center lead">স্বাগতম, {{ Auth::user()->name }}। আপনি একজন ডিস্ট্রিবিউটর। আপনার অর্ডারগুলো দেখুন।</p>
        
        </div>
</section>
@endsection