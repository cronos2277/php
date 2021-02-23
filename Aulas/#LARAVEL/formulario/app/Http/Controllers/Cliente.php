<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente as ModelCliente;

class Cliente extends Controller
{
    public function index()
    {
        $title = '1 PARA 1 Exemplo';
        return view('clientes.home',compact(['title']));
    }


    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show($id = 0)
    {
        if($id == 0){
            $clientes = ModelCliente::with('endereco')->get();                        
            
        }else{
            $clientes = ModelCliente::find($id);
            //$clientes->with(['endereco'])->get();
        }

        return $clientes->toJson();
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
