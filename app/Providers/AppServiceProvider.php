<?php

declare(strict_types=1);

namespace App\Providers;

use BAS\LogzIo\Validators\LogzIoConfigValidator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

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
