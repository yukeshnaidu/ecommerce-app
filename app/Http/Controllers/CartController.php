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
        
        if (auth()->check()) {
            // Authenticated user
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
        } else {
            // Guest user - store in session
            $cart = session()->get('cart', []);
            
            if (isset($cart[$request->product_id])) {
                $cart[$request->product_id] += $request->quantity;
            } else {
                $cart[$request->product_id] = $request->quantity;
            }
            
            session()->put('cart', $cart);
        }
        
        return response()->json([
            'success' => true,
            'cart_count' => $this->getCartCount()
        ]);
    }
    
    public function index()
    {
        if (auth()->check()) {
            $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        } else {
            $cart = session()->get('cart', []);
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)->get();
            
            $cartItems = collect();
            foreach ($products as $product) {
                $cartItems->push((object)[
                    'id' => $product->id,
                    'product_id' => $product->id,
                    'product' => $product,
                    'quantity' => $cart[$product->id]
                ]);
            }
        }
        
        return view('cart.index', compact('cartItems'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        if (auth()->check()) {
            $cartItem = Cart::where('user_id', auth()->id())
                        ->where('id', $id)
                        ->firstOrFail();
            
            $cartItem->update(['quantity' => $request->quantity]);
        } else {
            $cart = session()->get('cart', []);
            $cart[$id] = $request->quantity;
            session()->put('cart', $cart);
        }
        
        return response()->json([
            'success' => true,
            'item_id' => $id,
            'item_total' => $this->getItemTotal($id, $request->quantity),
            'subtotal' => $this->calculateSubtotal(),
            'gst' => $this->calculateSubtotal() * 0.18,
            'total' => $this->calculateSubtotal() * 1.18 + $this->getShippingCharge(),
            'cart_count' => $this->getCartCount()
        ]);
    }
    
    public function remove($id)
    {
        if (auth()->check()) {
            $cartItem = Cart::where('user_id', auth()->id())
                        ->where('id', $id)
                        ->firstOrFail();
                        
            $cartItem->delete();
        } else {
            $cart = session()->get('cart', []);
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        $cartCount = $this->getCartCount();
        $subtotal = $this->calculateSubtotal();
        $gst = $subtotal * 0.18;
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
        if (auth()->check()) {
            return Cart::where('user_id', auth()->id())->sum('quantity');
        } else {
            $cart = session()->get('cart', []);
            return array_sum($cart);
        }
    }
    
    private function calculateSubtotal()
    {
        if (auth()->check()) {
            return Cart::where('user_id', auth()->id())
                     ->with('product')
                     ->get()
                     ->sum(function($item) {
                         return $item->quantity * $item->product->price;
                     });
        } else {
            $cart = session()->get('cart', []);
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)->get();
            
            $subtotal = 0;
            foreach ($products as $product) {
                $subtotal += $cart[$product->id] * $product->price;
            }
            
            return $subtotal;
        }
    }
    
    private function getItemTotal($productId, $quantity)
    {
        if (auth()->check()) {
            $product = Product::findOrFail($productId);
            return $quantity * $product->price;
        } else {
            $product = Product::findOrFail($productId);
            return $quantity * $product->price;
        }
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
    
    // Method to merge guest cart with user cart after login
    public function mergeGuestCartWithUserCart($userId)
    {
        $guestCart = session()->get('cart', []);
        
        if (!empty($guestCart)) {
            foreach ($guestCart as $productId => $quantity) {
                $cartItem = Cart::where('user_id', $userId)
                              ->where('product_id', $productId)
                              ->first();
                
                if ($cartItem) {
                    $cartItem->quantity += $quantity;
                    $cartItem->save();
                } else {
                    Cart::create([
                        'user_id' => $userId,
                        'product_id' => $productId,
                        'quantity' => $quantity
                    ]);
                }
            }
            
            // Clear the guest cart
            session()->forget('cart');
        }
    }


    
}