<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
  public function users(){
    return $this->belongsToMany('App\User');
  }

  protected $fillable = [
      'pagetype_id',
    	'page_name',
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
  ];

}
