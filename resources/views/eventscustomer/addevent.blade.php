@extends("layouts.pc")

@push("head")
 <script src="/js/pc.js"></script>
@endpush
@section("title", "Открытие смены")
@section("main")
	<h1>Открытие смены</h1>
	<form method="POST" action="{{ route('addevent.store') }}"  enctype="multipart/form-data">
		{{ csrf_field() }}
		
		<label>Название ресторана</label>
		<select name="restaurants_id" id="rest_id">
		<!--<option value="0">---ВЫБОР---</option>-->
		  @foreach ($rests as $rest)
			<option value="{{ $rest->id }}" @if (old('id', $rest->id) == $restaurant->id) selected @endif>{{ $rest->name }}</option>
		  @endforeach
		</select>
		
	    @if(count($events))
			<label>Название должности:</label>
			<select name="positions_id">
			@foreach ($events as $event)
				<option value="{{ $event->id }}">{{ $event->name }}</option>
			@endforeach
			<!-- ------------------hidden--------------------- -->
			<input type="hidden" name="title" value="Не подтверждена" required />
			<input type="hidden" name="color" value="#FF0000" required />	
			<input type="hidden" name="status" value="0" required />
			<input type="hidden" name="start_date" value = "<?php echo date("Y-m-d H:i:s"); ?>" required />
			
		 <input type="submit" value="Сохранить">
		@else
			<p style="color: blue;">Выберите пожалуста, ресторан и должность в нем.</p>
			<p style="color: red;">Если выбора должности нет, то их должен создать менеджер ресторана.</p>
		@endif
  </form>
  <p><a href="/eventscustomer">Назад</a></p>
@endsection
	
