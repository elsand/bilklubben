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

		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="{{url('css/styles.css')}}">
		@yield('css')

		@yield('headjs')
		<!--[if lt IE 9]>
			<script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body id="page-{{ Util::getCurrentRouteAsClassName() }}">

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
			<nav>
				<ul>
					<li><a href="{{ url('/rentals') }}">Lei bil</a></li>
					<li><a href="{{ url('/cars') }}">Våre biler</a></li>
					<li><a href="{{ url('/subscriptions') }}">Abonnement</a></li>
					<li><a href="{{ url('/users/create') }}">Registrer konto</a></li>
					<li><a href="{{ url('/about') }}">Om oss</a></li>
				</ul>
			</nav>
		@show
		@section('navbarlogin')
			@if ($user = Confide::user())
			<div class="navbar-logged-in">
				Logget inn som {{{ $user->first_name . " " . $user->last_name }}}
				| <span class="points">{{ $user->points }}</span>
				| <a href="{{ url("users/mypage") }}">Min side</a>
				| <a href="{{ url("users/logout") }}">Logg ut</a>
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

		@if (($error = Session::get('error')))
			<div class="alert alert-danger" role="alert">{{ $error }}</div>
		@endif

		@if (($success = Session::get('success')))
			<div class="alert alert-success" role="alert">{{ $success }}</div>
		@endif

		@yield('content')

		<hr>
		<footer>
		<p>&copy; {{ Config::get('app.name') }} {{ date('Y') }}</p>
		</footer>
	</div> <!-- /container -->

	@yield('belowcontent')

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	@yield('js');
	</body>
</html>
