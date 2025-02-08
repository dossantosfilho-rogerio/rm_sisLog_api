<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Compra;
use App\Models\ContaAReceber;
use App\Models\ItemCompra;
use App\Models\ItemVenda;
use App\Models\MovimentacaoEstoque;
use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MovimentacaoEstoqueTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_can_create_Movimentacao_on_create_item_compra()
        {
            // Definindo dados de entrada
            
            
            $itemCompra = ItemCompra::factory()->create();

            $this->assertDatabaseHas('movimentacoes_estoque', [
                'produto_id' => $itemCompra->produto_id,
                'quantidade' => $itemCompra->quantidade,
                'tipo' => MovimentacaoEstoque::TIPO_ENTRADA,
            ]);
        }

        /** @test */
    public function checks_produto_estoque_on_create_item_compra()
    {
        // Definindo dados de entrada
        $produto = Produto::factory()->create();
        $qtd_antes = $produto->estoque;

        $itemCompra = ItemCompra::create([
            'compra_id' => Compra::factory()->create()->id,
            'preco_unitario' => $produto->preco_venda,
            'quantidade' => 10,
            'produto_id' => $produto->id
        ]);

        $this->assertDatabaseHas('produtos', [
            'id' => $itemCompra->produto_id,
            'estoque' => $itemCompra->quantidade + $qtd_antes,
        ]);
    }

    /** @test */
    public function it_can_create_Movimentacao_on_create_item_venda()
        {
            // Definindo dados de entrada
            
            
            $itemVenda = ItemVenda::factory()->create();

            $this->assertDatabaseHas('movimentacoes_estoque', [
                'produto_id' => $itemVenda->produto_id,
                'quantidade' => $itemVenda->quantidade,
                'tipo' => MovimentacaoEstoque::TIPO_SAIDA,
            ]);
        }

        /** @test */
    public function checks_produto_estoque_on_create_item_venda()
    {
        // Definindo dados de entrada
        $produto = Produto::factory()->create();
        $qtd_antes = $produto->estoque;

        $itemVenda = ItemVenda::create([
            'venda_id' => Venda::factory()->create()->id,
            'preco_unitario' => $produto->preco_venda,
            'percentual_comissao'=> $produto->percentual_comissao,
            'quantidade' => 10,
            'produto_id' => $produto->id
        ]);

        $this->assertDatabaseHas('produtos', [
            'id' => $itemVenda->produto_id,
            'estoque' => $qtd_antes - $itemVenda->quantidade ,
        ]);
    }
}
