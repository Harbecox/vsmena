@extends("layouts.pc")

@push("head")
  <script src="/js/pc.js"></script>
@endpush

@section("title", "Закрытие смены")
@section("main")
  <h1>Закрытие смены</h1>
   <form method="POST" action="{{ route('EventManagerController@save',$events->id) }}"  enctype="multipart/form-data">
    {{ csrf_field() }}
	<label>Время закрытия смены</label>
		<input type="text" name="end_date" value = "<?php echo date("Y-m-d H:i:s"); ?>" required readonly >
	<input type="submit" value="Сохранить">
   </form>	
	<p><a href="/events">Назад</a></p>   
@endsection