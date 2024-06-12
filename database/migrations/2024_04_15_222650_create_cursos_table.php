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
        Schema::create('cursos', function (Blueprint $table) {
            $table->unsignedBigInteger('cod_curso');
            $table->unsignedBigInteger('cod_periodo');
            $table->unsignedBigInteger('cod_categoria');
            $table->string('codigo_curso', 50)->default('');
            $table->string('nombre_curso', 150)->default('');
            $table->string('imagen_curso', 150)->default('');
            $table->date('fecha_inicio_inscripcion');
            $table->date('fecha_fin_inscripcion');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('modalidad', 15)->default('');
            $table->integer('cupo')->default(1);
            $table->text('descripcion')->default('');
            $table->string('documento_descripcion', 100)->nullable();
            $table->integer('visualizar')->default(1);
            $table->integer('estado')->default(1);
            $table->primary('cod_curso');
            $table->foreign('cod_periodo')->references('cod_periodo')->on('periodos')
                   ->onDelete('cascade') 
                   ->onUpdate('cascade');
            $table->foreign('cod_categoria')->references('cod_categoria')->on('categorias')
                   ->onDelete('cascade') 
                   ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
