<?php

namespace Brickx\Calendax\Facades;

use Brickx\Calendax\Calendax as CalendaxComponent;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Brickx\Calendax\Calendax
 */
class Calendax extends Facade
{
	protected static function getFacadeAccessor() : string
	{
		return CalendaxComponent::class;
	}
}
