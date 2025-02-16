<?php

namespace App\Http\Controllers;

use App\Models\Rota;
use Exception;
use Illuminate\Http\Request;

class RotaController extends Controller
{
    //
    public function listRotas(Request $request)
    {
        $limit = $request->input("limit",9);
        $titulo = $request->input("titulo");
        $data_saida = $request->input("data_saida");
        
        $rotas = Rota::when($titulo, function ($query) use ($titulo) {
            return $query->where('titulo', 'like', "%{$titulo}%");
        })->when($data_saida, function ($query) use ($data_saida) {
            return $query->where('data_saida', $data_saida);
        })->withCount('vendas')
        ->orderBy('titulo')->paginate($limit); // Retorna $limit produtos por página
    
        return response()->json($rotas);
    }

    public function listRotasSelect(Request $request)
    {
        $limit = $request->input("limit",9);
        $name = $request->input("search");
        //$categoria = $request->input("categoria");
        
        $rotas = Rota::when($name, function ($query) use ($name) {
            return $query->where('titulo', 'like', "%{$name}%");
        })->orderBy('titulo')->limit($limit)->get(); // Retorna $limit produtos por página
    
        return response()->json($rotas);
    }

    public function createRota(Request $request){
        try{
            $inputs = $request->all();
            $rota = Rota::create($inputs);
            return response()->json($rota);
        } catch (Exception $e) {
            return response()->json(['Erro ao cadastrar a rota.'. $e->getMessage()], 400);
        }
    }

}
