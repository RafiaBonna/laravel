@extends('master') 

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Distributor Management (Under Your Depo)</h1> 
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('depo.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Distributors</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Distributor List</h3>
                    <div class="card-tools">
                        {{-- Add Distributor Button --}}
                        <a href="{{ route('depo.users.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Add New Distributor
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
                                <th>Depo ID</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- $users (Distributors) is passed from Depo\UserController@index --}}
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->distributor->depo_id ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('depo.users.edit', $user->id) }}" class="btn btn-sm btn-primary mr-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('depo.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this Distributor? This will delete associated customer records.');">
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
                                    <td colspan="5" class="text-center">No Distributors found under your Depo.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection