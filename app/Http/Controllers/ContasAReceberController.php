<?php

namespace App\Http\Controllers;

use App\Models\ContaAReceber;
use App\Models\Pagamento;
use DB;
use Exception;
use Illuminate\Http\Request;
use function PHPUnit\Framework\throwException;

class ContasAReceberController extends Controller
{
    //
    public function listContasAReceber(Request $request)
    {
        $limit = $request->get('limit', 9);
        $contasareceber = ContaAReceber::with('venda:id,cliente_id,numero_documento')->with('venda.cliente:id,nome')
        ->orderBy('data_vencimento', 'ASC')
        ->get();
        return response()->json($contasareceber);
    }


    public function createContaAReceber(Request $request)
    {
        try{
            $id = $request->input('params.idPedidoVenda');
            $conta = $request->input('params.conta');
            DB::beginTransaction();
            $conta['venda_id'] = $id;
            if(strtotime($conta['data_vencimento']) < strtotime(date('Y-m-d'))){
                $conta['status'] = ContaAReceber::STATUS_VENCIDO;
            } else {
                $conta['status'] = ContaAReceber::STATUS_PENDENTE;
            }
            ContaAReceber::create($conta);
            
            DB::commit();
            return response()->json($conta);

        } catch (Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function baixarContaAReceber(Request $request)
    {
        try{
            $id = $request->input('params.id');
            DB::beginTransaction();
            $contaareceber = ContaAReceber::whereNot('status', ContaAReceber::STATUS_PAGO)->findOrFail($id);
            $contaareceber->update(['status' => ContaAReceber::STATUS_PAGO]);

            $pagamento = new Pagamento();
            $pagamento->contas_a_receber_id = $contaareceber->id;
            $pagamento->valor_pago = $request->input('params.valor');
            $pagamento->tipo = $request->input('params.tipo');
            $pagamento->data_pagamento = $request->input('params.data_pagamento');
            $pagamento->save();
            DB::commit();
            return response()->json($contaareceber);

        } catch (Exception $e){
            DB::rollBack();
            throw $e;
        }
    }


    public function deleteContaAReceber(Request $request)
    {
        try{
            $id = $request->input('params.id');
            $contaareceber = ContaAReceber::findOrFail($id);
            if($contaareceber->status == 'pago'){
                throw new Exception('Conta paga não pode ser excluída.');
            }
            $contaareceber->delete();
            return true;

        } catch (Exception $e){
            throw $e;
        }
    }


}
