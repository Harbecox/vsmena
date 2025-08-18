<div class="menu">
    <div class="menu_shadaw"></div>
    <div class="p-15">
        <x-user-card />
    </div>
    @switch(auth()->user()->role)
        @case('a')

            <a href="{{ route('events.index') }}"
               class="menu_item {{ request()->routeIs('events.*') ? 'active' : '' }}">
                <x-icon name="book"/><span>История смен</span>
            </a>
            <a href="/userscustomer" class="menu_item {{ request()->routeIs('userscustomer.*') ? 'active' : '' }}">
                <x-icon name="user"/><span>Мои данные</span>
            </a>
        @case('e')
            <a href="/userscustomer"
               class="menu_item {{ request()->routeIs('userscustomer.*') ? 'active' : '' }}">
                <x-icon name="user"/><span>Мои данные</span>
            </a>
            <a href="/userscustomer" class="menu_item {{ request()->routeIs('userscustomer.*') ? 'active' : '' }}">
                <x-icon name="user"/><span>Мои данные</span>
            </a>
            <a href="{{ route('staff.index') }}"
               class="menu_item {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                <x-icon name="staff"/><span>Сейчас работают</span>
            </a>
            <a href="{{ route('calendar.index') }}"
               class="menu_item {{ request()->routeIs('calendar.*') ? 'active' : '' }}">
                <x-icon name="approve"/><span>Подтверждение смен</span>
            </a>
            <a href="{{ route('restaurants.index') }}"
               class="menu_item {{ request()->routeIs('restaurants.*') ? 'active' : '' }}">
                <x-icon name="cookie"/><span>Рестораны</span>
            </a>
            <a href="{{ route('positions.index') }}"
               class="menu_item {{ request()->routeIs('positions.*') ? 'active' : '' }}">
                <x-icon name="file"/><span>Должности</span>
            </a>
            <a href="{{ route('users.index') }}"
               class="menu_item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <x-icon name="users"/><span>Пользователи</span>
            </a>
            <a href="{{ route('logs.index') }}"
               class="menu_item {{ request()->routeIs('logs.*') ? 'active' : '' }}">
                <x-icon name="log"/><span>История событий</span>
            </a>
            <div class="ps-50 mt-20">
                <x-reward-modal/>
            </div>
            @break
        @case('b')
            {{--                    Бухгалтер--}}
            <a href="{{ route('calendar.index') }}"
               class="menu_item {{ request()->routeIs('calendar.*') ? 'active' : '' }}">
                <x-icon name="approve"/><span>Подтверждение смен</span>
            </a>
            <a href="/userscustomer" class="menu_item {{ request()->routeIs('userscustomer.*') ? 'active' : '' }}">
                <x-icon name="user"/><span>Мои данные</span>
            </a>
            <a href="{{ route('reports.index') }}"
               class="menu_item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <x-icon name="report"/><span>Отчетность</span>
            </a>
            @break
        @case('m')
            {{--                    Администратор--}}
            <a href="{{ route('events.index') }}"
               class="menu_item {{ request()->routeIs('events.*') ? 'active' : '' }}">
                <x-icon name="book"/><span>История смен</span>
            </a>
            <a href="/userscustomer" class="menu_item {{ request()->routeIs('userscustomer.*') ? 'active' : '' }}">
                <x-icon name="user"/><span>Мои данные</span>
            </a>
            <a href="{{ route('staff.index') }}"
               class="menu_item {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                <x-icon name="staff"/><span>Сейчас работают</span>
            </a>
            <a href="{{ route('calendar.index') }}"
               class="menu_item {{ request()->routeIs('calendar.*') ? 'active' : '' }}">
                <x-icon name="approve"/><span>Подтверждение смен</span>
            </a>
            <a href="{{ route('restaurants.index') }}"
               class="menu_item {{ request()->routeIs('restaurants.*') ? 'active' : '' }}">
                <x-icon name="cookie"/><span>Рестораны</span>
            </a>
            <a href="{{ route('positions.index') }}"
               class="menu_item {{ request()->routeIs('positions.*') ? 'active' : '' }}">
                <x-icon name="file"/><span>Должности</span>
            </a>
            <a href="{{ route('users.index') }}"
               class="menu_item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <x-icon name="users"/><span>Пользователи</span>
            </a>
            <a href="{{ route('logs.index') }}"
               class="menu_item {{ request()->routeIs('logs.*') ? 'active' : '' }}">
                <x-icon name="log"/><span>История событий</span>
            </a>
            <a href="{{ route('rewards.index') }}"
               class="menu_item {{ request()->routeIs('rewards.*') ? 'active' : '' }}">
                <x-icon name="reward"/><span>История премий</span>
            </a>
            <div class="ps-50 mt-20">
                <x-reward-modal/>
            </div>
            @break
    @endswitch
    <span class="menu_item">
        <x-logout-modal type="danger"/>
    </span>
</div>
