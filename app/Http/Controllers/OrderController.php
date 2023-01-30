<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderItem;
use App\EditedOrderItem;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Config;
use Carbon\Carbon;
use App\Jobs\SaveNewOrder;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Cache;
use App\Jobs\EditOrderList;
class OrderController extends Controller
{
    //
    public function getFullOrderres($id) {
        return Order::where('id',$id)->with('orderItems.product')->with('editedOrderItems.product')->with('user')->get()->first();
    }

    private function checkAuth($order_id){
        $user = Auth::user();
        $order = Order::find($order_id);
        if(!$user){return  false;}
        if($user->role_id < 2){return true;}
        if($order->user_id == $user->id){return true;}
        return false;
    }

    public function getEditedOrderItems($order_id) {
        if(!$this->checkAuth($order_id)){
            response()->json(['error' => 'Not authorized.'], 403);
        }
        $res = [];
        $original_order_items = OrderItem::where('order_id',$order_id)->get();
        
        array_push($res, ['edition'=>0,'order_items'=>$original_order_items]);
        
        $all_editions = EditedOrderItem::where('order_id',$order_id)->orderBy('edition_id','ASC')->get();
        
        foreach ($all_editions as $edition) {
            $edition_order_items = EditedOrderItem::where('order_id',$order_id)
            ->where('edition_id',$edition->edition_id)->get();
            array_push($res, ['edition'=>$edition->edition_id,'user'=>$edition->user,'order_items'=>$edition_order_items]);
        }
        
        return $res;
    }

    public function getFullOrder($id) {
        if (!$this->checkAuth($id)) {
            response()->json(['error' => 'Not authorized.'], 403);
        }
        $order = Order::where('id',$id)->with('user')->get()->first();
        $order_items = OrderItem::where('order_id',$id)->get();

        if ($order->edited) {
            $order_items = EditedOrderItem::where('order_id',$id)
                ->where('edition_id',$order->last_edition_id)
                ->get();
        }

        $full_order = array(
            'order' => $order,
            'order_items' => $order_items,
        );
        return $full_order;
    }
    
    public function checkListStatus(request $request) {
        $listp = json_decode($request->listp);
      
        $listp = array_column($listp,'id');
       
        $products = Product::findMany($listp);
       
        return ['products'=>$products];

    }

    public function getPaginated(request $request) {
        $searchterm = $request->searchTerm;
        $status = $request->status;
        $retiro_id = $request->retiro_id;
        
        $query = Order::with('user');

        if($status){
            $query = $query->where('status',$status);
        }

        if($searchterm && strlen($searchterm) > 1){
            $searchterm = '%'.trim(strtoupper($searchterm)).'%';
            $query = $query->whereRaw("UPPER(orders.client) LIKE '{$searchterm}' OR orders.user_id LIKE '{$searchterm}' OR orders.user_id IN ( SELECT id FROM users WHERE UPPER(users.name) LIKE '{$searchterm}' )");
        }

        if($retiro_id > 0){
            $query = $query->where('retiro_id',$retiro_id);
        }

        return $query->orderBy('created_at','DESC')->paginate(15);

    }

    public function getUfoStats() {
        $stats = DB::table('orders')->join('users', 'orders.user_id', 'users.id')
            ->select(
                DB::raw("MONTH(orders.created_at) AS dmonth"),
                DB::raw("YEAR(orders.created_at) AS dyear"),
                DB::raw("SUM(IF(orders.user_first_order,1,0)) AS ufo_cantidad"),
                DB::raw("SUM(IF(orders.user_first_order,0,1)) AS nufo_cantidad"),
                DB::raw("SUM(IF(orders.user_first_order,orders.total,0)) AS ufo_total"),
                DB::raw("SUM(IF(orders.user_first_order,0,orders.total)) AS nufo_total")
            )
            ->where('users.role_id','>',2)
            ->groupBy('dyear')
            ->groupBy('dmonth')
            ->orderBy('dyear', 'DESC')
            ->orderBy('dmonth', 'DESC')
            ->get();

        return $stats;
    }

    /* public function dangerSetUFOS(){
        $users = User::all();

        foreach ($users as $user) 
        {
            $ufo = Order::where('user_id', $user->id)->orderBy('created_at', 'ASC')->get()->first();
            if (!$ufo) {
                continue;
            }
            if ($ufo->user_first_order) {
                continue;
            }
            $ufo->user_first_order = true;
            print($ufo->id);
            print('<br/>');
            $ufo->save();
        }
    } */

