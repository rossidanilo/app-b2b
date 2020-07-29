<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    public function subcategory(){

    	return $this->hasMany('App\Subcategory', 'category_id');

    }

    public function discount(){

    	return $this->hasMany('App\CategoryDiscount', 'category_id');

    }

   }
