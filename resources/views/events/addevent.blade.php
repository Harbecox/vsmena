@extends("layouts.pc")

@push("head")
 <script src="/js/pc.js"></script>
@endpush
@section("title", "Открытие смены")
@section("main")
	<h1>Открытие смены</h1>
	<form method="POST" action="{{ route('addeventmanager.store') }}"  enctype="multipart/form-data">
		{{ csrf_field() }}
		@foreach ($events as $event)
		<label>Ресторан</label>
		<input type="text" size="70" name="rest" class="source" value="{{ old('rname', $event->rname) }}" disabled>
		<label>Должность</label>
		<input type="text" size="70" name="posit" class="source" value="{{ old('name', $event->name) }}" disabled>
		<label>Время начала смены</label>
		<input type="text" name="start_date" value = "<?php echo date("Y-m-d H:i:s"); ?>" required readonly >
		<label>Оплата за час</label>
		<input type="text" size="70" name="price" class="source" value="{{ old('price_hour', $event->price_hour) }}" disabled>
		<label>Описание должности</label>
		<textarea name="description" size="70" class="comment-content" disabled> {{ old('description', $event->description) }}</textarea>
		<input type="hidden" name="positions_id" value="{{ $event->id }}" required />
		@endforeach
		<!-- ------------------hidden--------------------- -->
		<input type="hidden" name="title" value="Не подтверждена" required />
		<input type="hidden" name="color" value="#FF0000"required />	
		<input type="hidden" name="status" value="0" required />
		
	 <input type="submit" value="Сохранить">
  </form>
@endsection
	
