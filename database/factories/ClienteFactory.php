<?php
namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'cpfcnpj' => $this->faker->numerify('###.###.###-##'),
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
