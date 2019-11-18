<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permisos extends Model
{
  public function Usuarios(){
    return $this->belongsToMany('App\User','usuarios_permisos','idPermiso','idUsuario');
  }
}
