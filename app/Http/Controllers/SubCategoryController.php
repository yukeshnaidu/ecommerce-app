<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DeleteRequest;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('category')->get();
        return view('sub_categories.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('sub_categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required'
        ]);
        SubCategory::create($request->all());
        return redirect()->route('sub-categories.index')->with('success', 'Sub-category created successfully.');
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::all();
        return view('sub_categories.edit', compact('subCategory', 'categories'));
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required'
        ]);
        $subCategory->update($request->all());
        return redirect()->route('sub-categories.index')->with('success', 'Sub-category updated successfully.');
    }

    public function destroy($id)
    {
        $subcategory = SubCategory::findorFail($id);

         // Super admin can delete directly
        if (auth()->user()->role->slug == 'super-admin') {
            $subcategory->delete();
            return back()->with('success', 'Product deleted successfully');
        }
        
        // Admin needs approval
        if (auth()->user()->role->slug == 'admin') {
            DeleteRequest::create([
                'model' => SubCategory::class,
                'model_id' => $id,
                'requested_by' => auth()->id(),
                'reason' => 'Requested delete from admin panel'
            ]);
            
            return back()->with('success', 'Delete request sent to Super Admin for approval');
        }
        return redirect()->route('sub-categories.index')->with('success', 'Sub-category deleted successfully.');
    }
}
