<?php

declare(strict_types=1);

namespace App\Providers;

use BAS\LogzIo\Validators\LogzIoConfigValidator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Ramsey\Uuid\Uuid;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->validateLoggingConfiguration();
        Model::shouldBeStrict();

        Http::globalRequestMiddleware(static fn ($request) => $request->withHeader(
            'X-Transaction-Id',
            $request->input('X-Transaction-Id') ?? Uuid::uuid4()->toString()
        ));

        Http::globalResponseMiddleware(static fn ($response) => $response->withHeader('X-Transaction-Id'));
    }

    /**
     * Validates the logging configuration for each channel that uses the LogzIoHandler.
     *
     * @throws \LogicException If a required key is missing, or if a key value doesn't match the expected value and type.
     */
    protected function validateLoggingConfiguration(): void
    {
        if (!config('logging.channels') || !is_array(config('logging.channels'))) {
            return;
        }

        LogzIoConfigValidator::validate(config('logging.channels'));
    }
}
