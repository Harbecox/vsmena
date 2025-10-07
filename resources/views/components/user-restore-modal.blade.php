<div>
    <x-form.modal>
        <x-slot:title>
            Восстановить пользователя
        </x-slot:title>
        <x-slot:button>
            <x-icon name="restore" />
        </x-slot:button>
        <x-slot:body>
            <p class="fs-18 text-center">Вы действительно хотите восстановить пользователя "{{ $fio }}"?</p>
            <form action="{{ $url }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
            </form>
        </x-slot:body>
    </x-form.modal>
</div>
