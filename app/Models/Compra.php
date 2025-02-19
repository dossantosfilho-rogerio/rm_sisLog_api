<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'pessoa_id',
        'numero_nota',
        'total',
        'data_compra',
    ];

    // Relacionamento de muitos para um com pessoas
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }

    // Relacionamento de um para muitos com itens de compra
    public function itensCompra()
    {
        return $this->hasMany(ItemCompra::class);
    }
}
