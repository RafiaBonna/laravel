@extends('master') {{-- Your main layout file (master.blade.php) --}}

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Add New Customer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('distributor.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('distributor.customers.index') }}">Customers</a></li>
                        <li class="breadcrumb-item active">Add Customer</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Customer Details</h3>
                        </div>
                        
                        {{-- Target: Distributor\CustomerController.php store() method --}}
                        <form action="{{ route('distributor.customers.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                
                                {{-- Customer Name Field (Required) --}}
                                <div class="form-group">
                                    <label for="name">Customer Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                {{-- Phone Number Field (Required) --}}
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                
                                {{-- NOTE: distributor_id is automatically set in the Controller --}}

                            </div>
                            
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Create Customer</button>
                                <a href="{{ route('distributor.customers.index') }}" class="btn btn-default float-right">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection