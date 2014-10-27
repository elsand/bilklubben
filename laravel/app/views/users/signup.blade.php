@extends('layout.default')
@section('title')
Registrering
@stop

@section('content')
<h1>Registrering av bruker</h1>
@include('users.signup-form')
@stop