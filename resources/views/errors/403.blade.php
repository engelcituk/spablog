@extends('layout')

@section('content')
<section class="pages container">
    <div class="page page-about">
        <h1 class="text-capitalize">Página no autorizada</h1>
            
            <span style="color:red">{{$exception->getMessage()}}</span>
            <p>Regresar <a href="{{url()->previous() }}">Volver</a></p>
    </div>
</section>

@endsection



