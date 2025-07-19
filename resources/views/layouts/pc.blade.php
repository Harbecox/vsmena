<!doctype html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{ asset('scss/basic.scss') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('scss/pc.scss') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('scss/print.scss') }}" type="text/css" media="print">
	<link href='https://fullcalendar.io/releases/fullcalendar/2.9.0/fullcalendar.min.css' rel='stylesheet' />
	<link href='https://fullcalendar.io/releases/fullcalendar/2.9.0/fullcalendar.print.min.css' rel='stylesheet' media='print' />
	<script src="{{ asset('js/main.js') }}"></script>

		@stack("head")
    <title>@yield("title") :: СУР</title>
  </head>
  <body>
    <div id="container"></div>
    <header>
      <div id="header_1"><h1>Система управления ресторанами</h1></div>
    </header>

	<!-- Всплывающее окно об удалении аккаунта -->
    <style>
    	#parent_popup {
    		background: #0000002e;
    		height: 100%;
    		opacity: 1;
    		position: fixed;
    		width: 100%;
    		z-index: 9999;
    		top: 0;
    		left: 0;
    	}
    	#popup {
    		background-color: white;
    		position: fixed;
    		top: 20%;
    		margin: auto;
    		padding: 20px;
    		max-width: 450px;
    		width: 87%;
    		transform: translate(-50%, 0);
    		left: 50%;
    		box-shadow: 12px 12px 2px 1px rgb(0 0 0 / 20%);
    		border-radius: 10px;
    	}
    	#popup p{
    		color: black;
    		text-align: right;
    		position: absolute;
    		right: 10px;
    		margin-top: 0 !important;
    		font-size: 20px;
    		font-weight: 600;
    		font-family: cursive;
    	}
    	#popup button{
    	cursor: pointer;
        position: absolute;
        margin: auto;
        text-align: center;
        top: 207px;
        transform: translate(-50%, -50%);
        left: 50%;
        padding: 10px 20px 10px 20px;
        border-radius: 50px;
    	}
    	#popup a{
    	color: black !important;
    	}
    	#popup img{
    		border-radius: 10px;
    	}
    	@media(max-width:600px){
    		#popup {
    			top: 20px;
    			text-align: center;
    		}
    	}

        #radio_one, #input_one, #radio_two, #input_two, #radio_three, #input_three{
            display: inline;
        }

    </style>

    <nav>
      <?php $p = request()->path(); $three = Request::segment(3);?>
      <!--<a href="/" @if ($p == "/") class="active" @endif>Главная</a>-->
	  <!--------------------------active-------------------------------->
	  @can ("manipulate", "App\Event")
        <a href="/events/eventpage" @if ($p == "events/eventpage") class="active"
        @endif>Подтверждение смен</a>
      @endcan

      @can ("manipulate", "App\User")
        <a href="/users" @if ($p == "users") class="active" @endif>Пользователи</a>
      @endcan
	  @can ("manipulate", "App\Logs")
        <a href="/logs" @if ($p == "logs") class="active" @endif>История событий</a>
      @endcan
	  @can ("manipulate", "App\EventManager")
        <a href="/events" @if ($p == "events") class="active" @endif>Открыть смену</a>
      @endcan
	  @can ("manipulate", "App\EventCustomer")
        <a href="/eventscustomer" @if ($p == "eventscustomer") class="active" @endif>Открыть смену</a>
      @endcan
	  @can ("manipulate", "App\EventManager")
        <a href="/events/todaywork" @if ($p == "events/todaywork") class="active" @endif>Сейчас работают</a>
      @endcan
	  <!------------------------from manager------------------------>
	  @can ("manipulate", "App\Restaurants")
        <a href="/restaurants" @if ($p == "restaurants") class="active"
		@elseif ($p == "positionsmanager") class="active"
        @endif>Рестораны</a>
      @endcan
	   <!------------------------------------------------------------>
	    @can ("manipulate", "App\Booker")
        <a href="/booker" @if ($p == "booker") class="active" @endif>Экспорт в Эксель</a>
      @endcan
	   <!---------------------------booker--------------------------->
	  @can ("manipulate", "App\Positions")
        <a href="/positions" @if ($p == "positions") class="active" @endif>Должности</a>
      @endcan

	  @can ("manipulate", "App\EventManager")
        <a href="{{ url('/events/mview', 'confirm') }}" @if ($three =="confirm") class="active"
		@endif> Подтверждение смен </a>
      @endcan
	  @can ("manipulate", "App\EventCustomer")
        <a href="/eventscustomer/mview" @if ($p == "eventscustomer/mview") class="active"
		@endif> История смен </a>
      @endcan
	  @can ("manipulate", "App\UserManager")
        <a href="/usersmanager" @if ($p == "usersmanager") class="active" @endif>Пользователи</a>
      @endcan
	  @can ("manipulate", "App\UserCustomer")
        <a href="/userscustomer" @if ($p == "userscustomer") class="active" @endif>Мои данные</a>
      @endcan
	  @can ("manipulate", "App\EventManager")
        <a href="{{ url('/events/mview', 'history') }}" @if ($three =="history") class="active"
		@endif> История смен </a>
      @endcan
      @if (auth()->check())
        <a href="/logout">Выход</a>
      @else
        <a href="/login" @if ($p == "login") class="active" @endif>Вход</a>
        <a href="/register" @if ($p == "register") class="active" @endif>Регистрация</a>
      @endif
    </nav>
    <section>
      @if (session('status'))
        <p>{{ session('status') }}</p>
      @endif
	  @if (auth()->check())
        <span style ="color: blue;" > {{ auth()->user()->fio }} - {{ auth()->user()->friendly_role }}! </span>
	  @endif
      @yield("main")
    </section>

  </body>
</html>
