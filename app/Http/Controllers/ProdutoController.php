<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Exception;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    //
    public function listProdutos(Request $request)
    {
        $limit = $request->input("limit",9);
        $name = $request->input("name");
        //$categoria = $request->input("categoria");
        
        $produtos = Produto::when($name, function ($query) use ($name) {
            return $query->where('nome', 'like', "%{$name}%");
        })->orderBy('nome')->paginate($limit); // Retorna $limit produtos por página
    
        return response()->json($produtos);
    }

    public function listProdutosSelect(Request $request)
    {
        $limit = $request->input("limit",9);
        $name = $request->input("search");
        //$categoria = $request->input("categoria");
        
        $produtos = Produto::when($name, function ($query) use ($name) {
            return $query->where('nome', 'like', "%{$name}%");
        })->orderBy('nome')->limit($limit)->get(); // Retorna $limit produtos por página
    
        return response()->json($produtos);
    }

    public function createProduto(Request $request){
        try{
            $inputs = $request->all();
            $pessoa = Produto::create($inputs);
            return response()->json($pessoa);
        } catch (Exception $e) {
            return response()->json(['Erro ao cadastrar o produto.'], 400);
        }
    }

}
