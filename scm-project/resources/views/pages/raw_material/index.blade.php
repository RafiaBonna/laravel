@extends('master')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Raw Materials Master List</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('raw_material.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Material
                </a>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                
                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Registered Materials</h3>
                    </div>
                    
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 5%">ID</th>
                                    <th>Name</th>
                                    <th>Unit</th>
                                    <th>Current Stock</th>
                                    <th>Alert Stock</th>
                                    <th style="width: 15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($materials as $material)
                                <tr>
                                    <td>{{ $material->id }}</td>
                                    <td>{{ $material->name }}</td>
                                    <td><span class="badge badge-info">{{ $material->unit }}</span></td>
                                    
                                    {{-- Stock Status with color --}}
                                    <td>
                                        @if($material->current_stock <= $material->alert_stock)
                                            <span class="badge badge-danger">{{ $material->current_stock }}</span>
                                        @else
                                            <span class="badge badge-success">{{ $material->current_stock }}</span>
                                        @endif
                                    </td>
                                    
                                    <td>{{ $material->alert_stock }}</td>
                                    
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            {{-- Edit Button --}}
                                            <a href="{{ route('raw_material.edit', $material->id) }}" class="btn btn-info">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            
                                            {{-- Delete Form --}}
                                            <form action="{{ route('raw_material.destroy', $material->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete {{ $material->name }}?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No raw materials found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection