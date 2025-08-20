@extends("layouts.dashboard")

@section('page_header')
    <x-page-header
        title-primary="Редактировать профиль"
        :back-url="route('users.index')"
        back-text="Пользователи"
    />
@endsection

@section('content')
    <form action="{{ $action }}" method="post" class="page_form_container w_xl">
        @csrf
        @method($method)

        <div class="d-flex flex-column gap-15 gap-lg-0">
            <div class="d-flex gap-lg-30 flex-column flex-lg-row w-100">
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
            <div class="d-flex gap-lg-30 flex-column flex-lg-row w-100">
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
            <div class="d-flex gap-lg-30 flex-column flex-lg-row w-100">
                <x-form.select
                    name="role"
                    label="Роль"
                    :values="\App\Enum\Role::labels()"
                    :selected="$user->role ?? old('role')"
                    class="flex_1"
                />
                <div class="flex_1"></div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-30">Сохранить</button>
    </form>
@endsection
