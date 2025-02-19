<?php

namespace App\Http\Controllers;

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

        $vendas = Venda::with('cliente:id,nome','itensVenda:id,venda_id,produto_id,quantidade,total,preco_unitario', 'itensVenda.produto:id,nome')
        ->when($numero_documento, function ($query) use ($numero_documento) {
            $query->where('numero_documento', '%'.$numero_documento.'%');
        })
        ->paginate($limit);
    
        return response()->json($vendas);
    }

    public function createVenda(Request $request){
        try{
            $itens_venda = $request->get('produtos');
            $total = 0;
            foreach ($itens_venda as $key => $item) {
                $total += $item['quantidade'] * $item['preco_unitario'];
            }
            DB::beginTransaction();
            $venda = Venda::create([
                'cliente_id' => $request->get('cliente_id'),
                'vendedor_id' => $request->get('vendedor_id'),
                'rota_id' => $request->get('rota_id'),
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
            DB::commit();
            return response()->json($venda);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['Erro ao cadastrar a venda.' . $e->getMessage()], 400);
        }
    }

}
