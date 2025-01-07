<?php

namespace App\Http\Middleware;

use App\Services\CsrfTokenService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

class StatelessCsrfMiddleware
{
    private CsrfTokenService $csrfTokenService;

    public function __construct(CsrfTokenService $csrfTokenService)
    {
        $this->csrfTokenService = $csrfTokenService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip CSRF check for read-only methods
        if (in_array($request->method(), ['HEAD', 'GET', 'OPTIONS'])) {
            return $next($request);
        }

        $token = $request->header('X-CSRF-TOKEN') ?? $request->input('_token');

        if (!$token || !$this->csrfTokenService->validate($token)) {
            if ($request->expectsJson()) {
                return new JsonResponse(['message' => 'CSRF token mismatch'], 419);
            }
            abort(419, 'CSRF token mismatch');
        }

        // Generate new token for the next request
        $newToken = $this->csrfTokenService->refresh($token);
        
        $response = $next($request);
        
        // Add new token to response headers
        $response->headers->set('X-CSRF-TOKEN', $newToken);
        
        // Also set token in meta tag for Blade views
        if (!$request->expectsJson() && method_exists($response, 'getContent')) {
            $content = $response->getContent();
            $metaTag = '<meta name="csrf-token" content="' . $newToken . '">';
            $content = preg_replace('/<\/head>/', $metaTag . "\n</head>", $content);
            $response->setContent($content);
        }

        return $response;
    }
}
