<div>
    <x-form.modal>
        <x-slot:title>
            Премии и штрафы
        </x-slot:title>
        <x-slot:button>
            <button class="btn btn-light">Премии и штрафы</button>
        </x-slot:button>
        <x-slot:body>
            <div class="d-flex justify-content-center align-items-center h-100" id="app_reward">
                <div class="w-100">
                    <reward-form action="{{ route('rewards.store') }}" />
                </div>
            </div>
        </x-slot:body>
    </x-form.modal>

</div>
