@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="container card">
                

            <p>Id: {{$category->id}}</p> 
            <form method="post" action="/admin/categories/{{$category->id}}/edit">
                @csrf
                <div class="form-group">
                    <label for="title">Rubro</label>
                    <input type="text" class="form-control" name="title" value="{{$category->name}}">
                </div>

                <input class="btn btn-primary" type="submit" value="Guardar">
                <a class="btn btn-primary" href="/admin/categories/{{$category->id}}/delete">Eliminar</a>

            </form>
            </div>

            <hr>
         </div>   
    </div>
</div>
@endsection