<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Segundo
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
        echo "<p style='color:red;font-size:18px;'>Interceptado pelo segundo middleware</p>"; 
        return $next($request);
    }
}
