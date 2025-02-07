<?php

namespace Database\Factories;

use App\Models\Venda;
use App\Models\Pessoa;
use App\Models\Vendedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendedorFactory extends Factory
{
    protected $model = Vendedor::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->word,
        ];
    }
}