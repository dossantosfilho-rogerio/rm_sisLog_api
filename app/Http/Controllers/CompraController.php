<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\ItemCompra;
use DB;
use Exception;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    //
    public function listCompras(Request $request)
    {
        $limit = $request->input("limit",9);
        $numero_documento = $request->input("numero_documento");
        $fornecedor_id = $request->input("fornecedor_id");

        $compras = Compra::with('pessoa:id,nome','itensCompra:id,compra_id,produto_id,quantidade,total,preco_unitario', 'itensCompra.produto:id,nome')
        ->when($fornecedor_id, function ($query) use ($fornecedor_id) {
            $query->where('pessoa_id', $fornecedor_id);
        })
        ->when($numero_documento, function ($query) use ($numero_documento) {
            $query->where('numero_nota', '%'.$numero_documento.'%');
        })
        ->paginate($limit);
    
        return response()->json($compras);
    }

    public function createCompra(Request $request){
        try{
            $itens_compra = $request->get('produtos');
            $total = 0;
            foreach ($itens_compra as $key => $item) {
                $total += $item['quantidade'] * $item['preco_unitario'];
            }
            DB::beginTransaction();
            $compra = Compra::create([
                'pessoa_id' => $request->get('pessoa_id'),
                'numero_nota' => $request->get('numero_nota'),
                'data_compra' => $request->get('data_compra'),
                'total' => $total
            ]);
            
            
            foreach ($itens_compra as $key => $item) {
                ItemCompra::create([
                    'compra_id' => $compra->id,
                    'produto_id' => $item['produto_id'],
                    'preco_unitario' => $item['preco_unitario'],
                    'quantidade' => $item['quantidade'],
                ]);
            }
            DB::commit();
            return response()->json($compra);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['Erro ao cadastrar a compra.'. $e->getMessage()], 400);
        }
    }

    public function existCompra(Request $request)
    {
        $numero_nota = $request->input("numero_nota");

        $compra = Compra::when($numero_nota, function ($query) use ($numero_nota) {
            $query->where('numero_nota', $numero_nota);
        })
        ->first();
        return $compra? true : false;
        //return response()->json($compra);
    }


}
