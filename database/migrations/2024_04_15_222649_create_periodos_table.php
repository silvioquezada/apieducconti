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
        Schema::create('periodos', function (Blueprint $table) {
            $table->unsignedBigInteger('cod_periodo');
            $table->integer('anio')->default(0);
            $table->string('descripcion', 100)->default('');
            $table->integer('estado')->default(1);
            $table->primary('cod_periodo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodos');
    }
};
