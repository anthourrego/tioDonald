<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class platos extends Model
{
    public function pedidos(){
        return $this->belongsToMany('App\Pedidos','pedidos_detalle','idPlato','idPedido');
    }
}
