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
use Illuminate\Support\Facades\Queue;

class PrometheusServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register counters for HTTP request metrics, matching your middleware labels
        Prometheus::addGauge('laravel_memory_usage')
            ->helpText('Current memory usage of the Laravel process in bytes')
            ->value(fn() => memory_get_usage(true));

        Prometheus::addGauge('laravel_cpu_usage_percent')
            ->helpText('CPU usage percent by Laravel process')
            ->value(function() {
                $pid = getmypid();
                $cpu = shell_exec("ps -p $pid -o %cpu | tail -n 1");
                return floatval(trim($cpu));
            });

//        Prometheus::addGauge('queue_pending_jobs')
//            ->helpText('Number of jobs waiting in the queue')
//            ->value(fn() => Queue::size('default'));

        Prometheus::addGauge('current_unix_timestamp')
            ->helpText('The current Unix timestamp')
            ->value(fn() => time());

        // Uncomment if using Horizon
        // $this->registerHorizonCollectors();
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
