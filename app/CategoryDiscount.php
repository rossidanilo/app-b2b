<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryDiscount extends Model
{
     protected $fillable = [
        'category_id',
        'discount_group_id',
        'discount',
    ];

    public function category(){

    	return $this->belongsTo('App\Category');

    }

  
}
