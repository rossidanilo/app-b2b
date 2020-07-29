@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="container card">
                
            <p>Id: {{$subcategory->id}}</p> 
            <p>Rubro: {{$category->name ?? ''}}</p> 
            <form method="post" action="/admin/subcategories/{{$subcategory->id}}/edit">
                @csrf
                <div class="form-group">
                    <label for="title">Subrubro</label>
                    <input type="text" class="form-control" name="title" value="{{$subcategory->name}}">
                </div>

                <div class="form-group">
                    <label for="category">Seleccione el rubro</label>
                       <select class="form-control" name="category">
                            @if($category)
                            <option selected value="{{$category->id}}">{{$category->name}}</option>
                                @if($categories->count())
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                @endif
                            @else
                            <option selected value="">Seleccionar rubro</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                            @endif
                       </select> 

                </div>

                <input class="btn btn-primary" type="submit" value="Actualizar">
                <a class="btn btn-primary" href="/admin/subcategories/{{$subcategory->id}}/delete">Eliminar</a>

            </form>
            </div>

            <hr>
         </div>   
    </div>
</div>
@endsection