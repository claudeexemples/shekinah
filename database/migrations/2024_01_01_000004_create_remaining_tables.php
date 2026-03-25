<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /* EBD */
        Schema::create('ebd_registros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained('eventos')->cascadeOnDelete();
            $table->string('professor');
            $table->string('tema');
            $table->unsignedInteger('total_presentes')->default(0);
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });

        /* Classe Celestial */
        Schema::create('celestial_registros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained('eventos')->cascadeOnDelete();
            $table->unsignedInteger('total_criancas')->default(0);
            $table->unsignedInteger('total_professores')->default(0);
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });

        /* Turmas Doutrinária */
        Schema::create('turmas_doutrinaria', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_inicio');
            $table->date('data_fim_prevista')->nullable();
            $table->unsignedInteger('total_aulas_previstas')->default(12);
            $table->unsignedInteger('aula_atual')->default(0);
            $table->string('professor');
            $table->string('sala')->nullable();
            $table->boolean('ativa')->default(true);
            $table->date('data_batismo_prevista')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });

        /* Candidatos ao Batismo */
        Schema::create('candidatos_batismo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('turma_id')->constrained('turmas_doutrinaria')->cascadeOnDelete();
            $table->string('nome');
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->date('data_matricula');
            $table->enum('status', ['ativo', 'inativo', 'batizado'])->default('ativo');
            $table->unsignedInteger('total_presencas')->default(0);
            $table->unsignedInteger('total_faltas')->default(0);
            $table->decimal('percentual_presenca', 5, 2)->default(0);
            $table->date('data_batismo_realizada')->nullable();
            $table->boolean('is_novo')->default(false);
            $table->string('bairro')->nullable();
            $table->string('provincia')->nullable()->default('Luanda');
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });

        /* Presenças Classe Doutrinária */
        Schema::create('presencas_doutrinaria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('turma_id')->constrained('turmas_doutrinaria')->cascadeOnDelete();
            $table->foreignId('candidato_id')->constrained('candidatos_batismo')->cascadeOnDelete();
            $table->unsignedInteger('aula_numero');
            $table->date('data_aula');
            $table->boolean('presente')->default(false);
            $table->text('observacao')->nullable();
            $table->timestamps();

            $table->unique(['candidato_id', 'aula_numero']);
        });

        /* Ofertas */
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained('eventos')->cascadeOnDelete();
            $table->string('tipo')->default('Oferta de Louvor');
            $table->decimal('valor_dinheiro', 12, 2)->default(0);
            $table->decimal('valor_transferencia', 12, 2)->default(0); /* Angola usa mais transferência bancária / referência multicaixa */
            $table->decimal('valor_cartao', 12, 2)->default(0);
            $table->decimal('valor_total', 12, 2)->default(0);
            $table->string('moeda', 3)->default('AOA'); /* Kwanza Angolano */
            $table->text('observacao')->nullable();
            $table->timestamps();
        });

        /* Despesas */
        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->string('descricao');
            $table->string('categoria')->default('Outros');
            $table->decimal('valor', 12, 2);
            $table->string('moeda', 3)->default('AOA');
            $table->enum('forma_pagamento', ['dinheiro', 'transferencia', 'cartao', 'multicaixa', 'cheque'])->default('dinheiro');
            $table->string('comprovante_url')->nullable();
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('despesas');
        Schema::dropIfExists('ofertas');
        Schema::dropIfExists('presencas_doutrinaria');
        Schema::dropIfExists('candidatos_batismo');
        Schema::dropIfExists('turmas_doutrinaria');
        Schema::dropIfExists('celestial_registros');
        Schema::dropIfExists('ebd_registros');
    }
};
