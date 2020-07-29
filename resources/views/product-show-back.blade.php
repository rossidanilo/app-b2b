@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="/admin/products/update/{{$product->id}}">
                      @csrf
                      
                      <div class="form-group">
                      <label for="subcategory">Subrubro</label>
                      <select name="subcategory_id" class="form-control">
                        
                        @foreach($subcategories as $subcategory)
                        
                          @if($subcategory->id == $product->subcategory_id)
                          <option selected value="{{$subcategory->id}}">
                            {{$subcategory->name}}
                          </option>
                          @else
                          <option value="{{$subcategory->id}}">
                            {{$subcategory->name}}
                          </option>
                          @endif
                        @endforeach

                      </select>
                      </div>

                      <div class="form-group">
                      <label for="name">Titulo</label>
                      <input type="text" name="name" class="form-control" value="{{$product->name}}">
                      </div>

                      <div class="form-group">
                      <label for="code">Código</label>
                      <input type="text" name="code" class="form-control" value="{{$product->code}}">
                      </div>
                      
                      <div class="form-group">
                      <label for="brand">Marca</label>
                      <input type="text" name="brand" class="form-control" value="{{$product->brand}}">
                      </div>
                      
                      <div class="form-group">  
                      <label for="stock">Stock</label>
                      <input type="number" name="stock" class="form-control" value="{{$product->stock}}">
                      </div>
                      
                      <div class="form-group">
                      <label for="price">Precio</label>
                      <input type="text" name="price" class="form-control" value="{{$product->price}}">
                      </div>

                      <div class="form-group">
                      <label for="published">No publicar</label>
                        @if($product->published === 0)
                          <input type="checkbox" checked name="published" id="published" value="0">
                        @else
                          <input type="checkbox" name="published" id="published" value="0">
                        @endif
                      </div>
                      
                      <div class="form-group">
                      <label for="description">Descripción</label>
                      <textarea class="form-control" name="description" class="form-control">{{$product->description}}</textarea>
                      </div>

                      <input type="submit" class="btn btn-info" name="enviar" value="ACTUALIZAR">

                    </form>

                    <hr>

                    <div class="container">

                      @if(session('success'))

                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <p>La imagen se subio correctamente</p>
                      <button class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      </div>
                      @endif
                      

                    <form method="post" enctype="multipart/form-data" action="/admin/products/uploadImage/{{$product->id}}">
                      @csrf
                      <div class="custom-file">
                        <input type="file" name="image" class="custom-file-input form-control" id="file-upload">
                        <label class="custom-file-label" id="label-upload" for="image"></label><br>
                      </div>

                        <input type="submit" class="btn btn-info" name="enviar" value="SUBIR IMAGEN">

                    </form><br>

                    </div>
                    @if($images->count())

                    <div class="container">

                      <div class="row">
                      @foreach($images as $image)

                        <div class="card text-center col product-image-back">
                          <div class="card-body">
                            
                          <img src="/img/{{$image->name}}" alt="">

                          </div>

                          <div class="card-footer">
                          <a href="/admin/products/deleteImage/{{$image->id}}" class="btn btn-danger">ELIMINAR</a>
                          </div>
                        </div>


                      @endforeach
                      </div>

                    </div>

                    @endif

                    <hr>

                    <div class="container">

                    <form method="post" action="/admin/products/link/{{$product->id}}">
                        @csrf
                        <div class="form-group">
                              <label for="alternative">Agregar alternativa</label>
                              <input type="text" name="alternative" class="form-control">
                        </div>

                         <input type="submit" class="btn btn-info" name="enviar" value="VINCULAR">
                    </form>

                    </div>
                      </div>
                  </div>
            </div>
            <hr>

            <h4 style="color: #fff">Productos alternativos</h4>

              <div class="table-responsive" style="padding: 0 15px;">
                
                <table class="table table-striped">
                  
                  <thead>
                    <tr>
                      <th scope="col">Código</th>
                      <th scope="col">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($alternatives->count())
                    @foreach($alternatives as $alternative)
                    <tr>
                      <td>{{$alternative->alternative_code}}</td>
                      <td><a href="/admin/products/alternatives/{{$product->id}}/{{$alternative->alternative_id}}"><i class="fa fa-trash-alt"></i></a></td>
                    </tr>
                    @endforeach
                    @endif
                  </tbody>


                </table>

              </div>
        </div>
    </div>
</div>
<script>
  $('#file-upload').change(function() {
  var file = $('#file-upload')[0].files[0].name
  $('#label-upload').text(file);
});
</script>
@endsection