@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    BUSCAR PEDIDOS
                </div>
                <div class="card-body">
                    <form class="card-text" method="post" action="/admin/orders">
                        @csrf
                        
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="date-from">Desde</label>
                            <input type="date" class="form-control" name="date-from">
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="date-until">Hasta</label>
                            <input type="date" class="form-control" name="date-until">
                        </div>

                    </div>
                        <label for="status">Seleccionar estado del pedido</label>
                        <select name="status" class="custom-select">
                          <option value="" selected>Todos</option>
                          <option value="0" >Pendiente</option>
                          <option value="1">Entregado</option>
                        </select><br><br>

                        <label for="status">Ingrese el CUIT de la empresa</label>
                        <input type="number" class="form-control" name="cuit">
                        <br>

                         <label for="user">Usuario</label>
                        <select name="user" class="custom-select">
                          <option value="" selected>Seleccionar</option>
                          @if($users->count())
                          @foreach($users as $user)
                          <option value="{{$user->id}}">{{$user->name}}-{{$user->company}}</option>
                          @endforeach
                          @endif
                        </select><br><br>

                        <input type="submit" class="btn btn-info" value="BUSCAR"> 

                        <a href="/admin/orders" class="btn btn-info">LIMPIAR FILTROS</a>

                    </form>
                    
                </div>
                
            </div>

            <hr>

            @foreach($orders as $order)

            <div class="card">
              <div class="card-header">
                Pedido # {{$order->id}}
              </div>
              <div class="card-body">
                <h5 class="card-title">Usuario {{$order->user->name}}</h5>
                <p class="card-text">
                    Empresa:  {{$order->user->company}} <br>
                    CUIT:  {{$order->user->cuit}} <br>
                    Total $ {{$order->total}} <br>
                    Fecha: {{$order->created_at}} <br>
                    @if ($order->status == 0)
                    Estado: Pendiente
                    @elseif ($order->status == 1)
                    Estado: Entregado
                    @endif
                </p>
                <a href="/admin/order/{{$order->id}}" class="btn btn-primary">VER DETALLE</a>
              </div>
            </div>
            <p> 
            </p>
            @endforeach
             <div id="pagination" class="col-md-6 mb-3">
                      {{ $orders->links() }}
              </div>
         </div>   
    </div>
</div>
@endsection