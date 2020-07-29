<?php

namespace App\Imports;

use App\Image;
use App\Product;
use DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImagesImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows){

        foreach ($rows as $row) {
            
            $product = Product::where('code', $row[0])->first();

            if($product != null){

                $image = file_get_contents($row[1]);

                $size = getimagesize($row[1]);
                $extension = image_type_to_extension($size[2]);

                $imageName = time().$extension;

                file_put_contents(public_path('img/'.$imageName), $image);

                DB::table('images')->insert([

                    'name' => $imageName, 
                    'product_id' => $product->id,

                    ]);

                $product->image_id = $imageName;

                $product->save();

            } 
        }
        
    }
}
