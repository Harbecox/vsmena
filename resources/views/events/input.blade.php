@extends("layouts.pc")

@push("head")
  <script src="/js/pc.js"></script>
@endpush
@section("title", "Закрытие смены")
@section("main")
	<h1>Закрытие смены</h1>
	 <form action="{{ action('EventManagerController@save') }}" method="POST">
		@if ($events->id)
		  {{ method_field('PUT') }}
		  <input type="hidden" name="id" value="{{ old('id', $events->id) }}">
		@endif
		{{ csrf_field() }}
		<label>Время закрытия смены</label>
		<input type="text" name="end_date" value = "<?php echo date("Y-m-d H:i:s"); ?>" required readonly >
		<input type="hidden" name="status" value="1" required />	
		<input type="submit" value="Сохранить">
   </form>
   <p><a href="/events">Назад</a></p>
   @endsection