<?php

namespace Database\Factories;

use App\Models\Rota;
use App\Models\Venda;
use App\Models\Pessoa;
use App\Models\Funcionario;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendaFactory extends Factory
{
    protected $model = Venda::class;

    public function definition()
    {
        return [
            'fornecedor_id' => Pessoa::factory(),
            'vendedor_id' => Pessoa::factory(),
            'rota_id' => Rota::factory(),
            'data_venda' => $this->faker->date(),
            'total' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}
