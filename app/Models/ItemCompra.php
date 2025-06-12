<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCompra extends Model
{
    use HasFactory;
    protected $table = 'itens_compra';
    protected $fillable = [
        'compra_id',  // chave estrangeira
        'produto_id', // chave estrangeira
        'quantidade',
        'preco_unitario'
    ];

    // Relacionamento de muitos para um com compras
    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    // Relacionamento de muitos para um com produtos
    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($itemCompra) {
            $itemCompra->total = $itemCompra->quantidade * $itemCompra->preco_unitario;
        });

        static::created(function ($itemCompra) {
            MovimentacaoEstoque::create(
                [
                    'produto_id' => $itemCompra->produto_id,
                    'quantidade' => $itemCompra->quantidade,
                    'item_compra_id' => $itemCompra->id,
                    'tipo' => MovimentacaoEstoque::TIPO_ENTRADA
                ]
                );
        });

        static::deleted(function ($itemCompra) {
            $movimentacao = MovimentacaoEstoque::where('item_compra_id', $itemCompra->id)->first();
            $movimentacao->delete();
        });
    }

}
