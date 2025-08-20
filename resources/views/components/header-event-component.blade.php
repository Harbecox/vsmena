<div class="d-flex gap-20">
    @if(isset($event_id) && $event_id)
        <x-event-info-modal wrapper_class="w-100" :event_id="$event_id" />
        <x-close-event-modal wrapper_class="w-100" :event_id="$event_id" />
    @else
        <x-add-event-modal wrapper_class="w-100" />
    @endif
</div>
