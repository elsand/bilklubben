@extends('...layout.default')

@section('abovecontent')
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h1>Enklere og billigere billeie!</h1>
    <p>Hos Bilklubben kan du tegne abonnement og leie biler svært billig. Maecenas ac faucibus lorem. Vivamus sapien justo, convallis ut diam id, gravida consequat felis. Curabitur enim tortor, lacinia sit amet tincidunt tempor, tempor in ligula. </p>
    <p><a class="btn btn-primary btn-lg" role="button" href="{{ url("about") }}">Les mer &raquo;</a></p>
  </div>
</div>
@stop
@section('content')

  <!-- Example row of columns -->
  <div class="row">
    <div class="col-md-4 frontpage-box">
      <h2>Hvordan fungerer det?</h2>
      <div class="row">
        <div class="col-md-3">
            <span class="points huge"></span>
        </div>
        <div class="col-md-9">
            <p>Bilene i bilklubben leies ved hjelp av bilklubbenpoeng, og kan ikke leies for penger. Poeng får du gjennom våre svært prisgunstige abonnementsavtaler.</p>
		</div>
      </div>
      <p class="bottom"><a class="btn btn-default" href="{{ url('about') }}" role="button">Les mer om Bilklubben &raquo;</a></p>
   </div>
   <div class="col-md-4 frontpage-box">
         <h2>Våre biler</h2>
      <div class="row">
        <div class="col-md-3">
            <img class="car" src="<?=Croppa::url("/gfx/cars/audi-r6.jpg", 100)?>" />
        </div>
        <div class="col-md-9">
         <p>Vi har til enhver tid en stall full av top moderne og attraktive biler. Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. </p>
        </div>
        </div>
         <p class="bottom"><a class="btn btn-default" href="{{ url('/cars') }}" role="button">Se på våre biler &raquo;</a></p>
       </div>
    <div class="col-md-4 frontpage-box">
      <h2>Kom i gang!</h2>
      <div class="row">
        <div class="col-md-3">
            <img src="<?=Croppa::url("/gfx/signup.png", 80)?>" />
        </div>
        <div class="col-md-9">
      <p>Hva venter du på? Begynn oppsamling av poeng i dag! Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta.</p>
        </div>
        </div>
      <p class="bottom"><a class="btn btn-primary" href="{{ url("subscriptions") }}" role="button">Tegn abonnement &raquo;</a></p>
    </div>
  </div>

<hr>

  <div class="row news">

    <div class="col-md-4">
        <h4>En nyhetssak</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc libero leo, lacinia eget est quis, vulputate bibendum dolor. </p>
        <p><a href="#">Les mer &raquo</a></p>
    </div>
    <div class="col-md-4">
        <h4>Enda en nyhetssak</h4>
        <p>Pellentesque sed feugiat lectus. Duis quis pretium massa. Etiam ac dictum tortor. Interdum et malesuada fames ac ante ipsum primis in faucibus. </p>
        <p><a href="#">Les mer &raquo</a></p>
    </div>
    <div class="col-md-4">
        <h4>Nok en nyhetssak</h4>
        <p>Etiam ac dictum tortor. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
        <p><a href="#">Les mer &raquo</a></p>
    </div>


  </div>

@stop
