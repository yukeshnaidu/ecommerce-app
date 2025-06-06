@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Sub-Category</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sub-categories.update', $subCategory->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Parent Category:</label>
            <select name="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $cat->id == $subCategory->category_id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Sub-Category Name:</label>
            <input type="text" name="name" value="{{ $subCategory->name }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('sub-categories.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
