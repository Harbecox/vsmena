@extends("layouts.pc")

@push("head")
   
  <!-- Add jQuery JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
   <!-- DataTables JavaScript & CSS -->
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
  
  <script>
  $(document).ready(function() {
	  $('#datatable').dataTable({
		searching: false,
		"language": {
			"url": " https://cdn.datatables.net/plug-ins/2.0.7/i18n/ru.json"
		}
    });
  });
  </script>
@endpush

@section("title", "История событий")
@section("main")
  <h1>Список событий</h1>
  
  <div id="backgroundtable">
  <table id="datatable" class="list">
    <thead>
    <tr>
	  <th>Дата события</th>
      <th>Сотрудник</th>
	  <th>Ресторан</th>
	  <th>Название должности</th>
      <th>Событие</th>
	  <th>Администратор</th>
    </tr>
	</thead>
	<tbody>
    @foreach ($data as $subcat)
      <tr>
        <td>{{ $subcat->date_add }}</td>
		<td>{{ $subcat->usrfio }}</td>
		<td>{{ $subcat->restname }}</td>
		<td>{{ $subcat->posname }}</td>
        <td class="center">{{ $subcat->title }}</td>
		<td>{{ auth()->user()->fio }}</td>
      </tr>
    @endforeach
	</tbody>
  </table>
  </div>
  
@endsection
