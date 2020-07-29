@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card">
                <div class="card-header">
                Importador de imágenes
                </div>
                <div class="card-body">
                     @if($message = Session::get('success'))
                    <div class="alert alert-success" role="alert">
                    <strong>{{$message}}</strong>
                    </div>
                    @endif
                    <form action="/admin/images/upload" enctype="multipart/form-data" method="post">
                        @csrf
                        <p class="card-text">La estructura del archivo debe ser: código de producto, link de la imagen.</p>
                        <div class="custom-file">
                            <input id="file-upload" required type="file" class="custom-file-input" name="import_file">
                            <label class="custom-file-label" for="import_file" id="label-upload"></label>
                        </div><br><br>
                        <input class="btn btn-info" type="submit" value="SUBIR IMÁGENES">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
<script>
    $('#file-upload').change(function() {
  var file = $('#file-upload')[0].files[0].name
  $('#label-upload').text(file);
});
</script>
@endsection