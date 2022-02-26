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

    // public function services(){
    //     return $this->belongsToMany('App\Service');
    // }

    protected $fillable = [
      'pagetype_id',
      'name',
      'logo',
      'description',
      'website',
      'linkedin',
      'page_varificated',
      'slug',
      'latitude',
      'longitude',
      'lifecycle_id',
      'pitch',
      'incorporated',
      'moneyrange_id',
      'startup_n',
    ];

}
