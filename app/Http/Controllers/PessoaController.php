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
        //$categoria = $request->input("categoria");
        
        $pessoas = Pessoa::when($search, function ($query) use ($search) {
            return $query->where('nome', 'like', "%{$search}%");
        })->orderBy('nome')->get();

        return response()->json($pessoas);
    }

}
