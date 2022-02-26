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
    // public function pages(){
    //     return $this->belongsToMany('App\Page');
    // }

}
