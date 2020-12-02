<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class view_avancado extends Controller
{
    public function response($param = null){
        return view('componentes.avancado',compact(['param']));
    }
}
