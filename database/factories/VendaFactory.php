<?php

namespace Database\Factories;

use App\Models\Venda;
use App\Models\Cliente;
use App\Models\Vendedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendaFactory extends Factory
{
    protected $model = Venda::class;

    public function definition()
    {
        return [
            'cliente_id' => Cliente::factory(),
            'vendedores_id' => Vendedor::factory(),
            'data_venda' => $this->faker->date(),
            'total' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}
