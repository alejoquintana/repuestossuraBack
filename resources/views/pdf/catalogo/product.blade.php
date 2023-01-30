
<td style="width:47%; overflow:hidden; ">                        
    <div>
        <table>
            <tr>
                <td style="width:25%;max-width:25%;">
                    @if (isset($product->images[0]))
                        @php
                            $miniature = $product->images[0];
                        @endphp
                     
                        <img style="width:100%;" src="{{public_path().$miniature->url}}"> 
                    @endif
                    @if (!isset($product->images[0]))
                        <img style="width:100%;" src="{{public_path().'/storage/images/app/no-image.png'}}"> 
                    @endif
                </td>
                <td style="width:75%;max-width:75%;">
                    <h1 style='font-size: 1rem; font-weight:bold; display:inline; line-height:normal'>
                        {{$product->name}} .Cod {{$product->code}}  
                    </h1>
                </td>
            </tr>
           
        </table>
</td>
