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
        $subCategories = SubCategory::with(['category', 'parent'])->get();
        $categories = Category::all();
        $allSubCategories = SubCategory::all();
        
        return view('sub_categories.index', compact('subCategories', 'categories', 'allSubCategories'));
    }

    public function table()
    {
        $subCategories = SubCategory::with(['category', 'parent'])->get();
        return view('sub_categories.partials.table_rows', compact('subCategories'));
    }

    public function create()
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();
        return view('sub_categories.create', compact('categories', 'subCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required'
        ]);
        
        SubCategory::create($request->all());
        
        return response()->json([
            'success' => 'Sub-category created successfully.'
        ]);
    }

    public function edit(SubCategory $subCategory)
    {
        // dd($subCategory);
        return response()->json($subCategory);
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required'
        ]);
        
        $subCategory->update($request->all());
        
        return response()->json([
            'success' => 'Sub-category updated successfully.'
        ]);
    }

    public function destroy(SubCategory $subCategory)
    {
        // Check if subcategory has children
        if ($subCategory->children()->count() > 0) {
            return response()->json([
                'error' => 'Cannot delete subcategory with child categories.'
            ], 422);
        }

        // Check if subcategory has products
        if ($subCategory->products()->count() > 0) {
            return response()->json([
                'error' => 'Cannot delete subcategory with associated products.'
            ], 422);
        }

        // Super admin can delete directly
        if (auth()->user()->role->slug == 'super-admin') {
            $subCategory->delete();
            return response()->json(['success' => 'Sub-category deleted successfully.']);
        }
        
        // Admin needs approval
        if (auth()->user()->role->slug == 'admin') {
            DeleteRequest::create([
                'model' => SubCategory::class,
                'model_id' => $subCategory->id,
                'requested_by' => auth()->id(),
                'reason' => 'Requested delete from admin panel'
            ]);
            
            return response()->json(['success' => 'Delete request sent to Super Admin for approval.']);
        }

        return response()->json(['error' => 'You are not authorized to delete subcategories.'], 403);
    }
}