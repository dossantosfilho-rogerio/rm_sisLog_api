<?php
namespace App\Models;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentacaoEstoque extends Model
{
    use HasFactory;
    protected $table = 'movimentacoes_estoque';

    protected $fillable = ['produto_id', 'quantidade', 'tipo', 'observacao'];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($movimentacao) {
            $produto = Produto::findOrFail($movimentacao->produto_id);
            if($movimentacao->tipo == self::TIPO_ENTRADA) {
                $produto->estoque += $movimentacao->quantidade;
            } else if($movimentacao->tipo == self::TIPO_SAIDA) {
                $produto->estoque -= $movimentacao->quantidade;
            }
            $produto->save();
        });
    }

    const TIPO_ENTRADA = 'entrada';
    const TIPO_SAIDA = 'saida';
}