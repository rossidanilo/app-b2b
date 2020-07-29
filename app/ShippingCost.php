<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingCost extends Model
{
    protected $fillable = [
        'amount',
        'cost',
    ];
}
