<?php

namespace App\Providers;

use App\Interfaces\FileInterface;
use App\Interfaces\PopupInterface;
use App\Services\File ;
use App\Services\PopupService;
use Illuminate\Support\ServiceProvider;

class FileProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FileInterface::class,File::class);
        $this->app->bind(PopupInterface::class,PopupService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
