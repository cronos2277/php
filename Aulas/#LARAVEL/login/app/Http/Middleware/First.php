<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class First
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $param1)
    {
        echo "<p style='color:blue;font-size:18px'>Executando  middleware PRÉ CONTROLLER FIRST com parametro $param1</p>";
        $req = $next($request);
        echo "<p style='color:blue;font-size:18px'>Executando middleware FIRST PÓS CONTROLLER com parametro $param1</p>";
        return $req;
    }
}
