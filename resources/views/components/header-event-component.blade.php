<div class="d-flex gap-20">
    @if(isset($event_id) && $event_id)
        <x-event-info-modal :event_id="$event_id" />
        <x-close-event-modal :event_id="$event_id" />
    @else
{{--        <x-add-event-modal />--}}
        <livewire:add-event />
    @endif
</div>
