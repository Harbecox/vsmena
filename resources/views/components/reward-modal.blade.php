<div>
    <x-form.modal>
        <x-slot:title>
            Премии и штрафы
        </x-slot:title>
        <x-slot:button>
            <button class="btn btn-light">Премии и штрафы</button>
        </x-slot:button>
        <x-slot:body>
            <div class="d-flex justify-content-center align-items-center h-100">
                <form action="{{ route('rewards.create') }}" method="POST" class="w-100">
                    @csrf
                    <div id="app_reward" class="w-100">
                        <reward-form />
                    </div>
                </form>
            </div>
        </x-slot:body>
    </x-form.modal>

</div>
