@extends('layouts.app')

@section('content')
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
<div class="container">
    <h2>Create Product</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Category:</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Sub-Category:</label>
            <select name="sub_category_id" id="sub_category_id" class="form-control" required>
                <option value="">Select Sub-Category</option>
            </select>
        </div>

        <div class="form-group">
            <label>Product Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>Price:</label>
            <input type="number" name="price" step="0.01" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Product Image:</label>
            <input type="file" name="image" id="image" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-success">Create</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
@section("scripts")
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script>
    CKEDITOR.replace('description');
    
    document.getElementById('category_id').addEventListener('change', function () {
        let categoryId = this.value;
        console.log(categoryId);
        let subCategoryDropdown = document.getElementById('sub_category_id');

        subCategoryDropdown.innerHTML = '<option value="">Loading...</option>';

        fetch(`/get-subcategories/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                subCategoryDropdown.innerHTML = '<option value="">Select Sub-Category</option>';
                data.forEach(function(subCat) {
                    subCategoryDropdown.innerHTML += `<option value="${subCat.id}">${subCat.name}</option>`;
                });
            });
    });
</script>
@endsection