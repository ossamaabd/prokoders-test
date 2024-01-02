<?php

namespace App\Console\Commands;

use App\Models\Page;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class StoreRoutePages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'routes:store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'haha you have stored routes successfully';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $routes = Route::getRoutes()->getRoutes();

        foreach ($routes as $route) {
            if ($route->getName() != '' && $route->getAction()['middleware']['0'] == 'web') {
                $page = Page::where('title', $route->getName())->first();

                if (is_null($page)) {
                    Page::create(['title' => $route->getName(), 'route'=> $route->getName()]);
                }
            }
        }

        $this->info('Hahaha pages routes added successfully.');
    }
}
