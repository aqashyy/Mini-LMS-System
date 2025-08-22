<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class apiLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('API Request',[
            'ip'    => $request->ip(),
            'user_id' => $request->user()->id ?? 'is public route',
            'method' => $request->method(),
            'url'   => $request->fullUrl(),
            'body'  => $request->all(),
        ]);
        
        return $next($request);
    }
}
