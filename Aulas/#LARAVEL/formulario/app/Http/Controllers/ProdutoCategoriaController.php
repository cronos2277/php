<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
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

    function atualizarCategoria(Request $request, $id){
        try{
            $categoria = Categoria::find($id);
            $categoria->nome = $request->input('nome');
            $categoria->update();
            response('Updated',202);
        }catch(\Exception $e){
            return response($e->getMessage(),500);
        }
    }

    function atualizarProdutoCategoria(Request $request, $id){
        try{
            $produto = Produto::find($id);
            $numero = $request->input('categoria_id');
            $produto->categoria_id = ($numero > 0) ? $numero : null;
            $produto->update();
            response('Updated',202);
        }catch(\Exception $e){
            return response($e->getMessage(),500);
        }
    }

    function atualizarProdutoEstoque(Request $request, $id){
        try{
            $produto = Produto::find($id);
            $estoque = ($request->input('estoque') > 0) ?$request->input('estoque'):0;
            $produto->estoque = $estoque;
            $produto->update();
            response('Updated',202);
        }catch(\Exception $e){
            return response($e->getMessage(),500);
        }
    }
}
