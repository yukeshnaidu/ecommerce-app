@foreach($subCategories as $key => $subCategory)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $subCategory->name }}</td>
        <td>{{ $subCategory->category->name ?? 'N/A' }}</td>
        <td>{{ $subCategory->parent->name ?? 'N/A' }}</td>
        <td>
            <button class="btn btn-sm btn-info edit-btn" data-id="{{ $subCategory->id }}">Edit</button>
            <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $subCategory->id }}">Delete</button>
        </td>
    </tr>
@endforeach