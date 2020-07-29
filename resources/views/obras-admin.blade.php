@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">


            @if($obras->count())

            <div class="card">

                <div class="card-header"><h4>Obras activas</h4></div>
                <div class="card-body">
                    
                    @foreach ($obras as $obra)
                <div class="card">
                    <div class="card-body">
                        <p>{{$obra->name ?? 'Sin nombre'}}</p>
                        <p>{{$obra->adress}}</p>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-confirmation" onClick="obraId({{$obra->id}})">
                        FINALIZAR OBRA
                        </button>
                    </div>
                </div>
                    @endforeach
            <hr>

                </div>
                
            </div>
            @else

            <div class="alert alert-danger" role="alert">
                  No se encuentran obras activas para este usuario.
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Confirmation -->
                  <div class="modal fade" id="modal-confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">¿Confirma que desea finalizar la obra?</h5>
                          <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <p>En caso de finalizar una obra ya no podrá realizar nuevos pedidos para la misma.</p>
                        </div>
                        <div class="modal-footer">
                          <a class="btn btn-secondary" data-dismiss="modal" style="color:#fff">CANCELAR</a>
                          <a href="" id="accept" class="btn btn-primary">ACEPTAR</a>
                        </div>
                      </div>
                    </div>
                  </div>

        <script type="application/javascript">
          var obraId = function(id){

            var acceptBtn = document.querySelector('#accept');

            acceptBtn.href = '/obras/admin/finish/'+id;

          }
        </script>
@endsection
