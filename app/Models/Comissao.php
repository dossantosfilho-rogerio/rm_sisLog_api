<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comissao extends Model
{
    use HasFactory;
    protected $table = 'comissoes';
    protected $fillable = ['vendedores_id', 'item_venda_id', 'percentual_comissao', 'valor'];

    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class);
    }

    public function itemVenda()
    {
        return $this->belongsTo(ItemVenda::class);
    }
}
