<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BrowserCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $postmanToken = $request->header('Postman-Token');

        // Check for the presence of headers that indicate a Postman request
        if (!empty($postmanToken)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized request',
                'data' => new \stdClass()
            ], 403);
        }

        return $next($request);
    }
}