    public function getProvinceStats($month = null, $year = null)
    {

        $minDate = Carbon::create(2017, 1, 1, 0, 0, 0);
        $maxDate = Carbon::today();
        if ($month && $year) {
            $minDate = Carbon::create($year, $month, 1, 0, 0, 0);
            $maxDate = Carbon::create($year, $month + 1, 1, 0, 0, 0);
            if ($month == 12) {
                $maxDate = Carbon::create($year + 1, 1, 1);
            }
        }

        return  DB::table('orders')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('cities', 'orders.city_id', 'cities.id')
            ->join('states', 'cities.state_id', 'states.id')
            ->select(
                DB::raw("states.name as state"),
                DB::raw("COUNT( DISTINCT( CASE WHEN users.role_id > 2 THEN orders.id END ) ) as cantidad")
            )
            ->where('orders.status', '!=', 'cancelado')
            ->whereBetween('orders.created_at', [$minDate, $maxDate])
            ->groupBy('state_id')
            ->orderBy('cantidad', 'DESC')
            ->get();
    }

    public function getStats()
    {
        $stats = DB::table('orders')
                ->join('users','orders.user_id','users.id')
                ->join('order_items','orders.id','=','order_items.order_id')
                ->select(DB::raw("MONTH(orders.created_at) AS dmonth"),
                         DB::raw("YEAR(orders.created_at) AS dyear"),
                         DB::raw("COUNT( DISTINCT( CASE WHEN users.role_id <= 2 THEN orders.id END ) ) as admin_cantidad "),
                         DB::raw("COUNT( DISTINCT( CASE WHEN users.role_id > 2 THEN orders.id END ) ) as user_cantidad "),
                       /*   DB::raw("SUM(IF(users.role_id > 2, 1 , 0 )) as user_cantidad"),
                         DB::raw("SUM(IF(users.role_id <= 2, 1 , 0 )) as admin_cantidad"), */
                        /*  DB::raw("COUNT(DISTINCT(orders.id)) AS cantidad"), */
                         DB::raw("SUM(IF( users.role_id > 2 
                                        ,order.total, 0) ) AS user_total"),
                         DB::raw("SUM(IF( users.role_id <= 2 
                                        , order.total, 0) ) AS admin_total"))
                ->where('orders.status','!=','cancelado')
                ->groupBy('dyear')
                ->groupBy('dmonth')
                ->orderBy('dyear','DESC')
                ->orderBy('dmonth','DESC')
                ->get();
       
