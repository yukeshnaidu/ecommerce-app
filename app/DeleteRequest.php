<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeleteRequest extends Model
{
   protected $fillable = ['model', 'model_id', 'requested_by', 'status', 'reason'];
    
    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}
