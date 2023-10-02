<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $role)
    {
        $type = 0;

        switch ($role) {
            case 'admin':
                $type = 1;
            break;
            case 'driver':
                $type = 2;
            break;
        }

        if ($request->user()->type == $type) { 
            return $next($request);
        }

        $response = [
            'success' => false,
            'message' => 'Forbidden',
            'data' => [],
            'code' => 403,
        ];
    
       
        return response()->json($response, 403);

    }
}
