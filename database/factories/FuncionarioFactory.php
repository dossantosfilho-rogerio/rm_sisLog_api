<?php

namespace Database\Factories;

use App\Models\Venda;
use App\Models\Pessoa;
use App\Models\Funcionario;
use Illuminate\Database\Eloquent\Factories\Factory;

class FuncionarioFactory extends Factory
{
    protected $model = Funcionario::class;

    public function definition()
    {
        return [
            'pessoa_id' => Pessoa::factory(),
            'data_admissao' => $this->faker->date(),
            'data_demissao' => $this->faker->date(),
            'tipo' => $this->faker->randomElement(Funcionario::getAllTipos()),

        ];
    }
}