<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->nullable()->constrained('eventos')->nullOnDelete();
            $table->string('nome');
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->unsignedTinyInteger('idade')->nullable();
            $table->enum('tipo', ['adulto', 'adolescente', 'crianca'])->default('adulto');
            $table->boolean('primeira_visita')->default(true);
            $table->date('data_visita');
            $table->string('como_conheceu')->nullable();
            $table->boolean('acompanhado')->default(false);
            $table->enum('status', ['pendente', 'acompanhado', 'convertido', 'inativo'])->default('pendente');
            $table->string('bairro')->nullable();
            $table->string('municipio')->nullable();
            $table->string('provincia')->nullable()->default('Luanda');
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitantes');
    }
};
