<div class="x-table-cell text-center">
    @if($status)
        <span>Подтверждена</span>
    @else
        <div class="d-flex gap-30 align-items-center">
            <a href="{{ route('calendar.accept',$id) }}" class="text-success">Подтвердить</a>
            <a href="{{ route('calendar.edit',$id) }}"><x-icon name="edit" /></a>
            <x-delete-event-modal event_id="{{$id}}" />
        </div>
    @endif
</div>
