<?php

use Brickx\Calendax\Tests\TestCase;
use Illuminate\Support\Carbon;

uses(TestCase::class)->in(__DIR__);

expect()->extend('toBeWithin', function (Carbon $start, Carbon $end) {
	return $this->get('startsAt')->toEqual($start) && $this->get('endsAt')->toEqual($end);
});
