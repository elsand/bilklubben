<!doctype html>
<html lang="nb">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Biklubben.no - leiebiler på nett">
		<meta name="author" content="Bjørn Langfors">
		<link rel="icon" href="{{url('favicon.ico')}}">

		<title>
		@section('title')
		Forsiden
		@show
		| {{ Config::get('app.name') }}
		</title>

		@section('css')
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="{{url('css/styles.css')}}">
		@show

		@yield('headjs')
		<!--[if lt IE 9]>
			<script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>

	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">

		@section('navbarheader')
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Vis navigasjon</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('') }}"><span>Bilklubben.no</span></a>
			</div>
		@show
		@section('navbarlogin')
			@if ($user = Confide::user())
			<div class="navbar-logged-in">
				Logget inn som {{{ $user->first_name . " " . $user->last_name }}} |
				<a href="">Min side</a> |
				<a href="{{ url("users/logout") }}">Logg ut</a>
			</div>
			@else
			<div class="navbar-collapse collapse">
				<form class="navbar-form navbar-right" role="form" method="post" action="{{ url('users/login') }}">
					<input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
					<div class="form-group">
						<input type="email" placeholder="E-post" class="form-control" name="email">
					</div>
					<div class="form-group">
						<input type="password" placeholder="Passord" class="form-control" name="password">
					</div>
					<button type="submit" class="btn btn-success">Logg inn</button>
				</form>
			</div><!--/.navbar-collapse -->
			@endif
		 @show
		</div>
	</div>

	@yield('abovecontent')

	<div class="container main-content">

		@yield('content')

		<hr>
		<footer>
		<p>&copy; {{ Config::get('app.name') }} {{ date('Y') }}</p>
		</footer>
	</div> <!-- /container -->

	@yield('belowcontent')

	@section('js')
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	@show
	</body>
</html>
