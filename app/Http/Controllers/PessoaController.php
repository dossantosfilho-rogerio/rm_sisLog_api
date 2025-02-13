<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;

class PessoaController extends Controller
{
    //
    public function listPessoas(Request $request)
    {
        $limit = $request->input("limit",9);
        $search = $request->input("search");
        $cpfcnpj = $request->input("cpfcnpj");
        $nome = $request->input("nome");
        //$categoria = $request->input("categoria");
        
        if($search){
            $pessoas = Pessoa::when($search, function ($query) use ($search) {
                return $query->where('nome', 'like', "%{$search}%");
            })
            ->orderBy('nome')->get();    
        } else {
            $pessoas = Pessoa::when($nome, function ($query) use ($nome) {
                return $query->where('nome', 'like', "%{$nome}%");
            })->when($cpfcnpj, function($query) use ($cpfcnpj) {
                return $query->where('cpfcnpj', 'like', "%{$cpfcnpj}%");
            })
            ->orderBy('nome')->get();    

        }

        return response()->json($pessoas);
    }



    public function createPessoa(Request $request){
        try{
            $inputs = $request->all();
            $pessoa = Pessoa::create($inputs);
            return response()->json($pessoa);
        } catch (Exception $e) {
            return response()->json(['Erro ao cadastrar a pessoa.'], 400);
        }
    }


}
