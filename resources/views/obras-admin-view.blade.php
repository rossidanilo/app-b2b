@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">


            @if($obra->count())

            <div class="card">

                <div class="card-header">
                    
                    <h4>Obra N° {{$obra->id}}</h4>

                </div>

                    <div class="card-body">
                        <p>Dirección: {{$obra->adress}}</p>
                        <p>Estado: 
                            @if($obra->approved == 0)
                            <button class="btn btn-danger">
                            PENDIENTE
                            </button>
                            @else
                            <button class="btn btn-success">
                            APROBADA
                            </button>
                            @endif        
                        </p>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-confirmation">
                        FINALIZAR OBRA
                        </button>
                    </div>
                </div>
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
                          <a class="btn btn-secondary" data-dismiss="modal">CANCELAR</a>
                          <a href="/obras/admin/finish/{{$obra->id}}" class="btn btn-primary">ACEPTAR</a>
                        </div>
                      </div>
                    </div>
                  </div> 
@endsection