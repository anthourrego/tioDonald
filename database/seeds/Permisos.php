<?php

use Illuminate\Database\Seeder;

class Permisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Datos permisos
        DB::table('permisos')->insert([
            'nombre' => "Usuarios",
            'idCreador' => 1,
            'estado' => 1,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ]);
        DB::table('permisos')->insert([
            'nombre' => "Permisos",
            'idCreador' => 1,
            'estado' => 1,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ]);
    }
}
