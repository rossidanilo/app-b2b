<?php

namespace App\Imports;

use App\Alternative;
use DB;
use Illuminate\Support\Collection;
//use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class AlternativesImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows){


        foreach($rows as $row){
        
        $check = DB::table('alternatives')
                ->where('product_id', $row[1])
                ->where('alternative_id', $row[3])
                ->get();
        //dd($row[0]);

            if ($row[0] == "" && $check->isEmpty()) {

                Alternative::create([

                    'product_id' => $row[1],
                    'product_code' => $row[2],
                    'alternative_id'=> $row[3],
                    'alternative_code' => $row[4],

                ]);

                 Alternative::create([
                    'product_id' => $row[3],
                    'product_code' => $row[4],
                    'alternative_id'=> $row[1],
                    'alternative_code' => $row[2],                        
                                    ]);
            } else {
            
            $alternative = Alternative::find($row[0]);

            $alternative->update(

                    ['product_id' => $row[1],
                    'product_code' => $row[2],
                    'alternative_id'=> $row[3],
                    'alternative_code' => $row[4],]
            );
                
            }

        }

    }
}
