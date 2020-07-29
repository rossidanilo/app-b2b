@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card text-center">
              <div class="card-header">
                Pedido # {{$order->id}}
              </div>
              <div class="card-body">
                <h5 class="card-title">Usuario {{$order->user->name}}</h5>
                <p class="card-text">
                    Empresa: {{$order->user->company}} <br>
                    CUIT: {{$order->user->cuit}} <br>
                    Total $ {{$order->total}} <br>
                    @if($order->shipping_cost > 0)
                    Costo de envío $ {{$order->shipping_cost}}
                    @endif
                    Fecha: {{$order->date}} <br>
                    Comentarios: {{$order->comments}} <br>
                </p>
                @if($order->shippingList)
                <div>
                  <img src="/shipping-list/{{$order->shippingList->link}}" alt="" class="img-thumbnail">
                  <div class="text-center">
                    <a class="btn btn-info" href="/shipping-list/{{$order->shippingList->link}}" download>DESCARGAR</a>
                  </div>
                </div>
                @endif
              </div>
              
              <div class="card-footer">
                  @if($order->status == 0)
                <p>
                  Estado: Pendiente
                </p>
                <form method="post" enctype="multipart/form-data" action="/admin/order/update/{{$order->id}}" class="prevent-double-submit">
                  @csrf
                  <select name="status" class="custom-select">
                    <option selected>Seleccione el estado</option>
                    <option value="0">Pendiente</option>
                    <option value="1">Entregado</option>
                  </select><br><br>

                  <div class="custom-file">
                        <input type="file" name="doc" required class="custom-file-input form-control" id="file-upload" accept="image/*" capture="camera">
                        <label class="custom-file-label" id="label-upload" for="doc">Subir remito</label><br>
                      </div>
                  <button type="submit" class="btn btn-info prevent-button"><i class="spinner fa fa-spinner fa-spin" hidden></i>ACTUALIZAR</button>
                </form>
                  @elseif($order->status == 1)
                  <p>
                  Estado: Entregado
                  </p>
                  @endif
                </p>
              </div>
            </div>
            <hr>
          
          @foreach($details as $detail)
            <div class="card">
              <div class="card-header">
                Código de producto: {{$detail->code}}
              </div>
              <div class="card-body">
                <h5 class="card-title">{{$detail->name}}</h5>
                <p class="card-text">
                  Precio: $ {{$detail->price}} <br>
                  Cantidad: {{$detail->quantity}} <br>
                  Total: $ {{$detail->total}} <br>
                    
                </p>
                
              </div>
            </div>
            @endforeach

          <br><a href="/admin/orders" class="btn btn-info">VOLVER</a>

         </div>   
    </div>
</div>
<script>
  $('#file-upload').change(function() {
  var file = $('#file-upload')[0].files[0].name
  $('#label-upload').text(file);
});
</script>
<script src="/js/submit.js"></script>
@endsection