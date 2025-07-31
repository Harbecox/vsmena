@props(['event_id'])
@php
$event = \App\Models\Event::query()
->join('positions','positions.id','events.positions_id')
->join('restaurants','positions.restaurants_id','restaurants.id')
->select('positions.name as position_name','events.start_date as start_data','restaurants.name as restaurant_name')
->where('events.id',$event_id)
->first();
@endphp
<div>
    <x-form.modal>
        <x-slot:title>
            О смене
        </x-slot:title>
        <x-slot:button>
            <button class="btn btn-light">О смене</button>
        </x-slot:button>
        <x-slot:body>
            <div class="d-flex flex-column gap-15">
                <div class="d-flex justify-content-between fs-18">
                    <span class="fw-700">Время начала смены</span>
                    <span>{{ \App\Helpers\Helper::formatRussianDate($event->start_data,true) }}</span>
                </div>
                <div class="d-flex justify-content-between fs-18">
                    <span class="fw-700">Должность</span>
                    <span>{{ $event->position_name }}</span>
                </div>
                <div class="d-flex justify-content-between fs-18">
                    <span class="fw-700">Ресторан</span>
                    <span>{{ $event->restaurant_name }}</span>
                </div>
            </div>
        </x-slot:body>
        <x-slot:footer></x-slot:footer>
    </x-form.modal>
</div>

