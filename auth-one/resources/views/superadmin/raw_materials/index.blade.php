@extends('master') 

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">Raw Material Management</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Raw Materials Master List</h3>
                    <div class="card-tools">
                        <a href="{{ route('superadmin.raw_materials.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Add New Material
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
                                <th>Unit</th>
                                <th>Current Stock</th>
                                <th>Alert Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rawMaterials as $material)
                                <tr>
                                    <td>{{ $material->id }}</td>
                                    <td>{{ $material->name }}</td>
                                    <td>{{ $material->unit }}</td>
                                    <td>{{ number_format($material->current_stock, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $material->current_stock <= $material->alert_stock ? 'bg-danger' : 'bg-warning' }}">
                                            {{ number_format($material->alert_stock, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('superadmin.raw_materials.edit', $material->id) }}" class="btn btn-sm btn-primary mr-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('superadmin.raw_materials.destroy', $material->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this Raw Material?');">
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
                                    <td colspan="6" class="text-center">No Raw Materials found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection