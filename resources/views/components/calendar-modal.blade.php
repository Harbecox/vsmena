<div>
    <x-form.modal type="danger">
        <x-slot:title>
            Подтверждение смен
        </x-slot:title>
        <x-slot:button>
            @if($day['status'] == -1)
                <a class="day {{ $day['type'] }} reject">
                    <span class="num">{{ $day['value'] }}</span>
                    <span class="text">Не подтверждена</span>
                </a>
            @elseif($day['status'] == 0)
                <a class="day {{ $day['type'] }}">
                    <span class="num">{{ $day['value'] }}</span>
                </a>
            @elseif($day['status'] == 1)
                <a class="day {{ $day['type'] }} approve">
                    <span class="num">{{ $day['value'] }}</span>
                    <span class="text">Подтверждена</span>
                </a>
            @endif
        </x-slot:button>
        <x-slot:body>
            <div class="event_items">
                @foreach($events as $event)
                    @if($event['status'] == 1)
                        <div class="event_item text-success">
                            <span>{{ $event['fio'] }}</span>
                            <span>Подтверждена</span>
                        </div>
                    @else
                        <div class="event_item text-danger">
                            <span>{{ $event['fio'] }}</span>
                            <span>Не подтверждена</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </x-slot:body>
        <x-slot:footer></x-slot:footer>
    </x-form.modal>
</div>
