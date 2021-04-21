<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Quarto
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
        echo "<p style='color:purple;font-size:18px;'>Interceptado pelo quarto middleware</p>"; 
        return $next($request);
    }
}
