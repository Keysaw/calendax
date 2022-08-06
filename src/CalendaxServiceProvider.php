<?php

namespace Brickx\Calendax;

use Brickx\Calendax\Commands\CalendaxCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CalendaxServiceProvider extends PackageServiceProvider
{
	public function configurePackage(Package $package) : void
	{
		$package->name('calendax')
			->hasConfigFile()
			->hasViews()
			->hasMigration('create_calendax_table')
			->hasCommand(CalendaxCommand::class);
	}
}
