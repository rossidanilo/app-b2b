<?php

namespace App\Exports;

use App\Alternative;
use Maatwebsite\Excel\Concerns\FromCollection;

class AlternativesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Alternative::all();
    }
}
