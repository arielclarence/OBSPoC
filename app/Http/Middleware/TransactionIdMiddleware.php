<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionIdMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->hasHeader('X-Transaction-Id') || ! $request->header('X-Transaction-Id')) {
            $transactionId = uniqid();
            $request->headers->set('X-Transaction-Id', $transactionId);
        }

        return $next($request);
    }
}
