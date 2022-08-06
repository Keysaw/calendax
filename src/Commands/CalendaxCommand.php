<?php

namespace Brickx\Calendax\Commands;

use Illuminate\Console\Command;

// TODO: Handle that. See: https://laravel.com/docs/9.x/packages#about-artisan-command
class CalendaxCommand extends Command
{
	public $signature = 'calendax';
	public $description = 'Generate a new Calendax component';

	public function handle() : int
	{
		$this->comment('Calendar generated!');

		return self::SUCCESS;
	}
}
