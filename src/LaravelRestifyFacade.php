<?php

namespace Limewell\LaravelRestify;

use Illuminate\Support\Facades\Facade;

class LaravelRestifyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'restify';
    }
}
