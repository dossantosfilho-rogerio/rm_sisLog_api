<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = [
        'pessoa_id', // chave estrangeira
        'vendedores_id', // chave estrangeira
        'data_venda',
        'total',
    ];

    // Relacionamento de muitos para um com pessoa
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }

    // Relacionamento de muitos para um com Vendedor
    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class);
    }


    // Relacionamento de um para muitos com itens de venda
    public function itensVenda()
    {
        return $this->hasMany(ItemVenda::class);
    }

    // Relacionamento de um para um com conta a receber
    public function contaAReceber()
    {
        return $this->hasOne(ContaAReceber::class);
    }
}
