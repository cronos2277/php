<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexCtrl extends Controller
{
    public function index(){
        return "<h1>Carregando indice</h1>";
    }
}
