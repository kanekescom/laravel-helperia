<?php

namespace Kanekescom\Helperia\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kanekescom\Helperia\Helperia
 */
class Helperia extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Kanekescom\Helperia\Helperia::class;
    }
}
