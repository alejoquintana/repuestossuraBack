<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\TrackEvents;
use App\Order;
use App\Survey;
use App\Product;
use App\City;
use Carbon\Carbon;

class StatsController extends Controller
{
    public function getSalesYears() {
        $res = [];
        $years = DB::table('orders')
                 ->select(DB::raw("DISTINCT YEAR(created_at) AS year"))
                 ->orderBy('year','DESC')
                 ->get();
        foreach ($years as $year) {
            $res[] = $year->year;
        }
        return $res;
    }
    
    private function random_color() {
        return '#'.str_pad(dechex(mt_rand(0,255)),2,'0',STR_PAD_LEFT).str_pad(dechex(mt_rand(0,255)),2,'0',STR_PAD_LEFT).str_pad(dechex(mt_rand(0,255)),2,'0',STR_PAD_LEFT);
    }

    //! GRAFICO DE VENTAS
    public function getSalesChartStats() {
        $res = [];
        $comparators = ['=','!='];

        $years = $this->getSalesYears();

        foreach ($years as $year) {
            $salesData = [];

            foreach ($comparators as $comparator) {
                $allMonths = [];
                for ($i=1 ; $i <= 12 ; $i++) {
                    $amount = DB::table('orders')
                    ->select(DB::raw("COUNT(status) AS amount"))
                    ->whereRaw("YEAR(created_at) = ".$year)
                    ->whereRaw("MONTH(created_at) = ".$i)
                    ->whereRaw("status ".$comparator." 'cancelado'")
                    ->get()->first();
                    array_push($allMonths,$amount->amount);
                }
                $label = 'cancelados';
                $color = '#ff0000';
                if ($comparator == '!=') {
                    $label = 'no cancelados';
                    $color = '#00ff00';
                }
                $salesData[] = [
                    'label' => $label,
                    'data' => $allMonths,
                    'backgroundColor' => $color
                ];
            }
            
            array_push($res,[
                'year'=>$year,
                'salesData'=>$salesData
            ]);
        }
        return $res;
    }
    
    //! USUARIOS
    public function usersMonthly() {
        return User::where('role_id', '>', 2)
        ->select(
            DB::raw('COUNT(id) as n'),
            DB::raw('SUM( IF( service = "local", 1, 0 ) ) as local'),
            DB::raw('SUM( IF( service = "facebook", 1, 0 ) ) as facebook'),
            DB::raw("YEAR(created_at) AS year"),
            DB::raw("MONTH(created_at) AS month")
        )
            ->groupBy('year')
            ->groupBy('month')
            ->orderBy('year', 'DESC')
            ->orderBy('month', 'DESC')
            ->get();
    }

    public function usersList($search = null) {
        $q = User::where('role_id', '>', 2);
        if ($search) {
            $search = '%' . $search . '%';
            $q->where('name', 'LIKE', $search)
            ->orWhere('email', 'LIKE', $search)
            ->orWhere('id', 'LIKE', $search);
        }
        $q = $q->orderBy('id', 'DESC');
        return $q->paginate();
    } 

    public function usersDaily($year, $month) {

        $minDate = Carbon::create($year, $month, 1);
        $maxDate = Carbon::create($year, $month + 1, 1);
        if ($month == 12) {
            $maxDate = Carbon::create($year + 1, 1, 1);
        }


        return User::where('role_id', '>', 2)
        ->select(
            DB::raw('COUNT(id) as n'),
            DB::raw('SUM( IF( service = "local", 1, 0 ) ) as local'),
            DB::raw('SUM( IF( service = "facebook", 1, 0 ) ) as facebook'),
            DB::raw("YEAR(created_at) AS year"),
            DB::raw("MONTH(created_at) AS month"),
            DB::raw("DAY(created_at) AS day")
        )
            ->whereBetween('created_at', [$minDate, $maxDate])
            ->groupBy('year')
            ->groupBy('month')
            ->groupBy('day')
            ->orderBy('day', 'DESC')
            ->get();
    }

