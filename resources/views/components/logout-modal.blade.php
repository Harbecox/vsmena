<div class="logout_button_outer">
    <x-form.modal buttonClass="menu_item">
        <x-slot:title>
            Выйти из аккаунта?
        </x-slot:title>
        <x-slot:button>
            <x-icon name="logout"/><span>Выход</span>
        </x-slot:button>
        <x-slot:body>
            <div class="d-flex justify-content-center align-items-center h-100">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            </div>
        </x-slot:body>
    </x-form.modal>
</div>
