<?php

namespace Database\Factories;

use App\Models\Compra;
use App\Models\Fornecedor;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompraFactory extends Factory
{
    protected $model = Compra::class;

    public function definition()
    {
        return [
            'fornecedor_id' => Fornecedor::factory(),
            'data_compra' => $this->faker->date('Y-m-d'),
            'total' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}

