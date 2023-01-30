@extends('mails.base')

@section('content')
    <div>
        <p>
          Suspensión Lujan RECIBIO UN PEDIDO NUEVO
        </p>
      
        <p> 
            Si querés descargar una copia del presupuesto podes hacerlo en el siguiente enlace: 
        </p>
        <p>
            <a href="https://back.suspensionlujan.com/pdf/{{$order->id}}"> <span> --> Descargar presupuesto en PDF <-- </span>  </a>
        </p>

        <p>IMPORTANTE: Este es un mail generado automaticamente, NO RESPONDER.</p>
      
       
    </div>
@endsection