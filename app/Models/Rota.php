<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rota extends Model
{
    use HasFactory;

    protected $fillable = [
        'funcionario_id',
        'placa_veiculo',
        'titulo',
        'descricao',
        'data_saida',
        'data_retorno',
        'status',
    ];

    public function funcionario(){
        return $this->belongsTo(Funcionario::class);
    }

    // Relacionamento de um para muitos com produtos
    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }

    public static function getAllStatus(){
        return [self::STATUS_AGUARDANDO, self::STATUS_EMROTA, self::STATUS_RETORNADO];
    }
    const STATUS_AGUARDANDO = 'aguardando';
    const STATUS_EMROTA = 'em rota';
    const STATUS_RETORNADO = 'retornado';
}