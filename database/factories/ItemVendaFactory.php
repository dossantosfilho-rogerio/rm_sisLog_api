<?php

namespace Database\Factories;

use App\Models\ItemVenda;
use App\Models\Venda;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemVendaFactory extends Factory
{
    protected $model = ItemVenda::class;

    public function definition()
    {
        $produto = Produto::factory()->create();
        return [
            'venda_id' => Venda::factory(),
            'produto_id' => $produto->id,
            'quantidade' => $this->faker->randomNumber(2),
            'percentual_comissao' => $produto->percentual_comissao,
            'preco_unitario' => $produto->preco_venda,
        ];
    }
}
