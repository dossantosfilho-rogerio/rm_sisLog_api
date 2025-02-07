<?php

namespace App\Http\Controllers;

use App\Models\Compra;
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
            $query->where('id', $numero_documento);
        })
        ->paginate($limit);
    
        return response()->json($compras);
    }

}
