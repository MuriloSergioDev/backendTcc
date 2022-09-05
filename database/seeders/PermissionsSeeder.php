<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permissões para bloco
        Permission::create(['name' => 'Alterar bloco']);
        Permission::create(['name' => 'Excluir bloco']);
        Permission::create(['name' => 'Visualizar bloco']);
        Permission::create(['name' => 'Cadastrar bloco']);

        // Permissões para sala
        Permission::create(['name' => 'Alterar sala']);
        Permission::create(['name' => 'Excluir sala']);
        Permission::create(['name' => 'Visualizar sala']);
        Permission::create(['name' => 'Cadastrar sala']);

        // Permissões para horario
        Permission::create(['name' => 'Alterar horario']);
        Permission::create(['name' => 'Excluir horario']);
        Permission::create(['name' => 'Visualizar horario']);
        Permission::create(['name' => 'Cadastrar horario']);

        // Permissões para professor
        Permission::create(['name' => 'Alterar professor']);
        Permission::create(['name' => 'Excluir professor']);
        Permission::create(['name' => 'Visualizar professor']);
        Permission::create(['name' => 'Cadastrar professor']);

        // Permissões para agendamento
        Permission::create(['name' => 'Alterar agendamento']);
        Permission::create(['name' => 'Excluir agendamento']);
        Permission::create(['name' => 'Visualizar agendamento']);
        Permission::create(['name' => 'Cadastrar agendamento']);

        // Permissões para tipo
        Permission::create(['name' => 'Alterar tipo']);
        Permission::create(['name' => 'Excluir tipo']);
        Permission::create(['name' => 'Visualizar tipo']);
        Permission::create(['name' => 'Cadastrar tipo']);

        // Permissões para feriado
        Permission::create(['name' => 'Alterar feriado']);
        Permission::create(['name' => 'Excluir feriado']);
        Permission::create(['name' => 'Visualizar feriado']);
        Permission::create(['name' => 'Cadastrar feriado']);

        // Permissões para homologacao
        Permission::create(['name' => 'Alterar homologacao']);
        Permission::create(['name' => 'Excluir homologacao']);
        Permission::create(['name' => 'Visualizar homologacao']);
        Permission::create(['name' => 'Cadastrar homologacao']);
    }
}
