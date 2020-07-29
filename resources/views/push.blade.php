@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">



           <form method="post" style="background-color: #fff; padding: 30px;" action="/admin/push/create">
              @csrf
        <h1>Crear Push Notification</h1>
        <h4>Usuarios totales suscriptos: {{$users['total']}}</h4>
        <h6>Desde esta sección podrá enviar push notification a todos aquellos usuarios que se hayan suscripto a las notificaciones de la app.</h6>

            <div class="form-group">
            <label for="name">Nombre</label><br>
            <input class="form-control" required type="text" name="name">
            </div>            
            
            <div class="form-group">
            <label for="title">Titulo</label><br>
            <input class="form-control" required type="text" name="title">
            </div>

            <div class="form-group">
            <label for="subtitle">Subtitulo</label><br>
            <input class="form-control" required type="text" name="subtitle">
            </div>

            <button type="submit" class="btn btn-primary">ENVIAR</button>
            <a href="/admin/push/view" class="btn btn-primary">VER NOTIFICACIONES ENVIADAS</a>

          </form>

        </div>
    </div>
</div>
@endsection