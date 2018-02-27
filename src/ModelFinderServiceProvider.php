<?php

namespace Prototype\ModelFinder;

use Illuminate\Support\ServiceProvider;
use Prototype\ModelFinder\Inspector;
use Symfony\Component\Finder\Finder;

class ModelFinderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Inspector::class, function () {
            return new Inspector(new Finder);
        });
    }
}
