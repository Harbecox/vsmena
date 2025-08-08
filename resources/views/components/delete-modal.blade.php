<div>
    <x-form.modal type="danger">
        <x-slot:title>
            {{ $title }}
        </x-slot:title>
        <x-slot:button>
            <x-icon name="trash" />
        </x-slot:button>
        <x-slot:body>
            <p class="fs-18 text-center">{{ $text }}<br>Это действие нельзя отменить.</p>
            <form action="{{ $url }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" value="{{ $id }}">
            </form>
        </x-slot:body>
    </x-form.modal>
</div>
