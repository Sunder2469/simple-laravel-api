<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CurrencyFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'currency';
    }
}
