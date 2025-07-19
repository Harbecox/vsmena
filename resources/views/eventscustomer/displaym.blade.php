@extends("layouts.pc")

@push("head")
  <script src="/js/pc.js"></script>
@endpush

@section("title", $header)
@section("main")
  <h1>{{$header}}</h1>
  <div id="backgroundtable">
  <form action="{{ action('EventCustomerController@filterdloads') }}" method="POST">
   {{ csrf_field() }}
	  <table class="list">
		<tr>
			<td>Дата от: <input type="date" name="start_date" value="{{$start_date}}" readonly></td>
			<td>Дата до: <input type="date" name="end_date" value="{{$end_date}}" readonly></td>
			<td>Ресторан: <input type="text" name="rests" value="{{$rests[0]->name}}" readonly></td>
			<td>Статус смены: <input type="text" name="title" value="{{$title}}" readonly></td>
			@if(count($events))
				<td><input type="submit" value="Экспорт в Excel"></td>
			@endif
		</tr>
	  </table>
	<input type="hidden" name="restaurants_id" value="{{$rests[0]->id}}">
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
   @forelse ($events as $event)
      <tr>
		<td>{{ $event->posname }}</td>
		<td>{{ $event->restname }}</td>
		<td>{{ $event->start_date }}</td>
		<td>{{ $event->end_date }}</td>
		<td>{{ $event->period }}</td>  
		<td style="background-color:{{ $event->color }};" class="center">{{ $event->title }}</td>
	 
	  </tr>
	@empty
		<tr>
			<td colspan="8" align="center" bgcolor="#FBF0DB">Данные,соответствующие поиску не найдены.</td>
		</tr>
    @endforelse
  </table>
  </div>
    <a href="/eventscustomer/mview"> К поиску моих смен </a>
  
@endsection