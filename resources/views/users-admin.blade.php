@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
<form method="GET" action="{{ url('admin/users/search') }}">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Ingrese nombre, email o descuento.">
                </div>
                <div class="col-md-6">
                    <button class="btn btn-primary">Buscar</button>
                </div>
            </div><br>
        </form>
        <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Email</th>
                  <th scope="col">Grupo de descuento</th>
                  <th scope="col">Descuento usuario</th>
                  <th scope="col">Administrador</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                @if($users->count())
                @foreach($users as $user)
                            <tr>
                              <td>{{$user->id}}</td>
                              <td>{{$user->name}}</td>
                              <td>{{$user->email}}</td>
                              <td>{{$user->discount_group->name ?? 'Sin grupo asignado'}}</td>
                              <td>@if($user->discount)
                                {{$user->discount}}%
                                @else
                                <a href="/admin/users/{{$user->id}}" class="btn btn-info">AGREGAR DESCUENTO</a>
                                @endif
                                </td>
                                
                              <td>
                                @if($user->admin)
                                  Si
                                  @else
                                  No

      
                              </td>
                              @endif
                              <td>
                                 <a href="/admin/users/{{$user->id}}" class="btn btn-info">VER USUARIO</a>
                              </td>
                            </tr>
                        
                @endforeach
                @else
                <div class="alert alert-primary" role="alert">
                    No se encontraron usuarios registrados.
                </div>
                @endif
              </tbody>
            </table>
          </div>
        </div>
    </div>
</div>
@endsection