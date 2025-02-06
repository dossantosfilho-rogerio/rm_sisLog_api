<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'fornecedor_id', // chave estrangeira
        'total',
        'data_compra',
    ];

    // Relacionamento de muitos para um com fornecedores
    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }

    // Relacionamento de um para muitos com itens de compra
    public function itensCompra()
    {
        return $this->hasMany(ItemCompra::class);
    }
}
