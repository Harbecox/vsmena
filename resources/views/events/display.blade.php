@extends("layouts.pc")

@push("head")
  <script src="/js/pc.js"></script>
@endpush

@section("title", "Смены")
@section("main")
  <h1>Список смен</h1>
  <div id="backgroundtable">
  <table class="list">
    <tr>
	  <th>ФИО Сотрудника</th>
      <th>Должность</th>
	  <th>Ресторан</th>	  
	  <th>Время начала смены</th>
	  <th>Время окончания смены</th>
      <th>Длительность смены</th>
	  <th>Оплата за смену</th>
	  <th>Статус смены</th>
      <th colspan="2">Действия</th>
    </tr>
    @foreach ($events as $event)
      <tr>
        <td>{{ $event->usrfio }}</td>
		<td>{{ $event->posname }}</td>
		<td>{{ $event->restname }}</td>
		<td>{{ $event->start_date }}</td>
		<td>{{ $event->end_date }}</td>
		<td>{{ $event->period }}</td>  
		<td class="center">{{ $event->payment }}</td>
		<td style="background-color:{{ $event->color }};" class="center">{{ $event->title }}</td>
        <td class="links">
          <a href="{{action('EventController@edit',$event->id)}}" style="color:Purple">Редактировать </a>&nbsp;
        </td>
        <td class="links">
         <a href="{{action('EventController@destroy',$event->id)}}" onclick="return confirm('Вы действительно хотите удалить?')" style="color:Purple"> Удалить </a>&nbsp;
        </td>
      </tr>
    @endforeach
  </table>
  </div>
  <p><a href="/events/eventpage">Календарь смен</a></p>
@endsection