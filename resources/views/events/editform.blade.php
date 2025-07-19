@extends("layouts.pc")

@push("head")
  <script src="/js/pc.js"></script>
@endpush

@section("title", "Подтверждение смены")
@section("main")
  <h1>Подтверждение смены</h1>
   <form method="POST" action="{{ route('editform_update',$events->id) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
	<label>Время начала смены</label>
	<input type="datetime-local" name="start_date" value="{{ $events->start_date }}"/>
	<label>Время окончания смены</label>
	<input type="datetime-local" name="end_date" value="{{ $events->end_date }}"/>
	<label>Премия</label>
	<input type="number" min="0" max="1000000" step="0.01" name="premium" value="{{ $events->premium }}"/>
	<label>Статус смены</label>
    <?php $r = old('title', $events->title); ?>
	<select name="title" id="title_select" >
		<option value="Не подтверждена" @if ($r == "Не подтверждена") selected @endif>Не подтверждена</option>
		<option value="Оспаривается" @if ($r == "Оспаривается") selected @endif>Оспаривается</option>
		<option value="Подтверждена" @if ($r == "Подтверждена") selected @endif>Подтверждена</option>
	</select>
	<input type="hidden" id="title_input" name="color" value="{{ $events->color }}"/>
	<input type="submit" value="Сохранить">
   </form>	
	<p><a href="/events/editeventurl">Список смен</a></p>   
@endsection