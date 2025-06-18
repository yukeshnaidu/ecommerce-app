@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Sub-Categories</h2>

    <div id="alert-container"></div>

    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#subCategoryModal">
        Add Sub-Category
    </button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Sub-Category</th>
                <th>Parent Category</th>
                <th>Parent Sub-Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="subcategory-table-body">
            @include('sub_categories.partials.table_rows', ['subCategories' => $subCategories])
        </tbody>
    </table>

    <!-- Create/Edit Modal -->
    <div class="modal fade" id="subCategoryModal" tabindex="-1" role="dialog" aria-labelledby="subCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subCategoryModalLabel">Add Sub-Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="subCategoryForm">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="subcategory_id" name="subcategory_id">
                        
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="parent_id">Parent Subcategory (optional)</label>
                            <select class="form-control" id="parent_id" name="parent_id">
                                <option value="">None (Top Level Subcategory)</option>
                                @foreach($allSubCategories as $subCat)
                                    <option value="{{ $subCat->id }}">{{ $subCat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Subcategory Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this sub-category?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize variables
    let deleteId;
    let isEdit = false;

    // Show create modal
    $('#subCategoryModal').on('show.bs.modal', function (e) {
        isEdit = false;
        $('#subCategoryModalLabel').text('Add Sub-Category');
        $('#subCategoryForm')[0].reset();
        $('#subcategory_id').val('');
    });
  
    // Show edit modal
    // Show edit modal
$(document).on('click', '.edit-btn', function() {
    isEdit = true;
    let id = $(this).data('id');
    $('#subCategoryModalLabel').text('Edit Sub-Category');
    
    // Add '/admin/' prefix to the URL
    $.ajax({
        url: `/admin/sub-categories/${id}/edit`,
        type: 'GET',
        success: function(data) {
            $('#subcategory_id').val(data.id);
            $('#name').val(data.name);
            $('#category_id').val(data.category_id);
            $('#parent_id').val(data.parent_id);
            $('#subCategoryModal').modal('show');
        },
        error: function(xhr) {
            console.error(xhr);
            showAlert('danger', 'Error loading subcategory data');
        }
    });
});

    // Handle form submission
    $('#subCategoryForm').submit(function(e) {
        e.preventDefault();
        
        let formData = $(this).serialize();
        let url = isEdit ? '/sub-categories/' + $('#subcategory_id').val() : '/sub-categories';
        // let method = isEdit ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#subCategoryModal').modal('hide');
                showAlert('success', response.success);
                refreshTable();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessages = '';
                $.each(errors, function(key, value) {
                    errorMessages += value[0] + '<br>';
                });
                showAlert('danger', errorMessages);
            }
        });
    });

    // Handle delete button click
    $(document).on('click', '.delete-btn', function() {
        deleteId = $(this).data('id');
        $('#deleteModal').modal('show');
    });

    // Confirm delete
    $('#confirmDelete').click(function() {
        $.ajax({
            url: '/sub-categories/' + deleteId,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#deleteModal').modal('hide');
                showAlert('success', response.success);
                refreshTable();
            },
            error: function(xhr) {
                showAlert('danger', 'Error deleting sub-category');
            }
        });
    });

    // Refresh table after CRUD operations
    function refreshTable() {
        $.get('/sub-categories/table', function(data) {
            $('#subcategory-table-body').html(data);
        });
    }

    // Show alert message
    function showAlert(type, message) {
        $('#alert-container').html(
            `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>`
        );
        
        // Auto-hide alert after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    }
});
</script>
@endsection