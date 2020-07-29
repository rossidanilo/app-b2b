@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">

            
                <div class="col-md-6 p-3" style="color: #fff">
                  Hola {{Auth::user()->name}} <br> {{Auth::user()->email}}   
                </div>

            <br>

            @if($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                 <strong>{{$message}}</strong>
            </div>
            @endif
           
            @if($obras->count())
            
            <div style="color: #fff;">
                <p>Seleccione la obra para la cual desea realizar el pedido.</p>
                <!-- <small>Seleccione TODAS para realizar un pedido de todas sus obras activas.</small> -->
            </div>
            <hr>

            <form action="/obras" id="obras-form" method="post">
                @csrf
            @foreach ($obras as $obra)
                <div class="card">
                    <div class="card-body">
                        <div class="custom-control custom-radio">
                        <input value="{{$obra->id}}" type="radio" id="radio{{$obra->id}}" name="obraRadio" class="custom-control-input" onclick="document.getElementById('obras-form').submit();">
                        <label class="custom-control-label text-left" for="radio{{$obra->id}}">{{$obra->name}}</label>
                        </div>
                    </div>
                </div>
            <hr>
            @endforeach
            <!-- <div class="card">
                    <div class="card-body" style="padding-top: 32px; padding-bottom: 32px">
                        <div class="custom-control custom-radio">
                        <input value="0" type="radio" id="radio0" name="obraRadio" class="custom-control-input" onclick="$('#obras-form').submit();">
                        <label class="custom-control-label" for="radio0">TODAS
                        </label>
                        </div>
                    </div>
                </div>  -->
            <!-- <input type="submit" class="btn btn-primary" value="CONTINUAR" name="continuar"> -->
            </form>

            @else
            
            <div class="alert alert-primary" role="alert">
                 No se registran obras activas, haga click en el botón NUEVA OBRA para crear una nueva obra.

            </div>
            @endif
            
            <hr>
             <div class="row">
                <div class="text-center mx-auto">
                    <a class="btn btn-primary" href="/obras/admin">ADMINISTRAR OBRAS</a>
                    <a class="btn btn-primary" href="/obras/create">NUEVA OBRA</a>
                </div>
            </div>
            <hr>    

            @if($obras_pending->count())

            <div class="card">

                <div class="card-header"><h4>Obras pendientes de aprobación</h4></div>
                <div class="card-body">
                    <p class="card-text">Debe aguardar la aprobación por parte de H30 para que la obra se encuentre activa y pueda realizar pedidos.</p>
                    
                    @foreach ($obras_pending as $obra_pending)
                <div class="card">
                    <div class="card-body">
                        <p class="align-middle">{{$obra_pending->adress}}</p>
                    </div>
                </div>
                    @endforeach

                </div>
                
            </div>
            @endif

        </div>
    </div>
</div>

@endsection
