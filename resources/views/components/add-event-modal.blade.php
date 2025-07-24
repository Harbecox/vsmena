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
                <form class="w-100" method="POST">
                    @csrf
                    <x-form.select
                        name="restorant_id"
                        :values="$restaurants"
                        label="Название ресторана"
                    />
                    <x-form.select
                        name="position_id"
                        :values="$positions"
                        label="Выберите должность"
                    />
                    <x-form.input-with-label
                        label="Время начала смены"
                        icon="lock"
                        placeholder="Время начала смены"
                        name="start_date"
                        :value="\App\Helpers\Helper::formatRussianDate(\Carbon\Carbon::now())"
                    />
                </form>
            </div>
        </x-slot:body>
    </x-form.modal>

</div>
