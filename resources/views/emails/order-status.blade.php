<div>
	
	@if($status == 0)
	<h1>El pedido N° {{$order_id}} se encuentra pendiente</h1>
	<p>
		El pedido N° {{$order_id}} se encuentra pendiente. Te comunicaremos por este medio cuando el mismo sea enviado.
	</p>
	@elseif($status == 1)
	<h1>El pedido N° {{$order_id}} ha sido entregado</h1>
	<p>
		El pedido N° {{$order_id}} ha sido entregado. Por cualquier consulta quedamos a disposición.
	</p>
	@endif

	<p>
			Para ver los pedidos realizados, haga <a href="https://app.h30.store/orders">click aquí</a>
	</p>

  <p>Saludos, H30 Ferretería</p>

	
</div>