    //! VENTAS
    public function getSalesStats() {
        return DB::table('orders')
                ->select(
                    DB::raw("YEAR(created_at) AS dyear"),
                    DB::raw("MONTH(created_at) AS dmonth"),
                    DB::raw("count(MONTH(created_at)) AS cantidad"),
                    DB::raw("sum(total) AS original_total"),
                    DB::raw("sum(IF(edited = 0, null, edited_total)) AS edited_total"),
                    DB::raw("sum(IF(status = 'pagado', 1, null)) AS c_pagados"),
                    DB::raw("sum(IF(status = 'pagado', IF(edited = 0, total, edited_total), null)) AS pagados"),
                    DB::raw("sum(IF(status = 'enviado', 1, null)) AS c_enviados"),
                    DB::raw("sum(IF(status = 'enviado', IF(edited = 0, total, edited_total), null)) AS enviados")
                )->groupBy('dyear')
                ->groupBy('dmonth')
                ->orderBy('dyear','DESC')
                ->orderBy('dmonth','ASC')
                ->get();
        //? SELECT
        //?     YEAR(created_at) AS dyear,
        //?     MONTH(created_at) AS dmonth,
        //?     count(MONTH(created_at)) AS cantidad
        //?     sum(IF(edited = 0, total, null)) AS original_total
        //?     sum(IF(edited = 0, null, edited_total)) AS edited_total
        //?     sum(IF(status = 'pagado', 1, null)) AS c_pagados
        //?     sum(IF(status = 'pagado', IF(edited = 0, total, edited_total), null)) AS pagados
        //?     sum(IF(status = 'enviado', 1, null)) AS c_enviados
        //?     sum(IF(status = 'enviado', IF(edited = 0, total, edited_total), null)) AS enviados
        //? FROM orders
        //? GROUP BY dyear,dmonth
        //? ORDER BY dyear DESC,dmonth ASC;
    }
    public function getCanceledSalesStats() {
        return DB::table('orders')
                ->select(
                    DB::raw("YEAR(created_at) AS dyear"),
                    DB::raw("MONTH(created_at) AS dmonth"),
                    DB::raw("count(MONTH(created_at)) AS cantidad"),
                    DB::raw("sum(total) AS original_total"),
                    DB::raw("sum(IF(edited = 0, null, edited_total)) AS edited_total")
                )
                ->whereRaw("status = 'cancelado'")
                ->groupBy('dyear')
                ->groupBy('dmonth')
                ->orderBy('dyear','DESC')
                ->orderBy('dmonth','ASC')
                ->get();
    }
    public function getMonthStats($month,$year,$status = null, $retiro_id = null) {
        $minDate = Carbon::create($year,$month,1,0,0,0);
        $maxDate = Carbon::create($year,$month+1,1,0,0,0);
        
        if($month==12)
        {
            $maxDate = Carbon::create($year + 1,1,1,0,0,0);
        }

        
       $stats = DB::table('orders')
                ->select(DB::raw("DAY(orders.created_at) AS day"),
                        DB::raw("COUNT(DISTINCT(orders.id)) AS cantidad"),
                        DB::raw("SUM(orders.total) AS original_total"),
                        DB::raw("SUM(IF(orders.edited,orders.edited_total,orders.total)) as edited_total"),
                        DB::raw("SUM(IF(orders.status='enviado',(IF(orders.edited,orders.edited_total,orders.total)),0)) as enviados"),
                        DB::raw("SUM(IF(orders.status='enviado',1,0)) as c_enviados"),
                        DB::raw("SUM(IF(orders.status='pagado',(IF(orders.edited,orders.edited_total,orders.total)),0)) as pagados"), 
                        DB::raw("SUM(IF(orders.status='pagado',1,0)) as c_pagados") 
                        );
      if(!$status){
            $stats = $stats->where('orders.status','!=','cancelado');
        }else{
            $stats = $stats->where('orders.status','cancelado');
        }

        if ($retiro_id) {
            $stats = $stats->where('orders.retiro_id', $retiro_id);
        }

        $stats = $stats->whereBetween('orders.created_at',[$minDate,$maxDate])
                ->groupBy('day')
                ->orderBy('day','DESC');

        

        return $stats->get();
    }
    public function getMonthStatsByDelivery($month, $year) {
        $minDate = Carbon::create($year, $month, 1, 0, 0, 0);
        $maxDate = Carbon::create($year, $month + 1, 1, 0, 0, 0);
        if ($month == 12) {
            $maxDate = Carbon::create($year + 1, 1, 1,0,0,0);
        }


        return  DB::table('orders')
            ->select(
                DB::raw("COUNT(DISTINCT(orders.id)) AS cantidad"),
                DB::raw("SUM(orders.total) AS original_total"),
                DB::raw("SUM(IF(orders.edited,orders.edited_total,orders.total)) as edited_total"),

                DB::raw("SUM(IF( orders.delivery_option LIKE 'retiro' ,(IF(orders.edited,orders.edited_total,orders.total)),0)) as retiro_editado"),
                DB::raw("SUM(IF( orders.delivery_option LIKE  'retiro' , orders.total, 0 ) ) as retiro_original"),
                DB::raw("SUM(IF( orders.delivery_option LIKE 'retiro' ,1,0 ) ) as c_retiro"),

                DB::raw("SUM(IF(orders.delivery_option='interior',(IF(orders.edited,orders.edited_total,orders.total)),0)) as interior_editado"),
                DB::raw("SUM(IF( orders.delivery_option='interior',orders.total,0 ) ) as interior_original"),
                DB::raw("SUM(IF(orders.delivery_option='interior',1,0)) as c_interior"),

     
                DB::raw("SUM(IF(orders.delivery_option='gratis',(IF(orders.edited,orders.edited_total,orders.total)),0)) as gratis_editado"),
                DB::raw("SUM(IF( orders.delivery_option='gratis',orders.total,0 ) ) as gratis_original"),
                DB::raw("SUM(IF(orders.delivery_option='gratis',1,0)) as c_gratis")

            )
            ->where('orders.status', '!=', 'cancelado')
            ->whereBetween('orders.created_at', [$minDate, $maxDate])
            ->get();
    }
    public function getCanceledStats() {
      
       $stats = DB::table('orders')->select(DB::raw("MONTH(orders.created_at) AS dmonth"),
                         DB::raw("YEAR(orders.created_at) AS dyear"),
                         DB::raw("COUNT(DISTINCT(orders.id)) AS cantidad"),
                         DB::raw("SUM(orders.total) AS original_total"),
                         DB::raw("SUM(IF(orders.edited,orders.edited_total,orders.total)) as edited_total"),
                         DB::raw("SUM(IF(orders.status='pagado',1,0)) as c_pagados"),
                         DB::raw("SUM(IF(orders.status='enviado',1,0)) as c_enviados"),
                        DB::raw("SUM(IF(orders.status='enviado',(IF(orders.edited,orders.edited_total,orders.total)),0)) as enviados"),
                        DB::raw("SUM(IF(orders.status='pagado',(IF(orders.edited,orders.edited_total,orders.total)),0)) as pagados")
                        );
     
        $stats = $stats->where('status','cancelado');
        
       
        $stats = $stats->groupBy('dyear')
                ->groupBy('dmonth')
                ->orderBy('dyear','DESC')
                ->orderBy('dmonth','DESC');
       
        return $stats->get();
    }
    public function getCanceledMonthStats($month, $year) {
        $minDate = Carbon::create($year, $month, 1, 0, 0, 0);
        $maxDate = Carbon::create($year, $month + 1, 1, 0, 0, 0);
        if ($month == 12) {
            $maxDate = Carbon::create($year + 1, 1, 1,0,0,0);
        }

        return  DB::table('orders')
            ->select(DB::raw('cancelation as motivo'),
                DB::raw("COUNT(DISTINCT(orders.id)) AS cantidad"),
                DB::raw("SUM(orders.total) AS original_total"),
                DB::raw("SUM(IF(orders.edited,orders.edited_total,orders.total)) as edited_total")
            )
            ->where('orders.status', 'cancelado')
            ->whereBetween('orders.created_at', [$minDate, $maxDate])
            ->groupBy('cancelation')
            ->get();
    }
    
