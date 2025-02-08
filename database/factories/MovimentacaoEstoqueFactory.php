<?php

namespace Database\Factories;

use App\Models\MovimentacaoEstoque;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovimentacaoEstoqueFactory extends Factory
{
    /**
     * O nome do model correspondente à factory.
     *
     * @var string
     */
    protected $model = MovimentacaoEstoque::class;

    /**
     * Define os atributos padrão do model.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'produto_id' => Produto::factory(), // Cria um produto associado
            'quantidade' => $this->faker->numberBetween(1, 100), // Quantidade aleatória
            'tipo' => $this->faker->randomElement(['entrada', 'saida']), // Tipo aleatório
            'observacao' => $this->faker->sentence(), // Observação fictícia
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Data aleatória no último ano
        ];
    }
}