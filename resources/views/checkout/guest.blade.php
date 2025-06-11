@extends('layouts.ecom')

@section('content')
<div class="container">
    <h1>Guest Checkout</h1>
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Shipping Information</h3>
                </div>
                <div class="card-body">
                    <form id="guestCheckoutForm">
                        @csrf                        
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="zip_code">Zip Code</label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" class="form-control" id="state" name="state">
                        </div>
                        
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country" value="India">
                        </div>
                        
                        <div class="form-group">
                            <label for="notes">Order Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Continue to Payment</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Order Summary</h3>
                </div>
                <div class="card-body">
                    @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                {{ $item->product->name }} × {{ $item->quantity }}
                            </div>
                            <div>
                                ₹{{ number_format($item->quantity * $item->product->price, 2) }}
                            </div>
                        </div>
                    @endforeach
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between">
                        <div>Subtotal</div>
                        <div>₹{{ number_format($subtotal, 2) }}</div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <div>GST (18%)</div>
                        <div>₹{{ number_format($gst, 2) }}</div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <div>Shipping</div>
                        <div>₹{{ number_format($shipping, 2) }}</div>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between font-weight-bold">
                        <div>Total</div>
                        <div>₹{{ number_format($total, 2) }}</div>
                    </div>
                </div>
            </div>
            
            <div class="mt-3 text-center">
                <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
                <p>Need to create an account? <a href="{{ route('register') }}">Register</a></p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#guestCheckoutForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("checkout.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect;
                } else {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else {
                        alert(response.message);
                    }
                }
            },
            error: function(xhr) {
                var response = xhr.responseJSON;
                if (response && response.errors) {
                    // Handle validation errors
                    alert('Please fix the errors in the form');
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
    });
});
</script>
@endsection