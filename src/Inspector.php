<?php

namespace Prototype\ModelFinder;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

class Inspector
{
    public function __construct(Finder $finder)
    {
        $this->finder = $finder;
    }

    public function locate()
    {
        $files = $this->getAllFilesInThePath();

        $classes = $this->getAllClassesDeclared($files);

        return $this->filterAndGetTheModels($classes);
    }

    public function getAllFilesInThePath()
    {
        return $this->finder->files()->in(config('model.path'))->name("*.php");
    }

    public function getAllClassesDeclared($files)
    {
        ob_start();

            collect($files)->each(function ($file) {
                try {
                    require_once $file->getRealPath();
                } catch (Exception $e) {
                }
            });
        ob_end_clean();

        return collect(get_declared_classes());
    }

    public function filterAndGetTheModels($classes)
    {
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
