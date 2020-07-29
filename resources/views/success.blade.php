@extends('layouts.app')

@section('content')

<main role="main" class="inner cover text-center">

	<div class="container col-md-8">
		
        <h1 class="cover-heading">El pedido n°{{$order->id}} se envio con éxito</h1>
        <p class="lead">Te enviamos una copia del detalle de tu pedido a tu email.</p>
        <p class="lead">
          <a href="/orders" class="btn btn-lg btn-secondary">VER PEDIDOS</a>
        </p>

	</div>
      </main>

@endsection