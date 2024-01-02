<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Queue;
use App\Jobs\RemoveDiscount;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Queue::after(function ($event) {
            if ($event->job instanceof RemoveDiscount) {
                $job = $event->job;
                if (!$job->hasFailed()) {
                    $job->handle();
                }
            }
        });
    }
}
