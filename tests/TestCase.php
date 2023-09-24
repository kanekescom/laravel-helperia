<?php

namespace Kanekescom\Helperia\Tests;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Kanekescom\Helperia\HelperiaServiceProvider::class,
        ];
    }
}
