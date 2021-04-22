<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Third
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $numero = random_int(0,10);
        if($numero >= 5){
            echo "<p style='color:green;font-size:18px'>Executando middleware THIRD PRÉ CONTROLLER sem parametros e podendo interceptar.</p>";
            $req = $next($request);
        }else{
            echo "Valor de número = $numero, ou seja o MIDDLEWARE vai bloquear";
            return response("BLOQUEADO!!!!",403);
        }
        
        echo "<p style='color:green;font-size:18px'>Executando middleware THIRD PÓS CONTROLLER sem parametros e podendo interceptar.</p>";
        return $req;
    }
}
