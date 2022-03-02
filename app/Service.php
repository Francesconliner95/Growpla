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
        return $this->belongsToMany('App\Page','give_page_services','page_id','service_id')
        ->withPivot('id');
    }

    public function have_page_services(){
        return $this->belongsToMany('App\Page','have_page_services','page_id','service_id');
    }

}
