<?php

namespace Prototype\ModelFinder;

use Illuminate\Support\ServiceProvider;
use Prototype\ModelFinder\Inspector;
use Symfony\Component\Finder\Finder;

class ModelFinderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/model.php' => config_path('model.php'),
        ], 'config');
    }

    public function register()
    {
        $this->app->bind(Inspector::class, function () {
            return new Inspector(new Finder);
        });
    }
}
