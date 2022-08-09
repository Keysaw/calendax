<?php

namespace Brickx\Calendax;

use Brickx\Calendax\Commands\CalendaxCommand;
use Brickx\Calendax\Components\Flatpickr;
use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CalendaxServiceProvider extends PackageServiceProvider
{
	public function configurePackage(Package $package) : void
	{
		$package->name('calendax')
			->hasConfigFile()
			->hasViews()
			->hasViewComponent('calendax', Flatpickr::class)
			->hasCommand(CalendaxCommand::class);
	}

	public function bootingPackage()
	{
		Blade::directive('calendaxScripts', function () {
			return <<<'HTML'
            <script>
                function onCalendaxEventDragStart(event, eventId) {
                    event.dataTransfer.setData('id', eventId);
                }
                function onCalendaxEventDragEnter(event, componentId, dateString, dragAndDropClasses) {
                    event.stopPropagation();
                    event.preventDefault();
                    let element = document.getElementById(`${componentId}-${dateString}`);
                    element.className = element.className + ` ${dragAndDropClasses} `;
                }
                function onCalendaxEventDragLeave(event, componentId, dateString, dragAndDropClasses) {
                    event.stopPropagation();
                    event.preventDefault();
                    let element = document.getElementById(`${componentId}-${dateString}`);
                    element.className = element.className.replace(dragAndDropClasses, '');
                }
                function onCalendaxEventDragOver(event) {
                    event.stopPropagation();
                    event.preventDefault();
                }
                function onCalendaxEventDrop(event, componentId, dateString, year, month, day, dragAndDropClasses) {
                    event.stopPropagation();
                    event.preventDefault();
                    let element = document.getElementById(`${componentId}-${dateString}`);
                    element.className = element.className.replace(dragAndDropClasses, '');
                    const eventId = event.dataTransfer.getData('id');
                    window.Livewire.find(componentId).call('onEventDropped', eventId, year, month, day);
                }
            </script>
HTML;
		});
	}
}
