<div class="d-flex flex-column gap-5">
    <span class="text-secondary fs-14">Система управления ресторанами</span>
    <div class="d-flex gap-10 align-items-center">
        <span class="fw-bold">{{ auth()->user()->fio }}</span>
        <div class="fw-bold ps-20 pe-20 pt-5 pb-5 bg-light"
             style="border-radius: 17px">{{ \App\Helpers\Helper::role_to_russian() }}</div>
    </div>
</div>
