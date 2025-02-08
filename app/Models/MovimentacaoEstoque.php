<?php
namespace App\Models;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentacaoEstoque extends Model
{
    use HasFactory;
    protected $table = 'movimentacoes_estoque';

    protected $fillable = ['produto_id', 'item_venda_id', 'item_compra_id', 'quantidade', 'tipo', 'observacao'];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
    public function itemVenda()
    {
        return $this->belongsTo(ItemVenda::class);
    }
    public function itemCompra()
    {
        return $this->belongsTo(ItemCompra::class);
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($movimentacao) {
            if ($movimentacao->item_venda_id && $movimentacao->tipo !== self::TIPO_SAIDA) {
                throw new \Exception('Se for venda, o tipo deve ser "saída".');
            }
            if ($movimentacao->item_compra_id && $movimentacao->tipo !== self::TIPO_ENTRADA) {
                throw new \Exception('Se for compra, o tipo deve ser "entrada".');
            }
        });

        //Atualiza o estoque do produto automaticamente.
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