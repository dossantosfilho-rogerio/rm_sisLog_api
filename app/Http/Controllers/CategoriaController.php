<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Exception;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    //
    public function listCategorias(Request $request)
    {
        $limit = $request->input("limit",9);
        $name = $request->input("name");
        //$categoria = $request->input("categoria");
        
        $categorias = Categoria::when($name, function ($query) use ($name) {
            $query->where('nome', 'like', "%{$name}%");
        })->withSum('produtos', 'estoque')
        ->withCount('produtos') 
        ->orderBy(column: 'nome')->paginate($limit); // Retorna $limit categorias por página
    
        return response()->json($categorias);
    }

    public function listCategoriasSelect(Request $request)
    {
        $limit = $request->input("limit",9);
        $name = $request->input("search");
        //$categoria = $request->input("categoria");
        
        $categorias = Categoria::when($name, function ($query) use ($name) {
            return $query->where('nome', 'like', "%{$name}%");
        })->orderBy('nome')->limit($limit)->get(); // Retorna $limit categorias por página
    
        return response()->json($categorias);
    }

    public function createCategoria(Request $request){
        try{
            $inputs = $request->all();
            $pessoa = Categoria::create($inputs);
            return response()->json($pessoa);
        } catch (Exception $e) {
            return response()->json(['Erro ao cadastrar a categoria de Produto.'], 400);
        }
    }

     public function getCategoria(Request $request)
    {
        try{
            $id = $request->input("id");
            
            $rota = Categoria::with('produtos')->findOrFail($id);
        
            return response()->json($rota);

        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

}
