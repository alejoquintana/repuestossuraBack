@extends('pdf.base')

@section('content')

<main>
      
	@if ($categories)
      @foreach ($categories as $category)
         @if (count($category->products)>0)
            <table>
					<tr>
						<div style="width:100%;height:40px;"></div>
					</tr>
            </table>

				<div style="text-align: center ; font-size : 28px; text-decoration:underline;">
					<h4> {{strtoupper($category->name)}} </h4>
				</div>
                         
            <table>
					<tr>
						<div style="width:100%;height:40px;"></div>
					</tr>
            </table>
				<table class="table table-bordered" style="width:100%;" >
					<tbody >
						@php
							$max = count($category->products) / 2 ;
						@endphp      
						@for ($i = 0; $i < $max; $i++)
							@php
								$products = $category->products;
								if (isset($products[$i*2])){ $product1 = $category->products[($i*2)];} else {$product1 = null;};
								if (isset($products[$i*2+1])){ $product2 = $category->products[($i*2)+1];} else {$product2 = null;};
							
							@endphp
							<tr>
								@if ($product1)
				
									@include('pdf.catalogo.product',['product'=>$product1])
								    
                                @endif
                                @if ($product2)
								   
									@include('pdf.catalogo.product',['product'=>$product2])
								    
								@endif
							</tr>
						@endfor
					</tbody>
				</table>
			<hr>
		@endif
		@endforeach
	@endif
</main>
      
     
@endsection