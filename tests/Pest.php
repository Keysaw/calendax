<?php

use Brickx\Calendax\Tests\TestCase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Illuminate\Support\Carbon;

uses(TestCase::class, InteractsWithViews::class)->in('Unit', 'Feature');

expect()->extend('toBeWithin', function (Carbon $start, Carbon $end) {
	return $this->get('startsAt')->toEqual($start) && $this->get('endsAt')->toEqual($end);
});
