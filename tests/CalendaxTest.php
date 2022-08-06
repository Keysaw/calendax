<?php

use Brickx\Calendax\Calendax;
use Illuminate\Support\Carbon;
use function Pest\Livewire\livewire;

beforeEach(function () {
	$this->calendar = livewire(Calendax::class)->assertOk();
});

it('can build component', function () {
	// Assert the component is built
	expect($this->calendar)->not()->toBeNull();
});

it('can display months names', function () {
	// Loop through each month index
	foreach (range(1, 12) as $month) {
		// Assert that we get the proper month name
		$monthName = $this->calendar->instance()->getMonthName($month);
		expect($monthName)->toEqual(today()->startOfMonth()->month($month)->translatedFormat('F'));
	}
});

it('can navigate to previous month', function () {
	// Navigate to the previous month
	$this->calendar->call('goToPreviousMonth');

	// Assert that the calendar starts & ends last month
	expect($this->calendar)->toBeWithin(
		today()->startOfMonth()->subMonthNoOverflow(),
		today()->endOfMonth()->startOfDay()->subMonthNoOverflow()
	);
});

it('can navigate to current month', function () {
	// Set calendar to start 3 months ago
	$this->calendar->set('startsAt', today()->startOfMonth()->subMonthsNoOverflow(3));
	$this->calendar->set('endsAt', today()->endOfMonth()->startOfDay()->subMonthsNoOverflow(3));

	// Navigate to the current month
	$this->calendar->call('goToCurrentMonth');

	// Assert that the calendar starts & ends this month
	expect($this->calendar)->toBeWithin(
		today()->startOfMonth(),
		today()->endOfMonth()->startOfDay()
	);
});

it('can navigate to next month', function () {
	// Navigate to the next month
	$this->calendar->call('goToNextMonth');

	// Assert that the calendar starts & ends next month
	expect($this->calendar)->toBeWithin(
		today()->startOfMonth()->addMonthNoOverflow(),
		today()->endOfMonth()->startOfDay()->addMonthNoOverflow()
	);
});

it('can navigate to specific month', function () {
	// Set calendar to start 3 months ago
	$this->calendar->set('startsAt', today()->startOfMonth()->subMonthsNoOverflow(3));
	$this->calendar->set('endsAt', today()->endOfMonth()->startOfDay()->subMonthsNoOverflow(3));

	// Navigate to the next two month this year
	$this->calendar->call('goToMonth', $month = today()->startOfMonth()->addMonthsNoOverflow(2)->month, $year = today()->startOfYear()->year);

	// Assert that the calendar starts & ends in two months
	expect($this->calendar)->toBeWithin(
		Carbon::createMidnightDate($year, $month)->startOfMonth(),
		Carbon::createMidnightDate($year, $month)->endOfMonth()->startOfDay()
	);

	// Navigate to the same month next year
	$this->calendar->call('goToMonth', $month = today()->startOfMonth()->month, $year = today()->startOfYear()->addYearNoOverflow());

	// Assert that the calendar starts & ends next year
	expect($this->calendar)->toBeWithin(
		Carbon::createMidnightDate($year, $month)->startOfMonth(),
		Carbon::createMidnightDate($year, $month)->endOfMonth()->startOfDay()
	);
});
