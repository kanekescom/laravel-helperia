<?php

namespace Kanekescom\Helperia;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Kanekescom\Helperia\Commands\HelperiaCommand;

class HelperiaServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-helperia')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_helperia_table')
            ->hasCommand(HelperiaCommand::class);
    }
}
