<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\TrackEvents;

class TrackEventsController extends Controller
{
    //
    public function getStats(){
        $res = [];
        $years = DB::table('track_events')
                 ->select(DB::raw("DISTINCT YEAR(created_at) AS year"))
                 ->orderBy('year','DESC')
                 ->get();
                        
        $events = DB::table('track_events')
                  ->select(DB::raw("DISTINCT event"))
                  ->orderBy('event','ASC')
                  ->get();

        foreach ($events as $event) {
            $event->color = $this->random_color();
        }

        foreach ($years as $year) {
            array_push($res,[
                'year'=>$year->year,
                'eventsData'=>$this->eventsData($year,$events)
            ]);
        }
        
        return $res;
    }

    private function eventsData($year,$events){
        $res = [];
        foreach ($events as $event) {
            $eventInYear = DB::table('track_events')->select('event')
                        ->whereRaw("YEAR(created_at) = ".$year->year)
                        ->whereRaw("event = '".$event->event."'")
                        ->get()->first();
            if (!$eventInYear) {
                continue;
            }
            $allMonths = [];
            for ($i=1 ; $i <= 12 ; $i++) {
                $amount = DB::table('track_events')
                    ->select(DB::raw("COUNT(event) AS amount"))
                    ->whereRaw("YEAR(created_at) = ".$year->year)
                    ->whereRaw("MONTH(created_at) = ".$i)
                    ->whereRaw("event = '".$event->event."'")
                ->get()->first();
                array_push($allMonths,$amount->amount);
            }
            $res[] = [
                'label' => $event->event,
                'data' => $allMonths,
                'backgroundColor' => $event->color
            ];
        }
        return $res;
    }

    private function random_color() {
        return '#'.str_pad(dechex(mt_rand(0,255)),2,'0',STR_PAD_LEFT).str_pad(dechex(mt_rand(0,255)),2,'0',STR_PAD_LEFT).str_pad(dechex(mt_rand(0,255)),2,'0',STR_PAD_LEFT);
    }
    
    public function getStats_RES(){

        return DB::table('track_events')->select(
                        DB::raw("MONTH(created_at) AS dmonth"),
                        DB::raw("YEAR(created_at) AS dyear"),
                        DB::raw("event"),
                        DB::raw("COUNT(event) AS cantidad")
                        )
                        ->groupBy('dyear')
                        ->groupBy('dmonth')
                        ->groupBy('event')
                        ->orderBy('dyear','DESC')
                        ->orderBy('dmonth','DESC')
                        ->orderBy('event')->get() ;

       /*  $everySingleEvent = TrackEvent::select('event')->groupBy('event')->get();
        //return $everySingleEvent;
        $res =array();
        
        foreach ($everySingleEvent as $event) {
            $$event = TrackEvent::select(
                DB::raw("YEAR(created_at) AS dyear"),
                DB::raw("MONTH(created_at) AS dmonth"),                
                DB::raw("SUM( IF( event = '".$event."' , 1, 0 ) ) as ".$event)
                )
                ->groupBy('dmonth')
                ->groupBy('dyear')
                ->orderBy('dyear','ASC')
                ->orderBy('dmonth','ASC')
                ->get();
            array_push($a, $$event);
        }
        return $res; */
    }


    public function event(request $request){
        TrackEvents::create(['event'=>$request->event]);
    }
}
