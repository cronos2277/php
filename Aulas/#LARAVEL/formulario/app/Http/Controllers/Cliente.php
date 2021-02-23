<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente as ModelCliente;
use App\Models\Endereco;

class Cliente extends Controller
{
    public function index()
    {
        $title = '1 PARA 1 Exemplo';
        return view('pages.home',compact(['title']));
    }


    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $cliente = new Cliente();
        $cliente->nome = $request->input('nome');
        $cliente->email = $request->input('email');
        //$cliente->save();

        $endereco = new Endereco();
        $endereco->rua = $request->input('rua');
        $endereco->cidade = $request->input('cidade');
        $endereco->estado = $request->input('estado');
        //$endereco->cliente_id = $cliente->id;

        //$cliente->endereco()->save($endereco);
        return response('Created',201);
    }

    
    public function show($id = 0)
    {
        if($id == 0){
            $clientes = ModelCliente::with('endereco')->get();                        
            
        }else{
            $clientes = ModelCliente::with('endereco')->where(['cliente_id' => $id])->get();            
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
