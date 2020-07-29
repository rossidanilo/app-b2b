@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="container card">
                 @if($message = Session::get('error'))
                            <div class="alert alert-danger text-center" role="alert">
                            {{$message}}
                            </div>
                            @endif

            <form method="post" action="/admin/subcategories/create">
                @csrf
                <div class="form-group">
                    <label for="title">Ingrese el nombre del subrubro</label>
                    <input type="text" required class="form-control" name="title">
                </div>

                <div class="form-group">
                    @if($categories->count())
                    <select class="form-control" name="category">
                       <option value="" selected>Seleccionar rubro</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                    </select>
                    @else
                    <div class="alert alert-primary" role="alert">
                    No se registran rubros. Para poder crear un subrubro, debe primero crear el rubro al cual pertenece. 
                    </div>
                    @endif
                </div>

                <input class="btn btn-primary" type="submit" value="Crear Subrubro">

            </form>
            </div>

            <hr>

            <table class="table table-striped">
                @if($subcategories->count())
              <thead>
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Subrubro</th>
                  <th scope="col">Rubro</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($subcategories as $subcategory)
                    <tr>
                        <td>
                            <a href="/admin/subcategories/{{$subcategory->id}}">{{$subcategory->id}}
                            </a>
                        </td>
                        <td>
                            <a href="/admin/subcategories/{{$subcategory->id}}">
                            {{$subcategory->name}}
                            </a>
                        </td>
                        <td>
                            <a href="#">
                            {{$subcategory->category['name']}}
                            </a>
                        </td>
                    </tr>
                @endforeach
                @else
                <tbody>
                <tr>
                    <td>
                        <div class="alert alert-primary" role="alert">
                        No se encontraron subcategorías. 
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