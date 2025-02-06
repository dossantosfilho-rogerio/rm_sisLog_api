<?php

namespace Database\Factories;

use App\Models\ContaAReceber;
use App\Models\Pagamento;
use App\Models\Venda;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagamentoFactory extends Factory
{
    protected $model = Pagamento::class;

    public function definition()
    {
        return [
            'contas_a_receber_id' => ContaAReceber::factory(),
            'valor_pago' => $this->faker->randomFloat(2, 50, 5000),
            'tipo' => $this->faker->randomElement(Pagamento::getAllTipos()),
        ];
    }
}

