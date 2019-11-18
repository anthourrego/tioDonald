<?php

use Illuminate\Database\Seeder;

class PisosMesas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Creamos los pisos
        for ($i=1; $i <=3 ; $i++) { 
            DB::table('pisos')->insert([
                'nroPiso' => $i,
                'estado' => 1,
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
                'idCreador' => 1,
            ]);
            
            //Adicionamos la mesas para cada piso
            for ($j=1; $j <=10; $j++) { 
                DB::table('mesas')->insert([
                    'nroMesa' => $j,
                    'estado' => 1,
                    'idPiso' => $i,
                    'idCreador' => 1,
                    'created_at' => date('Y-m-d H:m:s'),
                    'updated_at' => date('Y-m-d H:m:s')
                ]);
            }
        }

    }
}
