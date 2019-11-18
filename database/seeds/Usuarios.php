<?php

use Illuminate\Database\Seeder;

class Usuarios extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'nroDocumento' => '0',
            'nombres' => 'Admin',
            'apellidos' => 'Admin',
            'telefono' => '0000',
            'password' => '123456',
            'estado' => 1,
            'idCreador' => 1,
            'remember_token' => null,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
        ]);
    }
}
