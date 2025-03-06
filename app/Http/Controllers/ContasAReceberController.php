<?php

namespace App\Http\Controllers;

use App\Models\ContaAReceber;
use Exception;
use Illuminate\Http\Request;

class ContasAReceberController extends Controller
{
    //
    public function listContasAReceberAbertos(Request $request)
    {
        $limit = $request->get('limit', 9);
        $contasareceber = ContaAReceber::whereNot("status", ContaAReceber::STATUS_PAGO)
        ->with('venda:id,cliente_id,numero_documento')->with('venda.cliente:id,nome')
        ->orderBy('data_vencimento', 'ASC')->limit($limit)
        ->get();
        return response()->json($contasareceber);
    }


}
