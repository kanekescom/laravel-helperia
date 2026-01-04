<?php

namespace Kanekescom\Helperia;

use Kanekescom\Helperia\Commands\TransCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

/**
 * Helperia Service Provider.
 *
 * Registers the package with Laravel application.
 */
class HelperiaServiceProvider extends PackageServiceProvider
{
    /**
     * Configure the package.
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-helperia')
            ->hasCommand(TransCommand::class);
    }
}
