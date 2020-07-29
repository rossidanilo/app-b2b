@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
           
           <form method="post" style="background-color: #fff; padding: 30px" action="/admin/brands/create">
             @csrf
             <div class="form-group">
               <label for="name">Marca</label>
               <input class="form-control" type="text" name="name">
             </div>

             <input type="submit" class="btn btn-info" value="CREAR">

           </form>

           <hr>

           <div class="table-responsive table-striped">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @if($brands->count())
                  @foreach($brands as $brand)
                  <tr>
                    <td>{{$brand->id}}</td>
                    <td>{{$brand->name}}</td>
                    <td>
                      <a class="btn btn-info" href="/admin/brands/edit/{{$brand->id}}">EDITAR</a> 
                      <a class="btn btn-info" href="/admin/brands/delete/{{$brand->id}}">ELIMINAR</a>
                    </td>
                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
          </div>

        </div>
    </div>
</div>
@endsection