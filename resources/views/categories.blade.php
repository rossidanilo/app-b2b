@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card container">

                @if($message = Session::get('error'))
                            <div class="alert alert-danger text-center" role="alert">
                            {{$message}}
                            </div>
                            @endif

            <form method="post" action="/admin/categories/create">
                @csrf
                <div class="form-group">
                    <label for="title">Ingrese el nombre deL rubro</label>
                    <input type="text" required class="form-control" name="title">
                </div>

                <input class="btn btn-primary" type="submit" value="Crear Rubro">

            </form>
                
            </div>

            <hr>

            <table class="table table-striped">
                @if($categories->count())
              <thead>
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Nombre</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>
                            <a href="/admin/categories/{{$category->id}}">{{$category->id}}
                            </a>
                        </td>
                        <td>
                            <a href="/admin/categories/{{$category->id}}">
                            {{$category->name}}
                            </a>
                        </td>
                    </tr>
                @endforeach
                @else
                <tbody>
                <tr>
                    <td>
                        <div class="alert alert-primary" role="alert">
                        No se encontraron rubros. 
                        </div>
                    </td>
                </tr>
                @endif
              </tbody>
        </table>
         </div>   
    </div>
</div>
@endsection