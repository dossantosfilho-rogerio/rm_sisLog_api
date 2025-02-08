<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $fillable = [
        'pessoa_id',
        'data_admissao',
        'data_demissao',
    ];

    public function pessoa(){
        return $this->belongsTo(Pessoa::class);
    }

    // Relacionamento de um para muitos com produtos
    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }

    public static function getAllTipos(){
        return [self::TIPO_ADMINISTRATIVO, self::TIPO_ENTREGADOR, self::TIPO_VENDEDOR];
    }
    const TIPO_ADMINISTRATIVO = 'administrativo';
    const TIPO_VENDEDOR = 'vendedor';
    const TIPO_ENTREGADOR = 'entregador';
}