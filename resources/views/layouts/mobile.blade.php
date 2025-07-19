<!doctype html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/basic.css" type="text/css">
    <link rel="stylesheet" href="/css/mobile.css" type="text/css">
    <link rel="stylesheet" href="/css/print.css" type="text/css" media="print">			
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<script src="/js/main.js"></script>		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>@yield("title") :: СУР</title>
  </head>
  <body>
    <header>
      <h1>Система управления рестораном</h1>
    </header>	<?php $p = request()->path(); ?>	
	@if ($p == "/") 		
	<nav class="navbar navbar-dark bg-dark">		 
		<div class="container-fluid">			
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">			  <span class="navbar-toggler-icon"></span></button>
		</div>		
	</nav>	
	@endif
    <section>		
	<nav> @if (auth()->check())						
			<a href="/logout">Выход</a>	
			@else						
			<a href="/login" @if ($p == "login") class="active" @endif>Вход</a>						
			<a href="/register" @if ($p == "register") class="active" @endif>Регистрация</a>					  
		@endif				
	</nav>				
	@if (session('status'))					
		<p>{{ session('status') }}</p>				  
	@endif			
      @yield("main")
    </section>
    <footer>
      <p>© 2024&nbsp;г.</p>
    </footer>
  </body>
</html>
