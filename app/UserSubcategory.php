<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSubcategory extends Model
{
    protected $fillable = [
        'user_id',
        'subcategory_id',
    ];

    public function user(){

        return $this->belongsTo('App\User');
    }
}
