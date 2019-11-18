<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call('Usuarios');
        $this->call('PisosMesas');
        $this->call('Permisos');
        $this->call('Platos');
    }
}
