<?php 

namespace Deviam\Bancard;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\{Collection, ServiceProvider};

class BancardServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/bancard.php' => config_path('bancard.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    public function register()
    {
        //
    }
}