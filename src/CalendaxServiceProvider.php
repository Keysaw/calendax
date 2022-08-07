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
			->hasCommand(CalendaxCommand::class);
	}
}
