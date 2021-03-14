<?php

namespace App\Http\Controllers;

use App\Models\Motorista;
use App\Models\UsoMotoristaVeiculo;
use Illuminate\Http\Request;
use App\Models\Veiculo;

class ManyController extends Controller
{
    public function getAllVeiculo(){
        $veiculos = Veiculo::with('motoristas')->get();
        return response($veiculos->toJson(),200);
    }

    public function getAllMotorista(){
        $motoristas = Motorista::with('veiculos')->get();
        return response($motoristas->toJson(),200);
    }
    
}
