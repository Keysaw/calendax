<?php

use Brickx\Calendax\Components\Flatpickr;
use Illuminate\Support\Carbon;

beforeEach(function () {
	$this->defaultDateFormat = 'd/m/Y';
	$this->defaultTimeFormat = 'H:i';
});

it('has default configuration values', function () {
	$component = new Flatpickr();

	expect($component->config())
		->toMatchArray([
			'dateFormat' => $this->defaultDateFormat,
			// TOFIX: Test these once working. See: Flatpickr.php
			/*'altInput' => true,*/
			'altFormat' => $this->defaultDateFormat,
			'disable' => [],
		]);
});

it('sets the default time to 24hr', function () {
	$component = new Flatpickr(
		showTime: true,
	);

	expect($component->config())
		->toMatchArray([
			'time_24hr' => true,
		]);
});

it('formats disabled dates', function () {
	$component = new Flatpickr(
		disable: [null, '', 0, 'today', '2022-06-13']
	);

	expect($component->config()['disable'])
		->toBeArray()
		->toHaveCount(2)
		->toEqual([today()->getTimestampMs(), Carbon::parse('2022-06-13')->getTimestampMs()]);
});

it('formats enabled dates', function () {
	$component = new Flatpickr(
		enable: [null, '', 0, 'today', '2022-06-13']
	);

	expect($component->config()['enable'])
		->toBeArray()
		->toHaveCount(2)
		->toEqual([today()->getTimestampMs(), Carbon::parse('2022-06-13')->getTimestampMs()]);
});

it('sets user-friendly date format', function () {
	$component = new Flatpickr(
		dateFormat: $this->defaultDateFormat
	);

	expect($component->config())
		->toMatchArray([
			'dateFormat' => $this->defaultDateFormat,
			'altFormat' => $this->defaultDateFormat,
		]);
});

it('matches the provided date user-friendly format', function () {
	$component = new Flatpickr(
		userFormat: 'd/m/Y'
	);

	expect($component->config())
		->toMatchArray([
			'dateFormat' => $this->defaultDateFormat,
			'altFormat' => 'd/m/Y',
		]);
});

it('matches the provided time format', function () {
	$component = new Flatpickr(
		showTime: true,
		timeFormat: $this->defaultTimeFormat
	);

	expect($component->config())
		->toMatchArray([
			'dateFormat' => $this->defaultDateFormat.' '.$this->defaultTimeFormat,
			'altFormat' => $this->defaultDateFormat.' '.$this->defaultTimeFormat,
		]);
});

it('can set time to 12hr', function () {
	$component = new Flatpickr(
		showTime: true,
		time24hr: false,
	);

	expect($component->config())
		->toMatchArray([
			'time_24hr' => false,
		]);
});

it('sets the default date according to provided value', function () {
	$component = new Flatpickr(
		value: today()
	);

	expect($component->config())
		->toMatchArray([
			'defaultDate' => today()->getTimestampMs(),
		]);
});

it('sets the default dates if \'multiple\' is true', function () {
	$component = new Flatpickr(
		multiple: true,
		value: [today(), today()->addDays(3), null]
	);

	expect($component->config())
		->toMatchArray([
			'defaultDate' => [today()->getTimestampMs(), today()->addDays(3)->getTimestampMs()],
		]);
});

it('can set the default date to a formatted string if \'range\' is true', function () {
	$component = new Flatpickr(
		range: true,
		value: '2022-06-13 to 2022-06-15'
	);

	expect($component->config())
		->toMatchArray([
			'defaultDate' => '2022-06-13 to 2022-06-15',
		]);
});

it('can set the default date to an array if \'range\' is true', function () {
	$component = new Flatpickr(
		range: true,
		value: ['2022-06-13', '2022-06-15']
	);

	expect($component->config())
		->toMatchArray([
			'defaultDate' => [
				Carbon::parse('2022-06-13')->getTimestampMs(),
				Carbon::parse('2022-06-15')->getTimestampMs(),
			],
		]);
});

it('cannot accept an array as value if no mode is set', function () {
	new Flatpickr(
		value: ['2022-06-13']
	);
})->throws('The value cannot be an array. Please provide a date string or a Carbon instance.');

it('cannot accept a string with the wrong formatting if mode is \'range\'', function () {
	new Flatpickr(
		range: true,
		value: '2022-06-13'
	);
})->throws('The two dates must be a string, and be separated by "to" when \'range\' is set.');

it('cannot accept an array with less than 2 items if mode is \'range\'', function () {
	new Flatpickr(
		range: true,
		value: ['2022-06-13']
	);
})->throws('The value must be an array with only 2 dates when \'range\' is set.');

it('cannot accept an array with more than 2 items if mode is \'range\'', function () {
	new Flatpickr(
		range: true,
		value: ['2022-06-11', '2022-06-13', '2022-06-15']
	);
})->throws('The value must be an array with only 2 dates when \'range\' is set.');

it('can only accept an array if mode is \'multiple\'', function () {
	new Flatpickr(
		multiple: true,
		value: '2022-06-13'
	);
})->throws('The value must be an array of dates or Carbon instances when \'multiple\' is set.');
