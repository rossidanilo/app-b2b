@extends('layouts.app')

@section('content')
<div class="container">
    
        <div class="col-md-12" style="padding: 0 2px">

          @if($message = Session::get('success'))
           <div class="alert alert-success" role="alert">
                    {{$message}}
                </div>
                @endif

          <div class="col-md-6 text-center container" style="padding: 0">
        
                <div class="card">
                    <div class="card-header">Obra seleccionada: {{session()->get('obra_name')}} </div>
                    <div class="card-text">
                      <button class="btn btn-primary" data-toggle="modal" data-target="#modal-change-obra">
                        CAMBIAR OBRA
                    </button></div>
                    
                </div>

            </div>
          
          <hr>

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">CARRITO DE COMPRAS</h5>
              

          @if($items->count())
                @foreach($items as $item)

                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">{{$item->name}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{$item->attributes->product_code}} - P. Unitario: ${{$item->price}}</h6>

                    <form method="post" id="update-form" action="/cart/update/{{$item->id}}">
                                  @csrf
                                    

                                    <div class="container">
                                    <div class="row align-items-center"> 
                                    <input type="number" name="quantity" id="quantity" class="form-control mb-2" style="width: 30%" value="{{$item->quantity}}">

                                    <button class="btn" type="submit"> <i class="fas fa-edit"></i></button>
                                      
                                    <a href="/cart/remove/{{$item->id}}" class="btn"> <i class="fa fa-trash-alt"></i></a>
                                      
                                    </div>
                                    </div>


                                    <p class="number mb-0">  
                                    Subtotal: $ {{$item->price*$item->quantity}}
                                    </p>

                                    
                    </form>
                  </div>
                @endforeach
            </div>
          </div>
              
              <h6 class="number" style="padding:10px 20px">
                @if($shipping_cost === 0)
                  Envio sin cargo
                @else
                  Faltan $ {{$shipping_cost->amount - $total}} para tener envío sin cargo <br><br>
                  Costo de envío $ {{$shipping_cost->cost}}
                @endif
              </h6>
              <h4 class="number" style="padding:10px 20px">
              @if($shipping_cost === 0)  
                Total: $ {{$total}}
              @else
                Total: $ {{$total + $shipping_cost->cost}}
              @endif
              </h4>
                </div>
                    
                <div class="card">

                  <div class="card-text text-center">

                    <h5 class="card-title pt-3">COMENTARIOS</h5>

                    <form id="comments" method="post" action="/cart/sendOrder">
                        @csrf

                        <div class="col-md-12 mb-3">
                          
                          <textarea id="comments-text-area" placeholder="Ingrese algún comentario u observación sobre su pedido" name="comments" class="  form-control" rows="3"></textarea>
                          
                        </div>


                    </form>
                    
                  </div>
                  
                </div>

                <div class="cart text-center">
                  
                	<a href="/products" class="btn btn-info">CONTINUAR COMPRANDO</a>
                  <div class="row">
                    <div class="col">
                      <button data-toggle="modal" data-target="#modal-cart" class="btn btn-danger">VACIAR</button>
                    </div>
                    <div class="col">
                  	  <button data-toggle="modal" data-target="#modal-order" class="btn btn-success">CONFIRMAR</button>
                    </div>
                  </div>

                </div>
                  </div>
                </div>        
                @else
                <div class="alert alert-primary" role="alert">
                    No se encontraron productos.
                </div>
                @endif

                <!-- Modal Order -->
                  <div class="modal fade" id="modal-order" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">¿Confirma que desea enviar el pedido?</h5>
                          <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" data-dismiss="modal" style="color:#fff">CANCELAR</button>
                          <button form="comments" type="submit" class="btn btn-primary">ENVIAR PEDIDO</button>
                        </div>
                      </div>
                    </div>
                  </div>  

                <!-- Modal Cart -->
                  <div class="modal fade" id="modal-cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">¿Confirma que desea vaciar el carrito?</h5>
                          <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-footer">
                          <a class="btn btn-secondary" data-dismiss="modal" style="color:#fff">CANCELAR</a>
                          <a href="/cart/clear" class="btn btn-primary">VACIAR CARRITO</a>
                        </div>
                      </div>
                    </div>
                  </div> 

                  <!-- Modal Obra -->
                  <div class="modal fade" id="modal-change-obra" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">ATENCIÓN!</h5>
                          <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="container modal-text">
                          <p>En caso de cambiar la obra se perderán todos los productos que habían sido agregados al carrito.
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                          <a href="/obras" class="btn btn-primary">ACEPTAR</a>
                        </div>
                      </div>
                    </div>
                  </div>
 
@endsection