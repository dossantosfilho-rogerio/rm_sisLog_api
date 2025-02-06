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
    }
}
