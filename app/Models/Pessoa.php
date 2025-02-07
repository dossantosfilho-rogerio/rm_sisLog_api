<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cpfcnpj',
        'email',
        'telefone',
        'logradouro',
        'numero',
        'cep',
        'bairro',
        'cidade',
        'uf',
        'complemento',
    ];

    // Relacionamento de um para muitos com vendas
    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }
    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}
