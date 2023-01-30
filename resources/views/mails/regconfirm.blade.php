@extends('mails.base')

@php
    $url = "https://suspensionlujan.com/registro-exitoso/".$token ;
@endphp

@section('content')
    Hola {{$name}}
    Gracias por registrate en Suspensión Lujan 

    Hace click  <a href="{{url($url)}}" style="font-weight:bold ; color:blue;">En este enlace</a> para completar  tu registro
    <br>
    <br>

    <span class="text-blue">
        {{$url}}
    </span>

@endsection