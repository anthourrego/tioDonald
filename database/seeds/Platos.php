<?php

use Illuminate\Database\Seeder;

class Platos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Datos platos
        DB::table('platos')->insert([
            'nombre' => "Modongo",
            'precio' => 8800,
            'estado' => 1,
            'idCreador' => 1,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ]);
        DB::table('platos')->insert([
            'nombre' => "Minipaisa",
            'precio' => 6800,
            'estado' => 1,
            'idCreador' => 1,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ]);
        DB::table('platos')->insert([
            'nombre' => "Maxipaisa",
            'precio' => 10800,
            'estado' => 1,
            'idCreador' => 1,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ]);
        DB::table('platos')->insert([
            'nombre' => "Doblepaisa",
            'precio' => 13800,
            'estado' => 1,
            'idCreador' => 1,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ]);
    }
}
