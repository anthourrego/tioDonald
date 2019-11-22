<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidosDetalle extends Model
{
    public function Platos(){
        return $this->hasMany('App\platos', 'id', 'idPlato');
    }
}
