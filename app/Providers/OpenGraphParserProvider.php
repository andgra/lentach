<?php

namespace App\Providers;

use OpenGraphParser\OpenGraphParser;
use Illuminate\Support\ServiceProvider;

class OpenGraphParserProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('OpenGraphParser', function()
        {
            return new OpenGraphParser;
        });
    }
}
