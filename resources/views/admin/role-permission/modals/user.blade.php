<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <form id="userForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="userId">
                    <div class="form-group">
                        <label for="userName">Name</label>
                        <input type="text" class="form-control" id="userName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Email</label>
                        <input type="email" class="form-control" id="userEmail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="userPassword">Password</label>
                        <input type="password" class="form-control" id="userPassword" name="password">
                        <small class="text-muted">Leave blank to keep current password</small>
                    </div>
                    <div class="form-group">
                        <label>Roles</label>
                        <select class="form-control select2" id="userRoles" name="roles[]" multiple="multiple" style="width: 100%;" required>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Direct Permissions (Optional)</label>
                        <select class="form-control select2" id="userPermissions" name="permissions[]" multiple="multiple" style="width: 100%;">
                            @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>