@extends('master')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Depot Master List</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('depot.create') }}" class="btn btn-dark">
                    <i class="fas fa-plus"></i> Add New Depot
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
                        <h3 class="card-title">All Registered Depots</h3>
                    </div>
                    
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Manager Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($depots as $depot)
                                <tr>
                                    <td>{{ $depot->id }}</td>
                                    <td>{{ $depot->name }}</td>
                                    <td>{{ $depot->address ?? 'N/A' }}</td>
                                    <td>{{ $depot->manager_name ?? 'N/A' }}</td>
                                    <td>
                                        <div class="d-flex">
                                            {{-- Edit Button --}}
                                            <a href="{{ route('depot.edit', $depot->id) }}" class="btn btn-sm btn-info" style="margin-right: 10px;">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            {{-- Delete Form --}}
                                            <form action="{{ route('depot.destroy', $depot->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete {{ $depot->name }}?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No depots found.</td>
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