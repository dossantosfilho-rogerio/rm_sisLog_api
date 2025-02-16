<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('comissoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendedor_id')->constrained('pessoas')->restrictOnDelete();
            $table->foreignId('item_venda_id')->constrained('itens_venda')->onDelete('cascade');
            $table->foreignId('conta_a_receber_id')->constrained('contas_a_receber')->onDelete('cascade');
            $table->decimal( 'percentual_comissao', 5, 2);
            $table->decimal('valor', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comissoes');
    }
};