    //! URL REPETIDAS
    public function getRepeatedUrl() {
        $slugs = DB::table('products')
                    ->select('slug')
                    ->groupBy('slug')
                    ->havingRaw('count(slug) > 1')
                    ->orderBy('slug','DESC')
                    ->get();

        $slugs = json_decode( json_encode($slugs), true);

        $prod = DB::table('products')
                    ->select('*')
                    ->whereIn('slug', $slugs)->orderBy('slug')
                    ->get();      

        return $prod;
    }
    
    //! SURVEYS
    public function getSurveysStatDate($year,$month) {
        if ( $year == 0 || $month == 0 ) {
            return DB::table('surveys')
                        ->select(
                            DB::raw("distinct surveys.option as opt"),
                            DB::raw("count(surveys.option) as amount"),
                            DB::raw("count(*) * 100.0 / (select count(*) from surveys) as percentage")
                        )
                        ->groupBy('opt')
                        ->orderBy('opt','ASC')
                        ->get();
        }

        return DB::table('surveys')
                    ->select(
                        DB::raw("distinct surveys.option as opt"),
                        DB::raw("count(surveys.option) as amount"),
                        DB::raw("count(*) * 100.0 / (select count(*) from surveys) as percentage")
                    )
                    ->whereRaw('YEAR(created_at) = '.$year)
                    ->whereRaw('MONTH(created_at) = '.$month)
                    ->groupBy('opt')
                    ->orderBy('opt','ASC')
                    ->get();
    }
    public function getSurveysDate($year,$month) {
        if ( $year == 0 || $month == 0 ) {
            return DB::table('surveys')
                        ->select(DB::raw("*"))
                        ->orderBy('id','DESC')
                        ->get();
        }

        return DB::table('surveys')
                ->select(DB::raw("*"))
                ->whereRaw('YEAR(created_at) = '.$year)
                ->whereRaw('MONTH(created_at) = '.$month)
                ->orderBy('id','DESC')
                ->get();
    }
                
