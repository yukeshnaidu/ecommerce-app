@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Product</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Category:</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $cat->id == $product->category_id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Sub-Category:</label>
            <select name="sub_category_id" id="sub_category_id" class="form-control" required>
                <option value="">Select Sub-Category</option>
                @foreach ($product->category->subCategories ?? [] as $subCategory)
                    <option value="{{ $subCategory->id }}"
                        {{ $product->sub_category_id == $subCategory->id ? 'selected' : '' }}>
                        {{ $subCategory->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Product Name:</label>
            <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label>Price:</label>
            <input type="number" name="price" step="0.01" value="{{ $product->price }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Current Image:</label>
            @if($product->image)
                <img src="{{ asset('product_images/'.$product->image) }}" width="100" class="d-block mb-2">
            @else
                <p>No image uploaded</p>
            @endif
            <label>Update Image:</label>
            <input type="file" name="image" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
    
    document.addEventListener('DOMContentLoaded', function () {
        const categorySelect = document.getElementById('category_id');
        const subCategorySelect = document.getElementById('sub_category_id');

        categorySelect.addEventListener('change', function () {
            const categoryId = this.value;
            subCategorySelect.innerHTML = '<option value="">Loading...</option>';

            if (categoryId) {
                fetch(`/get-subcategories/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
                        data.forEach(subCategory => {
                            const option = document.createElement('option');
                            option.value = subCategory.id;
                            option.text = subCategory.name;
                            subCategorySelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        subCategorySelect.innerHTML = '<option value="">Error loading</option>';
                        console.error(error);
                    });
            } else {
                subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
            }
        });
    });
</script>
@endsection