@extends("layouts.dashboard")

@section('page_header')
    <x-page-header
        title-primary="Подтверждение смен"
        title-secondary="Рабочий ритм задан"
    />
@endsection

@section('content')
    <div class="full_page_calendar">
        <div class="head">
            <div class="day">ПН</div>
            <div class="day">ВТ</div>
            <div class="day">СР</div>
            <div class="day">ЧТ</div>
            <div class="day">ПТ</div>
            <div class="day">СБ</div>
            <div class="day">ВС</div>
        </div>
        <div class="body">
            @if(auth()->user()->role == 'b')
                @foreach($calendar as $day)
                    <x-calendar-modal :day="$day" />
                @endforeach
            @else
                @foreach($calendar as $day)
                    @if($day['status'] == -1)
                        <a href="{{ route('calendar.show',$day['date']) }}" class="day {{ $day['type'] }} reject">
                            <span class="num">{{ $day['value'] }}</span>
                            <span class="text">Не подтверждена</span>
                        </a>
                    @elseif($day['status'] == 0)
                        <a href="{{ route('calendar.show',$day['date']) }}" class="day {{ $day['type'] }}">
                            <span class="num">{{ $day['value'] }}</span>
                        </a>
                    @elseif($day['status'] == 1)
                        <a href="{{ route('calendar.show',$day['date']) }}" class="day {{ $day['type'] }} approve">
                            <span class="num">{{ $day['value'] }}</span>
                            <span class="text">Подтверждена</span>
                        </a>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
@endsection
