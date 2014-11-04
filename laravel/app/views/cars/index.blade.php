@extends('layout.default')

@section('title')
Våre biler
@stop

@section('js')
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="{{ url("/js/jquery.lightbox_me.js") }}"></script>
<script type="text/javascript" src="{{ url("/js/cars.js") }}"></script>
@stop

@section('content')

<h1>Våre biler</h1>
<p>Under ser du en oversikt over vår bilstall. Ikke alle bilene er til enhver tid tilgjengelig. Lorem ipsum etc etc.</p>
<ul class="cars clearfix">
@foreach ($cars as $car)
<?php
	$is_available = true;
	$available_text = 'Ja';

	if ($rental = $car->rentals()->active()->get()->first()) {
		$is_available = false;
		$available_text = "Nei, utleid til " . Format::shortDate($rental->to_date);
	}
	else if (!$car->available) {
		$is_available = false;
		$available_text = "Nei, for tiden ikke i tilgjengelig";
	}

	list($lat, $lng) = explode(',', $car->location);

?>
	<li>
		<div>
			<img src="<?=Croppa::url($car->image, 300)?>" />
		</div>
		<h3>{{ $car->make }} {{ $car->model }}</h3>
		<dl>
		<dt>Type</dt><dd>{{ $car->cartype()->get()->first()->name }}</dd>
		<dt>Årsmodell</dt><dd>{{ $car->year }}</dd>
		<dt>Ant. seter / bagasjevolum</dt><dd>{{ $car->seats }} / {{ $car->luggage_volume }}L</dd>
		<dt>Tilgjengelig</dt><dd>{{ $available_text }}</dd>
		<dt>Poengpris/dag</dt><dd>Fra <span class="points">{{ $car->getWeekdayPrice() }}</span></dd>
		<dt>Lokasjon</dt><dd><a href="javascript:showMap({{ $lat }}, {{ $lng }})">Åpne kart</a></dd>
		</dl>

		@if ($is_available)
			<a role="button" class="btn btn-primary" href="{{ url('/rentals/create/' . $car->id) }}">Lei denne bilen!</a>
		@else
			<a role="button" class="btn btn-default disabled">Ikke tilgjengelig!</a>
		@endif


	</li>
@endforeach
</ul>
<div id="js-car-location-map"></div>
@stop