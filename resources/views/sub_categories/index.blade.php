@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Sub-Categories</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('sub-categories.create') }}" class="btn btn-primary mb-3">Add Sub-Category</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Sub-Category</th>
                <th>Parent Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subCategories as $key => $subCategory)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $subCategory->name }}</td>
                    <td>{{ $subCategory->category->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('sub-categories.edit', $subCategory->id) }}" class="btn btn-sm btn-info">Edit</a>

                        <form action="{{ route('sub-categories.destroy', $subCategory->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
