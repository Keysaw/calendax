<div class='grid cursor-pointer gap-2 rounded-lg border bg-white py-2 px-3 shadow-sm transition ease-out hover:scale-105'
	@if ($eventClickEnabled) wire:click.stop="onEventClick('{{ $event['id'] }}')" @endif>
	<p class='m-0 text-sm font-medium'>
		{{ $event['title'] }}
	</p>

	@isset($event['description'])
		<p class='m-0 text-xs'>
			{{ $event['description'] }}
		</p>
	@endisset
</div>
