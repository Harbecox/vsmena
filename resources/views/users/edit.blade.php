@extends("layouts.dashboard")

@section('content')
    <div class="page_header d-flex justify-content-between mb-30">
        <div class="d-flex flex-column gap-5">
            <a href="{{ route('staff.index') }}" class="text-secondary d-flex gap-5 align-items-center">
                <x-icon name="back"/>
                <span class="text-secondary">Вернуться</span>
                <span class="text-success">Должности</span>
            </a>
            <h1 class="text-primary">Добавить должность</h1>
        </div>
    </div>
    <form action="{{ $action }}" method="post" class="page_form_container w_xl">
        @csrf
        @method($method)
        <div class="d-flex gap-30 w-100">
            <x-form.input-with-label
                name="fio"
                :value="($user->fio ?? old('fio'))"
                label="ФИО"
                placeholder="Введите ФИО..."
                :required="true"
                class="flex_1"
            />
            <x-form.input-with-label
                name="year_birth"
                :value="($user->year_birth ?? old('year_birth'))"
                label="Год рождения"
                placeholder="Введите Год рождения..."
                :required="true"
                class="flex_1"
            />
        </div>
        <div class="d-flex gap-30 w-100">
            <x-form.input-with-label
                name="phone"
                :value="($user->phone ?? old('phone'))"
                label="Номер телефона"
                placeholder="Введите Номер телефона..."
                :required="true"
                class="flex_1"
            />
            <x-form.input-with-label
                name="email"
                :value="($user->email ?? old('email'))"
                label="E-mail"
                placeholder="Введите E-mail..."
                :required="true"
                class="flex_1"
            />
        </div>
        <div class="d-flex gap-30 w-100">
            <x-form.select
                name="role"
                label="Роль"
                :values="\App\Enum\Role::labels()"
                :selected="$user->role ?? old('role')"
                class="flex_1"
            />
            <div class="flex_1"></div>
        </div>
        <button type="submit" class="btn btn-primary mt-30">Сохранить</button>
    </form>
@endsection
