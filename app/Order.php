<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'obra_id',
        'user_id',
        'total',
        'comments',
        'status',
        'date',
        'cuit',
        'shipping_cost',
    ];

    public function obras(){

    	return $this->belongsTo('App\Obra', 'obra_id');

    }

    public function user(){

    	return $this->belongsTo('App\User');

    }

    public function shippingList(){

        return $this->hasOne('App\ShippingList');
    }

}
