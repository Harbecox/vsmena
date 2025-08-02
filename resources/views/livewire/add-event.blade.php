<div>

    <x-form.modal>
        <x-slot:title>
            Открыть смену
        </x-slot:title>
        <x-slot:button>
            <button class="btn btn-success">Открыть смену</button>
        </x-slot:button>
        <x-slot:body>
            <div class="d-flex justify-content-center w-100 align-items-center h-100">
                <div class="w-100" data-class="AddEventRequest" method="POST" >
                    <livewire:form.select label="Выберите Ресторан" :options="$restaurants" wire:key="restaurant_id" var="restaurant_id" :value="$restaurant_id" />
                    @if(!empty($positions))
                        <livewire:form.select label="Выберите должность" :options="$positions" wire:key="position_id" var="position_id" :value="$position_id" />
                    @endif
                    {{--                    {{ $position_id }}--}}
{{--                    @if($position_id)--}}
{{--                        <livewire:form.select--}}
{{--                            name="positions_id"--}}
{{--                            :values="$positions"--}}
{{--                            label="Выберите должность"--}}
{{--                        />--}}
{{--                    @endif--}}
{{--                    <x-form.input-with-label--}}
{{--                        label="Время начала смены"--}}
{{--                        icon="lock"--}}
{{--                        placeholder="Время начала смены"--}}
{{--                        name="start_date"--}}
{{--                        :value="\App\Helpers\Helper::formatRussianDate(\Carbon\Carbon::now())"--}}
{{--                    />--}}
                </div>
            </div>
        </x-slot:body>
    </x-form.modal>

</div>