        return $stats;
    }

    public function getMonthStats($month,$year)
    {
        $minDate = Carbon::create($year,$month,1,0,0,0);
        $maxDate = Carbon::create($year,$month+1,1,0,0,0);
        if($month==12)
        {
            $maxDate = Carbon::create($year+1,1,1);
        }

        
       return  DB::table('orders')
                ->join('users', 'orders.user_id', 'users.id')
                ->join('order_items','orders.id','=','order_items.order_id')
                ->select(DB::raw("DAY(orders.created_at) AS day"),
                        DB::raw("COUNT( DISTINCT( CASE WHEN users.role_id <= 2 THEN orders.id END ) ) as admin_cantidad "),
                        DB::raw("COUNT( DISTINCT( CASE WHEN users.role_id > 2 THEN orders.id END ) ) as user_cantidad "),
                        DB::raw("SUM(IF( users.role_id > 2 
                                                    , order.total, 0) ) AS user_total"),
                        DB::raw("SUM(IF( users.role_id <= 2 
                                        , order.total, 0) ) AS admin_total")
                 )
                ->where('orders.status','!=','cancelado')
                ->whereBetween('orders.created_at',[$minDate,$maxDate])
                ->groupBy('day')
                ->orderBy('day','DESC')
                ->get();
    }

    public function forgetCaches(){
        Cache::forget('productsNotPaused');
        Cache::forget('categories');
    }

    public function lastOrder($token)
    {
        $user = User::where('reg_verif_code',$token)->get()->first();
        if($user)
        {
            $order = Order::where('user_id',$user->id)->orderBy('created_at','desc')->get()->first();
            if($order){
                return $order;
            }
        }
       
    }
    
    public function originalToPDF($reg_verif_code,$order)
    {
        $user = User::where('reg_verif_code', $reg_verif_code)->get()->first();
        
        if(!$user){return;}

        $order = Order::find($order);
        $order_items = OrderItem::where('order_id',$order->id)->get();
        
        if($user->role_id <= 2 || $order->user_id == $user->id)
        {
            $today = $order->created_at->format('d-m-Y H:i');
            
            /* dd($order->getTheFuckingCity($order->city_id)); */
            $logo = Config::base64('/storage/images/app/logo.jpg');
            
            $html = View::make('pdf.Cotizacion',compact('order','order_items','today','logo'))->render();
            
            $pdf = PDF::loadHTML($html);
            
            return $pdf->stream("{$today}-Cotizacion.pdf");
        }
    }
    
    public function lastEditionToPDF($reg_verif_code,$order)
    {
        $user = User::where('reg_verif_code', $reg_verif_code)->get()->first();
        
        if(!$user){return;}
        
        $order = Order::find($order);
        $order_items = EditedOrderItem::where('order_id',$order->id)->where('edition_id',$order->last_edition_id)->get();
        
        if($user->role_id <= 2 || $order->user_id == $user->id)
        {
            //return $order;
            $today = $order->created_at->format('d-m-Y H:i');
            
            /* dd($order->getTheFuckingCity($order->city_id)); */
            $logo = Config::base64('/storage/images/app/logo.jpg');
            
            $html = View::make('pdf.Cotizacion',compact('order','order_items','today','logo'))->render();
            
            $pdf = PDF::loadHTML($html);
            
            return $pdf->stream("{$today}-Cotizacion.pdf");
        }
    }
    
    public function toPDF($reg_verif_code,$order)
    {
        $user = User::where('reg_verif_code', $reg_verif_code)->get()->first();
        
        if(!$user){return;}
        
        $order = Order::find($order);
        
        if($user->role_id <= 2 || $order->user_id == $user->id)
        {
            $today = $order->created_at->format('d-m-Y H:i');
            $order_items = [];
            if ($order->edited) {
                $order_items = EditedOrderItem::where('order_id',$order->id)->where('edition_id',$order->last_edition_id)->get();
            }
            else {
                $order_items = OrderItem::where('order_id',$order->id)->get();
            }
            
            /* dd($order->getTheFuckingCity($order->city_id)); */
            $logo = Config::base64('/storage/images/app/logo.jpg');
            
            $html = View::make('pdf.Cotizacion',compact('order','order_items','today','logo'))->render();
            
            $pdf = PDF::loadHTML($html);
            
            return $pdf->stream("{$today}-Cotizacion.pdf");
        }
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        
        $data = $request->userdata;
        $list = $request->list;
    
        //return $data;

        Queue::push(new SaveNewOrder($data,$list,$user));
        TelegramNotificationLogController::telegramNotifyAdmins("INGRESO UNA NUEVA COTIZACION DE #" . $user->id . " - " . $user->name );

        Cache::forget('orders');

        /* get last order id */
        $lastOrder = Order::orderBy('id','DESC')->get()->first();
        if(!$lastOrder)return 1;
        return ($lastOrder->id + 1 );
    }

    public function update(Request $request)
    {
        Cache::forget('orders');
        $order = Order::find($request->order);
        
        $field = $request->field;
        $order->$field = $request->value;
        $order->save();
        
       
        
        return ;
    }

    public function saveEditedOrder(Request $request){

        $user = Auth::user();
        $order = Order::find($request->order_id);

        if (!$order->edited) {
            $order->edited = 1;
            $order->save();
        }

        Queue::push(new EditOrderList($order,$request->order_items,$user));
    }

    public function getUserOrders()
    {
        $user = Auth::user();
        if(!$user){return;}
        return $user->orders;
    }

    public function get()
    {
        return Order::where('status','!=','cancelado')
                ->with('orderItems')
                ->with('user')
                ->get();     
    }           

    public function getNew()
    {
        return Order::where('status','nuevo')
                ->with('orderItems')
                ->with('user')
                ->get();     
    }           


    public function getCanceledOrders()
    {
        return Order::where('status','cancelado')
                ->with('orderItems')
                ->with('user')
                ->get();     
    }           
        
    
}
