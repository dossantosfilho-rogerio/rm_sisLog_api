<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'contas_a_receber_id', // chave estrangeira
        'valor_pago',
        'tipo',
    ];

    // Relacionamento de muitos para um com contas a receber
    public function contaAReceber()
    {
        return $this->belongsTo(ContaAReceber::class);
    }

    public static function getAllTipos(){
        return [
            self::TIPO_CARTÃO, self::TIPO_DINHEIRO, self::TIPO_TRANSFERÊNCIA
        ];
    }

    // Constantes para status
    const TIPO_CARTÃO = 'cartão';
    const TIPO_DINHEIRO = 'dinheiro';
    const TIPO_TRANSFERÊNCIA = 'transferência';
}
