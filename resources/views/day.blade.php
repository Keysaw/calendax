<div class='h-40 min-w-[10rem] flex-1 border-b border-inherit lg:h-48 [&:not(:first-of-type)]:border-l'
	ondragenter="onCalendaxEventDragEnter(event, '{{ $componentId }}', '{{ $day }}', '{{ $dragAndDropClasses }}');"
	ondragleave="onCalendaxEventDragLeave(event, '{{ $componentId }}', '{{ $day }}', '{{ $dragAndDropClasses }}');" ondragover="onCalendaxEventDragOver(event);"
	ondrop="onCalendaxEventDrop(event, '{{ $componentId }}', '{{ $day }}', {{ $day->year }}, {{ $day->month }}, {{ $day->day }}, '{{ $dragAndDropClasses }}');">

	<div id='{{ $componentId }}-{{ $day }}' class='h-full w-full'>
		<div @class([
		    'flex h-full w-full flex-col p-2',
		    'bg-white' => $dayInMonth && !$isToday,
		    'bg-indigo-50' => $dayInMonth && $isToday,
		    'bg-gray-100' => !$dayInMonth,
		]) @if ($dayClickEnabled)
			wire:click="onDayClick({{ $day->year }}, {{ $day->month }}, {{ $day->day }})"
			@endif>

			<div class='flex items-center gap-4'>
				<p @class([
				    'my-0 flex h-6 w-6 flex-col items-center justify-center rounded-full p-3.5 text-sm',
				    'bg-teal-400 text-white' => $isToday,
				    'font-medium' => $dayInMonth,
				])>
					{{ $day->format('j') }}
				</p>

				<p class='my-0 text-xs'>
					@if ($events->isNotEmpty())
						{{ $events->count() }} {{ Str::plural('évènement', $events->count()) }}
					@endif
				</p>
			</div>

			<div class='flex-1 overflow-y-auto p-2'>
				<div class='grid grid-flow-row grid-cols-1 gap-2'>
					@foreach ($events as $event)
						<div @if ($dragAndDropEnabled) draggable='true' @endif ondragstart="onCalendaxEventDragStart(event, '{{ $event['id'] }}')">
							@include($eventView, ['event' => $event])
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
