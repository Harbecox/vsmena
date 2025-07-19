@extends("layouts.pc")

@push("head")
 <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->
 <script src="/js/pc.js"></script>
 <script src='https://fullcalendar.io/releases/fullcalendar/2.9.0/lib/moment.min.js'></script>
 <script src='https://fullcalendar.io/releases/fullcalendar/2.9.0/lib/jquery.min.js'></script>
 <script src='https://fullcalendar.io/releases/fullcalendar/2.9.0/fullcalendar.min.js'></script>
 <script src='https://fullcalendar.io/releases/fullcalendar/2.9.0/lang-all.js'></script>
@endpush

@section("title", "Календарь смен")
@section("main")
  <h1><?php echo $header; ?></h1>
   <a href="/events/export" class="btn btn-primary"> Экспорт в Эксель </a><br/>
   <div id="backgroundtable">
	{!! $calendar->calendar() !!}  
    {!! $calendar->script() !!}
	</div>
@endsection