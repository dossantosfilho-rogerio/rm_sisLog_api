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
        $numero_documento = $request->get('numero_documento');
        $contasareceber = ContaAReceber::with('venda:id,cliente_id,numero_documento')->with('venda.cliente:id,nome')
        ->when($numero_documento, function($query) use ($numero_documento) {
            $query->whereHas('venda', function($query) use ($numero_documento){
                $query->whereLike('numero_documento', $numero_documento);
            });
        })
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
            $valor_pago = $request->input('params.valor');
            DB::beginTransaction();
            $contaareceber = ContaAReceber::whereNot('status', ContaAReceber::STATUS_PAGO)->findOrFail($id);
            if($valor_pago < $contaareceber->valor){
                $novaConta = new ContaAReceber();
                $novaConta->valor = $contaareceber->valor - $valor_pago;
                $novaConta->venda_id = $contaareceber->venda_id;
                $novaConta->data_vencimento = $contaareceber->data_vencimento;
                if(strtotime($novaConta->data_vencimento) > strtotime(date('Y-m-d'))){
                    $novaConta->status = contaareceber::STATUS_PENDENTE;
                } else {
                    $novaConta->status = contaareceber::STATUS_VENCIDO;
                }
                $novaConta->save();
                $contaareceber->valor = $valor_pago;
            }
            $contaareceber->status = ContaAReceber::STATUS_PAGO;
            $contaareceber->save();

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
