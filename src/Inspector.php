<?php

namespace Prototype\ModelFinder;

use Symfony\Component\Finder\Finder;

class Inspector
{
    public function __construct(Finder $finder)
    {
        $this->finder = $finder;
    }

    public function locate()
    {
        $files = $this->finder->files()->in(base_path('app'))->name("*.php");


        ob_start();

            collect($files)->each(function ($file) {
                try {
                    require_once $file->getRealPath();
                } catch (Exception $e) {
                }
            });
        ob_end_clean();

        $classes = collect(get_declared_classes());

        return $classes->map(function ($class) {
            return new ReflectionClass($class);
        })

        ->reject(function ($class) {
            if (starts_with($class->getNamespaceName(), 'Illuminate')) {
                return true;
            }
            return false;
        })
        ->reject(function ($class) {
            if ($class->isSubclassOf(Model::class)) {
                return false;
            }
            return true;
        })->map(function ($model) {
            return $model->getName();
        })->values();
    }
}
