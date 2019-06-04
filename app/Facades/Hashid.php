<?php

namespace App\Facades;

use App\Support\Hashids;
use Illuminate\Support\Facades\Facade;

class Hashid extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Hashids::class;
    }
}
