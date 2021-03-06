<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class ProdutoCategoriaController extends Controller
{
    
    public function index()
    {
        $title = 'One To One';
        return view('1ton.home',compact('title'));
    }     

    function todosProdutos(){
        $produtos = \App\Models\Produto::with('categoria')->get();
        return $produtos->toJson();
    }

    function todasCategorias(){
        $categorias = \App\Models\Categoria::all();
        return $categorias->toJson();
    }

    function adicionarProduto(Request $request){

    }

    function adicionarCategoria(Request $request){
        $categoria = new Categoria();        
        $categoria->nome = $request->input('nome');
        try{
            $categoria->save();
            return response('Created',201);
        }catch(\Exception $e){
            return response($e->getMessage(),401);
        }
    }

    function removerCategoria($id){
        try{
            $categoria = Categoria::find($id);
            $categoria->delete();
            return response('Deleted',204);
        }catch(\Exception $e){
            return response($e->getMessage(),401);
        }
    }
}
