@extends('layout.default')

@section('title')
Abonnementer
@stop

@section('content')
<h1>Abonnementer</h1>

<p>Velg hvilket abonnement du ønsker. Velg "Platinum" for å få mest for pengene!</p>

<dl class="clearfix">
	@foreach ($plans as $plan)
	<dt><span class="subsc subsc-{{ Util::safe($plan->name) }}">{{ $plan->name }}</span>
        <br>kr {{ $plan->monthlycost }},- for <span class="points">{{ $plan->points }}</span> per mnd
    </dt>
    <dd>
        <button class="btn btn-primary">Tegn abonnement</button>
    </dd>
	@endforeach
</dl>

@stop