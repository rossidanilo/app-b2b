<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Nicolaslopezj\Searchable\SearchableTrait;
use App\Notifications\MailResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'discount', 'admin','master', 'active', 'discount_group_id', 'company', 'cuit', 'phone', 'cc_emails',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders() {

        return $this->hasMany('App\Order', 'user_id');

    }

     public function discount_group() {

        return $this->belongsTo('App\DiscountGroup');

    }

     use SearchableTrait;

     protected $searchable = [

		'columns' => [

			'users.name' => 10,
			'users.email' => 10,
			'users.discount' => 10,

		]

	];

    public function sendPasswordResetNotification($token)
{
    $this->notify(new MailResetPasswordNotification($token));
}

    public function obras(){

        $this->hasMany('App\Obra');

    }

    public function subcategory(){

        return $this->hasMany('App\UserSubcategory');
    }

}
