  @extends('pdf.base')

  @section('content')

 
  <main>
      
    @if ($ppl)
         
   

     
      
         @if (count($ppl)>0)
             
            <table>
                <tr>
                    <div style="width:100%;height:40px;"></div>
                </tr>
            </table>

            
          
                         
              <table class="table table-bordered " style="width:800px ;" >

                  <tbody >
                    @php
                        $max = count($ppl) / 3 ;
                    @endphp      
                      @for ($i = 0; $i < $max; $i++)
                            @php
                            
                            if (isset($ppl[$i*3+0])){ $p1 = $ppl[($i*3)+0];} else {$p1 = null;};
                            if (isset($ppl[$i*3+1])) {   $p2 = $ppl[($i*3)+1];} else {$p2 = null;};
                            if (isset($ppl[$i*3+2])) {   $p3 = $ppl[($i*3)+2];} else {$p3 = null;};
                           
                            @endphp
                          <tr>
                              @if ($p1)
                                  
                                    @include('pdf.sorteo.cupon',['p'=>$p1])
                              @endif
                              @if ($p2)
                                  
                                @include('pdf.sorteo.cupon',['p'=>$p2])
                              @endif
                              @if ($p3)
                                  
                                @include('pdf.sorteo.cupon',['p'=>$p3])
                              @endif
                          
                            
                          </tr>
                      @endfor
                  </tbody>
              </table>
              <hr>
        @endif
      

    @endif
  </main>
      
     
  @endsection