<?php

namespace Database\Factories;

use App\Models\Compra;
use App\Models\Pessoa;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompraFactory extends Factory
{
    protected $model = Compra::class;

    public function definition()
    {
        return [
            'pessoa_id' => Pessoa::factory(),
            'data_compra' => $this->faker->date('Y-m-d'),
            'numero_nota' => $this->faker->randomFloat(2, 100, 10000),
            'total' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}

