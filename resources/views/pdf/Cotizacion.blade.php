
    @extends('pdf.base')    
    
    @section('content')

    <main>
         <div style="margin-top:20px">
            <span style="font-size:14px; color:blue">#{{$order->id}}</span> <br>
            @if ($order->client)
                Nombre: {{$order->client}}
            @else    
                <span> <b>Nro cliente:</b>{{$order->user->id}}/ <b>Nombre:</b> {{$order->user->name}}  </span>
            @endif
            @if ($order->discount)
                <span><b>Descuento aplicado:</b> {{$order->discount}}%</span>
            @endif
            <span>
                // <b>Telefono:</b> {{$order->phone_code}}-{{$order->phone}}
            </span>
            @if ($order->dni)
                <span>
                    // <b>DNI:</b> {{$order->dni}}
                </span>
            @endif
        </div>

        @php
            $total = 0;
        @endphp
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td>Codigo</td>
                    <td>Producto</td>
                    <td>Precio</td>
                    <td>Cantidad</td>
                    <td>Subtotal</td>
                </tr>
            </thead>
            <tbody>
                @foreach($order_items as $op)
                @php
                    $price = $op->price - ( $op->price * ( $order->discount/100 ) ) ;
                @endphp
                <tr>
                    <td> {{$op->code}} </td>
                    <td> {{$op->name}}  </td>
                    <td> ${{$price}}</td>
                    <td> {{$op->units}} </td>
                    <td> ${{$op->units * $price}} </td>
                    @php
                        $total += ($op->units * $price);
                    @endphp
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="color : blue">TOTAL</td>
                    <td style="color : blue"> ${{$total}} </td>
                </tr>
            </tfoot>
        </table>
        <hr>
        <div colspan="5" style="color:red; text-align:center; ">
            <h3 style="color:red">
                PRESUPUESTO NO DEFINITIVO
            </h3> 
            
            <p class="margin-top:30px;">
                Aguarda la confirmacion de stock y el presupuesto final del area de venta
            </p>
        </div>
        <hr>
        <div>
            <table class="table table-bordered">
                <tr>
                    <td>
                          <ul>
                            @if ($order->client)
                                <li>Nombre: {{$order->client}} </li>
                            @else
                                <li>Nro cliente:{{$order->user->id}}</li>
                                <li>Nombre: {{$order->user->name}} </li>
                            @endif
                            @if ($order->dni)
                                <li>
                                    DNI: {{$order->dni}}
                                </li>
                            @endif
                            <li>Telefono:{{$order->phone_code}}-{{$order->phone}} </li>
                            <li>Email: {{$order->user->email}} </li>
                            <li>Mensaje: {{$order->message}} </li>
                        </ul>
                    </td>
                    @if ($order->shipping)
                        <td>
                            <ul>
                                @if ($order->City)    
                                        <li> Provincia: {{$order->City->state->name}} </li> 
                                        <li> Ciudad: {{$order->City->name}} </li> 
                                @endif
                                    <li> CP: {{$order->cp}} </li> 
                                    <li> direccion: {{$order->address}} </li> 
                                    <li> transporte: {{$order->transport}} </li> 
                            </ul>     
                        </td>    
                    @endif
                  {{--   @else
                        <td>
                            <span style="color:blue">RETIRA EN SHOWROOM</span>
                        </td>    
                    @endif --}}
                </tr>
            </table>
          
           
        </div>
        
    </main>
    @endsection

    </body>
    </html>


   