<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Notifications\InvoicePaid;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

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

    public function views(){
        return $this->belongsToMany('App\View');
    }

    public function currency(){
        return $this->belongsTo('App\Currency');
    }

    public function moneyrange(){
        return $this->belongsTo('App\Moneyrange');
    }

    public function region(){
        return $this->belongsTo('App\Region');
    }

    public function companies(){
        return $this->hasMany('App\Company');
    }

    public function notifications(){
        return $this->hasMany('App\Notification');
    }

    public function chats_sender(){
        return $this->hasMany('App\Chat','sender_user_id');
    }

    public function chats_recipient(){
        return $this->hasMany('App\Chat','recipient_user_id');
    }

    public function mail_settings(){
        return $this->belongsToMany('App\MailSetting', 'user_mail_settings', 'user_id', 'mail_setting_id');
    }

    public function give_user_skills(){
        return $this->belongsToMany('App\Skill','give_user_skills','user_id','skill_id')
        ->withPivot('id');
    }

    public function give_user_services(){
        return $this->belongsToMany('App\Service','give_user_services','user_id','service_id')
        ->withPivot('id');
    }

    public function have_user_services(){
        return $this->belongsToMany('App\Service','have_user_services','user_id','service_id')
        ->withPivot('id');
    }

    public function user_following(){ //utenti seguiti
        return $this->
        belongsToMany('App\User','follows','user_id','user_following_id')
        ->withPivot('id');
    }

    public function user_follower(){ //utenti che mi seguono
        return $this->
        belongsToMany('App\User','follows','user_following_id','user_id')
        ->withPivot('id');
    }

    public function page_following(){ //pagine seguite
        return $this->
        belongsToMany('App\Page','follows','user_id','page_following_id')
        ->withPivot('id');
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
        'summary',
        'description',
        'cv',
        'linkedin',
        'website',
        'moneyrange_id',
        'startup_n',
        'country_id',
        'region_id',
        'latitude',
        'longitude',
        'municipality',
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
