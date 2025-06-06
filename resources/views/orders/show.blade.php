@extends('layouts.ecom')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2>Order #{{ $order->id }}</h2>
            <p class="text-muted">Placed on {{ $order->created_at->format('F j, Y \a\t g:i a') }}</p>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Order Details</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
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
                                    <td>₹{{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>₹{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>GST (18%):</span>
                        <span>₹{{ number_format($order->gst, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping:</span>
                        <span>₹{{ number_format($order->shipping, 2) }}</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between font-weight-bold">
                        <span>Total:</span>
                        <span>₹{{ number_format($order->total, 2) }}</span>
                    </div>
                    
                    <div class="mt-4">
                        <h5>Shipping Information</h5>
                        <div class="card card-body">
                            @if($order->shippingInformation)
                                <p><strong>Name:</strong> {{ $order->shippingInformation->name }}</p>
                                <p><strong>Email:</strong> {{ $order->shippingInformation->email }}</p>
                                <p><strong>Phone:</strong> {{ $order->shippingInformation->phone }}</p>
                                <p><strong>Address:</strong> {{ $order->shippingInformation->address }}</p>
                                <p><strong>City:</strong> {{ $order->shippingInformation->city }}</p>
                                <p><strong>State:</strong> {{ $order->shippingInformation->state }}</p>
                                <p><strong>Country:</strong> {{ $order->shippingInformation->country }}</p>
                                <p><strong>ZIP Code:</strong> {{ $order->shippingInformation->zip_code }}</p>
                                @if($order->shippingInformation->notes)
                                    <p><strong>Notes:</strong> {{ $order->shippingInformation->notes }}</p>
                                @endif
                            @else
                                <p>No shipping information available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection