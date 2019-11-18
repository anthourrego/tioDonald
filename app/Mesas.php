<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mesas extends Model
{
    //
    public function Piso(){
        return $this->belongsTo('App\Pisos', 'idPiso');
    }

    public function Pedidos(){
        return $this->hasMany('App\Pedidos', 'idMesa', 'id');
    }
}
