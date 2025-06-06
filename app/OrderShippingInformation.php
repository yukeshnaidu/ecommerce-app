<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderShippingInformation extends Model
{
    protected $table = 'order_shipping_information';
    
    protected $fillable = [
        'order_id',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'notes'
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
