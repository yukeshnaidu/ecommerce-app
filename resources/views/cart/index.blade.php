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
                        <span id="subtotal-display">₹{{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity; }), 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>GST (18%):</span>
                        <span id="gst-display">₹{{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity * 0.18; }), 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping:</span>
                        <span id="shipping-display">₹{{ $cartItems->isEmpty() ? '0.00' : '100.00' }}</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between font-weight-bold">
                        <span>Total:</span>
                        <span id="total-display">₹{{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity * 1.18; }) + ($cartItems->isEmpty() ? 0 : 100), 2) }}</span>
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
// $(document).ready(function() {
//     // console.log("ytest");
//     $('.quantity-input').on('change', function() {
//         const id = $(this).data('id');
//         const quantity = $(this).val();
        
//         $.ajax({
//             url: "{{ route('cart.update', '') }}/" + id,
//             method: 'POST',
//             data: {
//                 _token: "{{ csrf_token() }}",
//                 quantity: quantity
//             },
//             success: function(response) {
//                 if (response.success) {
//                     location.reload();
//                 }
//             }
//         });
//     });    

//     $('.remove-item').on('click', function() {
        
//         if (confirm('Are you sure you want to remove this item?')) {
//             const id = $(this).data('id');
            
//             $.ajax({
//                 url: "{{ route('cart.remove', '') }}/" + id,
//                 method: 'POST',
//                 data: {
//                     _token: "{{ csrf_token() }}"
//                 },
//                 success: function(response) {
//                     if (response.success) {
//                         location.reload();
//                     }
//                 }
//             });
//         }
//     });
// });

$(document).ready(function() {
   
    // function updateCartTotals(response) {
    
    //     if (response.item_total) {
    //         $(`input[data-id="${response.item_id}"]`).closest('tr').find('td:nth-child(4)').text(
    //             '₹' + response.item_total.toFixed(2)
    //         );
    //     }

       
    //     if (response.subtotal) {
    //         $('.card-body span:nth-child(2)').eq(0).text('₹' + response.subtotal.toFixed(2));
    //     }
    //     if (response.gst) {
    //         $('.card-body span:nth-child(2)').eq(1).text('₹' + response.gst.toFixed(2));
    //     }
    //     if (response.total) {
    //         $('.card-body span:nth-child(2)').eq(3).text('₹' + response.total.toFixed(2));
    //     }

        
    //     if (response.cart_count !== undefined) {
    //         $('.cart-count').text(response.cart_count);
    //     }

       
    //     if (response.cart_count === 0) {
    //         $('.btn-primary').addClass('disabled');
    //     }
    // }

    function updateCartTotals(response) {
    
    if (response.item_total) {
        $(`input[data-id="${response.item_id}"]`).closest('tr').find('td:nth-child(4)').text(
            '₹' + response.item_total.toFixed(2)
        );
    }

  
    $('.card-body span:nth-child(2)').eq(0).text('₹' + (response.subtotal || 0).toFixed(2));
    $('.card-body span:nth-child(2)').eq(1).text('₹' + (response.gst || 0).toFixed(2));
    $('.card-body span:nth-child(2)').eq(2).text('₹' + (response.shipping || 0).toFixed(2));
    $('.card-body span:nth-child(2)').eq(3).text('₹' + (response.total || 0).toFixed(2));

   
    if (response.cart_count !== undefined) {
        $('.cart-count').text(response.cart_count);
    }

   
    if (response.cart_count === 0) {
        $('.btn-primary').addClass('disabled');
        $('table').after('<div class="alert alert-info">Your cart is empty</div>');
    }
}

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
                    updateCartTotals(response);
                }
            },
            error: function(xhr) {
                alert('Error updating quantity. Please try again.');
            }
        });
    });
    
    // Remove item
    // $('.remove-item').on('click', function() {
    //     if (confirm('Are you sure you want to remove this item?')) {
    //         const id = $(this).data('id');
    //         const row = $(this).closest('tr');
            
    //         $.ajax({
    //             url: "{{ route('cart.remove', '') }}/" + id,
    //             method: 'POST',
    //             data: {
    //                 _token: "{{ csrf_token() }}"
    //             },
    //             success: function(response) {
    //                 if (response.success) {
    //                     // Remove the row from table
    //                     row.fadeOut(300, function() {
    //                         row.remove();
                            
    //                         // Update totals
    //                         updateCartTotals(response);
                            
    //                         // Show empty message if cart is empty
    //                         if (response.cart_count === 0) {
    //                             $('table').after(
    //                                 '<div class="alert alert-info">Your cart is empty</div>'
    //                             );
    //                         }
    //                     });
    //                 }
    //             },
    //             error: function(xhr) {
    //                 alert('Error removing item. Please try again.');
    //             }
    //         });
    //     }
    // });


    $('.remove-item').on('click', function() {
        if (confirm('Are you sure you want to remove this item?')) {
            const id = $(this).data('id');
            const row = $(this).closest('tr');
            
            $.ajax({
                url: "{{ route('cart.remove', '') }}/" + id,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        // Remove the row from table
                        row.fadeOut(300, function() {
                            row.remove();
                            updateCartTotals(response);
                            
                            // If cart is empty, hide the table and show empty message
                            if (response.cart_count === 0) {
                                $('table').hide();
                                $('.alert-info').remove();
                                $('.table-responsive').after(
                                    '<div class="alert alert-info">Your cart is empty</div>'
                                );
                            }
                        });
                    }
                },
                error: function(xhr) {
                    alert('Error removing item. Please try again.');
                }
            });
        }
    });
});
</script>
@endsection


