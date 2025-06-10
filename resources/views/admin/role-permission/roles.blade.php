@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Role Management</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Roles</h4>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#roleModal">
                        <i class="fas fa-plus"></i> Add Role
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="rolesTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Permissions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @foreach($role->permissions as $permission)
                                        <span class="badge badge-info">{{ $permission->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm edit-role" data-id="{{ $role->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-role" data-id="{{ $role->id }}">
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

@include('admin.role-permission.modals.role')
@endsection
@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        placeholder: "Select permissions",
        allowClear: true,
        dropdownParent: $('#roleModal')
    });

    // Global AJAX setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#roleForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = $(this).serialize();
        let roleId = $('#roleId').val();
        console.log("roleid-".roleId);
        $.ajax({
            url: roleId ? '/admin/roles/update/' + roleId : '/admin/roles/store',
            type: 'POST', 
            data: formData,
            success: function(response) {
                $('#roleModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                let errorMsg = xhr.responseJSON?.message || 'Failed to save role';
                alert('Error: ' + errorMsg);
                console.error(xhr.responseText);
            }
        });
    });


    $(document).on('click', '.edit-role', function() {
        let roleId = $(this).data('id');
        //  console.log(roleId);
        $.ajax({
            url: '/admin/roles/get/' + roleId,
            type: 'GET',
            success: function(data) {
                $('#roleModalLabel').text('Edit Role');
                $('#roleId').val(data.id);
                $('#name').val(data.name);
                $('#slug').val(data.slug);
                $('#description').val(data.description);
                
               
                $('#permissions').val(null).trigger('change');
                let permissionIds = data.permissions.map(p => p.id);
                $('#permissions').val(permissionIds).trigger('change');
                
                $('#roleModal').modal('show');
            },
            error: function(xhr) {
                alert('Error loading role data');
                console.error(xhr.responseText);
            }
        });
    });


     $('#roleModal').on('hidden.bs.modal', function() {
        $('#roleModalLabel').text('Add New Role');
        $('#roleForm')[0].reset();
        $('#roleId').val('');
        $('#permissions').val(null).trigger('change');
    });

     $(document).on('click', '.delete-role', function() {
        if(confirm('Are you sure you want to delete this role?')) {
            let roleId = $(this).data('id');
            $.ajax({
                url: '/admin/roles/delete/' + roleId,
                type: 'POST',
                success: function() {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error deleting role: ' + (xhr.responseJSON?.message || 'Unknown error'));
                }
            });
        }
    });


    // Role form submission and other role-specific JS here
    // (Copy the relevant parts from your original script)
});
</script>
@endsection