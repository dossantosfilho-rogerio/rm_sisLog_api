<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id', // chave estrangeira
        'vendedor_id', // chave estrangeira
        'rota_id',
        'data_venda',
        'total',
    ];

    // Relacionamento de muitos para um com pessoa
    public function cliente()
    {
        return $this->belongsTo(Pessoa::class, 'cliente_id', 'id');
    }

    // Relacionamento de muitos para um com Funcionario
    public function vendedor()
    {
        return $this->belongsTo(Pessoa::class, 'id', 'vendedor_id');
    }

    public function rota()
    {
        return $this->belongsTo(Rota::class);
    }


    // Relacionamento de um para muitos
    public function itensVenda()
    {
        return $this->hasMany(ItemVenda::class);
    }

    public function contaAReceber()
    {
        return $this->hasMany(ContaAReceber::class);
    }
}
