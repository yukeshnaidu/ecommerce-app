<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use app\Http\Controllers\Auth\AdminController;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }   
    
    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     $credentials = $request->only('email', 'password');
    //     $remember = $request->has('remember');

    //     if (Auth::attempt($credentials, $remember)) {
    //         $request->session()->regenerate();
            
    //         redirect()->setIntendedUrl(null);

    //         $user = Auth::user();      
        
            
    //         switch ($user->role->slug) {
    //             case 'super-admin':
    //                 return redirect()->route('admin.dashboard');
    //             case 'admin':
    //                 return redirect()->route('admin.dashboard');
    //             case 'user':
    //                 return redirect()->route('main');
    //             default:
    //                 return redirect('/home');
    //         }
    //     }

    //     return back()->withErrors(['email' => 'Invalid credentials.']);
    // }
        
    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'name'     => 'required|string|max:255',
    //         'email'    => 'required|email|unique:users,email',
    //         'password' => 'required|min:6|confirmed',
    //     ]);

    //     $user = User::create([
    //         'name'     => $request->name,
    //         'email'    => $request->email,
    //         'password' => Hash::make($request->password),
    //         'role_id'  => Role::where('slug', 'user')->first()->id,
    //     ]);

    //     Auth::login($user);
    //     return redirect()->route('main');
    // }

        public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            redirect()->setIntendedUrl(null);

            $user = Auth::user();
            
            // Check if user has any roles
            if ($user->roles->isEmpty()) {
                Auth::logout();
                return back()->withErrors(['email' => 'User has no assigned role.']);
            }

            // Get the first role (or implement your own logic for multiple roles)
            $primaryRole = $user->roles->first();
            
            switch ($primaryRole->slug) {
                case 'super-admin':
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'user':
                    return redirect()->route('main');
                default:
                    return redirect('/home');
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign default 'user' role
        $defaultRole = Role::where('slug', 'user')->first();
        if ($defaultRole) {
            $user->roles()->attach($defaultRole->id);
        }

        Auth::login($user);
        return redirect()->route('main');
    }
        
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}