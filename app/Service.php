<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
      'name',
    ];

    // public function users(){
    //     return $this->belongsToMany('App\User');
    // }
    //
    public function give_page_services(){
        return $this->belongsToMany('App\Page','give_page_services','service_id','page_id')
        ->withPivot('id');
    }

    public function have_page_services(){
        return $this->belongsToMany('App\Page','have_page_services','service_id','page_id');
    }

    public function give_user_services(){
        return $this->belongsToMany('App\User','give_user_services','service_id','user_id')
        ->withPivot('id');
    }

    public function have_user_services(){
        return $this->belongsToMany('App\User','have_user_services','service_id','user_id');
    }

}
