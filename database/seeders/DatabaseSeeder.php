<?php

namespace Database\Seeders;

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
        $this->call(PermissionsSeeder::class);
        $this->call(TipoAgendamentoSeeder::class);
        $this->call(BlocoSeeder::class);
        $this->call(SalaSeeder::class);
        $this->call(ProfessorSeeder::class);
        $this->call(FactorySeeder::class);
        $this->call(UsuarioSeeder::class);
        $this->call(StatusEventoSeeder::class);

    }
}
