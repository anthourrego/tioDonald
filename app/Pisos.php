<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pisos extends Model
{
    //
    public function Mesas(){
        return $this->hasMany('App\Mesas', 'idPiso', 'id');
    }
}
