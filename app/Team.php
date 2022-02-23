<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
      'page_id',	'user_id',	'name',	'surname',	'image',	'role',	'linkedin',	'position',
    ];

    public function page() {
        return $this->belongsTo('App\Page');
    }
}
