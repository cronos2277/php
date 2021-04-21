<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Primeiro
{
    
    public function handle(Request $request, Closure $next)
    {
        echo "<p style='color:blue;font-size:18px;'>Interceptado pelo primeiro middleware</p>";        
        return $next($request);
    }
}
