<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;
    protected $table = 'fornecedores';
    protected $fillable = [
        'nome',
        'cpfcnpj',
        'telefone',
        'email',
        'logradouro',
        'numero',
        'cep',
        'bairro',
        'cidade',
        'uf',
        'complemento',
    ];

    // Relacionamento de um para muitos com compras
    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}
