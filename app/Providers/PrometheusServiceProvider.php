<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Spatie\Prometheus\Collectors\Horizon\CurrentMasterSupervisorCollector;
use Spatie\Prometheus\Collectors\Horizon\CurrentProcessesPerQueueCollector;
use Spatie\Prometheus\Collectors\Horizon\CurrentWorkloadCollector;
use Spatie\Prometheus\Collectors\Horizon\FailedJobsPerHourCollector;
use Spatie\Prometheus\Collectors\Horizon\HorizonStatusCollector;
use Spatie\Prometheus\Collectors\Horizon\JobsPerMinuteCollector;
use Spatie\Prometheus\Collectors\Horizon\RecentJobsCollector;
use Spatie\Prometheus\Facades\Prometheus;

class PrometheusServiceProvider extends ServiceProvider
{
    public function register()
    {
        /*
         * Here you can register all the exporters that you
         * want to export to prometheus
         */
        Prometheus::addGauge('My gauge')
            ->value(function() {
                return 123.45;
            });
        Prometheus::addGauge('Laravel memory usage')
            ->helpText('Current memory usage of the Laravel process in bytes')
            ->value(fn() => memory_get_usage(true));

        Prometheus::addGauge('random_test_value')
            ->helpText('A random value to test Prometheus metrics')
            ->value(fn() => rand(1, 1000));

        Prometheus::addGauge('current_unix_timestamp')
            ->helpText('The current Unix timestamp')
            ->value(fn() => time());
        /*
         * Uncomment this line if you want to export
         * all Horizon metrics to prometheus
         */
//         $this->registerHorizonCollectors();
    }

    public function registerHorizonCollectors(): self
    {
        Prometheus::registerCollectorClasses([
            CurrentMasterSupervisorCollector::class,
            CurrentProcessesPerQueueCollector::class,
            CurrentWorkloadCollector::class,
            FailedJobsPerHourCollector::class,
            HorizonStatusCollector::class,
            JobsPerMinuteCollector::class,
            RecentJobsCollector::class,
        ]);

        return $this;
    }
}
