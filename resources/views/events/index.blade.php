@extends("layouts.pc")

@push("head")
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="/js/pc.js"></script>
@endpush

@section("title", "Открыть смену")
@section("main")
  <h1>Открыть смену</h1>
  <div id="backgroundtable">
  @php $flag=false; $flag_=false; $cnt=0; @endphp

    @if (count($events) >= 1)
   	 @foreach ($events as $event)
		@if ($event->status == 0)
			@php $flag = true; @endphp
		@else
			@if ($event->status == 1) @php $cnt=$cnt+1; @endphp @endif
			@if (App\Helpers\Helper::check_day_night($event->start_date,$cnt))
				@php $flag_ = true; @endphp
			@endif
		@endif
	 @endforeach
	 @else
		@php $flag = false; @endphp
	@endif

	<!-- check_day_night($start_date,count($events)) -->
	<!-- ------------------return $flag_ ------------------------- -->
	@if ($flag_)
		   <p style="color:red">&nbsp;&nbsp; Внимание! Не более 3 смен в сутки. </p>
	       <a class="btn disabled" href="#"> Смена закрыта </a>
		   <a class="btn disabled" href="#"> Открыть смену </a>
    @else
		<!-- ------------------return $flag ------------------------- -->
		@if (!$flag)
			<a href="/events/addeventurl" class="btn btn-danger"> Смена закрыта </a>&nbsp;
			<a href="/events/addeventurl" class="btn btn-info"> Открыть смену </a>
		@else
		   <table class="list table-list">
			<tr>
			  <th>Должность</th>
			  <th>Время начала смены</th>
			  <th colspan="1">Действия</th>
			  <th style="display: none"></th>
			  <th style="display: none"></th>
			  <th>Время открытой смены</th>
			  <th>Статус смены</th>
			  <th>Цена за час</th>
			  <th>Подтверждение смены</th>
			</tr>
			<tr> </tr>
			@foreach ($events as $event)
				@if ($event->status == 0)
				<a href="{{action('EventManagerController@input',$event->id)}}" class="btn btn-success" style="display: block; max-width: 350px; margin: auto; margin-top: 100px; margin-bottom: 30px;" > Смена открыта </a>
				  <tr>
				 <!-- <td class="links">-->
					<!--<a href="{{action('EventManagerController@input',$event->id)}}" class="btn btn-success" > Смена открыта </a>-->
				 <!-- </td>-->
				  	<td>{{ $event->posname }}</td>
				  	<td>{{ $event->start_date }}</td>
				  	<td class="links">
					  <a href="{{action('EventManagerController@input',$event->id)}}" class="btn btn-info" > Закрыть смену </a>&nbsp;
					</td>
					<td style="display: none"></td>
					<td style="display: none"></td>
				    <td class="center">@php
						header("Refresh: 60");
					    $interval = date_diff(date_create($event->start_date), date_create(date('Y-m-d H:i:s')));
						echo $interval->h . ":" . $interval->i . ":" . $interval->s;

						@endphp</td>
					<td>{{ $event->restname }}</td>

					<td class="center">{{ $event->price_hour }}</td>
					<td style="background-color:{{ $event->color }};" class="center">{{ $event->title }}</td>

				  </tr>
				@endif
			@endforeach
		  </table>
		@endif
	@endif
  </div>
@endsection
