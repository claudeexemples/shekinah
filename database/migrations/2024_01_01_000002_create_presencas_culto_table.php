<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presencas_culto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained('eventos')->cascadeOnDelete();
            $table->unsignedInteger('adultos')->default(0);
            $table->unsignedInteger('adolescentes')->default(0);
            $table->unsignedInteger('criancas')->default(0);
            // total calculado no Model (não como coluna gerada — compatível SQLite e MySQL)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presencas_culto');
    }
};
