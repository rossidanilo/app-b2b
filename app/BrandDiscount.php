<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandDiscount extends Model
{
    protected $fillable = [
    	'brand_id',
        'discount_group_id',
        'discount',
    ];

    public function brand(){

    	return $this->belongsTo('App\Brand');

    }
}
