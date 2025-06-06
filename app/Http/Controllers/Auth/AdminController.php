<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product; 
use App\DeleteRequest; 

class AdminController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,super-admin');
    }
    
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    
    public function deleteRequests()
    {
        $requests = DeleteRequest::where('status', 'pending')->get();
        return view('admin.delete-requests', compact('requests'));
    }
    
    public function approveDelete($id)
    {
        $request = DeleteRequest::findOrFail($id);
        
        // Only super admin can approve
        if (auth()->user()->role->slug != 'super-admin') {
            return back()->with('error', 'Only Super Admin can approve delete requests');
        }
        
        // Delete the item
        $model = $request->model;
        $item = $model::findOrFail($request->model_id);
        $item->delete();
        
        // Update request status
        $request->update(['status' => 'approved']);
        
        return back()->with('success', 'Delete request approved successfully');
    }
}
