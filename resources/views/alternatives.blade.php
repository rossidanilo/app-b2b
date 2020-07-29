@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Código de producto</th>
                  <th scope="col">Producto</th>
                  <th scope="col">Precio</th>
                  <th scope="col">Cantidad</th>
                  <th scope="col">Total</th>
                </tr>
              </thead>
              <tbody>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                        
                <div class="alert alert-primary" role="alert">
                    No se encontraron productos.
                </div>
                             
              </tbody>
            </table>
            	<a href="/admin/products/alternatives/export" class="btn btn-info">EXPORTAR</a>

               <form method="POST" action="{{ url('/admin/products/alternatives/import') }}" enctype="multipart/form-data">
                @csrf
                <div class="custom-file">
                <input type="file" class="custom-file-input" name="import_file">
                <label class="custom-file-label" for="import_file"></label>
                </div>
                <button type="submit" class="btn btn-primary">IMPORTAR</button>
            </form>

        </div>
    </div>
</div>
@endsection