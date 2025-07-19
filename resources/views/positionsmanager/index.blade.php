@extends("layouts.pc")

@push("head")
  <script src="/js/pc.js"></script>
@endpush

@section("title", "Должности")
@section("main")
 <h1>Список должностей {{ $restaurants->name }}</h1>
@if(!$subcats->isEmpty()) 
 
  <p><a href="{{ route('positionsmanager.create', [$restaurants->id]) }}">Добавить</a></p>
  <div id="backgroundtable">
  <table class="list table-list">
    <tr>
      <th style="display: none">Пользователь</th>
	  <th>Ресторан</th>
	  <th>Название должности</th>
      <th colspan="2">Действия</th>
      <th>Цена за смену</th>
	  <th>Цена за час</th>
	  <th style="display: none">Описание</th>
      
    <tr>
    @foreach ($subcats as $subcat)
      <tr>
        <td style="display: none">{{ $subcat->usrname }}</td>
		<td>{{ $subcat->restname }}</td>
		<td>{{ $subcat->name }}</td>
        <td class="links">
		<!----------------------------------------------------------------------->
		<a href="#" onclick="positionsmanagerFullName('{{$subcat->slug}}'),document.getElementById('parent_popup').style.display='block';">Редактировать</a>
			<!---------------------------------modal-------------------------------------->
			<div id="parent_popup" style="display: none;">
			  <div id="popup">
			  <b>Редактирование должности {{ $restaurants->name }}</b>
				<p style="cursor: pointer;" onclick="document.getElementById('parent_popup').style.display='none';">Х</p>

				 <form action="{{ action('PositionsManagerController@save') }}" method="POST">
					@if ($subcat->id)
					  {{ method_field('PUT') }}
					  <input type="hidden" name="id" id="idCall">
					@endif
					{{ csrf_field() }}
					<label align="left">Наименование должности</label>
					<input type="text" placeholder = "официант" size="30" name="name" class="source" id="nameCall">
					
					<label align="center">Цена за смену руб.</label>
					<input type="number" min="0" max="1000000" step="0.01" placeholder = "3000" name="price_shifts" id="input_one_" style="display: inline;">
					<!------------------------------------------------------->
					<input type="radio" name="pr" id="radio_one" />Метод оплаты за смену
					<!------------------------------------------------------->
					
					<label align="center">Цена за час руб.</label>
					<input type="number" min="0" max="1000000" step="0.01" placeholder = "250" name="price_hour" id="input_two_" style="display: inline;">
					<!------------------------------------------------------->
					<input type="radio" name="pr" id="radio_two" checked />Метод оплаты за час
					<!------------------------------------------------------->
					
					<label align="center">Цена за месяц руб.</label>
					<input type="number" min="0" max="1000000" step="0.01" placeholder = "100000" name="price_month" id="input_three_" style="display: inline;">
					<!------------------------------------------------------->
					<input type="radio" name="pr" id="radio_three" />Метод оплаты за месяц
					<!------------------------------------------------------->
					
					<label align="left">Слаг</label>
					<input type="text" name="slug" size="30" class="destination" id="slugCall" readonly>
					
					<label align="left" >Название ресторана</label>
					<select name="restaurants_id">
						<option value="{{ $restaurants->id }}" selected>{{ $restaurants->name }}</option>
					</select>
					
					<label align="left">Описание</label>
					<textarea name="description" size="30" id="descriptionCall"></textarea>
									
					<input type="submit" value="Сохранить">
				</form>
			 </div>
			</div>
          <!--<a href="{{ action('PositionsManagerController@input', ['position' => $subcat->slug]) }}">Редактировать</a>-->
		<!--------------------------------------script modal------------------------------------->
			 <script>
				function positionsmanagerFullName(position) {
					//-------------create XMLHttpRequest-------------------
					var request = new XMLHttpRequest();

					//------------create query-----------------------------
					request.open("GET", "/positionsmanager/"+position+"/edit");

					// ----------- readystatechange -----------------------
					request.onreadystatechange = function() {
						// -----------success------------------------------
						if(this.readyState === 4 && this.status === 200) {
							// ----------------insert html-----------------
							var response = request.response;
							var x = JSON.parse(response);					 				
							document.getElementById("idCall").value = x.id;
							document.getElementById("nameCall").value = x.name;
							document.getElementById("slugCall").value = x.slug;
							document.getElementById("descriptionCall").value = x.description;
							document.getElementById('input_one_').value = x.price_shifts
							document.getElementById('input_two_').value = x.price_hour
							document.getElementById('input_three_').value = x.price_month
						}
					};

					// --------send server-----------------------------------
					request.send(); 
				}
				</script>  
        </td>
        <td class="links">
          <a href="{{ action('PositionsManagerController@destroy',
          ['position' => $subcat->slug, 'rest_id' => $restaurants->id]) }}" class="adel">Удалить</a>
        </td>
        <td class="center">{{ $subcat->price_shifts }}</td>
        <td class="center">{{ $subcat->price_hour }}</td>
		<td style="display: none">{{ $subcat->description }}</td>
        
      </tr>
    @endforeach
  </table>
  </div>
  @else
	
	<p style="padding-bottom: 20px"><a href="{{ route('positionsmanager.create', [$restaurants->id]) }}">Добавить</a></p>
  @endif	
  <p style="padding-top: 20px"><a href="/restaurants">Назад к ресторанам</a></p>
@endsection
