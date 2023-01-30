  @extends('pdf.base')

  @section('content')

 
  <main>
      
     {{--   <div style="width:100% ; text-align : center;">
        <img src="{{$logo}}}" alt="">
        </div> --}}

      @foreach ($categories as $category)
       {{-- <div class="breakNow"></div> --}}
         
          <div style="text-align: center ; width :100vw ; margin-top:30px;"></div>
              <h2> {{strtoupper($category->name)}} </h2>
          </div>
          <hr>                 
          
              <table class="table table-bordered table-striped"  >
                  <thead>
                      <tr>
                          <td>Codigo</td>
                          <td>Producto</td>
                          <td>Precio</td>
                      </tr>
                    
                  </thead>
                  
                  <tbody>
                      
                      @foreach ($category->products as $key => $product)
                  
                        @if (!$product->paused)
                            <tr>
                                <td> {{$product->code}} </td>
                                <td> {{$product->name}} </td>
                                <td> ${{number_format($product->price,2)}} </td>
                            </tr>
                        @endif
                     @endforeach
                    </tbody>
                </table>
                <div class="breakNow"></div>
      @endforeach
  </main>
      
     
  @endsection