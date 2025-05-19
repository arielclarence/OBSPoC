<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Spatie\Prometheus\Http\Controllers\PrometheusMetricsController;

Route::get('/', function () {
    return view('welcome');
});

// Correct usage for an invokable controller
Route::get('/prometheus', PrometheusMetricsController::class)
    ->name('prometheus.default'); // name matters!
// Route for simulating memory usage


