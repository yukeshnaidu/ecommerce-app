<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderItem;
use App\Cart;
use App\Product;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth')->except(['guestCheckout']);
    }

    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        
        $gst = $subtotal * 0.18;
        $shipping = 100;
        $total = $subtotal + $gst + $shipping;
        
        return view('checkout.index', compact('cartItems', 'subtotal', 'gst', 'shipping', 'total'));
    }
    
    public function guestCheckout()
    {
        if (auth()->check()) {
            return redirect()->route('checkout.index');
        }
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }
        
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
        
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->quantity * $item->product->price;
        }
        
        $gst = $subtotal * 0.18;
        $shipping = 100;
        $total = $subtotal + $gst + $shipping;
        
        return view('checkout.guest', compact('cartItems', 'subtotal', 'gst', 'shipping', 'total'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Check if user is guest or not
        if (!auth()->check()) {            
            $userExists = User::where('email', $validated['email'])->exists();            
            if ($userExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'This email is already registered. Please login to complete your purchase.',
                    'redirect' => route('login')
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Please register to complete your purchase.',
                    'redirect' => route('register')
                ]);
            }
        }

        try {          
            DB::beginTransaction();

            $cartItems = Cart::with('product')
                ->where('user_id', auth()->id())
                ->get();            
         
            if ($cartItems->isEmpty()) {
                return redirect()
                    ->route('cart.index')
                    ->with('error', 'Your cart is empty');
            }
            
            // Calculate order totals
            $subtotal = $cartItems->sum(function($item) {
                return $item->quantity * $item->product->price;
            });
            
            $gst = $subtotal * 0.18;
            $shipping = 100;
            $total = $subtotal + $gst + $shipping;
            
            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'subtotal' => $subtotal,
                'gst' => $gst,
                'shipping' => $shipping,
                'total' => $total,
                'status' => 'pending',
            ]);
            
            if (!$order) {
                throw new \Exception('Failed to create order');
            }            
           
            $shippingInfo = $order->shippingInformation()->create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'] ?? null,
                'country' => $validated['country'] ?? 'India',
                'zip_code' => $validated['zip_code'],
                'notes' => $validated['notes'] ?? null,
            ]);
            
            if (!$shippingInfo) {
                throw new \Exception('Failed to save shipping information');
            }           
            
            foreach ($cartItems as $item) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
                
                if (!$orderItem) {
                    throw new \Exception('Failed to create order items');
                }
            }      
        
            $cartDeleted = Cart::where('user_id', auth()->id())->delete();        
            if ($cartDeleted === false) {
                throw new \Exception('Failed to clear cart');
            }     
        
            DB::commit();            
            return response()->json([
                'success' => true,
                'redirect' => route('orders.show', $order->id),
                'message' => 'Order placed successfully!'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {         
            DB::rollBack();
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
                'message' => 'Validation failed'
            ], 200);
        } catch (\Exception $e) {        
            DB::rollBack();     
            Log::error('Checkout failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your order. Please try again.',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }
}
