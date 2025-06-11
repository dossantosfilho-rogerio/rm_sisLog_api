<?php

namespace App\Http\Controllers;

use App\Models\ContaAReceber;
use App\Models\Produto;
use App\Models\Venda;
use App\Models\ItemVenda;
use DB;
use Exception;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    //
    public function listVendas(Request $request)
    {
        $limit = $request->input("limit",9);
        $numero_documento = $request->input("numero_documento");
        $fornecedor_id = $request->input("fornecedor_id");
        $rota_id = $request->input("rota_id");

        $vendas = Venda::with('cliente:id,nome','itensVenda:id,venda_id,produto_id,quantidade,total,preco_unitario', 'itensVenda.produto:id,nome')
        ->when($numero_documento, function ($query) use ($numero_documento) {
            $query->where('numero_documento', '%'.$numero_documento.'%');
        })->when($rota_id, function($query) use ($rota_id){
            $query->where('rota_id', $rota_id)->orderBy('data_venda');
        })
        ->get();
    
        return response()->json($vendas);
    }

    public function existVenda(Request $request)
    {
        $numero_documento = $request->input("numero_documento");

        $venda = Venda::when($numero_documento, function ($query) use ($numero_documento) {
            $query->where('numero_documento', $numero_documento);
        })
        ->first();
        return $venda? true : false;
        //return response()->json($venda);
    }

    public function createVenda(Request $request){
        try{
            $itens_venda = $request->get('produtos');
            $contas_a_receber = $request->get('contasAReceber');
            $total = 0;
            foreach ($itens_venda as $key => $item) {
                $total += $item['quantidade'] * $item['preco_unitario'];
            }
            DB::beginTransaction();
            $venda = Venda::create([
                'cliente_id' => $request->get('cliente_id'),
                'vendedor_id' => $request->get('vendedor_id'),
                'rota_id' => $request->get('rota_id'),
                'numero_documento' => $request->get('numero_documento'),
                'data_venda' => $request->get('data_venda'),
                'total' => $total
            ]);
            
            
            foreach ($itens_venda as $key => $item) {
                ItemVenda::create([
                    'venda_id' => $venda->id,
                    'produto_id' => $item['produto_id'],
                    'preco_unitario' => $item['preco_unitario'],
                    'quantidade' => $item['quantidade'],
                    'percentual_comissao' => Produto::findOrFail($item['produto_id'])->percentual_comissao
                ]);
            }

            foreach ($contas_a_receber as $item){
                if(strtotime($item['data_vencimento']) < strtotime(date('Y-m-d'))){
                    $item['status'] = ContaAReceber::STATUS_VENCIDO;
                } else {
                    $item['status'] = ContaAReceber::STATUS_PENDENTE;
                }
                ContaAReceber::create([
                    'venda_id' => $venda->id,
                    'valor' => $item['valor'],
                    'data_vencimento' => $item['data_vencimento'],
                    'status' => $item['status']
                ]);
            }
            DB::commit();
            return response()->json($venda);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['Erro ao cadastrar a venda.' . $e->getMessage()], 400);
        }
    }

}
