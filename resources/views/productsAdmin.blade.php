@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="col-md-12">
          <div class="container text-center card">
            
            <a href="/admin/products/export" class="btn btn-info">EXPORTAR PRODUCTOS</a>

          </div>
        </div>

            <div class="col-md-12" style="margin-top: 5px;">
                <div class="card form-group">
                    
            <div class="alert alert-light" role="alert">
             <p>Seleccione un archivo CSV para <strong>cargar nuevos productos</strong>. La estructura del archivo debe ser: código de producto, titulo, rubro, subrubro, marca, descripción, precio, stock.</p>
             <p>Para actualizar productos por CSV, debe primero <strong>EXPORTAR</strong> todos los productos.</p>
            </div>

            <form method="POST" action="{{ url('/admin/products/import') }}" enctype="multipart/form-data">
                @csrf
                <div class="custom-file">
                <input id="file-upload" required type="file" class="custom-file-input" name="import_file">
                <label class="custom-file-label" for="import_file" id="label-upload"></label>
                </div>
                <button type="submit" class="btn btn-primary">Importar</button>
            </form>
                </div>
            </div>
        <hr>

      <div class="col-md-12">
        

        <div class="container card text-center">


          
        <h3>Incrementador general de precios</h3>
          
          <form method="post" action="/admin/products/boost">
              @csrf
               <div class="col-md-12">
                    <div class="input-group mb-12">
                      <input type="number" name="porcentage" class="form-control">
                      <div class="input-group-append">
                        <div class="input-group-text">%</div>
                      </div>
                    </div>
                    <input type="submit" class="btn btn-info" name="enviar" value="AUMENTAR PRECIOS">
                  </div>
          </form>
        </div>

        <hr>

        <div class="container col-md-8 justify-content-center">

			<form id="form-products" method="GET" action="{{ url('/admin/products/search') }}">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Ingrese producto, código y/o marca">
                </div>
                <div class="col-md-6">
                    <button class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>
      </div>
        <hr>

         <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Código</th>
                  <th scope="col">Producto</th>
                  <th scope="col">Marca</th>
                  <th scope="col">Precio</th>
                  <th scope="col">Stock</th>
                  <th scope="col">Descripción</th>
                  <th scope="col">Publicado</th>
                  <th scope="col">Imagen</th>
                </tr>
              </thead>
              <tbody>
                @if($products->count())
                @foreach($products as $product)
                            <tr>
                              <td><a href="{{URL::to('/admin/products/show/'.$product->id)}}">{{$product->code}}</a></td>
                              <td><a href="{{URL::to('/admin/products/show/'.$product->id)}}">{{$product->name}}</a></td>
                              <td>{{$product->brand}}</td>
                              <td>{{$product->price}}</td>
                              <td>{{$product->stock}}</td>
                              <td>{{$product->description}}</td>
                              <td>@if($product->published === 1)
                                  Si
                                  @else
                                  No
                                  @endif
                              </td>
                              <td>@if($product->image_id)
                                  Si
                                  @else
                                  No
                                  @endif
                              </td>
                            </tr>
                        
                @endforeach
                @else
                <div class="alert alert-primary" role="alert">
                    No se encontraron productos.
                </div>
                @endif
              </tbody>
            </table>
        </div>
        {{ $products->links() }}
    </div>
</div>

<script>
	$('#file-upload').change(function() {
  var file = $('#file-upload')[0].files[0].name
  $('#label-upload').text(file);
});
</script>
@endsection