<?php
namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Order;
use App\Product;
use App\OrderItem;
use App\TelegramNotificationLog;
use Throwable;

class SaveNewOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $data;
    private $list;
   
    private $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$list,$user)
    {
        $this->data = $data;
        $this->list = $list;
       
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {        
        $data = $this->data;
        $list = $this->list;
        $user = $this->user;

        $ufo = 0;
        $orders = $user->orders;

        if (!$orders || !$orders->count()) {
            $ufo = 1;
        }
        

        $order = Order::create([
            'user_id' => $user->id,
            'discount'=>$user->discount,
            //'phone' => $data['phone'],
            'total' => $data['total'],
            'message' => $data['message'],
            'city_id' => $data['city_id'],
            'retiro_id' => 1,
            'address' => $data['address'],
        /*     'transport' => $data['transport'], */
            'cp' => $data['cp'],
            'status'=>'nuevo',
            'user_first_order'=>$ufo
        ]);

        if(array_key_exists('client',$data) ){
            $order->client = $data['client'];
            $order->save();
        }
        
            /* Creo items con los productos */
        
        $listOfIds = array_column($list, 'id');
        $products = Product::findMany($listOfIds);

        foreach($products as $p){
            foreach($list as $i){
                if ($i['id'] == $p->id)
                {
                    $p->units = $i['units'];
                }
            }
        }
        
        foreach($products as $product)
        {   
            $price = $product->price;
            if($product->units > 0){
                OrderItem::create([
                    'order_id'=>$order->id,
                    'product_id' => $product->id,
                    'code'=>$product->code,
                    'name'=>$product->name,
                    'price'=>$price,
                    'units'=>$product->units,
                ]);
            }         
        }
        
            
    }
    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
    */
    public function failed(Throwable $exception){
        $notification = 'Fallo al crear un pedido - SaveNewOrder';
        TelegramNotificationLog::telegramNotifySupers($notification);
    }
}
