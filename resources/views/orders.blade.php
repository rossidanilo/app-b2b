@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
  
          <div class="card text-center">
            <div class="card-header">
              FILTRAR POR OBRAS
            </div>
            <div class="card-body">
              <h5 class="card-title">Seleccione la obra que desea filtrar</h5>
              <form method="post" action="/orders/filter">
                @csrf
                <select required name="obra" class="custom-select">
                  <option selected value="">Seleccionar obra</option>
                  <!-- <option value="0">TODAS</option> -->
                  @foreach($obras as $obra)
                  <option value="{{$obra->id}}">{{$obra->adress}}</option>
                  @endforeach
                </select><br><br>
                
                
                <input type="submit" name="apply" value="APLICAR" class="btn btn-info">
                <a href="/orders" class="btn btn-info">LIMPIAR FILTRO</a>

              </form>
            </div>
          </div>
        

          <hr>

                @if($orders->count())
                @foreach($orders as $order)
            <div onclick="location.href='{{'/orders/'.$order->id}}';" class="card order-card">
              
              <div class="card-body">
                  <h5 class="card-title">Pedido N° {{$order->id}}</h5>
                  <h6 class="card-subtitle">Fecha de pedido: {{$order->created_at}}</h6>
                  <p class="card-text">Obra: {{$order->obras->name ?? 'TODAS'}}</p>
                  <p class="card-text">Estado: {{$order->status ? 'Entregado' : 'Pendiente'}}</p>
                  <p class="card-text">Total: $ {{$order->total}}</p>
                             <a href="/orders/{{$order->id}}" class="btn btn-info">Ver pedido</a>
              </div>


            </div>
              <hr>
                @endforeach
                @else
                <div class="alert alert-primary" role="alert">
                    No se encontraron pedidos.
                </div>
                @endif

                {{$orders->links()}}

        </div>
    </div>
</div>
@endsection