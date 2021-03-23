<?php

namespace App\Http\Controllers;

use App\Models\Motorista;
use App\Models\UsoMotoristaVeiculo;
use Illuminate\Http\Request;
use App\Models\Veiculo;
use Exception;

class ManyController extends Controller
{
    public function index(){
        $title = "Many to Many";
        return view('ntom.home',compact(['title']));
    }

    public function getAllVeiculo(){
        $veiculos = Veiculo::with('motoristas')->get();
        return response($veiculos->toJson(),200);
    }

    public function getAllMotorista(){
        $motoristas = Motorista::with('veiculos')->get();
        return response($motoristas->toJson(),200);
    }

    public function updateVeiculo(Request $request, $id){        
            try{
                $veiculo = Veiculo::find($id);
                $veiculo->placa = ($request->input('placa')) ? $request->input('placa') : $veiculo->placa;
                $veiculo->cor = ($request->input('cor')) ? $request->input('cor') : $veiculo->cor;
                $veiculo->luxo = ($request->input('luxo') == 'true') ? true : false;
                $veiculo->save();
                return response('UPDATED',202);
            }catch(Exception $e){
                echo $e->getMessage();
                echo "\n";
                return response("BAD REQUEST ON UPDATE",401);
            }        
    }

    public function updateMotorista(Request $request, $id){        
            try{
                $motorista = Motorista::find($id);
                $motorista->nome = ($request->input('nome')) ? $request->input('nome') : $motorista->nome;                
                $motorista->cpf = ($request->input('cpf')) ? $request->input('cpf') : $motorista->cpf;                
                $motorista->save();
                return response('UPDATED',202);
            }catch(Exception $e){
                echo $e->getMessage();
                echo "\n";
                return response("BAD REQUEST ON UPDATE",401);
            }        
    }
    
}
