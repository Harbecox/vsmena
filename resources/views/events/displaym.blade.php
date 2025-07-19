@extends("layouts.pc")

@push("head")
  <script src="/js/pc.js"></script>
@endpush

@section("title", $header)
@section("main")
  <h1>{{ $header }}</h1>
  <div id="backgroundtable" style="padding-bottom: 20px">
  <table class="list">
    <tr> 
	  
      <th>Должность</th>
	  <th>ФИО Сотрудника</th>
	  <th>Время начала смены</th>
	  <th>Время окончания смены</th>
      <th>Длительность смены</th>
	  <th>Статус смены</th>
	  @if ($flag == "cf")
		<th colspan="2">Действия</th>
	  @endif
    </tr>
    @foreach ($events as $event)
      <tr>
		<td>{{ $event->posname }}</td>
        <td>{{ $event->usrfio }}</td>
		<td>{{ $event->start_date }}</td>
		<td>{{ $event->end_date }}</td>
		<td>{{ $event->period }}</td>  
		<td style="background-color:{{ $event->color }};" class="center">{{ $event->title }}</td>
	  @if ($flag == "cf")
	  <td class="links">
		<a href="#" onclick="displayFullName({{$event->id}}),document.getElementById('parent_popup').style.display='block';">Редактировать</a>
			<!---------------------------------modal-------------------------------------->
			<div id="parent_popup" style="display: none;">
			  <div id="popup">
				<p style="cursor: pointer;" onclick="document.getElementById('parent_popup').style.display='none';">Х</p>
				
					<b>Редактирование данных {{ $event->restname }}</b>
					<form method="POST" action="{{ action('EventManagerController@update') }}" enctype="multipart/form-data">
						@if ($event->id)
						  {{ method_field('PUT') }}
						  <input type="hidden" name="id" id="idCall" />
						@endif				
						{{ csrf_field() }}				
						<label align="left" >Время начала смены</label>
						<input type="datetime" name="start_date" id="start_dateCall" />
						<label align="left">Время окончания смены</label>
						<input type="datetime" name="end_date" id="end_dateCall" />
						<label align="left">Премия</label>
						<input align="center" type="number" min="0" max="1000000" step="0.01" name="premium" id="premiumCall" />
						<label align="left">Статус смены</label>				
						<select align="center" name="title" id="titleCall">
							<option value="Не подтверждена" >Не подтверждена</option>
							<option value="Оспаривается" >Оспаривается</option>
							<option value="Подтверждена" >Подтверждена</option>
						</select>
						<input type="hidden" name="color" id="colorCall" />
						<input type="hidden" name="status" value="1" />
						
						<input type="submit" value="Сохранить" onclick="document.getElementById('parent_popup').style.display='none';" />
					</form>	
					
					<!--<button onclick="document.getElementById('parent_popup').style.display='none';">ОК</button>-->
			  </div>
			</div>
			<!--------------------------------------script modal------------------------------------->
			 <script>
				function displayFullName(id) {
					//-------------create XMLHttpRequest-------------------
					var request = new XMLHttpRequest();

					//------------create query-----------------------------
					request.open("GET", "/events/mviewurl/"+ id + "/edit");

					// ----------- readystatechange -----------------------
					request.onreadystatechange = function() {
						// -----------success------------------------------
						if(this.readyState === 4 && this.status === 200) {
							// ----------------insert html-----------------
							var response = request.response;
							var x = JSON.parse(response);					 				
							document.getElementById("idCall").value = x.id;
							document.getElementById("start_dateCall").value = x.start_date;
							document.getElementById("end_dateCall").value = x.end_date;
							document.getElementById("premiumCall").value = x.premium;
							document.getElementById("titleCall").value = x.title;
							document.getElementById("colorCall").value = x.color;
							 //------------------------------change color-------------------------------
							 var changeSelectTitle_ = document.querySelector('#titleCall');
							  if (changeSelectTitle_)
								changeSelectTitle_.addEventListener('change',function(){
									
									const colorInput_ = document.getElementById("colorCall");
									if (changeSelectTitle_.value == "Не подтверждена") {	
										colorInput_.value = "#FF0000";
									} else if (changeSelectTitle_.value == "Оспаривается") {	
										colorInput_.value = "#dbd524";
									} else if (changeSelectTitle_.value == "Подтверждена") {	
										colorInput_.value = "#008000";
									}
								});
						}
					};

					// --------send server-----------------------------------
					request.send(); 
				}
				</script>
      </td>
	  <td class="links">
		  <br/>
          <a href="{{action('EventManagerController@editstatus',$event->id)}}" style="color:Purple"> Подтвердить </a>&nbsp;
      </td>
	  @endif
	  </tr>
    @endforeach
  </table>
  </div>
  @if ($flag == "hs")
	  <p><a href="/events/mview/history"> История смен </a></p>
  @else
	  <p><a href="/events/mview/confirm"> Подтверждение смен </a></p>
  @endif
@endsection