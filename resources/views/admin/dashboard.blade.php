@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in as an admin!
                    
                    @can('delete')
                        <div class="mt-3">
                            <a href="{{ route('admin.delete-requests') }}" class="btn btn-info">
                                View Delete Requests
                            </a>
                        </div>
                    @endcan 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection