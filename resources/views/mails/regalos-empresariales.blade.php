@extends('mails.base')

@section('content')
    <h2>Mensaje desde: Regalos Empresariales</h2>
    <ul>
        <li>Nombre: {{$name}} </li>
       <li>Email: {{$email}}  </li>
       <li>Telefono: {{$phone}} </li>
       <li>Que productos quiere personalizar: {{$products}} </li>
       <li>Cantidad que necesita: {{$qty}} </li>
       <li>Fecha para cuando los necesita: {{$date}} </li>
     
    </ul>

  
@endsection