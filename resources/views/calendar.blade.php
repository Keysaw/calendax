<div class='container px-4' @if ($pollMillis !== null && $pollAction !== null) wire:poll.{{ $pollMillis }}ms='{{ $pollAction }}' @elseif($pollMillis !== null) wire:poll.{{ $pollMillis }}ms @endif>
	<div>
		@includeIf($beforeCalendarView)
	</div>

	<div class='flex'>
		<div class='w-full overflow-x-auto rounded-lg border'>
			<div class='flex w-full flex-row border-inherit'>
				@foreach ($monthGrid->first() as $day)
					@include($dowView, ['day' => $day])
				@endforeach
			</div>

			@foreach ($monthGrid as $week)
				<div class='group flex w-full flex-row border-inherit'>
					@foreach ($week as $day)
						@include($dayView, [
						    'componentId' => $componentId,
						    'day' => $day,
						    'dayInMonth' => $day->isSameMonth($startsAt),
						    'isToday' => $day->isToday(),
						    'events' => $getEventsForDay($day, $events),
						])
					@endforeach
				</div>
			@endforeach
		</div>
	</div>

	<div>
		@includeIf($afterCalendarView)
	</div>
</div>
