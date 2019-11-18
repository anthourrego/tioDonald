<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    public function platos(){
        return $this->belongsToMany('App\platos','pedidos_detalle','idPedido','idPlato')->withPivot('precio', 'estado', 'idCreador');
    }

    public function usuario(){
        return $this->belongsTo('App\User', 'idCreador');
    }
    
    public function Mesa(){
        return $this->belongsTo('App\Mesas', 'idMesa');
    }

    public function PedidoEstado(){
        return $this->belongsTo('App\pedido_estados', 'idEstado');
    }


}
