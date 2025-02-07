<?php

namespace App\Http\Controllers;

use App\Models\Produto;
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

}
