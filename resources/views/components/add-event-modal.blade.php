@props([
    'wrapper_class' => '',
])

<div class="{{ $wrapper_class }}">
    <x-form.modal buttonClass="AddEventModalButton">
        <x-slot:title>
            Открыть смену
        </x-slot:title>
        <x-slot:button>
            <button class="btn btn-success w-100 w-xl-auto">Открыть смену</button>
        </x-slot:button>
        <x-slot:body>
            <div class="d-flex justify-content-center w-100 align-items-center h-100">
                <div class="w-100" id="app_header_modal">
                    <form-example action="{{ route('events.open') }}" method="POST" :form-data="{ start_date: '{{ \App\Helpers\Helper::formatRussianDate(Carbon\Carbon::now()) }}' }" />
                </div>
            </div>
        </x-slot:body>
    </x-form.modal>
</div>
