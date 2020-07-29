@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="row text-center">
            <div class="col">
              <a href="/admin/obras/active" class="btn btn-info">VER OBRAS ACTIVAS</a>
            </div>
            <div class="col">
              <a href="/admin/obras" class="btn btn-info">VER OBRAS PENDIENTES</a>
            </div>
            <div class="col">
              <a href="/admin/obras/finished" class="btn btn-info">VER OBRAS FINALIZADAS</a>
            </div>          
          </div>
           <div class="col-12 mt-3 p-0">
            <form method="GET" class="mr-auto ml-auto" action="/admin/obras/finished/search">
               <div class="input-group">
                  <input type="text" name="search" class="form-control" placeholder="Busque producto, código y/o marca">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-primary" id="basic-addon2" style="margin-top: 0"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              <br>
            </form>
          </div>
          <div id="accordion">
            <div class="card">
              <div class="card-header text-center" id="headingOne">
                <h5 class="mb-0">
                 <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  {{$title ?? ''}}
                 </button>
                </h5>
              </div>

              <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
               @if($obras->count())

                  @foreach($obras as $obra)

                    <div class="card">
                        <div class="card-header row">
                          <div class="col">
                            {{$obra->name ?? 'Sin nombre'}}
                          </div>
                        <!-- <div class="col text-right">
                          <a href="/admin/obras/edit/{{$obra->id}}" class="mr-3">
                            <i class="fa fa-edit"></i>
                          </a>
                          <a href="/obras/admin/finish/{{$obra->id}}">
                            <i class="fa fa-trash-alt"></i>
                          </a>
                        </div> -->
                        </div>
                      <div class="card-body">
                        <p>
                          Empresa: {{$obra->user->company ?? ''}} <br>
                          Dirección: {{$obra->adress}}
                        </p>
                        @if($obra->approved === 0)
                        <a class="btn btn-success" href="/admin/obras/approve/{{$obra->id}}">APROBAR</a>
                        <a class="btn btn-danger" href="/admin/obras/reject/{{$obra->id}}">RECHAZAR</a>
                        @endif
                      </div>
                    </div>

                  @endforeach

                @else

                    <div class="alert alert-success" role="alert">
                      No se encontraron resultados
                    </div>

                @endif
            </div>
          </div>            
         </div>   
    </div>
</div>
@endsection