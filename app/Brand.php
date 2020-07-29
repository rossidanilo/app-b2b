<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
    ];

    public function products(){

         return $this->hasMany('App\Product', 'brand_id');

    }

    public function discount(){

         return $this->hasMany('App\BrandDiscount', 'brand_id');

    }
}
