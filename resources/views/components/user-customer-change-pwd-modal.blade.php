<div>
    <x-form.modal>
        <x-slot:title>
            Сменить пароль
        </x-slot:title>
        <x-slot:button>
            Сменить пароль
        </x-slot:button>
        <x-slot:body>
            <div class="d-flex justify-content-center align-items-center h-100">
                <form method="POST"  action="{{ route('userscustomer.update') }}" class="login_form">
                    @method('PUT')
                    @csrf
                    <x-form.input-with-label
                        label="Пароль"
                        placeholder="•••••••••"
                        name="password"
                        type="password"
                        icon="password_hide"
                    />
                    <x-form.input-with-label
                        label="Подтверждение пароля"
                        placeholder="•••••••••"
                        name="password_confirmation"
                        type="password"
                        icon="password_hide"
                    />
                </form>
            </div>
        </x-slot:body>
    </x-form.modal>

</div>
