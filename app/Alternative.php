<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    protected $fillable = [
        'product_id',
        'product_code',
        'alternative_id',
        'alternative_code',
    ];
}
