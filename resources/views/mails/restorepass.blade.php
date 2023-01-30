@extends('mails.base')


@section('content')
    Hola {{$name}}
   Para poder elegir una nueva contraseña hace click 
   <a class="text-blue" href="https://suspensionlujan.com/nueva-contraseña/{{$token}}" target="_blank">
       en este enlace.
    </a>


    <a class="text-blue" href="https://suspensionlujan.com/nueva-contraseña/{{$token}}" target="_blank">
       CAMBIAR CONTRASEÑA
    </a>

    

@endsection