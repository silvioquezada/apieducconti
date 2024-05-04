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
        Schema::create('matriculas', function (Blueprint $table) {
            $table->unsignedBigInteger('cod_matricula');
            //$table->timestamps();
            $table->timestamp('fecha_registro');
            $table->unsignedBigInteger('cod_curso');
            $table->unsignedBigInteger('cod_usuario');
            $table->integer('estado_matricula')->default(0);
            $table->integer('estado_respuesta')->default(0);
            $table->integer('estado_aprobacion')->default(0);
            $table->string('archivo_certificado', 50)->default('');
            $table->text('observacion_revision')->default('');
            $table->string('documento_descripcion', 50)->nullable();
            $table->integer('estado')->default(1);
            $table->primary('cod_matricula');
            $table->foreign('cod_curso')->references('cod_curso')->on('cursos')
                   ->onDelete('cascade') 
                   ->onUpdate('cascade');
            $table->foreign('cod_usuario')->references('cod_usuario')->on('usuarios')
                   ->onDelete('cascade') 
                   ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
