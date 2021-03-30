<?php

namespace App\Http\Controllers;

use App\Models\Motorista;
use App\Models\UsoMotoristaVeiculo;
use Illuminate\Http\Request;
use App\Models\Veiculo;
use Exception;
use Illuminate\Support\Facades\Date;

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
    
    public function newMotorista(Request $request){
        try{
            $motorista = new Motorista();
            $motorista->nome = $request->input('nome');
            $motorista->cpf = $request->input('cpf');
            $motorista->save();
            return response('CREATED',201);
        }catch(Exception $e){
            echo $e->getMessage();
            echo "\n";
            return response("BAD REQUEST ON UPDATE",401);
        }
    }

    public function newVeiculo(Request $request){
        try{
            $veiculo = new Veiculo();
            $veiculo->placa = $request->input('placa');
            $veiculo->cor = $request->input('cor');
            $veiculo->luxo = ($request->input('luxo') == 'on') ? true : false;
            $veiculo->save();
            return response('CREATED',201);
        }catch(Exception $e){
            echo $e->getMessage();
            echo "\n";
            return response("BAD REQUEST ON UPDATE",401);
        }
    }

    public function deleteMotorista($id){
        try{
            $motorista = Motorista::find($id);
            $motorista->delete();
            return response('Deleted',204);
        }catch(Exception $e){
            return response($e->getMessage(),401);
        }
    }

    public function deleteVeiculo($id){
        try{
            $veiculo = Veiculo::find($id);
            $veiculo->delete();
            return response('Deleted',204);
        }catch(Exception $e){
            return response($e->getMessage(),401);
        }
    }

    public function assocMotorista(Request $request, $id){
        try{
            $motorista = Motorista::find($id);
            $veiculo_id = $request->input('id');            
            $motorista->veiculos()->attach([$veiculo_id => ["ultimo_uso" => date("Y-m-d")]]);
            $motorista->save();
            return response('ASSOCIATED',202);
        }catch(Exception $e){
            return response($e->getMessage(),500);
        }
    }

    public function assocVeiculo(Request $request, $id){
        try{           
            $veiculo = Veiculo::find($id);
            $motorista_id = $request->input('id');
            $veiculo->motoristas()->attach([$motorista_id => ["ultimo_uso" => date("Y-m-d")]]);
            $veiculo->save();
            return response('ASSOCIATED',202);
        }catch(Exception $e){
            return response($e->getMessage(),500);
        }
    }

    
}
