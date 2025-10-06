@extends("layouts.auth")

@section("title", "Регистрация")
@section("content")
    <div class="container register_form_container">
        <div class="login_page_title text-center w-100 mt-30 mt-md-50">
            <img src="data:image/png;base64,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">
        </div>
        <div class="d-flex justify-content-center align-items-center h-100">
            <form method="POST" action="{{ route('register') }}" class="login_form" data-class="RegisterRequest">
                @csrf
                <h1 class="text-center">Регистрация</h1>
                <x-form.input-with-label
                    label="ФИО"
                    placeholder="Казачков Иван Николаевич"
                    name="fio"
                    value="{{ old('fio') }}"
                    required
                />
                <div class="d-flex gap-15">
                    <x-form.input-with-label
                        label="Дату рождения"
                        placeholder="1991-01-05"
                        name="year_birth"
                        value="{{ old('year_birth') }}"
                        required
                        class="datePicker"
                    />
                    <x-form.input-with-label
                        label="Номер телефона"
                        placeholder="8ХХХХХХХХХХ"
                        name="phone"
                        value="{{ old('phone') }}"
                        required
                    />
                </div>
{{--                <div class="input__with_label" >--}}
{{--                    <label class="9f6dca6d-e23a-4d2e-914f-3f03a325ec2e">Электронный адрес</label>--}}
{{--                    <input id="9f6dca6d-e23a-4d2e-914f-3f03a325ec2e" class="form-input" type="text" value="{{ old('email') }}" name="email" placeholder="user@bk.ru">--}}
{{--                    <span class="success non-text d-none">--}}
{{--                        <x-icon class="input_success" name="check_circle" />--}}
{{--                    </span>--}}
{{--                    <span class="error d-none non-text">--}}
{{--                        <x-icon class="input_danger" name="input_danger" />--}}
{{--                    </span>--}}
{{--                    <div class="error text-danger d-none "></div>--}}
{{--                </div>--}}
                <div class="input__with_label password">
                    <label class="d4d62035-768d-4a8e-92b4-ab7fe8640686">Пароль</label>
                    <input id="d4d62035-768d-4a8e-92b4-ab7fe8640686" class="form-input" type="password" value=""
                           name="password" placeholder="•••••••••">
                    <span>
                        <x-icon class="password_hide" name="password_hide" />
                    </span>
                    <span>
                        <x-icon class="password_show" name="password_show" />
                    </span>
                    <div class="error text-danger d-none"></div>
                </div>
                <div class="input__with_label password">
                    <label class="d4d62035-768d-4a8e-92b4-ab7fe8640686">Пароль</label>
                    <input id="d4d62035-768d-4a8e-92b4-ab7fe8640686" class="form-input" type="password" value=""
                           name="password_confirmation" placeholder="•••••••••">
                    <span>
                        <x-icon class="password_hide" name="password_hide" />
                    </span>
                    <span>
                        <x-icon class="password_show" name="password_show" />
                    </span>
                    <div class="error text-danger d-none"></div>
                </div>
                <div class="d-flex justify-content-between mt-15">
                    <label class="checkbox_custom flex-wrap">
                        <input type="checkbox" class="d-none" name="politics">
                        <svg width="24.000000" height="24.000000" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <defs>
                                <clipPath id="clip11_87">
                                    <rect id="Frame 1437255009" rx="3.000000" width="22.000000" height="22.000000" transform="translate(1.000000 1.000000)" fill="white" fill-opacity="0"></rect>
                                </clipPath>
                            </defs>
                            <g class="check">
                                <path id="Vector" d="M15.52 10L11.17 14.35L9 12.17" stroke="#249104" stroke-opacity="1.000000" stroke-width="2.000000" stroke-linejoin="round" stroke-linecap="round"></path>
                            </g>
                            <rect id="Frame 1437255009" rx="3.000000" width="22.000000" height="22.000000" transform="translate(1.000000 1.000000)" stroke="#249104" stroke-opacity="1.000000" stroke-width="2.000000"></rect>
                        </svg>
                        <span class="label">Я согласен с <a href="{{ route('policy') }}" class="text-success">Политикой конфиденциальности</a></span>
                        <div class="error text-danger d-none flex_1 flex-grow-1" style="flex-basis: 100%"></div>
                    </label>
                </div>
                <button type="submit" class="btn btn-success w-100 mt-30 text-white">Регистрация</button>
                <div class="mt-50 d-flex justify-content-center form_footer">
                    <a href="{{ route('login') }}" class="text-secondary">Уже есть аккаунт?</a>
                    <span class="ps-10 pe-10">/</span>
                    <a href="{{ route('login') }}" class="text-success fw-bold">Войти</a>
                </div>
            </form>
        </div>
    </div>

@endsection
