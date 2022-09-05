<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $professor = Role::create(['name' => 'Professor']);;
        User::create(array(
		    'name' => 'Bredi',
		    'email' => 'professor@bredi.com.br',
		    'password' => Hash::make('bredi')
		))->assignRole($professor);

        $professor->givePermissionTo('Visualizar agendamento');
        $professor->givePermissionTo('Cadastrar agendamento');
        $professor->givePermissionTo('Visualizar bloco');

        $homologador = Role::create(['name' => 'Homologador']);
        User::create(array(
		    'name' => 'Bredi',
		    'email' => 'homologador@bredi.com.br',
		    'password' => Hash::make('bredi')
		))->assignRole($homologador);

        $permissions = Permission::get();
        foreach($permissions as $permission){
            $homologador->givePermissionTo($permission);
        }
    }
}
