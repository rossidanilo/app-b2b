@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <a class="btn btn-primary" href="/admin/push">CREAR PUSH NOTIFICATION</a>

            <hr>

           <div class="table-responsive">

                <table class="table table-striped">
                    
                    <thead>
                        <tr>                          
                          <th scope="col">Titulo</th>
                          <th scope="col">Texto</th>
                          <th scope="col">Receptores</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(count($notifications))
                        @foreach($notifications['notifications'] as $notification)
                        <tr>
                            <td>{{$notification['headings']['en']}}</td>
                            <td>{{$notification['contents']['en']}}</td>
                            <td>{{$notification['successful']}}</td>
                        </tr>
                        @endforeach
                        @endif
                        </tbody>   
                </table>
               
           </div>

        </div>
    </div>
</div>
@endsection