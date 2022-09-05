<?php

namespace Database\Seeders;

use App\Models\Bloco;
use App\Models\Filial;
use Illuminate\Database\Seeder;

class BlocoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bloco::create(['titulo' => 'Ep']);
        Bloco::create(['titulo' => 'Fp']);
    }
}
