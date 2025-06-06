<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Cart;


class CartController extends Controller
{
   public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cartItem = Cart::where('user_id', auth()->id())
                       ->where('product_id', $request->product_id)
                       ->first();
        
        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }
        
        return response()->json([
            'success' => true,
            'cart_count' => $this->getCartCount()
        ]);
    }
    
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        return view('cart.index', compact('cartItems'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cartItem = Cart::where('user_id', auth()->id())
                       ->where('id', $id)
                       ->firstOrFail();
        
        $cartItem->update(['quantity' => $request->quantity]);
        
        return response()->json([
            'success' => true,
            'subtotal' => $this->calculateSubtotal(),
            'cart_count' => $this->getCartCount()
        ]);
    }
    
    public function remove($id)
    {
        Cart::where('user_id', auth()->id())
            ->where('id', $id)
            ->delete();
            
        return response()->json([
            'success' => true,
            'subtotal' => $this->calculateSubtotal(),
            'cart_count' => $this->getCartCount()
        ]);
    }
    
    private function getCartCount()
    {
        return Cart::where('user_id', auth()->id())->sum('quantity');
    }
    
    private function calculateSubtotal()
    {
        return Cart::where('user_id', auth()->id())
                 ->with('product')
                 ->get()
                 ->sum(function($item) {
                     return $item->quantity * $item->product->price;
                 });
    }

    public function count()
    {
        return response()->json([
            'count' => $this->getCartCount()
        ]);
    }
}