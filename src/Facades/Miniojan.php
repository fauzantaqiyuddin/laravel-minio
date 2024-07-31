<?php

namespace Fauzantaqiyuddin\LaravelMinio\Facades;

use Illuminate\Support\Facades\Facade;

class Miniojan extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'miniojan';
    }
}
