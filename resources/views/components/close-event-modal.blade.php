@props(['event_id'])

<div>
    <x-form.modal type="danger" buttonClass="CloseEventModalButton">
        <x-slot:title>
            Закрыть смену?
        </x-slot:title>
        <x-slot:button>
            <button class="btn btn-danger w-100 w-xl-auto">Закрыть смену</button>
        </x-slot:button>
        <x-slot:body>
            <p class="body_text text-center">Вы действительно хотите закрыть смену?<br>Это действие нельзя отменить.</p>
            <form action="{{ route('events.close') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $event_id }}">
            </form>
        </x-slot:body>
    </x-form.modal>
</div>
