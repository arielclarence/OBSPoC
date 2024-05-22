<?php

declare(strict_types=1);

use App\Http\Controllers\ExampleController\ExampleController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::get('/health', static function() {
    return response()->json([
        "code" => Response::HTTP_OK,
        "message" => "Health Check for PIM API is successful"
    ]);
});

Route::group(['prefix' => 'v1'], static function(): void {
    Route::get('/example', [ExampleController::class, 'index']);
});