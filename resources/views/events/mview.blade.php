@extends("layouts.pc")

@push("head")
 <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->
 <script src="/js/pc.js"></script>
 <script src='https://fullcalendar.io/releases/fullcalendar/2.9.0/lib/moment.min.js'></script>
 <script src='https://fullcalendar.io/releases/fullcalendar/2.9.0/lib/jquery.min.js'></script>
 <script src='https://fullcalendar.io/releases/fullcalendar/2.9.0/fullcalendar.min.js'></script>
 <script src='https://fullcalendar.io/releases/fullcalendar/2.9.0/lang-all.js'></script>
@endpush

@section("title", $header)
@section("main")
  <h1>{{$header}}</h1> 
  @if ($header == "Подтверждение смен")
	<label>Выбор ресторана:</label>
		<select name="restaurants_id" id="restcal_id">
			<option value="0">---НИЧЕГО---</option>
			@if(count($rests))
				@foreach ($rests as $rest)
					<option value="{{ $rest->id }}" 
					@isset($datas)
						@if (old('id', $rest->id) == $datas) selected 
						@endif
					@endisset>{{ $rest->name }}</option>
				@endforeach
			@endif
		</select>
   @endif
   <div id="backgroundtable" style="max-width: 600px">
   
	{!! $calendar->calendar() !!}  
    {!! $calendar->script() !!}
	</div>
@endsection