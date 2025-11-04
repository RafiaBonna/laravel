@extends('master') 

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">Supplier Management</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Supplier List</h3>
                    <div class="card-tools">
                        <a href="{{ route('superadmin.suppliers.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Add New Supplier
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-0">
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
                                <th>Email</th>
                                <th>Contact Person</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($suppliers as $supplier)
                                <tr>
                                    <td>{{ $supplier->id }}</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>{{ $supplier->contact_name }} ({{ $supplier->contact_email }})</td>
                                    <td>
                                        <a href="{{ route('superadmin.suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-primary mr-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('superadmin.suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this Supplier?');">
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
                                    <td colspan="5" class="text-center">No Suppliers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection