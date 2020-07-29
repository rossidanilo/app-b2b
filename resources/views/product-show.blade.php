@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-center">
                  <div class="card-header">{{$product->name}}</div>

                  <div class="card-body">

                     @if($images->count())

                    <div id="carouselExampleControls" class="carousel slide mobile-product-show-image" data-ride="carousel">
                       <ol class="carousel-indicators">
                        @for($i = 0; $i < $images->count(); $i++)
                        <li data-target="#carouselExampleControls" data-slide-to="{{$i}}"></li>
                        @endfor
                      </ol>
                    <div class="carousel-inner">

                      @for($i = 0; $i < $images->count(); $i++)
                      @if($i == 0)
                      <div class="carousel-item active">
                        <img class="d-block" src="/img/{{$images[$i]->name}}" alt="First slide">
                      </div>
                      @else
                      <div class="carousel-item">
                        <img class="d-block" src="/img/{{$images[$i]->name}}" alt="First slide">
                      </div>
                      @endif
                      @endfor

                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>

                    @else

                    <img src="/img/logo-h30.jpg" alt="logo-h30-ferreteria" border="0">

                    @endif

                    <div id="product-data">

                      <h6 class="card-subtitle mb-2">Código: {{$product->code}}</h6>
                      <h6 class="card-subtitle mb-2">Marca: {{$product->brand}}</h6><br>
                      <p>Precio de lista: $ {{$product->price}} <br>
                        Precio de usuario: $ {{$product->user_price ?? $product->price}} <br>
                      </p>
                      <p>
                        
                        Descripción: {{$product->description}}
                        
                      </p>
                    </div>


                    @if($images->count())

                    <div id="carouselExampleControls" class="carousel slide desktop-product-show-image" data-ride="carousel">
                       <ol class="carousel-indicators">
                        @for($i = 0; $i < $images->count(); $i++)
                        <li data-target="#carouselExampleControls" data-slide-to="{{$i}}"></li>
                        @endfor
                      </ol>
                    <div class="carousel-inner">

                      @for($i = 0; $i < $images->count(); $i++)
                      @if($i == 0)
                      <div class="carousel-item active">
                        <img class="d-block" src="/img/{{$images[$i]->name}}" alt="First slide">
                      </div>
                      @else
                      <div class="carousel-item">
                        <img class="d-block" src="/img/{{$images[$i]->name}}" alt="First slide">
                      </div>
                      @endif
                      @endfor

                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>

                    @endif


                    <form method="post" action="/products/show/add/{{$product->id}}">
                      @csrf
                      
                       <div class="align-items-center">

                        <div class="col-auto" style="padding: 0">
                        
                          <input required="true" type="number" placeholder="Ingrese cantidad" name="quantity" class="form-control" style="width: 100%;" >

                        </div>

                        <div class="col-auto" style="padding: 0">

                          <input type="submit" class="btn btn-info" style="width: 100%;" name="enviar" value="AGREGAR AL CARRITO">

                        </div>

                      </div>

                    </form>
                   <!--  @if($product->stock > 0) -->


                   <!--  @else
                                     
                                     <div>
                   <button data-toggle="modal" data-target="#modal-stock" class="btn btn-danger">CONSULTAR STOCK</button><br><br>
                                     </div>
                   
                   @endif -->

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                     {{session('success')}}
                    <button class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    @endif

                  </div>
            </div>
            <div class="col-md-12" style="padding: 0; margin-top: 20px">

              <div class="text-center" id="title-alternatives">
              
                <h3>Productos equivalentes</h3>
                
              </div>

                <hr>
                
                @if(isset($alternative_collection))
                
                @foreach($alternative_collection as $alternative)

                

                          <div onclick="location.href='{{'/products/show/'.$alternative['id']}}';" class="card border-dark mb-3" id="product-card">
                            <div class="card-header">{{$alternative['name']}}</div>
                            <div class="card-body text-dark">
                              <h5 class="card-title">Código de producto: {{$alternative['code']}}</h5>
                              <h6 class="card-text">Marca: {{$alternative['brand']}}</h6>
                              <p class="card-text">Precio de lista: $ {{$alternative['price']}}</p>
                              <p class="card-text">Precio de usuario: $ {{$alternative['user_price']}}</p>
                            </div>
                          </div>
                        
                @endforeach
                @else
                <div class="alert alert-primary" role="alert">
                      No se encontraron productos equivalentes.
                </div>
                @endif

              </div>

            </div>
        </div>
    </div>

    <!-- Modal Stock -->
                  <div class="modal fade" id="modal-stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Consultar Stock</h5>
                          <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="container modal-text">
                          <p>Si queres que te confirmemos disponibilidad de este producto y posibles equivalencias en otras marcas, haz clic en <strong>Aceptar</strong>.</p>
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                          <a href="/products/show/notify/{{$product->id}}" class="btn btn-primary">ACEPTAR</a>
                        </div>
                      </div>
                    </div>
                  </div> 
@endsection