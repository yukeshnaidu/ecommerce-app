<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\SubCategory;
use Illuminate\Support\Facades\Auth;
use App\DeleteRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'subCategory'])->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::with('subCategories')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'nullable',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('product_images'), $imageName);
            $data['image'] = $imageName;
        }

        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::with('subCategories')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required',
            'sub_category_id' => 'nullable',
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        
        if ($request->hasFile('image')) {
            
            if ($product->image && file_exists(public_path('product_images/'.$product->image))) {
                unlink(public_path('product_images/'.$product->image));
            }

            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('product_images'), $imageName);
            $data['image'] = $imageName;
        }

        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete associated image if exists
        if ($product->image && file_exists(public_path('product_images/'.$product->image))) {
            unlink(public_path('product_images/'.$product->image));
        }

        // Super admin can delete directly
        if (auth()->user()->role->slug == 'super-admin') {
            $product->delete();
            return back()->with('success', 'Product deleted successfully');
        }
        
        // Admin needs approval
        if (auth()->user()->role->slug == 'admin') {
            DeleteRequest::create([
                'model' => Product::class,
                'model_id' => $id,
                'requested_by' => auth()->id(),
                'reason' => 'Requested delete from admin panel'
            ]);
            
            return back()->with('success', 'Delete request sent to Super Admin for approval');
        }
        
        // Regular users can't delete
        return back()->with('error', 'You are not authorized to delete products');
    }

    public function getSubcategories($category_id)
    {
        $subcategories = SubCategory::where('category_id', $category_id)->get();
        return response()->json($subcategories);
    }
    public function test(){
        $user = Auth::user();  
        $categories = Category::all();
        $products = Product::with('category')->get();

        return view('layouts.main', compact('categories', 'products'));
    }

public function show(Product $product)
{
    $relatedProducts = Product::where('category_id', $product->category_id)
                            ->where('id', '!=', $product->id)
                            ->limit(4)
                            ->get();
    
    return view('products.show', compact('product', 'relatedProducts'));
}


    
    public function filteredProducts(Request $request)
    {
        $query = Product::with(['category', 'subCategory'])
                    ->select('products.*');
        
        // Category filter
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        // Subcategory filter
        if ($request->has('sub_category_id')) {
            $query->where('sub_category_id', $request->sub_category_id);
        }
        
        // Price range filter
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [
                $request->min_price, 
                $request->max_price
            ]);
        }
        
        // Search term filter (with debouncing handled client-side)
        if ($request->has('search')) {
            $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('description', 'like', '%'.$request->search.'%');
        }
        
        // Sorting
        $sort = $request->get('sort', 'latest');
        switch($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default: 
                $query->orderBy('created_at', 'desc');
        }
        
        // Pagination
        $perPage = $request->get('per_page', 12);
        $products = $query->paginate($perPage);
        
        // Related products (for sidebar)
        $relatedProducts = Product::inRandomOrder()
            ->limit(4)
            ->get();
        
        // Latest products
        $latestProducts = Product::orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
        
        if ($request->ajax()) {
            return response()->json([
                'products' => $products,
                'pagination' => (string) $products->links(),
                'relatedProducts' => $relatedProducts,
                'latestProducts' => $latestProducts
            ]);
        }
        
        $categories = Category::with('subCategories')->get();
        
        return view('products.listing', compact('categories', 'products', 'relatedProducts', 'latestProducts'));
    }
}