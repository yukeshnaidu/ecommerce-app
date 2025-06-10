@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Permission Management</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Permissions</h4>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#permissionModal">
                        <i class="fas fa-plus"></i> Add Permission
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="permissionsTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm edit-permission" data-id="{{ $permission->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-permission" data-id="{{ $permission->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.role-permission.modals.permission')
@endsection
@section('scripts')

<script>
$(document).ready(function() { 


    // Global AJAX setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

      $('#permissionForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = $(this).serialize();
        let permissionId = $('#permissionId').val();
         console.log("permissionId-".permissionId);
        $.ajax({
            url: permissionId ? '/admin/permissions/update/' + permissionId : '/admin/permissions/store',
            type: 'POST', 
            data: formData,
            success: function(response) {
                $('#permissionModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                let errorMsg = xhr.responseJSON?.message || 'Failed to save permission';
                alert('Error: ' + errorMsg);
            }
        });
    });

     $(document).on('click', '.edit-permission', function() {
        let permissionId = $(this).data('id');
         console.log("editpermissionId-".permissionId);
        $.ajax({
            url: '/admin/permissions/get/' + permissionId,
            type: 'GET',
            success: function(data) {
                $('#permissionModalLabel').text('Edit Permission');
                $('#permissionId').val(data.id);
                $('#permissionName').val(data.name);
                $('#permissionSlug').val(data.slug);
                $('#permissionDescription').val(data.description);
                
                $('#permissionModal').modal('show');
            },
            error: function(xhr) {
                alert('Error loading permission data');
            }
        });
    });

     $(document).on('click', '.delete-permission', function() {
        if(confirm('Are you sure you want to delete this permission?')) {
            let permissionId = $(this).data('id');
            $.ajax({
                url: '/admin/permissions/delete/' + permissionId,
                type: 'POST',
                success: function() {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error deleting permission: ' + (xhr.responseJSON?.message || 'Unknown error'));
                }
            });
        }
    });

    $('#permissionModal').on('hidden.bs.modal', function() {
        $('#permissionModalLabel').text('Add New Permission');
        $('#permissionForm')[0].reset();
        $('#permissionId').val('');
    });

    // Permission form submission and other permission-specific JS here
    // (Copy the relevant parts from your original script)
});
</script>
@endsection