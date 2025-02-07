<?php
namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    protected $model = Produto::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->word,
            'descricao' => $this->faker->sentence,
            'preco_venda' => $this->faker->randomFloat(2, 1, 500),
            'preco_custo' => $this->faker->randomFloat(2, 1, 500),
            'percentual_comissao' => $this->faker->randomFloat(2, 1, 500),
            'estoque' => $this->faker->randomNumber(2),
            'categoria_id' => Categoria::factory(),
        ];
    }
}

