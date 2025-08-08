<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@700&display=swap&subset=cyrillic"
          rel="stylesheet">
{{--    @livewireStyles--}}
    @vite(['resources/scss/app.scss', 'resources/js/app.js', 'resources/js/vue_script.js', 'resources/css/app.css'])
</head>
<body>
<header>
    <div class="d-flex justify-content-between w-100">
        <div class="d-flex flex-column gap-5">
            <span class="text-secondary fs-14">Система управления ресторанами</span>
            <div class="d-flex gap-10 align-items-center">
                <span class="fw-bold">{{ auth()->user()->fio }}</span>
                <div class="fw-bold ps-20 pe-20 pt-5 pb-5 bg-light"
                     style="border-radius: 17px">{{ \App\Helpers\Helper::role_to_russian() }}</div>
            </div>
        </div>
        <div class="d-flex gap-20">
            <div class="search_box">
                <x-icon name="search"/>
                <input type="text" name="search" placeholder="Поиск...">
            </div>
            <x-header-event-component/>
        </div>
    </div>
</header>
<div class="main_content">
    <aside>
        <div class="logo_box">
            <img
                src="data:image/png;base64,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">
        </div>
        <div class="menu">
            <span>
                <a href="{{ route('events.index') }}"
                   class="menu_item {{ request()->routeIs('events.*') ? 'active' : '' }}">
                    <x-icon name="book"/><span>История смен</span>
                </a>
                <a href="/userscustomer" class="menu_item {{ request()->routeIs('userscustomer.*') ? 'active' : '' }}">
                    <x-icon name="user"/><span>Мои данные</span>
                </a>
            @switch(auth()->user()->role)
                @case('e')
                    {{--                    Менеджер--}}
                    @break
                @case('b')
                    {{--                    Бухгалтер--}}
                    @break
                @case('m')
                    {{--                    Администратор--}}
                    <a href="{{ route('staff.index') }}" class="menu_item {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                        <x-icon name="staff"/><span>Сейчас работают</span>
                    </a>
                        <a href="{{ route('calendar.index') }}" class="menu_item {{ request()->routeIs('calendar.*') ? 'active' : '' }}">
                        <x-icon name="approve"/><span>Подтверждение смен</span>
                    </a>
                    <a href="{{ route('restaurants.index') }}" class="menu_item {{ request()->routeIs('restaurants.*') ? 'active' : '' }}">
                        <x-icon name="cookie"/><span>Рестораны</span>
                    </a>
                @break
            @endswitch
            </span>
            <span class="menu_item">
                <x-logout-modal type="danger"/>
            </span>
        </div>
    </aside>
    <div class="main_content_box" id="app">
        @yield('content')
    </div>
</div>
<x-notyf/>

{{--@livewireScripts--}}
</body>
</html>
