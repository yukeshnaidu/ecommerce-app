@extends('layouts.ecom')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2>Checkout</h2>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Shipping Information</h5>
                </div>
                <div class="card-body">
                   <form id="checkout-form" method="POST" action="{{ route('checkout.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" class="form-control" id="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" name="phone" class="form-control" id="phone" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" name="address" id="address" rows="3" required></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" name="city" class="form-control" id="city" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input type="text" name="state" class="form-control" id="state">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" name="country" class="form-control" id="country" value="India">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="zip_code">ZIP Code</label>
                                    <input type="text" name="zip_code" class="form-control" id="zip_code" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="notes">Order Notes (Optional)</label>
                            <textarea class="form-control" name="notes" id="notes" rows="2"></textarea>
                        </div>
                        
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary" id="place-order-btn">
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                <tr>
                                    <td>{{ $item->product->name }} × {{ $item->quantity }}</td>
                                    <td>₹{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>₹{{ number_format($subtotal, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>GST (18%):</span>
                        <span>₹{{ number_format($gst, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping:</span>
                        <span>₹{{ number_format($shipping, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between font-weight-bold">
                        <span>Total:</span>
                        <span>₹{{ number_format($total, 2) }}</span>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>

$(document).ready(function() {
    $('#checkout-form').on('submit', function(e) {
        e.preventDefault();
        
        // Disable button to prevent multiple submissions
        $('#place-order-btn').prop('disabled', true).html('Processing...');
        
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.redirect) {
                    window.location.href = response.redirect;
                }
            },
            error: function(xhr) {
                $('#place-order-btn').prop('disabled', false).html('Place Order');
                
                // Show validation errors if any
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorHtml = '<div class="alert alert-danger"><ul>';
                    
                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + value + '</li>';
                    });
                    
                    errorHtml += '</ul></div>';
                    
                    // Remove previous errors if any
                    $('.alert-danger').remove();
                    $('#checkout-form').prepend(errorHtml);
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
    });
});
</script>
@endsection