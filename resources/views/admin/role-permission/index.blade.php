@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Role & Permission Management</h2>
        </div>
    </div>

    <div class="row">
        <!-- Roles Section -->
        <div class="col-md-4">
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
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
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

        <!-- Permissions Section -->
        <div class="col-md-4">
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

        <!-- Users Section -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Users</h4>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#userModal">
                        <i class="fas fa-plus"></i> Add User
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="usersTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm edit-user" data-id="{{ $user->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-user" data-id="{{ $user->id }}">
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
@include('admin.role-permission.modals.permission')
@include('admin.role-permission.modals.user')

@endsection


@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
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


    $('#userForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = $(this).serialize();
        let userId = $('#userId').val();
        
        $.ajax({
            url: userId ? '/admin/users/update/' + userId : '/admin/users/store',
            type: 'POST', 
            data: formData,
            success: function(response) {
                $('#userModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                let errorMsg = xhr.responseJSON?.message || 'Failed to save user';
                alert('Error: ' + errorMsg);
            }
        });
    });

 
    $(document).on('click', '.edit-role', function() {
        let roleId = $(this).data('id');
         console.log("editroleid-".roleId);
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

  
    $(document).on('click', '.edit-user', function() {
        let userId = $(this).data('id');
         console.log("edituserId-".userId);
        $.ajax({
            url: '/admin/users/get/' + userId,
            type: 'GET',
            success: function(data) {
                $('#userModalLabel').text('Edit User');
                $('#userId').val(data.id);
                $('#userName').val(data.name);
                $('#userEmail').val(data.email);
                $('#userRole').val(data.role_id);
                $('#userPassword').val('').attr('placeholder', 'Leave blank to keep current');
                
                $('#userModal').modal('show');
            },
            error: function(xhr) {
                alert('Error loading user data');
            }
        });
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

  
    $(document).on('click', '.delete-user', function() {
        if(confirm('Are you sure you want to delete this user?')) {
            let userId = $(this).data('id');
            $.ajax({
                url: '/admin/users/delete/' + userId,
                type: 'POST',
                success: function() {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error deleting user: ' + (xhr.responseJSON?.message || 'Unknown error'));
                }
            });
        }
    });


    $('#roleModal').on('hidden.bs.modal', function() {
        $('#roleModalLabel').text('Add New Role');
        $('#roleForm')[0].reset();
        $('#roleId').val('');
        $('#permissions').val(null).trigger('change');
    });

    $('#permissionModal').on('hidden.bs.modal', function() {
        $('#permissionModalLabel').text('Add New Permission');
        $('#permissionForm')[0].reset();
        $('#permissionId').val('');
    });

    $('#userModal').on('hidden.bs.modal', function() {
        $('#userModalLabel').text('Add New User');
        $('#userForm')[0].reset();
        $('#userId').val('');
        $('#userPassword').attr('placeholder', '');
    });
});


</script>
@endsection