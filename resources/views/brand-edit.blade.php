@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          
           <form method="post" style="background-color: #fff; padding: 30px" action="/admin/brands/edit/{{$brand->id}}">
             @csrf
             <div class="form-group">
               <label for="name">Marca</label>
               <input class="form-control" type="text" name="name" placeholder="{{$brand->name}}">
             </div>

             <input type="submit" class="btn btn-info" value="ACTUALIZAR">

           </form>

        </div>
    </div>
</div>
@endsection