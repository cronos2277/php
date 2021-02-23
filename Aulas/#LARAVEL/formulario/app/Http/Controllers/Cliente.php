<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente as ModelCliente;
use App\Models\Endereco;
use Exception;

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
        $cliente = new ModelCliente();
        $cliente->nome = $request->input('nome');
        $cliente->email = $request->input('email');
        $cliente->save();

        $endereco = new Endereco();
        $endereco->rua = $request->input('rua');
        $endereco->cidade = $request->input('cidade');
        $endereco->estado = $request->input('estado');        

        $cliente->endereco()->save($endereco);
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
            $clientes = ModelCliente::with('endereco')->get();         
            $cliente = $clientes->find($id);                        
            if($cliente){                
                $cliente->nome = $request->input('nome');                
                $cliente->email = $request->input('email');
                
                $cliente->endereco->cliente_id = $request->input('id');
                $cliente->endereco->rua = $request->input('rua');
                $cliente->endereco->cidade = $request->input('cidade');
                $cliente->endereco->estado = $request->input('estado');
                $cliente->push();
                return response('Updated',202);
            }else{
                return response('Not Found',404);
            }            
    }

    
    public function destroy($id)
    {
        $clientes = ModelCliente::with('endereco')->get();         
        $cliente = $clientes->find($id);
        if($cliente){
            $cliente->delete();
            return response('Deleted',204);
        }else{
            return response('Not Found',404);
        }        
    }
}
