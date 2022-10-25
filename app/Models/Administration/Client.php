<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public function countries(){
        return $this->belongsTo('App\Models\Administration\Countries\Country','id_country');
    }

    public function states(){
        return $this->belongsTo('App\Models\Administration\Countries\State','id_state_received');
    }

    public function agencies(){
        return $this->belongsTo('App\Models\Administration\Agency','id_agency');
    }

    public function agents(){
        return $this->belongsTo('App\Models\Administration\Agent','id_agent');
    }

    public function making_code_rooms(){
        return $this->belongsTo('App\Models\Administration\Countries\MakingCode','id_code_room');
    }

    public function making_code_works(){
        return $this->belongsTo('App\Models\Administration\Countries\MakingCode','id_code_work');
    }

    public function making_code_mobiles(){
        return $this->belongsTo('App\Models\Administration\Countries\MakingCode','id_code_mobile');
    }

    public function making_code_fax(){
        return $this->belongsTo('App\Models\Administration\Countries\MakingCode','id_code_fax');
    }
}
