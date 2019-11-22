<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos_detalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idPedido');
            $table->foreign('idPedido')->references('id')->on('pedidos');
            $table->unsignedBigInteger('idPlato');
            $table->foreign('idPlato')->references('id')->on('platos');
            $table->integer('precio');
            $table->integer('estado');
            $table->unsignedBigInteger('idCreador');
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
        Schema::dropIfExists('pedidos_detalles');
    }
}
