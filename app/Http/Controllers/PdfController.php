<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Category;
use PDF;
use Carbon\Carbon;
use App\Jobs\GeneratePricesList;
use App\Jobs\GenerateSorteoCupons;
use App\Jobs\GenerateCatalogo;
use Queue;
use Illuminate\Support\Facades\Cache;

class PdfController extends Controller
{

    public function getPricesList(){
        
        if (Cache::has('prices_url')) {
            $url = Cache::get('prices_url');
            $file = public_path() . $url;
            $headers = [
                'Content-Type' => 'application/pdf',
            ];
    
            return response()->download($file, 'lista.pdf', $headers);
        }else{
            return "no file";
        }
    }

    public function getCatalogo() {
        if (Cache::has('catalogoUser')) {
            $url = Cache::get('catalogoUser');
            $file = public_path() . $url;
            $headers = [
                'Content-Type' => 'application/pdf',
            ];
            return response()->download($file, 'catalogo.pdf', $headers);
        }else {
            return "no file";
        }
    }

    

    public function dispatchCatalogoJob() {
        Queue::push(new GenerateCatalogo());
        return;
    }
    
    public function processingJob(){
        return DB::table('jobs')->count();
    }

    public function dispatchPricesListJob()
    {
      
        $date = str_slug(Carbon::now());
        $newPath = '/precios-'.$date.'.pdf';
        if(Cache::has('prices_url'))
        {
            if(file_exists(public_path().Cache::get('prices_url'))){
                unlink(public_path().Cache::get('prices_url'));
            }
            Cache::forget('prices_url');
        }
        Cache::forever('prices_url',$newPath); 
       
        Queue::push(new GeneratePricesList($newPath));

        return ;
    }

    public function dispatchSorteoCuponsJob()
    {
      
        $date = str_slug(Carbon::now());
        $newPath = '/sorteo-'.$date.'.pdf';
        if(Cache::has('sorteo_url'))
        {
            if(file_exists(public_path().Cache::get('sorteo_url'))){
                unlink(public_path().Cache::get('sorteo_url'));
            }
            Cache::forget('sorteo_url');
        }
        Cache::forever('sorteo_url',$newPath); 
       
        Queue::push(new GenerateSorteoCupons($newPath));

        return ;
    }


    public function imageEmbed($image)
    {
       

        // Read image path, convert to base64 encoding
        $imageData = base64_encode(file_get_contents($image));

        // Format the image SRC:  data:{mime};base64,{data};
        $src = 'data:'.mime_content_type($image).';base64,'.$imageData;

        // Echo out a sample image
       return $src;
    }


    public function downloadPricesList()
    {
        
        if (Cache::has('prices_url'))
        {
   
        
            return redirect(Cache::get('prices_url'));
        }
    }

    public function downloadSorteoCupons()
    {
        
        if (Cache::has('sorteo_url'))
        {
   
        
            return redirect(Cache::get('sorteo_url'));
        }
    }


      public function redirectCatalogoRaw()
    {
        $fileuri = Cache::get('catalogoRaw');
        
        if ($fileuri)
        {
            return redirect($fileuri);
        }
        
    }

       public function redirectCatalogo()
    {
        if (Cache::has('catalogoUser'))
        {
            //return Cache::get('catalogoUser');
            return redirect(Cache::get('catalogoUser'));
        }
    }
       public function redirectCatalogoSinPrecios()
    {
        if (Cache::has('catalogoSinPrecios'))
        {
            //return Cache::get('catalogoUser');
            return redirect(Cache::get('catalogoSinPrecios'));
        }
    }


       public function replaceCatalogo(Request $request)
    {
/* 
        $catalogo = $request->file('file');
        $filename = $catalogo->getClientOriginalName();
        
        */
        
        $catalogo = $request->file('pdf');

      

            if (Cache::has('catalogoUser'))
            {
                $curl = Cache::get('catalogoUser');
                if( file_exists(public_path().$curl))
                {
                    unlink(public_path().$curl);
                }
    
                Cache::forget('catalogoUser');
            }
    
            
            $date = str_slug(Carbon::now());
            $curl = '/catalogo'.$date.'.pdf';
            //$tmp = $catalogo->getRealPath();
            //$path = public_path().$fileuri->url;
            $request->file('pdf')->move(public_path(), $curl);
            Cache::rememberForever('catalogoUser',function(){
                $date = str_slug(Carbon::now());
                $curl = '/catalogo'.$date.'.pdf';
                return $curl ;
            });
    
            return $curl;
        

    }
       public function replaceCatalogoSinPrecios(Request $request)
    {
/* 
        $catalogo = $request->file('file');
        $filename = $catalogo->getClientOriginalName();
        
        */
        
        $catalogo = $request->file('pdf');

        if (Cache::has('catalogoSinPrecios'))
        {
            $curl = Cache::get('catalogoSinPrecios');
            if( file_exists(public_path().$curl))
            {
                unlink(public_path().$curl);
            }

            Cache::forget('catalogoSinPrecios');
        }

        
        $date = str_slug(Carbon::now());
        $curl = '/catalogoSP'.$date.'.pdf';
        //$tmp = $catalogo->getRealPath();
        //$path = public_path().$fileuri->url;
        $request->file('pdf')->move(public_path(), $curl);
        Cache::rememberForever('catalogoSinPrecios',function(){
            $date = str_slug(Carbon::now());
            $curl = '/catalogoSP'.$date.'.pdf';
            return $curl ;
        });

        return $curl;

    }
    




}
