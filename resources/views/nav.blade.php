<form class='flex items-center justify-between py-4' wire:submit.prevent>
	<button wire:click.stop="goToPreviousMonth()">{!! __('pagination.previous') !!}</button>

	<div wire:ignore>
		{{-- TODO: Try to clean that up, ideally avoiding Alpine altogether (i.e. using 'wire:change' instead of 'x-on:change'), or handling that awful '$el._flatpickr' in a better way... --}}
		<x-calendax::flatpickr x-on:change='$wire.goToMonth($el._flatpickr.currentMonth + 1, $el._flatpickr.currentYear)' />
	</div>

	{{-- TODO: Maybe use that as a fallback, in case Flatpickr could not be loaded? Else remove it... --}}
	{{-- <fieldset>
		<label class='hidden' for='month'>Month</label>
		<select id='month' class='rounded border-gray-300 placeholder-transparent shadow-sm checked:text-orange-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50'
			name='month' wire:change="goToMonth($event.target.value, {{ $startsAt->year }})">
			@foreach (range(1, 12) as $month)
				<option value='{{ $month }}' @selected(old('month', $startsAt->month) == $month)>{{ $this->getMonthName($month) }}</option>
			@endforeach
		</select>

		<label class='hidden' for='year'>Year</label>
		<select id='year' class='rounded border-gray-300 placeholder-transparent shadow-sm checked:text-orange-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50'
			name='year' wire:change="goToMonth({{ $startsAt->month }}, $event.target.value)">
			@foreach (range($startsAt->year - 10, $startsAt->year + 10) as $year)
				<option value='{{ $year }}' @selected(old('year', $startsAt->year) == $year)>{{ $year }}</option>
			@endforeach
		</select>
	</fieldset> --}}

	<button wire:click.stop="goToNextMonth()">{!! __('pagination.next') !!}</button>
</form>
