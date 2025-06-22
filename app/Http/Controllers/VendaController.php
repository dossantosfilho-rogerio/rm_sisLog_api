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
        $cliente_id = $request->input("cliente_id");
        $rota_id = $request->input("rota_id");

        $vendas = Venda::with('cliente:id,nome','itensVenda:id,venda_id,produto_id,quantidade,total,preco_unitario', 'itensVenda.produto:id,nome')
        ->when($numero_documento, function ($query) use ($numero_documento) {
            $query->where('numero_documento', 'LIKE', '%'.$numero_documento.'%');
        })->when($rota_id, function($query) use ($rota_id){
            $query->where('rota_id', $rota_id);
        })->when($cliente_id, function($query) use ($cliente_id){
            $query->where('cliente_id', $cliente_id);
        })
        ->orderBy('data_venda', 'DESC')
        ->get();
    
        return response()->json($vendas);
    }


    public function getVenda(Request $request)
    {
        try{
            $id = $request->input("id");

            $venda = Venda::with(['vendedor', 'rota', 'cliente', 'contaAReceber', 'itensVenda', 'itensVenda.produto'])
            ->findOrFail($id);
            return response()->json($venda);

        } catch (Exception $e) {
            throw $e;
        }
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


    public function createItemVenda(Request $request){
        try{
            DB::beginTransaction();
            $idVenda = $request->input('params.idPedidoVenda');
            $produto = $request->input('params.produto');
            $produto['venda_id'] = $idVenda;
            $produto = ItemVenda::create([
                    'venda_id' => $idVenda,
                    'produto_id' => $produto['produto_id'],
                    'preco_unitario' => $produto['preco_unitario'],
                    'quantidade' => $produto['quantidade'],
                    'percentual_comissao' => Produto::findOrFail($produto['produto_id'])->percentual_comissao
                ]);
            
            DB::commit();
           
            return response()->json($produto);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


     public function deleteItemVenda(Request $request){
        try{
            DB::beginTransaction();
            $idItemVenda = $request->input('params.id');
            $ItemVenda = ItemVenda::findOrFail($idItemVenda);
            $ItemVenda->delete();
            DB::commit();
           
            return response()->json($ItemVenda);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function updateVenda(Request $request){
        try{
            $id = $request->get('id');
            $venda = Venda::findOrFail($id);
            $venda->update([
                'cliente_id' => $request->get('cliente_id'),
                'vendedor_id' => $request->get('vendedor_id'),
                'rota_id' => $request->get('rota_id'),
                'numero_documento' => $request->get('numero_documento'),
                'data_venda' => $request->get('data_venda'),
            ]);
            
           
            return response()->json($venda);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['Erro ao atualizar a venda.' . $e->getMessage()], 400);
        }
    }

}
