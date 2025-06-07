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
            'item_id' => $id,
            'item_total' => $cartItem->quantity * $cartItem->product->price,
            'subtotal' => $this->calculateSubtotal(),
            'gst' => $this->calculateSubtotal() * 0.18,
            'total' => $this->calculateSubtotal() * 1.18 + 100,
            'cart_count' => $this->getCartCount()
        ]);
    }

   
    
    public function remove($id)
    {
        $cartItem = Cart::where('user_id', auth()->id())
                    ->where('id', $id)
                    ->firstOrFail();
                    
        $cartItem->delete();
        
        $cartCount = $this->getCartCount();
        $subtotal = $this->calculateSubtotal();
        $gst = $subtotal * 0.18;
        
        // Calculate shipping - 0 if cart is empty, otherwise 100
       $shipping = $cartCount > 0 ? $this->getShippingCharge() : 0;
        $total = $subtotal + $gst + $shipping;
        
        return response()->json([
            'success' => true,
            'subtotal' => $subtotal,
            'gst' => $gst,
            'shipping' => $shipping,
            'total' => $total,
            'cart_count' => $cartCount
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

    private function getShippingCharge()
    {
        return env('SHIPPING_CHARGE', 100);
    }
}