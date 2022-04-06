<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagetype extends Model
{
  public function users(){
    return $this->belongsToMany('App\User');
  }

  public function page(){
      return $this->hasOne('App\Page');
  }

  public function have_page_pagetypes(){
  return $this->belongsToMany('App\Page','have_page_pagetypes','pagetype_id','page_id');
  }

    public function have_services(){
    return $this->belongsToMany('App\Service','have_pagetype_services','pagetype_id','service_id');
    }

    public function give_services(){
    return $this->belongsToMany('App\Service','give_pagetype_services','pagetype_id','service_id');
    }
}
