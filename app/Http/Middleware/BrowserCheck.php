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
        if (!$this->isBrowser($request)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized request',
                'data' => new \stdClass()
            ], 403);
        }

        return $next($request);
    }

    private function isBrowser(Request $request): bool
    {
        $userAgent = $request->header('User-Agent');
        return $userAgent && !preg_match('/(Postman|Insomnia|curl|HTTPie|Wget)/i', $userAgent);
    }
}
