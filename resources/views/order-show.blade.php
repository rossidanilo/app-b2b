@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
             <div class="card text-center">
                  <div class="card-body">
                    <h5 class="card-subtitle mb-2 text-muted">{{$order[0]->obras->name}}</h5>
                    <p class="card-text">Total: ${{$order[0]->total}}</p>
                    @if($order[0]->shipping_cost > 0)
                    <p class="card-text">Cost de envío: ${{$order[0]->shipping_cost}}</p>
                    @endif
                    <p class="card-text">Cantidad: {{$order[0]->quantity}}</p>
                    <p class="card-text">Comentarios: {{$order[0]->comments}}</p>
                </div>        
            </div>
            <hr>
                @if($orders->count())
                @foreach($orders as $order) 
                 <div class="card text-center">
                  <div class="card-body">
                    <h5 class="card-subtitle mb-2 text-muted">{{$order->name}}</h5>
                    <p class="card-text">Precio: ${{$order->price}}</p>
                    <p class="card-text">Cantidad: {{$order->quantity}}</p>
                    <p class="card-text">Subtotal: {{$order->total}}</p>
                </div>        
            </div>
                @endforeach
                @else
                <div class="alert alert-primary" role="alert">
                    No se encontraron productos.
                </div>
                @endif
            
        <button data-toggle="modal" data-target="#modal-order" class="btn btn-success">REPETIR PEDIDO</button>
        <a href="/orders" class="btn btn-info">VOLVER</a>
        <div class="mt-3 text-center">
            <small style="color:#fff;">Al hacer clic en REPETIR PEDIDO se agregarán los productos al carrito para realizar un nuevo pedido.</small>
        </div>
    </div>
</div>

 <!-- Modal Order -->
                  <div class="modal fade" id="modal-order" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Seleccione la obra para la cual desea repetir el pedido</h5>
                          <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="/orders/repeat/{{$id}}" method="post">
                              @csrf
                              <select name="obra" class="form-control">
                                  @if($obras->count())
                                  @foreach($obras as $obra)
                                        <option value="{{$obra->id}}">{{$obra->name ?? ''}}</option>
                                  @endforeach
                                  @endif
                              </select>
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" data-dismiss="modal" style="color:#fff">CANCELAR</button>
                          <button type="submit" class="btn btn-primary">REPETIR PEDIDO</button>
                        </div>
                          </form>
                        <div class="container">
                          <small>Al hacer clic en REPETIR PEDIDO se agregarán los productos al carrito para realizar un nuevo pedido.</small>
                        </div>
                      </div>
                    </div>
                  </div>  
@endsection