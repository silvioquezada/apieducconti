<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('usuarios')->insert([
            'cod_usuario' => 1,
            'apellido' => 'Quezada Vasquez',
            'nombre' => 'Silerio Florentino',
            'celular' => '0999744113',
            'correo' => 'sss_silq@hotmail.com',
            'usuario' => 'silverio',
            'password' => '8c1860e5865d5f330dfedc66e22cba3f8679eb11959844b61043f66d2539da95ccc486e9d737be20b2ad4c6f24ecf6666b3a49f2fac5272762ecf354e678d669',//Silverio.1
            'tipo_usuario' => 'GESTOR'
        ]);
    }
}
