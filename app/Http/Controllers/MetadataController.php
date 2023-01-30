<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Metadata;



class MetadataController extends Controller
{
    //

    public function update(Request $request)
    {
        $meta = Metadata::find($request->id);
       
        
        $field = $request->field;
        
        $meta->$field = $request->value;
        
        $meta->save();
        
        return;
        
    } 


    public function getAll(){
        $pages = [
                  'home',
                  'carrito',
                  'categorias',
                  'contacto',
                  'novedades',
                  'ofertas',
                  'cotizador',
                  'mi-cuenta',
                  'donde-estamos',
                  'terminos-y-condiciones'
                ];
        
        $res = [];

        foreach ($pages as $page)
        {
            $res[] = Metadata::findOrCreate($page);
        }

        return $res;
    }
}
