@extends("layouts.pc")

@push("head")
  <script src="/js/pc.js"></script>
@endpush

@section("title", $header)
@section("main")
  <h1>{{$header}}</h1>
  <div id="backgroundtable">
  <form action="{{ action('EventCustomerController@show') }}" method="POST">
   {{ csrf_field() }}
  <table class="list filter-list">
	<tr>
		<td>Выбор даты от: <input type="date" name="start_date" value="<?php echo date('Y-m-d'); ?>"></td>
		<td>Выбор даты до: <input type="date" name="end_date" value="<?php echo date('Y-m-d'); ?>"></td>
		<td>
			<label>Выбор ресторана:</label>
			<select name="restaurants_id">
			  @foreach ($rests as $rest)
				<option value="{{ $rest->id }}">{{ $rest->name }}</option>
			  @endforeach
			</select>
			@include("common.errors", ["el" => "restaurants_id"])
		</td>
		<td>
			<label>Выбор статуса смены:</label>
			<select name="title">
				<option value="Не подтверждена">Не подтверждена</option>
				<option value="Оспаривается">Оспаривается</option>
				<option value="Подтверждена">Подтверждена</option>
			</select>
		</td>
		<td><input type="submit" value="Найти"></td>
		<td><a href="/eventscustomer/mview/load"> Экспорт в Excel </a></td>
	</tr>
  </table>
  </form>
  <table class="list">
    <tr> 
      <th>Должность</th>
	  <th>Ресторан</th>	  
	  <th>Время начала смены</th>
	  <th>Время окончания смены</th>
      <th>Длительность смены</th>
	  <th>Статус смены</th>
    </tr>
    @foreach ($events as $event)
      <tr>
		<td>{{ $event->posname }}</td>
		<td>{{ $event->restname }}</td>
		<td>{{ $event->start_date }}</td>
		<td>{{ $event->end_date }}</td>
		<td>{{ $event->period }}</td>  
		<td style="background-color:{{ $event->color }};" class="center">{{ $event->title }}</td>
	 
	  </tr>
    @endforeach
  </table>
  </div>
  
@endsection