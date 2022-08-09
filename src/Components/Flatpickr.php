<?php

namespace Brickx\Calendax\Components;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Flatpickr extends Component
{
	/**
	 * @throws Exception
	 */
	public function __construct(public string|int|null $id = null, public bool $multiple = false, public bool $range = false, public ?int $visibleMonths = null, public bool $disableWeekend = false, public bool $showTime = false, public bool $time24hr = true, public string $dateFormat = 'd/m/Y', public string $timeFormat = 'H:i', public array $enable = [], public array $disable = [], public string|Carbon|null $minDate = null, public string|Carbon|null $maxDate = null, public string|null $minTime = null, public string|null $maxTime = null, public string|array|Carbon|null $value = null, public bool $clearable = false)
	{
		// Generate a random ID if none was provided
		$this->id = $this->id ?: Str::random();

		// Set value to current date if not provided
		$this->value = $this->value ?: today();

		// Set the number of visible months according to mode
		if ($this->mode() === 'range' && $this->visibleMonths === null) {
			$this->visibleMonths = 2;
		}

		$this->throwValueExceptions();
	}

	public function config() : array
	{
		return collect([
			'locale' => App::currentLocale(),
			'mode' => $this->mode(),
			'showMonths' => $this->visibleMonths,
			'enableTime' => $this->showTime,
			'time_24hr' => $this->time24hr(),
			'dateFormat' => $this->dateFormat(),
			// TOFIX: This breaks the calendar, loading the page indefinitely...
			/*'altInput' => true,
			'altFormat' => $this->userFormat ?: $this->dateFormat(),*/
			'enable' => count($this->enable) > 0 ? $this->enable() : null,
			'disable' => $this->disable(),
			'minDate' => $this->minDate(),
			'maxDate' => $this->maxDate(),
			'minTime' => $this->minTime,
			'maxTime' => $this->maxTime,
			'defaultDate' => $this->default(),
			// TODO: Somehow this is used to enable clearing the input. See: https://flatpickr.js.org/examples/#flatpickr--external-elements
			/*'wrap' => $this->clearable,*/
		])
			->filter(fn ($item) => $item !== null)
			->toArray();
	}

	public function containerId() : string
	{
		return "$this->id-container";
	}

	public function selectorId() : string
	{
		return $this->clearable ? $this->containerId() : $this->id;
	}

	public function render() : View
	{
		return view('calendax::components.flatpickr');
	}

	private function mode() : ?string
	{
		if ($this->range) {
			return 'range';
		}

		return $this->multiple ? 'multiple' : null;
	}

	private function time24hr() : ?bool
	{
		return $this->showTime ? $this->time24hr : null;
	}

	private function dateFormat() : string
	{
		return $this->showTime ? "$this->dateFormat $this->timeFormat" : $this->dateFormat;
	}

	private function enable() : array
	{
		return $this->formatDates($this->enable);
	}

	private function disable() : array
	{
		return $this->formatDates($this->disable);
	}

	private function minDate() : ?int
	{
		return $this->minDate ? Carbon::parse($this->minDate)->getTimestampMs() : $this->minDate;
	}

	private function maxDate() : ?int
	{
		return $this->maxDate ? Carbon::parse($this->maxDate)->getTimestampMs() : $this->maxDate;
	}

	private function default() : string|int|array|null
	{
		if (!$this->value) {
			return null;
		}

		if ($this->multiple) {
			return $this->formatDates($this->value);
		}

		if ($this->range) {
			if (is_array($this->value)) {
				return $this->formatDates($this->value);
			}

			return $this->value;
		}

		return Carbon::parse($this->value)->getTimestampMs();
	}

	private function formatDates(array $items) : array
	{
		return collect($items)
			->filter()
			->map(fn ($item) => Carbon::parse($item)->getTimestampMs())
			->values()
			->toArray();
	}

	/**
	 * @throws Exception
	 */
	private function throwValueExceptions()
	{
		if (!$this->value) {
			return;
		}

		switch ($this->mode()) {
			case 'multiple':
				if (!is_array($this->value)) {
					throw new Exception('The value must be an array of dates or Carbon instances when "multiple" is set.');
				}

				break;

			case 'range':
				if (is_array($this->value)) {
					if (count($this->value) !== 2) {
						throw new Exception('The value must be an array with only 2 dates when "range" is set.');
					}

					return;
				}

				if (!is_string($this->value)) {
					throw new Exception('The value must be a string when "range" is set.');
				}

				if (!Str::contains($this->value, ' to ')) {
					throw new Exception('The two dates must be a string, and be separated by "to" when "range" is set.');
				}

				break;

			default:
				if (is_array($this->value)) {
					throw new Exception('The value cannot be an array. Please provide a date string or a Carbon instance.');
				}

				break;
		}
	}
}
