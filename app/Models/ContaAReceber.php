<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContaAReceber extends Model
{
    use HasFactory;
    protected $table = 'contas_a_receber';
    protected $fillable = [
        'venda_id',
        'valor',
        'data_vencimento',
        'status',
    ];

    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class);
    }

    public static function getAllStatus(){
        return [
            self::STATUS_PENDENTE,
            self::STATUS_PAGO,
            self::STATUS_VENCIDO
        ];
    }
    // Constantes para status
    const STATUS_PENDENTE = 'pendente';
    const STATUS_PAGO = 'pago';
    const STATUS_VENCIDO = 'vencido';
}
