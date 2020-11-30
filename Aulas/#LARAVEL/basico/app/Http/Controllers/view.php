<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class view extends Controller
{
    public function view_simples($parametro){
        return view('pasta.arquivo_simples',['parametro' => $parametro]);
    }

    public function template(){
        return view('pasta.template');
    }
}
