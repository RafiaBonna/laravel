@extends('master')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">Edit Supplier: {{ $supplier->name }}</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update Supplier Details</h3>
                        </div>
                        
                        <form action="{{ route('superadmin.suppliers.update', $supplier->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="card-body">
                                
                                <div class="form-group">
                                    <label for="name">Supplier Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $supplier->name) }}" required>
                                    @error('name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Company Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $supplier->email) }}">
                                    @error('email') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>

                                <hr>
                                <h4>Contact Person Details</h4>

                                <div class="form-group">
                                    <label for="contact_name">Contact Person Name</label>
                                    <input type="text" name="contact_name" class="form-control @error('contact_name') is-invalid @enderror" value="{{ old('contact_name', $supplier->contact_name) }}">
                                    @error('contact_name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="contact_email">Contact Person Email</label>
                                    <input type="email" name="contact_email" class="form-control @error('contact_email') is-invalid @enderror" value="{{ old('contact_email', $supplier->contact_email) }}">
                                    @error('contact_email') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>

                            </div>
                            
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update Supplier</button>
                                <a href="{{ route('superadmin.suppliers.index') }}" class="btn btn-default float-right">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection