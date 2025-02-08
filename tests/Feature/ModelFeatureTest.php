<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\MovimentacaoEstoque;
use Tests\TestCase;
use App\Models\Categoria;
use App\Models\Pessoa;
use App\Models\Compra;
use App\Models\ContaAReceber;
use App\Models\ItemCompra;
use App\Models\ItemVenda;
use App\Models\Pagamento;
use App\Models\Produto;
use App\Models\User;
use App\Models\Venda;

class ModelFeatureTest extends TestCase
{
    use RefreshDatabase; // Limpa o banco antes de cada teste

    /** @test */
    public function it_can_create_categoria()
    {
        $categoria = Categoria::factory()->create();
        $this->assertDatabaseHas('categorias', ['id' => $categoria->id]);
    }

    /** @test */
    public function it_can_create_movimentacao_estoque()
    {
        $movimentacao = MovimentacaoEstoque::factory()->create();
        $this->assertDatabaseHas('movimentacoes_estoque', ['id' => $movimentacao->id]);
    }

    /** @test */
    public function it_can_create_pessoa()
    {
        $pessoa = Pessoa::factory()->create();
        $this->assertDatabaseHas('pessoas', ['id' => $pessoa->id]);
    }

    /** @test */
    public function it_can_create_compra()
    {
        $compra = Compra::factory()->create();
        $this->assertDatabaseHas('compras', ['id' => $compra->id]);
    }

    /** @test */
    public function it_can_create_conta_a_receber()
    {
        $conta = ContaAReceber::factory()->create();
        $this->assertDatabaseHas('contas_a_receber', ['id' => $conta->id]);
    }

    /** @test */
    public function it_can_create_item_compra()
    {
        $itemCompra = ItemCompra::factory()->create();
        $this->assertDatabaseHas('itens_compra', ['id' => $itemCompra->id]);
    }
    public function it_calculates_total_on_insert_item_compra()
    {
        // Definindo dados de entrada
        $quantidade = 10;
        $precoUnitario = 5.50;
        // Criando o ItemCompra
        $itemCompra = ItemCompra::create([
            'compra_id' => Compra::factory(),
            'produto_id' => Produto::factory(),
            'quantidade' => $quantidade,
            'preco_unitario' => $precoUnitario,
        ]);

        // Verificando se o total foi calculado corretamente
        $expectedTotal = $quantidade * $precoUnitario;
        $this->assertEquals($expectedTotal, $itemCompra->total);
    }

    /** @test */
    public function it_calculates_total_on_update_item_compra()
    {
        // Criando um ItemCompra
        $itemCompra = ItemCompra::create([
            'compra_id' => Compra::factory()->create()->id,
            'produto_id' => Produto::factory()->create()->id,
            'quantidade' => 10,
            'preco_unitario' => 5.50,
        ]);

        // Atualizando o ItemCompra com novos valores
        $itemCompra->update([
            'quantidade' => 20,
            'preco_unitario' => 6.00,
        ]);

        // Verificando se o total foi recalculado corretamente
        $expectedTotal = 20 * 6.00;
        $this->assertEquals($expectedTotal, $itemCompra->total);
    }

    /** @test */
    public function it_can_create_item_venda()
    {
        $itemVenda = ItemVenda::factory()->create();
        $this->assertDatabaseHas('itens_venda', ['id' => $itemVenda->id]);
    }

        /** @test */
        public function it_calculates_total_on_insert_item_venda()
        {
            // Definindo dados de entrada
            $quantidade = 10;
            $precoUnitario = 5.50;
    
            // Criando o itemVenda
            $itemVenda = ItemVenda::create([
                'venda_id' => Venda::factory()->create()->id,
                'produto_id' => Produto::factory()->create()->id,
                'percentual_comissao' => 5,
                'quantidade' => $quantidade,
                'preco_unitario' => $precoUnitario,
            ]);
    
            // Verificando se o total foi calculado corretamente
            $expectedTotal = $quantidade * $precoUnitario;
            $this->assertEquals($expectedTotal, $itemVenda->total);
        }

    
        /** @test */
        public function it_calculates_total_on_update_item_venda()
        {
            // Criando um itemVenda existente
            $itemVenda = ItemVenda::create([
                'venda_id' => Venda::factory()->create()->id,
                'produto_id' => Produto::factory()->create()->id,
                'percentual_comissao' => 0.05,
                'quantidade' => 10,
                'preco_unitario' => 5.50,
            ]);
    
            // Atualizando o ItemVenda com novos valores
            $itemVenda->update([
                'quantidade' => 20,
                'preco_unitario' => 6.00,
            ]);
    
            // Verificando se o total foi recalculado corretamente
            $expectedTotal = 20 * 6.00;
            $this->assertEquals($expectedTotal, $itemVenda->total);
        }
    

    /** @test */
    public function it_can_create_pagamento()
    {
        $pagamento = Pagamento::factory()->create();
        $this->assertDatabaseHas('pagamentos', ['id' => $pagamento->id]);
    }

    /** @test */
    public function it_can_create_produto()
    {
        $produto = Produto::factory()->create();
        $this->assertDatabaseHas('produtos', ['id' => $produto->id]);
    }

    /** @test */
    public function it_can_create_user()
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_can_create_venda()
    {
        $venda = Venda::factory()->create();
        $this->assertDatabaseHas('vendas', ['id' => $venda->id]);
    }
}
