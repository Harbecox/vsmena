@props(['event_id'])

<div>
    <x-form.modal type="danger">
        <x-slot:title>
            Закрыть смену
        </x-slot:title>
        <x-slot:button>
            <x-icon name="trash" />
        </x-slot:button>
        <x-slot:body>
            <p class="fs-18 text-center">Вы действительно хотите удалить смену?<br>Это действие нельзя отменить.</p>
            <form action="{{ route('calendar.destroy',$event_id) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" value="{{ $event_id }}">
            </form>
        </x-slot:body>
    </x-form.modal>
</div>
