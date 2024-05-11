<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequisitosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('requisitos')->insert([
            'cod_requisitos' => 1,
            'requisitos' => 'Escribe los requisitos'
        ]);
    }
}
