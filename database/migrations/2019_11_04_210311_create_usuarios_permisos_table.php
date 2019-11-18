<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosPermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_permisos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idUsuario');
            $table->unsignedBigInteger('idPermiso');
            $table->unsignedBigInteger('idCreador');
            $table->foreign('idUsuario')->references('id')->on('users');
            $table->foreign('idPermiso')->references('id')->on('permisos');
            $table->foreign('idCreador')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios_permisos');
    }
}
