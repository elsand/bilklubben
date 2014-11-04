@extends('layout.default')

@section('title')
Leie {{ $car->make }}  {{ $car->model }}
@stop

@section('js')
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="{{ url("/js/rentals.js") }}"></script>
<script type="text/javascript" src="{{ url("/js/bootstrap-datepicker.js") }}"></script>
<script type="text/javascript" src="{{ url("/js/locales/bootstrap-datepicker.nb.js") }}"></script>
<script type="text/javascript" src="{{ url("/js/moment.js") }}"></script>

<?php
$ranges = array();
foreach ($car->rentals()->get() as $rental) {
	$ranges = array_merge($ranges, $rental->getDateRange());
}
?>

<script>
var car_dates_unavailable = {{ json_encode($ranges) }};
var overridden_price_dates = {{ json_encode($car->getOverridenPriceDates()) }};
$(function() {
	loadGoogleMap({{ $car->location }});
	doReverseGeocode({{ $car->location }}, '#js-reverse-geocode');
	loadDateRangePicker(car_dates_unavailable, overridden_price_dates, function(e) {
		handleDateChange(
			e,
			car_dates_unavailable,
			overridden_price_dates,
			{{ $car->getWeekdayPrice() }},
			{{ $car->getWeekEndPrice() }},
			'#js-rentals-period',
			'#js-rentals-total',
			'{{ url('/rentals/price/' . $car->id) }}'
		);
	});
});
</script>
@stop

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url("/css/datepicker3.css") }}">
@stop

@section('content')
<h1>Leie {{ $car->make }}  {{ $car->model }}</h1>
<div class="row">
	<div class="col-md-4">
		<dl class="clearfix">
		<dt>Pris per hverdag</dt><dd><span class="points">{{ $car->getWeekDayPrice() }}</span></dd>
		<dt>Pris per helgedag</dt><dd><span class="points">{{ $car->getWeekEndPrice() }}</span></dd>
		</dl>
		<p><em>Merk at prisene kan variere på helligdager eller andre enkeltdatoer.</em></p>
		<h3>Velg leieperiode</h3>
		<p>Velg første og siste dato i leieperioden du ønsker. Datoer som er opptatte, vil være merket i kalenderen og kan ikke overlappes.
		Når du har valgt dato, vil du få en oversikt over totalpris.</p>
		{{ Form::open(array('url' => 'rentals/store/' . $car->id)) }}
		<label>Velg datoer for leieperiode:</label>
		<div class="input-daterange input-group" id="datepicker">
			<input type="text" class="input-sm form-control" name="from" />
			<span class="input-group-addon">til</span>
			<input type="text" class="input-sm form-control" name="to" />
		</div>
		<h4>Valgt leieperiode</h4>
		<div id="js-rentals-total" class="clearfix"></div>
		<div id="js-rentals-period" class="clearfix">
		<em>Ingen periode valgt.</em>
		</div>
		{{ Form::hidden('from_date'); }}
		{{ Form::hidden('to_date'); }}
		<button id="js-rental-btn-store" type="submit" class="btn btn-primary">Lei bilen!</button>
		{{ Form::close() }}

		<h3>Tips en venn!</h3>
		<p>Tips en venn om denne bilen! Bare oppgi en e-postadresse i boksen under, og vi sender et tips!</p>
		{{ Form::open(array('url' => 'tipafriend/' . $car->id)) }}
		{{ Form::label('E-post:') }}
		{{ Form::email('email') }}
		{{ Form::submit('Send') }}

	</div>
	<div class="col-md-8">
		<img src="<?=Croppa::url($car->image, 800)?>" class="fill">
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3>Bilens nåværende posisjon</h3>
		<p>Bilen befinner seg nå på addressen <strong id="js-reverse-geocode"></strong></p>
		<div id="js-rentals-location-map"></div>
	</div>
</div>

@stop