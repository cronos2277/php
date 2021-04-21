<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Terceiro
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
        echo "<p style='color:green;font-size:18px;'>Interceptado pelo terceiro middleware</p>"; 
        return $next($request);
    }
}
