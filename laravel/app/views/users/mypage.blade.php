@extends('layout.default')

@section('title')
Min side
@stop

@section('content')

<h1>Min side</h1>
<div class="row">
	<div class="col-md-6 info">
		<h2>Personopplysninger</h2>
	    <dl class="clearfix">
		    <dt>Navn</dt><dd>{{{ $user->first_name }}} {{{ $user->last_name }}}</dd>
		    <dt>E-post</dt><dd>{{{ $user->email }}}</dd>
		    <dt>Registrert siden</dt><dd>{{{ strftime('%c', strtotime($user->created_at)) }}}</dd>
	    </dl>
	    <button class="btn btn-primary">Endre opplysninger</button>
	</div>
	<div class="col-md-6 subsc">
		<h2>Abonnement</h2>
		<dl class="clearfix">
			<dt class="large">Poengsaldo</dt><dd class="large"><span class="points">{{ $user->points }}</span></dd>
			@if ($subscription)
			<dt>Abonnement</dt>
			<dd><span class="subsc subsc-{{ Util::safe($plan->name) }}">{{ $plan->name }}</span>
				<br>kr {{ $plan->monthlycost }},- for <span class="points">{{ $plan->points }}</span> per mnd
			</dd>
			@else
			<dt>Abonnement</dt>
			<dd>
				<p>Du har ikke noe abonnement for tiden.</p>
            	<p><button class="btn btn-primary">Tegn abonnement</button>
			</dd>
			@endif
		</dl>
		@if ($subscription)
		<button class="btn btn-primary">Endre abonnement</button>
		@endif
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h2>Leieavtaler</h2>
		@if ($rentals)
		<table>
		<thead>
			<tr>
				<th>Bil</th>
				<th>Fra dato</th>
				<th>Til dato</th>
				<th>Betalt</th>
				<th>Rabatt</th>
				<th>Opprettet</th>
				<th>Tilbakemelding</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($rentals as $rental)
			<?php $car = $rental->car()->get()->first() ?>
			<tr>
				<td><a href="{{ url("rentals/create/" . $car->id) }}">{{ $car->make . " "  . $car->model }}</a></td>
				<td>{{ Format::shortDate($rental->from_date) }}</td>
				<td>{{ Format::shortDate($rental->to_date) }}</td>
				<td><span class="points">{{$rental->paid }}</span></td>
				<td>{{ $rental->discount ? $rental->discount . '%' : '-' }}</td>
				<td>{{ strftime('%c', strtotime($rental->created_at)) }}</td>
				<td><a href="#">Send tilbakemelding</a></td>
			</tr>
			@endforeach
		</tbody>
		</table>
		@else
		<p>Du har ikke leid bil hos oss.</p>
		<p><a class="btn btn-primary" href="{{ url("/cars") }}">Lei en bil i dag!</a></p>
		@endif
	</div>
</div>

@stop