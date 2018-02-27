<?php

namespace Prototype\ModelFinder;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\Finder;

class ModelFinderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Inspector::class, function () {
            return new Inspector(new Finder);
        });
    }
}
