<div>
	
	<h1>Nuevo pedido ingresado | Empresa {{$company}}</h1>

	<p>
		
	El cliente {{$customer}} ha ingresado el pedido n° {{$order_id}} para obra {{$obra_name}}<br> Dirección: {{$obra}}. <br><br>

  Día y hora de entrega: {{$schedule}} <br><br>
  
  @foreach($responsibles as $responsible)
  Responsable: {{$responsible}} <br>
  @endforeach
	
	</p>

	<table style="text-align: center">
              <thead>
                <tr>
                  <th scope="col">Código</th>
                  <th scope="col">Producto</th>
                  <th scope="col">Precio unitario</th>
                  <th scope="col">Cantidad</th>
                </tr>
              </thead>
              <tbody>
                @if($items->count())
                @foreach($items as $item)
                            <tr>
                              <td>{{$item->attributes->product_code}}</td>
                              <td>{{$item->name}}</td>
                              <td>${{$item->price}}</td>
                              <td>{{$item->quantity}}</td>
                            </tr>
                        
                @endforeach
                @endif
                <div class="alert alert-primary" role="alert">
                    <h5>{{$shipping_cost}}
                    <h3>Total $ {{$total}}</h3>
                </div>
                <div style="width:100%">
                  <p>Comentarios</p>
                  <p>{{$comment}}</p>
                </div>
              </tbody>
            </table>

</div>