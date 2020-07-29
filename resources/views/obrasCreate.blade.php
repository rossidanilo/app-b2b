@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">CREAR NUEVA OBRA</div>

                <div class="card-body">
                    
                    <form method="POST" action="/obras/create/new" class="prevent-double-submit">
                        @csrf

                        @if($message = Session::get('error'))
                            <div class="alert alert-danger text-center" role="alert">
                            {{$message}}
                            </div>
                            @endif

                        <label for="name">Ingrese el nombre de la obra</label><br>

                        <input required id="name" class="form-control" name="name" type="text" style="width:100%" placeholder="Obra de Cabildo"><br>

                        <label for="adress">Ingrese la dirección de la obra</label><br>

                        <input required id="adress" class="form-control" name="adress" type="text" style="width:100%" placeholder="Evergreen Av. 123"><br>

                        <label>Seleccione día(s) y franja horaria para la entrega</label><br>
                        
                        <div class="row text-center">

                            <div class="col-2">
                                <input type="checkbox" name="days[]" value="Lunes" id="lunes">
                                <br>
                                <label for="lunes">L</label>
                            </div>

                            <div class="col-2">
                                <input type="checkbox" name="days[]" value="Martes" id="martes">
                                <br>
                                <label for="martes">M</label>
                            </div>

                            <div class="col-2">
                                <input type="checkbox" name="days[]" value="Miercoles" id="miercoles">
                                <br>
                                <label for="miercoles">X</label>
                            </div>

                            <div class="col-2">
                                <input type="checkbox" name="days[]" value="Jueves" id="jueves">
                                <br>
                                <label for="jueves">J</label>
                            </div>

                            <div class="col-2">
                                <input type="checkbox" name="days[]" value="Viernes" id="viernes">
                                <br>
                                <label for="viernes">V</label>
                            </div>

                            <div class="col-2">
                                <input type="checkbox" name="days[]" value="Sabado" id="sabado">
                                <br>
                                <label for="sabado">S</label>
                            </div>
                            
                            <div class="col">
                                <select required name="hour_since" class="custom-select">
                                  <option value="">Hora</option>
                                  @for($i = 8; $i < 18; $i++)
                                    <option value="{{$i}}">{{$i}}:00</option>
                                  @endfor
                                </select><br><br>
                            </div>

                            <div class="col">
                                
                                <select required name="hour_until" class="custom-select">
                                  <option value="">Hora</option>
                                   @for($i = 9; $i < 19; $i++)
                                    <option value="{{$i}}">{{$i}}:00</option>
                                  @endfor
                                </select> <br><br>
                            </div>

                        </div>

                        <label for="responsible">Ingrese los responsables de recibir el pedido</label><br>

                        <div class="row">
                            <div class="col">
                                <input required id="responsible" class="form-control" name="responsible" type="text" placeholder="Nombre"><br>
                            </div>
                            <div class="col">
                                <input required class="form-control" type="number" name="dni" placeholder="DNI/CUIT">
                            </div>

                            <div class="col">
                                 <input required class="form-control" type="number" name="phone" placeholder="Teléfono">
                            </div>
                                
                        </div>


                        <div class="row">
                            <div class="col">
                                <input id="responsible_2" class="form-control" name="responsible_2" type="text" placeholder="Nombre (opcional)">   
                            </div>
                            <div class="col">
                                <input class="form-control" type="number" name="dni_2" placeholder="DNI/CUIT">
                            </div>

                            <div class="col">
                                 <input class="form-control" type="number" name="phone_2" placeholder="Teléfono"><br>
                            </div>
                                
                        </div>
                
                                
                        <div class="row">
                            <div class="col">
                                <input id="responsible_3" class="form-control" name="responsible_3" type="text" placeholder="Nombre (opcional)">
                            </div>
                            <div class="col">
                                <input class="form-control" type="number" name="dni_3" placeholder="DNI/CUIT">
                            </div>

                            <div class="col">
                                 <input class="form-control" type="number" name="phone_3" placeholder="Teléfono"><br>
                            </div>
                                
                        </div>                        
                        
                        <div>
                            
                            <button type="submit" class="btn btn-info prevent-button"><i class="spinner fa fa-spinner fa-spin" hidden></i>GUARDAR</button>

                        </div>    

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/submit.js"></script>
@endsection