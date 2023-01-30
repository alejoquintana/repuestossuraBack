@extends('mails.base')

@section('content')
    <div>
        <h2>Mensaje desde: Franquicia</h2>

        <ul>
            <li>Nombre: {{$name}}  </li>
            <li>Email: {{$mail}}  </li>
            <li>Telefono: {{$phone}}  </li>
            <li>Horarios disponibles: {{$msg}}  </li>
        </ul>
    </div>
@endsection