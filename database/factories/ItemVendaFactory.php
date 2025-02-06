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
        return [
            'venda_id' => Venda::factory(),
            'produto_id' => Produto::factory(),
            'quantidade' => $this->faker->randomNumber(2),
            'preco_unitario' => $this->faker->randomFloat(2, 1, 500),
        ];
    }
}
