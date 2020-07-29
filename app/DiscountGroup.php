<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountGroup extends Model
{
    protected $fillable = [
        'name',
        'discount',
    ];

     public function users(){

         return $this->hasMany('App\User', 'discount_group_id');

    }
}
