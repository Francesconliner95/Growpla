<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Notifications\InvoicePaid;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    public function accounts() {
        return $this->hasMany('App\Account');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmailQueued);
    }

    public function usertypes(){
        return $this->belongsToMany('App\Usertype');
    }

    public function pagetypes(){
        return $this->belongsToMany('App\Pagetype');
    }

    public function pages(){
        return $this->belongsToMany('App\Page');
    }

    public function sectors(){
        return $this->belongsToMany('App\Sector');
    }

    public function currency(){
        return $this->belongsTo('App\Currency');
    }

    public function moneyrange(){
        return $this->belongsTo('App\Moneyrange');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'name',
        'surname',
        'date_of_birth',
        'language_id',
        'image',
        'description',
        'cv',
        'linkedin',
        'website',
        'moneyrange_id',
        'startup_n',
        'latitude',
        'longitude',
        'last_access',
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
}
