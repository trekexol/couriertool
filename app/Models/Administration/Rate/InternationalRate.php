<?php

namespace App\Models\Administration\Rate;

use Illuminate\Database\Eloquent\Model;

class InternationalRate extends Model
{
    public function wharehouses_origin(){
        return $this->belongsTo('App\Models\Administration\Wharehouse','id_wharehouse_origin');
    }

    public function wharehouses_destiny(){
        return $this->belongsTo('App\Models\Administration\Wharehouse','id_wharehouse_destiny');
    }
    
    public function state_origin(){
        return $this->belongsTo('App\Models\Administration\Countries\State','id_state_origin');
    }
    public function state_destination(){
        return $this->belongsTo('App\Models\Administration\Countries\State','id_state_destination');
    }
}
