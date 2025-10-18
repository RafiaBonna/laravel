@extends('master')

@section('content')
<section class="content">
    <div class="container-fluid">
        <h1 class="text-center mt-5" style="color: orange;">DEPO DASHBOARD</h1>
        <p class="text-center lead">স্বাগতম, {{ Auth::user()->name }}। আপনি একজন ডিপো কর্মচারী। আপনার ইনভেন্টরি দেখুন।</p>
        
        </div>
</section>
@endsection