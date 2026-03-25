<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->enum('tipo_evento', ['culto_dominical', 'culto_semana', 'especial'])->default('culto_dominical');
            $table->time('horario_inicio')->nullable();
            $table->time('horario_fim')->nullable();
            $table->string('pregador')->nullable();
            $table->string('tema_culto')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
