@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

          <div class="card">
            <div class="card-header">
              {{$obra->name}}
            </div>
          <div class="card-body">
            <form action="/admin/obras/edit/update/{{$obra->id}}" method="post">
              @csrf
              <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" value="{{$obra->name}}">
              </div>
               <div class="form-group">
                <label for="adress">Dirección</label>
                <input type="text" class="form-control" id="adress" name="adress" value="{{$obra->adress}}">
              </div>
              <div class="form-group">
                <label for="schedule">Horario de entrega</label>
                <input type="text" class="form-control" id="schedule" name="schedule" value="{{$obra->schedule}}">
              </div>
              <div class="form-group">
                <label for="responsible">Responsable</label>
                <input type="text" class="form-control" id="responsible" name="responsible" value="{{$obra->responsible}}">
              </div>
              <div class="form-group">
                <label for="dni">DNI</label>
                <input type="number" class="form-control" id="dni" name="dni" value="{{$obra->dni}}">
              </div>
              <div class="form-group">
                <label for="phone">Teléfono</label>
                <input type="number" class="form-control" id="phone" name="phone" value="{{$obra->phone}}">
              </div>
              <div class="form-group">
                <label for="responsible_2">Responsable 2</label>
                <input type="text" class="form-control" id="responsible_2" name="responsible_2" value="{{$obra->responsible_2}}">
              </div>
              <div class="form-group">
                <label for="dni_2">DNI</label>
                <input type="number" class="form-control" id="dni_2" name="dni_2" value="{{$obra->dni_2}}">
              </div>
              <div class="form-group">
                <label for="phone_2">Teléfono</label>
                <input type="number" class="form-control" id="phone_2" name="phone_2" value="{{$obra->phone_2}}">
              </div>
              <div class="form-group">
                <label for="responsible_3">Responsable 3</label>
                <input type="text" class="form-control" id="responsible_3" name="responsible_3" value="{{$obra->responsible_3}}">
              </div>
              <div class="form-group">
                <label for="dni_3">DNI</label>
                <input type="number" class="form-control" id="dni_3" name="dni_3" value="{{$obra->dni_3}}">
              </div>
              <div class="form-group">
                <label for="phone_3">Teléfono</label>
                <input type="number" class="form-control" id="phone_3" name="phone_3" value="{{$obra->phone_3}}">
              </div>
              <div class="form-group">
                 <button type="submit" class="btn btn-primary">GUARDAR</button>
              </div>
            </form>
          </div>
        </div>
 
         </div>   
    </div>
</div>
@endsection