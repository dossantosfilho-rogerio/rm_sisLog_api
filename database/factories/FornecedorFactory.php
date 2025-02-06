<?php
namespace Database\Factories;

use App\Models\Fornecedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class FornecedorFactory extends Factory
{
    protected $model = Fornecedor::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->company,
            'cpfcnpj' => $this->faker->numerify('##.###.###/####-##'),
            'email' => $this->faker->unique()->safeEmail,
            'telefone' => $this->faker->phoneNumber,
            'logradouro' => $this->faker->sentence,
            'numero' => $this->faker->numberBetween(0,100),
            'cep' =>  $this->faker->numberBetween(10000000,99999999),
            'bairro' => $this->faker->word,
            'cidade' =>$this->faker->word,
            'uf' =>$this->faker->word,
            'complemento' =>$this->faker->sentence
        ];
    }
}
