@extends('layout.default')

@section('title')
Velg bil
@stop

@section('content')
<h1>Leie av bil</h1>

{{ Form::open(array('url' => 'rentals/select')) }}

{{ Form::label('car_id', 'Velg bil:'); }}
<?php
$options = array();
foreach ($cars as $car) {
	$options[$car->id] = $car->make . " " . $car->model;
}
?>
{{ Form::select('car_id', $options); }}
<p>
{{ Form::submit('Fortsett', array('class' => 'btn btn-primary')); }}
</p>

{{ Form::close() }}


@stop