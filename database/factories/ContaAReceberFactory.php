<?php

namespace Database\Factories;

use App\Models\ContaAReceber;
use App\Models\Venda;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContaAReceberFactory extends Factory
{
    protected $model = ContaAReceber::class;

    public function definition()
    {
        return [
            'venda_id' => Venda::factory(),
            'valor' => $this->faker->randomFloat(2, 50, 5000),
            'data_vencimento' => $this->faker->date(),
            'status' => $this->faker->randomElement(ContaAReceber::getAllStatus()),
        ];
    }
}
