@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

          <div class="card">
            <div class="card-header">
              Usuario N°{{$user->id}}
            </div>
            <div class="card-body">
              <h5 class="card-title">Nombre: {{$user->name}}</h5>
              <p class="card-text">Email: {{$user->email}}</p>

              <form method="post" action="/admin/users/update/{{$user->id}}">
              @csrf
              <div class="form-group row">
                <label class="col-sm-1 col-form-label" for="company">Empresa</label>
                <div class="col-sm-11">
                  <input value="{{$user->company}}" type="text" name="company" class="form-control">
                </div>
              </div>
              
              <div class="form-group row">
                <label class="col-sm-1 col-form-label" for="cuit">CUIT</label>
                 <div class="col-sm-11">
                    <input value="{{$user->cuit}}" maxlength="11" type="text" name="cuit" class="form-control">
                  </div>
               </div>

                <div class="form-group row">
                  <label class="col-sm-1 col-form-label" for="phone">Phone</label>
                  <div class="col-sm-11">
                    <input value="{{$user->phone}}" type="text" name="phone" class="form-control"><br>
                  </div>
                </div>

                <input type="submit" class="btn btn-info" value="ACTUALIZAR">

              </form>

              <hr>

              @if($user->active == 1)
              <a class="btn btn-info" href="/admin/users/access/{{$user->id}}">DESACTIVAR</a>
              @else
              <a class="btn btn-info" href="/admin/users/access/{{$user->id}}">ACTIVAR</a>
              @endif
              <hr>
          
                  <form method="post" action="/admin/users/addcc/{{$user->id}}">
                    
                    @csrf

                    <label for="cc">Ingrese los mails que recibirán una copia de las notificaciones</label>

                    <input value="{{$user->cc_emails}}" type="text" name="cc" required class="form-control" placeholder="ejemplo@ejemplo.com;ejemplo2@ejemplo2.com;etc..">
                    <small>Los mails deben estar separados por ";" y sin espacios</small><br><br>
                    
                    <input type="submit" class="btn btn-info" value="GUARDAR">
                    
                  </form>
              
              <hr>

              @if($logged_user->master)
              <p class="card-text">Administrador: 
               @if($user->admin)
                Si
                @else
                No
                @endif
              </p>
              <form method="post" action="/admin/users/makeadmin/{{$user->id}}">
                @csrf
                <select name="access" class="custom-select">
                  <option selected>Seleccionar nivel de acceso</option>
                  <option value="0">Externo</option>
                  <option value="1">Administrador</option>
                </select><br><br>
                <input type="submit" class="btn btn-info" value="ACTUALIZAR">
                @if(session('error'))
                <div class="alert alert-danger" role="alert">
                {{session('error')}}
                </div>
                @endif
              </form>
                
                <hr>

              @else
              <p class="card-text">Administrador: 
                
                @if($user->admin)
                Si
                @else
                No
                @endif

                </p>
         
              @endif
              <form method="post" action="/admin/users/discount/{{$user->id}}">
                @csrf
                <label for="discount">Descuento usuario: </label>
                <input required class="form-control" type="number" name="discount" placeholder="{{$user->discount}}%"><br>
                <input type="submit" name="submit" class="btn btn-info" value="APLICAR"><br>
                <small>Solo se aplica en el caso de que el usuario no se encuentre asignado a un grupo de descuento determinado</small>

              </form>

              <hr>

              <p class="card-text">Grupo de descuento: 
                
                {{$user->discount_group->name ?? 'Sin asignar'}}
               
                </p>

              <form method="post" action="/admin/discount-group/users/{{$user->id}}">
                @csrf
                <select name="group" class="custom-select">
                <option selected>Seleccionar grupo de descuento</option>
                @if($groups->count())
                @foreach($groups as $group)
                <option value="{{$group->id}}">{{$group->name}}</option>
                @endforeach
                @endif
              </select><br><br>
                <input type="submit" name="submit" class="btn btn-info" value="APLICAR"><br>

              </form>
              
              <hr>

              <p class="card-text">Subrubros de producto</p>
              <small>Por defecto, el usuario puede visualizar todos los subrubros. Seleccione aquellos que el usuario <strong>NO</strong> debe visualizar.</small>
              <form action="/admin/user-subcategory/save/{{$user->id}}" method="post">
                @csrf
                @if($subcategories->count())
                <div class="form-check">
                @foreach($subcategories as $subcategory)
                  <input class="form-check-input" type="checkbox" name="sub_{{$subcategory->id}}" id="sub_{{$subcategory->id}}" value="{{$subcategory->id}}">
                    <label class="form-check-label" for="sub_{{$subcategory->id}}">{{$subcategory->name}}</label><br>
                @endforeach
                </div><br>
                @endif
              <input type="submit" name="submit" class="btn btn-info" value="ACTUALIZAR"><br>
              </form>
            </div>
          </div>

        </div>
    </div>
</div>

<script type="application/javascript">
  var checked = @json($user->subcategory);
  var checkInputs = function(){
    checked.forEach(function(input){
      var tmp = document.querySelector('#sub_'+input.subcategory_id);
      tmp.setAttribute('checked', 'true');
    });
  }
  checkInputs();
</script>
@endsection