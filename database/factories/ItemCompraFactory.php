<?php

namespace Database\Factories;

use App\Models\ItemCompra;
use App\Models\Compra;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemCompraFactory extends Factory
{
    protected $model = ItemCompra::class;

    public function definition()
    {
        return [
            'compra_id' => Compra::factory(),
            'produto_id' => Produto::factory(),
            'quantidade' => $this->faker->randomNumber(2),
            'preco_unitario' => $this->faker->randomFloat(2, 1, 500),
        ];
    }
}

