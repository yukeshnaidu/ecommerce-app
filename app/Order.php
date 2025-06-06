<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'subtotal', 'gst', 'shipping', 'total', 'status'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

     public function shippingInformation()
    {
        return $this->hasOne(OrderShippingInformation::class);
    }
}
