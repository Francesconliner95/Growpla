<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'account_id','image','name','role','description','linkedin'
    ];

    public function account() {
        return $this->belongsTo('App\Account');
    }
}
