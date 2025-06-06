@extends('layouts.ecom')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2>Shopping Cart</h2>
            
            @if($cartItems->isEmpty())
                <div class="alert alert-info">Your cart is empty</div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('product_images/'.$item->product->image) }}" width="60" class="mr-3">
                                        <div>
                                            <h5 class="mb-0">{{ $item->product->name }}</h5>
                                            <small class="text-muted">{{ $item->product->category->name ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>₹{{ number_format($item->product->price, 2) }}</td>
                                <td>
                                    <div class="quantity">
                                        <input type="number" class="form-control quantity-input" 
                                               value="{{ $item->quantity }}" min="1" 
                                               data-id="{{ $item->id }}">
                                    </div>
                                </td>
                                <td>₹{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger remove-item" data-id="{{ $item->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Order Summary</h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>₹{{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity; }), 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>GST (18%):</span>
                        <span>₹{{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity * 0.18; }), 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping:</span>
                        <span>₹100.00</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between font-weight-bold">
                        <span>Total:</span>
                        <span>₹{{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity * 1.18; }) + 100, 2) }}</span>
                    </div>
                    
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-block mt-3 @if($cartItems->isEmpty()) disabled @endif">
                        Proceed to Checkout
                    </a>
                    
                    <a href="{{ route('main') }}" class="btn btn-outline-dark btn-block mt-2">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // console.log("ytest");
    $('.quantity-input').on('change', function() {
        const id = $(this).data('id');
        const quantity = $(this).val();
        
        $.ajax({
            url: "{{ route('cart.update', '') }}/" + id,
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    });    

    $('.remove-item').on('click', function() {
        
        if (confirm('Are you sure you want to remove this item?')) {
            const id = $(this).data('id');
            
            $.ajax({
                url: "{{ route('cart.remove', '') }}/" + id,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                }
            });
        }
    });
});
</script>
@endsection