<?php

namespace App\Http\Controllers;

use App\Category;
use App\Role;
use Illuminate\Http\Request;
use App\DeleteRequest;

class CategoryController extends Controller
{
     public function index()
    {
        $categories = Category::all();
          $roles = Role::all();
        return view('categories.index', compact('categories', 'roles'));
    }

    public function create()
    {   
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required']);
        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findorFail($id);
        // Super admin can delete directly
        if (auth()->user()->role->slug == 'super-admin') {
            $category->delete();
            return back()->with('success', 'Product deleted successfully');
        }
        
        // Admin needs approval
        if (auth()->user()->role->slug == 'admin') {
            DeleteRequest::create([
                'model' => Category::class,
                'model_id' => $id,
                'requested_by' => auth()->id(),
                'reason' => 'Requested delete from admin panel'
            ]);
            
            return back()->with('success', 'Delete request sent to Super Admin for approval');
        }

         return back()->with('error', 'You are not authorized to delete products');
        
        // return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    public function showCategories()
    {
        $categories = Category::latest()->get();
        return view('layouts.main', compact('categories'));
    }
}
