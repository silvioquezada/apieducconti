<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuarios')->insert([
            'cod_usuario' => 1,
            'apellido' => 'Quezada Puchaicela',
            'nombre' => 'Silvio Vinicio',
            'celular' => '0939278001',
            'correo' => 'sss.silq@gmail.com',
            'usuario' => 'silvio',
            'password' => 'f367d0b9c3400be6c0c9c8ca72c913bc7a7df7cacc250b091a289ec4861ef5cab1630893dc1ed2b624193dec64686d7856a97a0a6f25fd6078098aa89b68dc0c',//12345
            'tipo_usuario' => 'GESTOR'
        ]);
    }
}
