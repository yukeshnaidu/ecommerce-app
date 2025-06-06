<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\SubCategory;
use Illuminate\Support\Facades\Auth;
use App\DeleteRequest;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function home(){
         $user = Auth::user();  
        $categories = Category::all();
        $products = Product::with('category')->get();

        return view('home', compact('categories', 'products'));
    }
}
