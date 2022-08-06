<?php

namespace Brickx\Calendax\Tests;

use Brickx\Calendax\CalendaxServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

// TODO: Checkout https://pestphp.com/docs/plugins/livewire and modify tests accordingly
class TestCase extends Orchestra
{
	protected function setUp() : void
	{
		parent::setUp();

		Factory::guessFactoryNamesUsing(
			fn (string $modelName) => 'Brickx\\Calendax\\Database\\Factories\\'.class_basename($modelName).'Factory'
		);
	}

	protected function getPackageProviders($app) : array
	{
		return [
			LivewireServiceProvider::class,
			CalendaxServiceProvider::class,
		];
	}

	protected function getEnvironmentSetUp($app)
	{
		config()->set('app.key', 'base64:VQ1rFQmlFsEtWng7pMojG25a/sjFmYlqS7WhCfPr4HY=');
	}
}
