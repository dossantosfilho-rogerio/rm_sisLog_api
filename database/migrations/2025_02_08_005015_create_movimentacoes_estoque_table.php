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
        Schema::create('movimentacoes_estoque', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            $table->foreignId('item_venda_id')->nullable()->constrained('itens_venda')->restrictOnDelete();
            $table->foreignId('item_compra_id')->nullable()->constrained('itens_compra')->restrictOnDelete();
            $table->integer('quantidade');
            $table->enum('tipo', ['entrada', 'saida']);
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentacoes_estoque');
    }
};
