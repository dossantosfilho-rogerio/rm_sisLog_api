<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemVenda extends Model
{
    use HasFactory;
    protected $table = 'itens_venda';
    protected $fillable = [
        'venda_id', // chave estrangeira
        'produto_id', // chave estrangeira
        'quantidade',
        'percentual_comissao',
        'preco_unitario',
    ];

    // Relacionamento de muitos para um com vendas
    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }

    // Relacionamento de muitos para um com produtos
    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($itemVenda) {
            $itemVenda->total = $itemVenda->quantidade * $itemVenda->preco_unitario;
        });

        static::created(function ($itemVenda) {
            MovimentacaoEstoque::create([
                'produto_id' => $itemVenda->produto_id,
                'quantidade' => $itemVenda->quantidade,
                'item_venda_id' => $itemVenda->id,
                'tipo' => MovimentacaoEstoque::TIPO_SAIDA
            ]);
        });
        static::deleting(function ($itemVenda) {

            $venda = Venda::findOrFail($itemVenda->venda_id);
            $venda->update(['total' => $venda->total -= $itemVenda->total]);

            $movimentacao = MovimentacaoEstoque::where('item_venda_id', $itemVenda->id)->first();
            $movimentacao->delete();
        });
    }
}
