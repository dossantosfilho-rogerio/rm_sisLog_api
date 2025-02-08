<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = [
        'pessoa_id', // chave estrangeira
        'funcionario_id', // chave estrangeira
        'rota_id',
        'data_venda',
        'total',
    ];

    // Relacionamento de muitos para um com pessoa
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }

    // Relacionamento de muitos para um com Funcionario
    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
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
