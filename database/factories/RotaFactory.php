<?php

namespace Database\Factories;

use App\Models\Rota;
use App\Models\Funcionario;
use Illuminate\Database\Eloquent\Factories\Factory;

class RotaFactory extends Factory
{
    protected $model = Rota::class;

    public function definition()
    {
        return [
            'funcionario_id' => Funcionario::factory(),
            'placa_veiculo' => $this->faker->word(),
            'titulo' => $this->faker->word(),
            'descricao' => $this->faker->sentence(),
            'data_saida' => $this->faker->date(),
            'data_retorno' => $this->faker->date(),
            'status' => $this->faker->randomElement(Rota::getAllStatus()),

        ];
    }
}