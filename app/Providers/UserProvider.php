<?php

namespace App\Providers;

use App\Interfaces\UserInterface;
use App\Services\User;
use Illuminate\Support\ServiceProvider;


class UserProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserInterface::class,User::class);
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
