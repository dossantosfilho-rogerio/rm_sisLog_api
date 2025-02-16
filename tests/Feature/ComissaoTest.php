<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\ContaAReceber;
use App\Models\ItemVenda;
use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ComissaoTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_can_create_Comissao_on_update_conta_a_receber()
        {
            // Definindo dados de entrada
            $quantidade = 1;
            $precoUnitario = 300;
            
            
            $produto1 = Produto::create([
                'nome' => 'produto1',
                'preco_venda' => 300,
                'preco_custo' => 200,
                'percentual_comissao' => 5,
                'estoque' => 10,
                'categoria_id' => Categoria::factory()->create()->id,
            ]);

            $produto2 = Produto::create([
                'nome' => 'produto2',
                'preco_venda' => 700,
                'preco_custo' => 500,
                'percentual_comissao' => 2,
                'estoque' => 20,
                'categoria_id' => Categoria::factory()->create()->id,
            ]);

            $venda = Venda::factory()->create();

            // Criando o itemVenda1
            $itemVenda1 = ItemVenda::create([
                'venda_id' => $venda->id,
                'produto_id' => $produto1->id,
                'percentual_comissao' => $produto1->percentual_comissao,
                'quantidade' => 1,
                'preco_unitario' => $produto1->preco_venda,
            ]);
            // Criando o itemVenda2
            $itemVenda2 = ItemVenda::create([
                'venda_id' => $venda->id,
                'produto_id' => $produto2->id,
                'percentual_comissao' => $produto2->percentual_comissao,
                'quantidade' => 1,
                'preco_unitario' => $produto2->preco_venda,
            ]);

            $conta1 = ContaAReceber::create([
                'venda_id' => $venda->id,
                'data_vencimento' => now(),
                'status' => ContaAReceber::STATUS_PENDENTE,
                'valor' => 500,
            ]);
            $conta2 = ContaAReceber::create([
                'venda_id' => $venda->id,
                'data_vencimento' => now(),
                'status' => ContaAReceber::STATUS_PENDENTE,
                'valor' => 250,
            ]);
            $conta3 = ContaAReceber::create([
                'venda_id' => $venda->id,
                'data_vencimento' => now(),
                'status' => ContaAReceber::STATUS_PENDENTE,
                'valor' => 250,
            ]);
            $valorTotalContas = 1000;

            $conta2->update(['status' => ContaAReceber::STATUS_PAGO]);
    
            // Verificando se a comissão foi inserida.
            
            $this->assertDatabaseHas('comissoes', [
                'vendedor_id' => $venda->vendedor_id,
                'item_venda_id' => $itemVenda1->id,
                'conta_a_receber_id' => $conta2->id,
                'percentual_comissao' => $itemVenda1->percentual_comissao,
                'valor' =>  ($itemVenda1->quantidade * $itemVenda1->preco_unitario * $itemVenda1->percentual_comissao/100)/($valorTotalContas/$conta2->valor)
            ]);
        }
}