    public function getSurveysYears() {
        $res = [];
        $years = DB::table('surveys')
            ->select(DB::raw("DISTINCT YEAR(created_at) AS year"))
            ->orderBy('year','DESC')
            ->get();
        foreach ($years as $year) {
            $res[] = $year->year;
        }
        return $res;
    }
    
    //! SALES BY DATE
    public function getSalesByStates() {
        $res = [];
        $cities = DB::table('orders')
                ->join('cities', 'orders.city_id','=','cities.id')
                ->select(DB::raw("DISTINCT cities.state_id as state_id"),
                        DB::raw("COUNT(state_id) as amount"),
                        DB::raw("COUNT(*) * 100.0 / (SELECT COUNT(*) FROM orders) AS percentage"))
                ->orderBy('amount','DESC')
                ->groupBy('state_id')
                ->get();
        return $cities;
    }

    public function getSalesByStatesAndDate($year, $month){
        $cities = DB::table('orders')
            ->join('cities', 'orders.city_id','=','cities.id')
            ->select(DB::raw("DISTINCT cities.state_id as state_id"),
                    DB::raw("COUNT(state_id) as amount"),
                    DB::raw("COUNT(*) * 100.0 / (SELECT COUNT(*) FROM orders WHERE YEAR(created_at) = ".$year
                    ." and MONTH(created_at) = ".$month.") AS percentage"))
            ->whereRaw('YEAR(orders.created_at) = '.$year)
            ->whereRaw('MONTH(orders.created_at) = '.$month)
            ->orderBy('amount','DESC')
            ->groupBy('state_id')
            ->get();

        return $cities;
    }

    //! MOST SOLD 
    public function getMostSoldStat($year,$month) {
        if ($year == 0 || $month == 0) {
            return DB::table('order_items')
                    ->select(
                        DB::raw("DISTINCT product_id"),
                        DB::raw("order_items.code,order_items.name"),
                        DB::raw("COUNT(product_id) AS amount")
                    )
                    ->groupBy('product_id')
                    ->groupBy('code')
                    ->groupBy('name')
                    ->orderBy('amount','DESC')
                    ->limit(15)
                    ->get();
        }
        return DB::table('order_items')
                    ->select(
                        DB::raw("DISTINCT product_id"),
                        DB::raw("order_items.code,order_items.name"),
                        DB::raw("COUNT(product_id) AS amount")
                    )
                    ->whereRaw('YEAR(created_at) = '.$year)
                    ->whereRaw('MONTH(created_at) = '.$month)
                    ->groupBy('product_id')
                    ->groupBy('code')
                    ->groupBy('name')
                    ->orderBy('amount','DESC')
                    ->limit(15)
                    ->get();

        /*
        SELECT
            distinct product_id,
            order_items.code,order_items.name,
            count(product_id) as amount
        FROM order_items
        GROUP BY product_id,code,name
        ORDER BY amount DESC
        LIMIT 15;
        */
    }
    
    //! SEARCH HISTORY 
    public function getSearchHistory($year,$month) {
        if ($year == 0 || $month == 0) {
            return DB::table('search_history')
                    ->get();
        }
        return DB::table('search_history')
                    ->whereRaw('YEAR(created_at) = '.$year)
                    ->whereRaw('MONTH(created_at) = '.$month)
                    ->get();
    }

    public function getSearchHistoryYears() {
        $res = [];
        $years = DB::table('search_history')
                 ->select(DB::raw("DISTINCT YEAR(created_at) AS year"))
                 ->orderBy('year','DESC')
                 ->get();
        foreach ($years as $year) {
            $res[] = $year->year;
        }
        return $res;
    }

    //! UFOs
    public function getUfoStats()
    {
        $stats = DB::table('orders')
        ->select(
            DB::raw("MONTH(orders.created_at) AS dmonth"),
            DB::raw("YEAR(orders.created_at) AS dyear"),
            DB::raw("SUM(IF(orders.user_first_order,1,0)) AS ufo_cantidad"),
            DB::raw("SUM(IF(orders.user_first_order,0,1)) AS nufo_cantidad"),
            DB::raw("SUM(IF(orders.user_first_order,orders.total,0)) AS ufo_total"),
            DB::raw("SUM(IF(orders.user_first_order,0,orders.total)) AS nufo_total")
         )
            ->groupBy('dyear')
            ->groupBy('dmonth')
            ->orderBy('dyear', 'DESC')
            ->orderBy('dmonth', 'DESC')
            ->get();

        return $stats;
    }
}