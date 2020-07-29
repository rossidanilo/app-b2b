@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

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

      <div class="row">

             <div class="col-md-4" id="filter">
               

                <div style="background-color: #fff; padding: 20px;">

              <h5>Filtros</h5>
              
              @if(count($filters))
              @foreach($filters as $filter)
              <span class="badge badge-secondary">{{$filter->name}}</span>
              @endforeach
              @endif
              
              <a class="btn btn-link" href="/products/delete-filters">Eliminar filtros</a>
              
              <hr>

              <form action="/products" method="post">
              @csrf

                <!-- Category filters -->

                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="category">Rubro</label>
                  </div>
                  <select class="custom-select" id="category" name="category">
                    <option value="0" selected>Seleccionar</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                  </select>
                </div>

              <!-- Subcategory filters -->

                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="subcategory">Subrubro</label>
                  </div>
                  <select class="custom-select" id="subcategory" name="subcategory">
                    <option value="0" selected>Seleccionar</option>
                    @foreach($subcategories as $subcategory)
                    <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
                    @endforeach
                  </select>
                </div>
              <!-- Brand filters -->
                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="brand">Marcas</label>
                  </div>
                  <select class="custom-select" id="brand" name="brand">
                    <option value="0" selected>Seleccionar</option>
                    @foreach($brands as $brand)
                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                    @endforeach
                  </select>
                </div>


                <input type="submit" class="btn btn-info" value="APLICAR">
                
              </form>

                </div>

             </div>
                
        <div class="col-md-8 justify-content-center">

<form id="form-products" method="GET" action="{{ url('products/search') }}">
      
      <div class="input-group mb-3">
        <input type="text" name="search" class="form-control" placeholder="Busque producto, código y/o marca">
        <div class="input-group-append">
            <button type="submit" class="btn btn-primary" id="basic-addon2" style="margin-top: 0"><i class="fa fa-search"></i></button>
          </span>
        </div>
      </div>

            <div class="row">
                <div class="col-md-8" style="width: 70%; padding-right: 0">
                    
                </div>

                <div class="col-md-4" style="width: 30%; padding-left: 8px">

                    
                  
                </div>
                
                
            </div>
        </form>
            
    @if(isset($search))

     <div class="col-md-8 justify-content-center">

        <div class="row">
                <div class="search-result">
        
        <h6>Resultado de búsqueda para "{{$search}}"</h6>
        
        </div>
    </div>
        </div>
    
    @endif

                @if(count($filters))
                  <div class="container" id="mobile-filter-results">

                    <div class="row">
                      <p>
                        Filtros: 
                        @foreach($filters as $filter)
                        <span class="badge badge-secondary">{{$filter->name}}</span>
                        @endforeach
                        
                        <a class="btn btn-link" href="/products/delete-filters">Eliminar filtros</a>
                      </p>
                      
                    </div>
                    
                  </div>
                @endif

                @if($products->count())
                @foreach($products as $product)                  
                <div onclick="location.href='{{'/products/show/'.$product->id}}';" class="card border-dark mb-3 text-center" id="product-card">
                  <div class="card-header">{{$product->name}}</div>
                  <div class="card-body text-dark">
                    <div class="row">
                      
                    <div class="col-md-8">
                      <div class="col-md-4" id="mobile-product-picture">
                      @if($product->image_id)
                      <img src="/img/{{$product->image_id}}.jpeg" class="img-thumbnail" alt="">
                      @else
                      <img src="/img/logo-h30.jpg" class="img-thumbnail" alt="">
                      @endif
                    </div><br>
                    <div id="product-data">
                      
                      <h6>Código de producto: {{$product->code}}</h6> 
                      <h6>Marca: {{$product->brand}}</h6><br>
                      <p class="card-text">Precio de lista: $ {{number_format((float)$product->price,2,',','.')}} <br> Precio de usuario: $ {{number_format((float)$product->user_price,2,',','.') ?? $product->price}}<!--  | Stock: 
                      
                        @if($product->stock > 5)
                          
                          <span style="color: green;"><i class="fa fa-circle"></i></span>
                      
                        @elseif($product->stock < 1 )
                      
                        <span style="color: red;"><i class="fa fa-circle"></i></span>
                      
                        @else
                      
                        <span style="color: yellow;"><i class="fa fa-circle"></i></span>
                      
                        @endif --></p>
                    </div>
                    </div>
                    <div class="col-md-4" id="desktop-product-picture">
                      @if($product->image_id)
                      <img src="/img/{{$product->images[0]->name}}" class="img-thumbnail" alt="">
                      @else
                      <img src="/img/logo-h30.jpg" class="img-thumbnail" alt="">
                      @endif
                    </div>
                    </div>
                  </div>
                </div>
                @endforeach
                
                
                 @else
                <div class="alert alert-primary" role="alert">
                    No se encontraron productos.
                </div>
                  <div class="text-center">
                    <a href="/products" class="btn btn-info">ELIMINAR BÚSQUEDA</a>
                  </div>
                @endif
      
      
                  </div>
                   <div id="pagination" class="col-md-6 mb-3">
                      {{ $products->links() }}
                  </div>
              </div>
          </div>
      </div>
    </div>   
  
  <!-- Mobile filter bar -->

 
        <div class="fixed-bottom text-center filter-modal shadow mt-2" data-toggle="modal" data-target="#filterModal">
          <button class="btn btn-link">
          <i class="fa fa-filter"></i>
                Filtros
          </button>
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

          <!-- Modal -->
            <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filtrar productos</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                     <form action="/products" method="post">
              @csrf
               <!-- Category filters -->

                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="category">Rubro</label>
                  </div>
                  <select class="custom-select" id="category" name="category">
                    <option value="0" selected>Seleccionar</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                  </select>
                </div>

                <!-- Subcategory filters -->

                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="subcategory">Subrubros</label>
                  </div>
                  <select class="custom-select" id="subcategory" name="subcategory">
                    <option value="0" selected>Seleccionar</option>
                    @foreach($subcategories as $subcategory)
                    <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
                    @endforeach
                  </select>
                </div>

              <!-- Brand filters -->
              
                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="brand">Marcas</label>
                  </div>
                  <select class="custom-select" id="brand" name="brand">
                    <option value="0" selected>Seleccionar</option>
                    @foreach($brands as $brand)
                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                    @endforeach
                  </select>
                </div>

                <input type="submit" class="btn btn-info" value="APLICAR">
                
              </form>
                  </div>
                </div>
              </div>
            </div>
             <!-- <script type="text/javascript" src="js/productFilter.js"></script>     -->
@endsection
