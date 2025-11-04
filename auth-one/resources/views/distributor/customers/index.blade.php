@extends('master') {{-- Your main layout file (master.blade.php) --}}

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Customer Management (Distributor)</h1> 
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('distributor.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Customers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Customer List</h3>
                    <div class="card-tools">
                        {{-- Add Customer Button: Clicks to the create route --}}
                        <a href="{{ route('distributor.customers.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Add New Customer
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    {{-- Success/Error message display --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Assuming $customers variable is passed from the controller --}}
                            @forelse ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->id }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>
                                        <a href="{{ route('distributor.customers.edit', $customer->id) }}" class="btn btn-sm btn-primary mr-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('distributor.customers.destroy', $customer->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this Customer?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No Customers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection