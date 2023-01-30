<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Category;

use Carbon\Carbon;
use App\TelegramNotificationLog;
use Throwable;

use PDF;
use View;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Cache;
use Dompdf\Options;

class GenerateCatalogo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $tries = 1;
    public $timeout = 3600;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
     
        if( Cache::has('catalogoRaw'))
        {
            $url=Cache::get('catalogoRaw');
            if(file_exists(public_path().$url)){
                unlink(public_path().$url);
            }
            Cache::forget('catalogoRaw');
        }
        
        
        Cache::rememberForever('catalogoRaw',function(){
            $date = str_slug(Carbon::now());
            return '/catalogoRaw'.$date.'.pdf' ;
        } );

        $date = str_slug(Carbon::now());
        $path= '/catalogoRaw'.$date.'.pdf' ;

        $categories = Category::get();

        $categories = Category::with('products.images')
                    ->with(['products' => function($q){
                        $q->where('paused',0);
                    }])
                    ->whereHas('products' , function($q){
                        $q->where('paused',0)->orderBy('name');
                    })
                    ->orderby('order')->orderBy('name')->get();
        
        /* foreach ($categories as  $c) {
            foreach ($c->products as $k=>$p) {
                if (!isset($p->images[0]))
                {
                    unset($c->products[$k]);
                    
                } else {
                    $img = $p->images[0];
                    Miniature::findOrCreate($img->id,150);
                }
            }
        }*/

        $logo = $this->imageEmbed(public_path('/storage/images/app/logo.jpg'));
        $today = Carbon::now()->format('d/m/Y');
        $html = View::make('pdf.catalogo.Catalogo',compact('categories','today','logo'))->render();

        PDF::loadHTML($html)->save(public_path().$path);    
    }
    
    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
    */
    public function failed(Throwable $exception){
        $notification = 'Failed Job - GenerateCatalogo';
        TelegramNotificationLog::telegramNotifySupers($notification);
    }
}
