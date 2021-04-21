<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControladorController extends Controller
{
    public function __construct()
    {
        $this->middleware(\App\Http\Middleware\Terceiro::class);        
    }
    public function index(){
        return "<br>Middleware index";
    }
}
