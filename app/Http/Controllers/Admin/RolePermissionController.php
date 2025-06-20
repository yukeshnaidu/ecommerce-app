<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('role:super-admin');
    }


    public function rolesIndex()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('admin.role-permission.roles', compact('roles', 'permissions'));
    }

    public function permissionsIndex()
    {
        $permissions = Permission::all();
        return view('admin.role-permission.permissions', compact('permissions'));
    }

    public function usersIndex()
    {
        $users = User::with(['roles', 'permissions'])->get();
        $roles = Role::all(); // Needed for the user form
        $permissions = Permission::all(); // Needed for the user form
        return view('admin.role-permission.users', compact('users', 'roles', 'permissions'));
    }

    public function index()
    {
        
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        $users = User::with(['roles', 'permissions'])->get();        
        return view('admin.role-permission.index', compact('roles', 'permissions', 'users'));
    }

    public function getPermission($id)
    {
        $permission = Permission::findOrFail($id);
        return response()->json($permission);
    }

     public function getUser($id)
    {
        $user = User::with(['roles', 'permissions'])->findOrFail($id); 
        return response()->json($user);
    }
    // Roles CRUD
    public function getRole($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return response()->json($role);
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'slug' => 'required|unique:roles,slug',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create($request->only('name', 'slug', 'description'));
        
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return response()->json(['success' => 'Role created successfully']);
    }

    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        
        $request->validate([
            'name' => ['required', Rule::unique('roles')->ignore($role->id)],
            'slug' => ['required', Rule::unique('roles')->ignore($role->id)],
            'permissions' => 'nullable|array'
        ]);

        $role->update($request->only('name', 'slug', 'description'));
        $role->permissions()->sync($request->permissions ?? []);

        return response()->json(['success' => 'Role updated successfully']);
    }

    public function destroyRole($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        
        return response()->json(['success' => 'Role deleted successfully']);
    }

    // Permissions CRUD
    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'slug' => 'required|unique:permissions,slug'
        ]);

        Permission::create($request->only('name', 'slug', 'description'));

        return response()->json(['success' => 'Permission created successfully']);
    }

    public function updatePermission(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        
        $request->validate([
            'name' => ['required', Rule::unique('permissions')->ignore($permission->id)],
            'slug' => ['required', Rule::unique('permissions')->ignore($permission->id)]
        ]);

        $permission->update($request->only('name', 'slug', 'description'));

        return response()->json(['success' => 'Permission updated successfully']);
    }

    public function destroyPermission($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        
        return response()->json(['success' => 'Permission deleted successfully']);
    }

    // Users CRUD
     public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'roles' => 'required|array', 
            'roles.*' => 'exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->sync($request->roles);
        if ($request->has('permissions')) {
            $user->permissions()->sync($request->permissions);
        }

        return response()->json(['success' => 'User created successfully']);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:6',
            'roles' => 'required|array', 
            'roles.*' => 'exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->roles()->sync($request->roles);
        $user->permissions()->sync($request->permissions ?? []);

        return response()->json(['success' => 'User updated successfully']);
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return response()->json(['success' => 'User deleted successfully']);
    }
}