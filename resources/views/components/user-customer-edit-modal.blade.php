<div>
    <x-form.modal>
        <x-slot:title>
            Редактировать профиль
        </x-slot:title>
        <x-slot:button>
            Редактировать
        </x-slot:button>
        <x-slot:body>
            <div class="d-flex justify-content-center align-items-center h-100">
                <form method="POST"  action="{{ route('userscustomer.save') }}" class="login_form">
                    @method('PUT')
                    @csrf
                    <x-form.input-with-label
                        label="ФИО"
                        placeholder="Казачков Иван Николаевич"
                        name="fio"
                        value="{{ auth()->user()->fio }}"
                        required
                    />
                    <x-form.input-with-label
                        label="Год рождения"
                        placeholder="1980"
                        name="year_birth"
                        value="{{ auth()->user()->year_birth }}"
                        required
                    />
                    <x-form.input-with-label
                        label="Электронный адрес"
                        placeholder="user@bk.ru"
                        name="email"
                        value="{{ auth()->user()->email }}"
                        icon="check_circle"
                        required
                    />
                    <x-form.input-with-label
                        label="Номер телефона"
                        placeholder="8ХХХХХХХХХХ"
                        name="phone"
                        value="{{ auth()->user()->phone }}"
                        required
                    />
                </form>
            </div>
        </x-slot:body>
    </x-form.modal>

</div>
