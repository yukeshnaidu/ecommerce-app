@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>User Management</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
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
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge badge-primary">{{ $role->name }}</span>
                                    @endforeach
                                </td>
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
@endsection
@include('admin.role-permission.modals.user')



@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        placeholder: "Select items",
        allowClear: true,
        dropdownParent: $('#userModal')
    });

     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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

    $(document).on('click', '.edit-user', function() {
        let userId = $(this).data('id');
        
        $.ajax({
            url: '/admin/users/get/' + userId,
            type: 'GET',
            success: function(data) {
                $('#userModalLabel').text('Edit User');
                $('#userId').val(data.id);
                $('#userName').val(data.name);
                $('#userEmail').val(data.email);
                $('#userPassword').val('').attr('placeholder', 'Leave blank to keep current');
                
                // Set roles
                $('#userRoles').val(null).trigger('change');
                let roleIds = data.roles.map(role => role.id);
                $('#userRoles').val(roleIds).trigger('change');
                
                // Set permissions if available
                if (data.permissions) {
                    $('#userPermissions').val(null).trigger('change');
                    let permissionIds = data.permissions.map(p => p.id);
                    $('#userPermissions').val(permissionIds).trigger('change');
                }
                
                $('#userModal').modal('show');
            },
            error: function(xhr) {
                alert('Error loading user data');
            }
        });
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

    $('#userModal').on('hidden.bs.modal', function() {
        $('#userModalLabel').text('Add New User');
        $('#userForm')[0].reset();
        $('#userId').val('');
        $('#userPassword').attr('placeholder', '');
    });

  
});
</script>
@endsection