<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Obra extends Model
{
    protected $fillable = [
        'name',
        'adress',
        'user_id',
        'finished',
        'approved',
        'schedule',
        'responsible',
        'phone',
        'dni',
        'responsible_2',
        'phone_2',
        'dni_2',
        'responsible_3',
        'phone_3',
        'dni_3',

    ];

    use SearchableTrait;

    protected $searchable = [

        'columns' => [

            'obras.name' => 10,
            'obras.adress' => 10,
            'obras.responsible' => 8,
            'obras.dni' => 8,
            'obras.responsible_2' => 8,
            'obras.dni_2' => 8,
            'obras.responsible_3' => 8,
            'obras.dni_3' => 8,

        ],
        'joins' => [
            'users' => ['obras.user_id','users.id'],
        ],

    ];

    public function orders(){

    	 return $this->hasMany('App\Order', 'obra_id');

    }

    public function users(){

        return $this->belongsTo('App\User');

    }

}
