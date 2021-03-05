<?php

namespace App\Http\Controllers;

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
}
