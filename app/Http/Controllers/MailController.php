<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Cotizacion;
use App\Mail\RegalosEmpresariales;
use App\Mail\Franquicia;
use App\Mail\Contacto;
use Carbon\Carbon;
class MailController extends Controller
{

       public function imageEmbed($image)
    {
       

        // Read image path, convert to base64 encoding
        $imageData = base64_encode(file_get_contents($image));

        // Format the image SRC:  data:{mime};base64,{data};
        $src = 'data:'.mime_content_type($image).';base64,'.$imageData;

        // Echo out a sample image
       return $src;
    }



    public function regalosEmpresariales(Request $request)
    {
        
        //$image = $request->file('image');
        //$image = $this->imageEmbed($image->path());
        
        $mail = new RegalosEmpresariales(
            $request->phone,
            $request->email,
            $request->products,
            $request->name,
            $request->qty,
            Carbon::parse($request->date)->format('d/m/Y')
        );

        MailController::mailAdmin($mail);

      
        

    }

    public function franquicia(Request $request)
    {
        $mail = new Franquicia(
            $request->name,
            $request->mail,
            $request->phone,
            $request->msg
        );

        MailController::mailAdmin($mail);
        //return redirect('/');
    }

    public function contacto(Request $request)
    {
        $mail = new Contacto(
            $request->all()
               );

        MailController::mailAdmin($mail);
       // return redirect('/');
    }

     private static function mailAdmin($email){
        Mail::to('eri_k45@hotmail.com')
        ->send($email);
    }


    public static function mailOrderToClient($order)
    {
      /*   Mail::to('rsbertoa90@gmail.com')
            ->subject('Nuevo pedido en Suspensión Lujan')
            ->send(new Cotizacion($order)); */
            
        /* Mail::to('eri_k45@hotmail.com')
            ->bcc('rsbertoa90@gmail.com')
            ->subject('Nuevo pedido en Suspensión Lujan')
            ->send(new Cotizacion($order));
         */    
    }

    public static function mailOrderNotification($order)
    {
        Mail::to('eri_k45@hotmail.com')
            ->send(new Cotizacion($order));
            
        /* Mail::to('eri_k45@hotmail.com')
            ->bcc('rsbertoa90@gmail.com')
            ->bcc('rsbertoa90@gmail.com')
            ->subject('Nuevo pedido en Suspensión Lujan')
            ->send(new Cotizacion($order));
         */    
    }
}
