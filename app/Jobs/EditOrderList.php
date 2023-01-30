<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use App\Order;
use App\OrderItem;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Auth;
use View;
use PDF;
use Mail;
use App\Survey;
use App\Http\Controllers\MailController;
use App\OrderEdition;
use App\EditedOrderItem;
use App\TelegramNotificationLog;
use Throwable;

class EditOrderList implements ShouldQueue
{
    private $order;
    private $list;
    private $user;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order,$list, $user)
    {
        $this->order = $order;
        $this->list = $list;
        $this->user  = $user ;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = $this->order;
        //$list = json_decode($this->list);
        $list = $this->list;

        /* creo el resguardo de edicion */
        $edition = OrderEdition::create([
            'order_id' => $order->id,
            'user_id' => $this->user->id
        ]);

        /* $listOfIds = array_column($list, 'id');
        $products = Product::findMany($listOfIds);

        foreach($products as $p){
            foreach($list as $i){
                if ($i->id == $p->id)
                {
                    $p->units = $i->units;
                }
            }
        } */

        $edited_total = 0;

        foreach ($list as $item) {   
            //$price = $item->price;
            //$code = $item->mode->code;
            //! //////////////////////////////////////////////////
            $code = $item['product']['code'] ;
            $price = $item['product']['price'] ; 
            $product_id = $item['product']['id'];
            //! //////////////////////////////////////////////////
            
            if ($item['units'] > 0) {
                
                EditedOrderItem::create([
                    'order_id' => $order->id,
                    'product_id'=>$product_id,
                    'code'=>$code,
                    'name'=>$item['product']['name'],
                    'edition_id' => $edition->id,
                    'price' => $price,
                    'units'=>$item['units'],
                ]);
                
            }
            
            $edited_total += (($price*100)*$item['units']);
        }
        
        $order->edited_total = $edited_total;
        $order->last_edition_id = $edition->id;
        $order->save();
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
    */
    public function failed(Throwable $exception){
        $notification = 'Failed Job - EditOrderList';
        TelegramNotificationLog::telegramNotifySupers($notification);
    }
}
