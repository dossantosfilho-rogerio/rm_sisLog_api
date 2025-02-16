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
        Schema::create('rotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_id')->constrained();
            $table->string('placa_veiculo');
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->date('data_saida');
            $table->date('data_retorno')->nullable();
            $table->enum('status', ['aguardando','em rota', 'retornado'])->default('aguardando');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rotas');
    }
};
