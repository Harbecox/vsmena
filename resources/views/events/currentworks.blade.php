@extends("layouts.pc")

@push("head")
  <script src="/js/pc.js"></script>
@endpush

@section("title", "Сейчас работают")
@section("main")
  <h1>Сейчас работают</h1>
  <div id="backgroundtable">
  <table class="list">
    <tr>
	  <th>Ресторан</th>
	  <th>ФИО Сотрудника</th>
      <th>Должность</th>  	  
	  <th>Время начала смены</th>
	  <th>Время окончания смены</th>
	  <th>Статус смены</th>
      <th colspan="2">Действия</th>
    </tr>
    @foreach ($events as $event)
      <tr>
		<td>{{ $event->restname }}</td>
        <td>{{ $event->usrfio }}</td>
		<td>{{ $event->posname }}</td>
		<td>{{ $event->start_date }}</td>
		<td>{{ $event->end_date }}</td>
		
		<td style="background-color:{{ $event->color }};" class="center">{{ $event->title }}</td>
        <td class="links">
          <a href="{{action('EventManagerController@edit',$event->id)}}" style="color:Purple">Редактировать </a>&nbsp;
        </td>
      
      </tr>
    @endforeach
  </table>
  </div>
  <!--<p><a href="/events/eventpage">Календарь смен</a></p>-->
@endsection