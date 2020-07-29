@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

        	<div class="bg-light p-4">
          
          <form method="post" action="/admin/discount-group/update/{{$group->id}}">
           @csrf 

           <h3>Grupo de descuento {{$group->id}}</h3>

             <div class="form-group">
                <label for="name">Nombre del grupo de descuento</label>
                <input required type="text" class="form-control" name="name"value="{{$group->name}}">
              </div>
              <div class="form-group">
                <label for="discount">Descuento</label>
                <input required type="number" class="form-control" name="discount" value="{{$group->discount}}">
              </div>

              <input type="submit" class="btn btn-info" value="GUARDAR">

          </form>

        </div>

        <div class="bg-light p-4">

        	<div id="accordion">
			  <div class="card">
			    <div class="card-header" id="headingOne">
			      <h5 class="mb-0">
			        <button class="btn btn-link" data-toggle="collapse" data-target="#categories" aria-expanded="true" aria-controls="categories">
			          Rubros
			        </button>
			      </h5>
			    </div>

			    <div id="categories" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
			      <div class="card-body">

			      	<form method="post" action="/admin/discount-group/category/update/{{$group->id}}">
			      		@csrf
			      		<div class="table-responsive">

			                <table class="table table-striped">

			                  <thead>
			                    <tr>
			                      <th scope="col">Rubro</th>
			                      <th scope="col">Descuento</th>
			                    </tr>
			                  </thead>

			                  <tbody>
							
								@foreach($categories as $category)
			                  	<tr>

			                  		
                      				<td>{{$category->name}}</td>
                      				<td>
                      					<input class="form-control" name="{{$category->id}}" type="number" value="{{$category->discount ?? '0'}}">
                      				</td>
                      			</tr>	
								
								@endforeach
			                  </tbody>

			                 </table>

			            </div>

			            <input type="submit" class="btn btn-info" value="GUARDAR">

			            <a style="color: #fff" class="btn btn-primary" data-toggle="modal" data-target="#resetCategoryModal">
						  ELIMINAR DESCUENTOS
						</a>
			      	</form>
			       
			      </div>
			    </div>
			  </div>
			  <div class="card">
			    <div class="card-header" id="headingTwo">
			      <h5 class="mb-0">
			        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#subcategories" aria-expanded="false" aria-controls="subcategories">
			          Subrubros
			        </button>
			      </h5>
			    </div>
			    <div id="subcategories" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
			      <div class="card-body">

			      	<form method="post" action="/admin/discount-group/subcategory/update/{{$group->id}}">
			      		@csrf
			      		<div class="table-responsive">

			                <table class="table table-striped">

			                  <thead>
			                    <tr>
			                      <th scope="col">Subrubro</th>
			                      <th scope="col">Descuento</th>
			                    </tr>
			                  </thead>

			                  <tbody>
							
								@foreach($subcategories as $subcategory)
			                  	<tr>

			                  		
                      				<td>{{$subcategory->name}}</td>
                      				<td>
                      					<input class="form-control" name="{{$subcategory->id}}" type="number" value="{{$subcategory->discount ?? '0'}}">
                      				</td>
                      			</tr>	
								
								@endforeach
			                  </tbody>

			                 </table>

			            </div>

			            <input type="submit" class="btn btn-info" value="GUARDAR">

			      	</form>
			        
			      </div>
			    </div>
			  </div>
			  <div class="card">
			    <div class="card-header" id="headingThree">
			      <h5 class="mb-0">
			        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#marcas" aria-expanded="false" aria-controls="marcas">
			          Marcas
			        </button>
			      </h5>
			    </div>
			    <div id="marcas" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
			      <div class="card-body">

			      	<form method="post" action="/admin/discount-group/brand/update/{{$group->id}}">
			      		@csrf
			      		<div class="table-responsive">

			                <table class="table table-striped">

			                  <thead>
			                    <tr>
			                      <th scope="col">Marca</th>
			                      <th scope="col">Descuento</th>
			                    </tr>
			                  </thead>

			                  <tbody>
							
								@foreach($brands as $brand)
			                  	<tr>

			                  		
                      				<td>{{$brand->name}}</td>
                      				<td>
                      					<input class="form-control" name="{{$brand->id}}" type="number" value="{{$brand->discount ?? '0'}}">
                      				</td>
                      			</tr>	
								
								@endforeach
			                  </tbody>

			                 </table>

			            </div>

			            <input type="submit" class="btn btn-info" value="GUARDAR">

			             <a style="color:#fff" class="btn btn-primary" data-toggle="modal" data-target="#resetBrandModal">
						  ELIMINAR DESCUENTOS
						</a>

			      	</form>
			        
			      </div>
			    </div>
			  </div>
			</div>
        	
        </div>
         
        </div>
    </div>
</div>

<!-- Reset category Modal -->

<div class="modal fade" id="resetCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Atención!</h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        En caso de eliminar los descuentos de las categorías, se eliminarán también los descuentos configurados en las subcategorías correspondientes.
              </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
        <a href="/admin/discount-group/category/reset/{{$group->id}}" class="btn btn-primary">ACEPTAR</a>
      </div>
    </div>
  </div>
</div>

<!-- Reset brand Modal -->

<div class="modal fade" id="resetBrandModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Atención!</h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      Está a punto de eliminar todos los descuentos configurados a nivel marca para este grupo de descuentos.
              </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
        <a href="/admin/discount-group/brand/reset/{{$group->id}}" class="btn btn-primary">ACEPTAR</a>
      </div>
    </div>
  </div>
</div>
@endsection