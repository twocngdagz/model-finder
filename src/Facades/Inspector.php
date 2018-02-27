<?php

namespace Prototype\ModelFinder\Facades;

use Illuminate\Support\Facades\Facade;
use Prototype\ModelFinder\Inspector;

class Model extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Inspector::class;
    }
}
