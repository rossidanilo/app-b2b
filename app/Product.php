<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'brand_id',
        'stock',
        'price',
        'code',
        'image_id',
        'description',
        'subcategory_id',
        'subcategory',
        'published',
        'category_id',
        'category',
    ];

    use SearchableTrait;

	protected $searchable = [

		'columns' => [

			'products.name' => 10,
			'products.brand' => 10,
			'products.code' => 10,
            'products.subcategory' => 10,
			'products.description' => 8,

		]

	];

    public function images(){

         return $this->hasMany('App\Image');

    }

    public function brands(){

         return $this->belongsTo('App\Brand');         

    }

    public function subcategory(){

         return $this->belongsTo('App\Subcategory');         

    }

    public function scopeFilter($query, $params){

        if ( isset($params['brand']) && $params['brand'] > 0 )  {
            $query->where('brand_id', $params['brand']);
        }

        if ( isset($params['subcategory']) && $params['subcategory'] > 0 )  {
            $query->where('subcategory_id', $params['subcategory']);
        }

        if ( isset($params['category']) && $params['category'] > 0 )  {
            $query->where('category_id', $params['category']);
        }

        return $query;

    }

}
