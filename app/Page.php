<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    public function users(){
    return $this->belongsToMany('App\User');
    }

    public function sectors(){
      return $this->belongsToMany('App\Sector');
    }

    public function company(){
      return $this->hasOne('App\Company');
    }

    public function teams(){
      return $this->hasMany('App\Team');
    }

    public function pagetype(){
        return $this->belongsTo('App\Pagetype');
    }

    public function lifecycle(){
        return $this->belongsTo('App\Lifecycle');
    }

    public function region(){
        return $this->belongsTo('App\Region');
    }

    public function chats_sender(){
        return $this->hasMany('App\Chat','sender_page_id');
    }

    public function chats_recipient(){
        return $this->hasMany('App\Chat','recipient_page_id');
    }

    public function have_page_usertypes(){
        return $this->belongsToMany('App\Usertype','have_page_usertypes','page_id','usertype_id')
        ->withPivot('id');
    }

    public function have_page_pagetypes(){
        return $this->belongsToMany('App\Pagetype','have_page_pagetypes','page_id','pagetype_id')
        ->withPivot('id');
    }

    public function give_page_services(){
        return $this->belongsToMany('App\Service','give_page_services','page_id','service_id')
        ->withPivot('id');
    }

    public function have_page_services(){
        return $this->belongsToMany('App\Service','have_page_services','page_id','service_id')
        ->withPivot('id');
    }

    public function have_page_cofounders(){
        return $this->belongsToMany('App\Service','have_page_cofounders','page_id','service_id')
        ->withPivot('id');
    }

    public function page_follower(){ //utenti seguaci della pagina
        return $this->
        belongsToMany('App\User','follows','page_following_id','user_id')
        ->withPivot('id');
    }

    protected $fillable = [
      'pagetype_id',
      'name',
      'logo',
      'summary',
      'description',
      'website',
      'linkedin',
      'page_varificated',
      'slug',
      'latitude',
      'longitude',
      'country_id',
      'region_id',
      'type_bool_1',
      'type_int_1',
      'street_name',
      'street_number',
      'municipality',
      'lifecycle_id',
      'pitch',
      'incorporated',
      'moneyrange_id',
      'startup_n',
    ];

}
