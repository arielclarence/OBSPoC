<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Prometheus\Facades\Prometheus;

class RecordHttpMetrics
{
    protected $requestDurationSum;
    protected $requestDurationCount;
    protected $requestCounter;
    protected $errorCounter;

    public function __construct()
    {
        $this->requestDurationSum = Prometheus::addCounter('http_request_duration_seconds_sum')
            ->helpText('Sum of HTTP request durations in seconds')
            ->labels(['method', 'path', 'status']);

        $this->requestDurationCount = Prometheus::addCounter('http_request_duration_seconds_count')
            ->helpText('Count of HTTP requests for duration calculation')
            ->labels(['method', 'path', 'status']);

        $this->requestCounter = Prometheus::addCounter('http_requests_total')
            ->helpText('Total HTTP requests')
            ->labels(['method', 'path', 'status']);

        $this->errorCounter = Prometheus::addCounter('http_errors_total')
            ->helpText('Total HTTP error responses')
            ->labels(['method', 'path', 'status']);
    }

    public function handle($request, Closure $next)
    {
        $start = microtime(true);

        $response = $next($request);

        $duration = microtime(true) - $start;
        $method = $request->method();
        $path = $request->path();
        $status = $response->status();

        $this->requestDurationSum->incBy($duration, [$method, $path, (string) $status]);
        $this->requestDurationCount->inc([$method, $path, (string) $status]);
        $this->requestCounter->inc([$method, $path, (string) $status]);

        if ($status >= 400) {
            $this->errorCounter->inc([$method, $path, (string) $status]);
        }

        return $response;
    }
}
