<?php

namespace App\Http\Controllers;

use App\Models\ContaAReceber;
use App\Models\Pagamento;
use DB;
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

    public function baixarContaAReceber(Request $request)
    {
        try{
            $id = $request->input('params.id');
            DB::beginTransaction();
            $contaareceber = ContaAReceber::whereNot('status', 'pago')->findOrFail($id);
            $contaareceber->update(['status' => 'pago']);

            $pagamento = new Pagamento();
            $pagamento->contas_a_receber_id = $contaareceber->id;
            $pagamento->valor_pago = $contaareceber->valor;
            $pagamento->tipo = 'dinheiro';
            $pagamento->save();
            DB::commit();
            return response()->json($contaareceber);

        } catch (Exception $e){
            DB::rollBack();
            throw $e;
        }
    }


}
