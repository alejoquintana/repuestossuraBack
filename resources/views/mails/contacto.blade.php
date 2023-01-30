@extends('mails.base')

@section('content')
    <div>
        <h2>Mensaje desde: Contacto</h2>

        <ul>
            <li>Nombre: {{$data['name']}}  </li>
            <li>Email: {{$data['email']}}  </li>
            <li>Telefono: {{$data['phone']}}  </li>
            <li>Mensaje: {{$data['message']}}  </li>
        </ul>
    </div>
@endsection