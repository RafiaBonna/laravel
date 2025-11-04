@extends('master') {{-- Change this according to your master layout file --}}

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">Depo Management</h1>
            <a href="{{ route('superadmin.depos.create') }}" class="btn btn-indigo btn-sm mt-2">
                <i class="fas fa-plus-circle"></i> Add New Depo
            </a>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Depots</h3>
                </div>
                <div class="card-body">
                    {{-- Success/Error Message --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    {{-- $depos variable from Depo Controller is used here --}}
                    <table class="table table-bordered table-striped" id="dataTable">
                        <thead>
                            <tr>
                                <th style="width: 10px">ID</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Created At</th>
                                <th style="width: 150px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($depos as $depo)
                                <tr>
                                    <td>{{ $depo->id }}</td>
                                    <td>{{ $depo->name }}</td>
                                    <td>{{ $depo->location }}</td>
                                    <td>{{ $depo->created_at->format('d M, Y') }}</td>
                                    <td>
                                        {{-- Edit functionality is required but not fully implemented in the controller yet --}}
                                        <a href="{{ route('superadmin.depos.edit', $depo) }}" class="btn btn-info btn-sm">Edit</a>
                                        
                                        <form action="{{ route('superadmin.depos.destroy', $depo) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this Depo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No Depots found. Please add a new Depo.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    
    {{-- DataTables Initialization Script (if used in master layout) --}}
    @push('scripts')
        <script>
            // DataTables script initialized here (if DataTables is loaded in your project)
            $(document).ready(function() {
                $('#dataTable').DataTable();
            });
        </script>
    @endpush

@endsection
