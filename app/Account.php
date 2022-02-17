<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'name',/*'account_type_id',*/'cover_image','image','description','website','linkedin','phone_number','email','street','civic','city','region_id','state_id','vat_number',
        'money','currency_id','private_association','incorporated','subcategory',
        //STARTUP
        'startup_status_id','pitch','roadmap',
        //USER-CO-FOUNDER-BUSNESS ANGEL-SERVICES
        'investor','services','cofounder','role','curriculum_vitae','company_id',
        //INCUBATORI
        'num_startup',


        //SERVIZI ALLE STARTUP
        'startupservice_type_id',
        //ENTE
        'nation_region',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function locations(){
        return $this->belongsToMany('App\Location');
    }

    public function teams() {
        return $this->hasMany('App\Team');
    }

    public function others() {
        return $this->hasMany('App\Other');
    }

    public function company() {
        return $this->hasOne(Company::class);
    }

}
