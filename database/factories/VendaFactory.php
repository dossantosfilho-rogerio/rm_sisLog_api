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
            'pessoa_id' => Pessoa::factory(),
            'funcionario_id' => Funcionario::factory(),
            'rota_id' => Rota::factory(),
            'data_venda' => $this->faker->date(),
            'total' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}
