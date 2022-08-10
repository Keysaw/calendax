<div id='{{ $containerId() }}' class='flatpickr-container'>
	<input type='text' id='{{ $id }}'
		{{ $attributes->class(['flatpickr-input rounded border-gray-300 placeholder-transparent shadow-sm checked:text-orange-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50']) }}
		x-data data-selector-id='{{ $selectorId() }}' data-config='@json($config())' data-disable-weekend='{{ $disableWeekend ? 1 : 0 }}' data-input autocomplete='off' />

	{{-- TODO: Make this work. See: https://github.com/Laratipsofficial/laravel-flatpickr --}}
	{{-- @if ($clearable)
		<a id="{{ $id }}-clearable" title='clear' class='flatpickr-clearable' data-clear>
			<x-heroicon-o-x />
		</a>
	@endif --}}
</div>
