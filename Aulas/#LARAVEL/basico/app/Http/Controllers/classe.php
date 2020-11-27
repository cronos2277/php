<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class classe extends Controller
{
    public function metodo($param1,$param2){
        for($i=0; $i<$param1;$i++):
            echo $param2;
        endfor;
    }
}
