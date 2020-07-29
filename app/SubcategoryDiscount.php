<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubcategoryDiscount extends Model
{
     protected $fillable = [
        'category_id',
        'subcategory_id',
        'discount_group_id',
        'discount',
    ];

    public function subcategory(){

    	return $this->belongsTo('App\Subcategory');

    }

}
