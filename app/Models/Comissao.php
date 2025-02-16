<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comissao extends Model
{
    use HasFactory;
    protected $table = 'comissoes';
    protected $fillable = ['vendedor_id', 'item_venda_id', 'conta_a_receber_id', 'percentual_comissao', 'valor'];

    public function funcionario()
    {
        return $this->belongsTo(Pessoa::class, 'id', 'vendedor_id');
    }

    public function itemVenda()
    {
        return $this->belongsTo(ItemVenda::class, 'id', 'item_venda_id');
    }
    

    public static function gerarComissao(ContaAReceber $contaAReceber){
        $venda = $contaAReceber->venda;

        // Obter todas as contas a receber pagas para essa venda
        $totalPago = $venda->contaAReceber()->where('status', ContaAReceber::STATUS_PAGO)->sum('valor');

        // Não houve pagamento nenhum....
        if ($totalPago <= 0) {
            return;
        }
        $totalVenda = $venda->itensVenda()->sum('total');

        foreach ($venda->itensVenda as $item) {
            // Valor total da comissão do item
            $comissaoTotalItem = ($item->preco_unitario * $item->quantidade * $item->percentual_comissao) / 100;

            // Valor proporcional dessa conta a receber
            $valorProporcional = ($contaAReceber->valor / $totalVenda) * $comissaoTotalItem;

            // Criar a comissão proporcional apenas se ainda não foi gerada para esta conta e item
            Comissao::create([
                'vendedor_id' => $venda->vendedor_id,
                'item_venda_id' => $item->id,
                'conta_a_receber_id' => $contaAReceber->id,
                'percentual_comissao' => $item->percentual_comissao,
                'valor' => $valorProporcional,
            ]);
        }
    }
}
