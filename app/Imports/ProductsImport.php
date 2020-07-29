<?php

namespace App\Imports;

use App\Product;
use App\Brand;
use App\Subcategory;
use App\Category;
use Illuminate\Support\Collection;
//use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductsImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    public function model(array $row)
    {
        return new Product([
            
            'name' => $row[0],
            'brand' => $row[1],
            'stock'=> $row[2],
            'price' => $row[3],
            'code' => $row[4],
            'description' => $row[5],
            'subcategory_id' => $row[6],

        ]);
    }
    */

   public function collection(Collection $rows){

        foreach($rows as $row){

            if($row->count() === 9){
            $product = Product::find($row[0]);

            //Check if category exits. If not, create. 
                $category = Category::where('name', $row[3])->get();
                if (!$category->count()) {
                    $category = Category::create();
                    $category->name = $row[3];
                    $category->save();
                    $category = Category::where('name', $row[3])->get();
                }

            //Check if subcategory exits. If not, create.   
                $subcategory = Subcategory::where('name', $row[4])->get();
                 if (!$subcategory->count()) {
                    $subcategory = Subcategory::create();
                    $subcategory->name = $row[4];
                    $subcategory->category_id = $category[0]->id;
                    $subcategory->save();
                }

            //Check if brand exits. If not, create.
            $brand = Brand::where('name', $row[5])->get();
                if (!$brand->count()) {
                    $brand = Brand::create();
                    $brand->name = $row[5];
                    $brand->save();
                }                

            //Update de product
                $subcategory = Subcategory::where('name', $row[4])->get();
                $brand = Brand::where('name', $row[5])->get();

                $product->update([

                    'name' => $row[2],
                    'brand' => $row[5],
                    'brand_id' => $brand[0]->id,
                    'stock'=> $row[8],
                    'price' => $row[7],
                    'code' => $row[1],
                    'description' => $row[6],
                    'subcategory_id' => $subcategory[0]->id,
                    'subcategory' => $subcategory[0]->name,
                    'category_id' => $category[0]->id,
                    'category' => $category[0]->name,
                ]);
              
            } else {

            //Check if category exits. If not, create. 
                $category = Category::where('name', $row[2])->get();
                if (!$category->count()) {
                    $category = Category::create();
                    $category->name = $row[2];
                    $category->save();
                    $category = Category::where('name', $row[2])->get();
                }

                //Check if subcategory exits. If not, create.
                $subcategory = Subcategory::where('name', $row[3])->get();
                 if (!$subcategory->count()) {
                    $subcategory = Subcategory::create();
                    $subcategory->name = $row[3];
                    $subcategory->category_id = $category[0]->id;
                    $subcategory->save();
                }

            //Check if brand exits. If not, create.
                $brand = Brand::where('name', $row[4])->get();
                if (!$brand->count()) {
                    $brand = Brand::create();
                    $brand->name = $row[4];
                    $brand->save();
                } 


                //Create products                
                $subcategory = Subcategory::where('name', $row[3])->get();
                $brand = Brand::where('name', $row[4])->get();


                Product::create([

                    'name' => $row[1],
                    'brand' => $row[4],
                    'brand_id' => $brand[0]->id,
                    'stock'=> $row[6],
                    'price' => $row[3],
                    'code' => $row[0],
                    'description' => $row[5],
                    'subcategory_id' => $subcategory[0]->id,
                    'subcategory' => $subcategory[0]->name,
                    'category_id' => $category[0]->id,
                    'category' => $category[0]->name,

                ]);

            }

        }

    }
}
