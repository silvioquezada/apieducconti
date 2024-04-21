<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->unsignedBigInteger('cod_usuario');
            $table->string('cedula', 10)->default('0');
            $table->string('apellido', 50)->default('0');
            $table->string('nombre', 50)->default('0');
            $table->string('genero', 10)->default('0');
            $table->string('etnia', 20)->default('0');
            $table->string('direccion', 200)->default('0');
            $table->string('celular', 15)->default('0');
            $table->string('correo', 100)->default('0');
            $table->string('nivel_instruccion', 20)->default('0');
            $table->string('usuario', 50)->default('0');
            $table->string('password', 100)->default('0');
            $table->integer('estado')->default(1);
            $table->string('tipo_usuario', 10)->default('');
            $table->primary('cod_usuario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
