<?php

declare(strict_types=1);

use App\Http\Controllers\ExampleController\ExampleController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], static function(): void {
    Route::get('/example', [ExampleController::class, 'index']);
});
