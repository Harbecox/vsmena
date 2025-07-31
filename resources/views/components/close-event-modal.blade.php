@props(['event_id'])

<div>
    <x-form.modal type="danger">
        <x-slot:title>
            Закрыть смену?
        </x-slot:title>
        <x-slot:button>
            <button class="btn btn-danger">Закрыть смену</button>
        </x-slot:button>
        <x-slot:body>
            <p class="fs-18 text-center">Вы действительно хотите закрыть смену?<br>Это действие нельзя отменить.</p>
            <form action="{{ route('events.close') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $event_id }}">
            </form>
        </x-slot:body>
    </x-form.modal>
</div>
