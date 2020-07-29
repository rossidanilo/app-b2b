<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function collection()
    {
        return Product::all();
    }

    public function map($product): array

    {

    	return [

    		$product->id,
    		$product->code,
    		$product->name,
            $product->category,
            $product->subcategory,
    		$product->brand,
    		$product->description,
    		$product->price,
    		$product->stock,

    	];

    }
}
