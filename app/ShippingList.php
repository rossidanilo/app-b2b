<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingList extends Model
{
     protected $fillable = [
        'link',
        'order_id',
    ];

    public function order(){

    	return $this->belongsTo('App\Order');

    }
}
