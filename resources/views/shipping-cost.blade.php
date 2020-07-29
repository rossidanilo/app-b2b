@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

          <div class="card">
            <h5 class="card-header">Costo de envío</h5>
            <div class="card-body">
              <form action="/admin/shipping-cost" method="post">
                @csrf
                <p>Ingrese el precio de corte y costo de envío. Para los pedidos inferiores al precio de corte, el envío se sumará al total del pedido.</p>
                <div class="form-group">
                  <label for="amount">Precio de corte</label>
                  <input type="number" class="form-control" id="amount" name="amount" value="{{$shipping_cost->amount ?? ''}}">
                </div>
                <div class="form-group">
                  <label for="cost">Costo de envío</label>
                  <input type="number" class="form-control" id="cost" name="cost" value="{{$shipping_cost->cost ?? ''}}">
                </div>
                <button type="submit" class="btn btn-info">GUARDAR</button>
              </form>
            </div>
          </div>

          </div>
    </div>
</div>

@endsection