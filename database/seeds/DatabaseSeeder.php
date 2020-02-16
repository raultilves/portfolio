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
        // $this->call(UsersTableSeeder::class); ESTO ES PARA RELLENAR LA TABLA USERS
        $this->truncateTables([
            //'users',
            'proyectos',
            'categorias'
        ]);
        $this->call(CategoriasTableSeeder::class);
        $this->call(ProyectosTableSeeder::class);

    }

    //Borra los registros de las tablas
    public function truncateTables(array $tables) {
        foreach ($tables as $table) {
            //DB::statement("SET session_replication_role = 'replica';");   // ESTO ES COMO FK CHECKS 0
            DB::table($table)->truncate();
            //DB::statement("SET session_replication_role = 'origin';");    // ESTO ES COMO FK CHECK 1
        }
    }
}
