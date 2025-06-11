<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenAuth
{

    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('voter')) {
            return redirect()->route('login')->with('error', 'Silakan login dengan token terlebih dahulu.');
        }

        return $next($request);
    
    }
}