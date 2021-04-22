<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Second
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $param1, $param2)
    {
        echo "<p style='color:red;font-size:18px'>Executando middleware PRÉ CONTROLLER SECOND com parametros: [$param1,$param2]</p>";
        $req = $next($request);
        echo "<p style='color:red;font-size:18px'>Executando middleware SECOND PÓS CONTROLLER com parametros: [$param1,$param2]</p>";
        return $req;
    }
}
