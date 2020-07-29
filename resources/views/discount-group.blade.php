@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

        <div class="bg-light p-4">
          
          <form method="post" action="/admin/discount-group">
           @csrf 

           <h3>Crear Grupo de Descuento</h3>

             <div class="form-group">
                <label for="name">Nombre del grupo de descuento</label>
                <input required type="text" class="form-control" name="name">
              </div>
              <div class="form-group">
                <label for="discount">Descuento</label>
                <input required type="number" class="form-control" name="discount">
              </div>

              <input type="submit" class="btn btn-info" value="GUARDAR">

          </form>

        </div>

        <hr>

        <div class="bg-light p-4">
          
             <div class="table-responsive">

                <table class="table table-striped">

                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Grupo</th>
                      <th scope="col">Descuento</th>
                      <th scope="col">Acción</th>
                    </tr>
                  </thead>

                  <tbody>
                    @foreach($groups as $group)
                    <tr>
                      <td>{{$group->id}}</td>
                      <td>{{$group->name}}</td>
                      <td>{{$group->discount}}%</td>
                      <td><a class="btn-link" href="/admin/discount-group/edit/{{$group->id}}">Editar</a></td>
                    </tr>
                    @endforeach
                  </tbody>
                          

                </table>

              </div>

        </div>
      
         
        </div>
    </div>
</div>
@endsection