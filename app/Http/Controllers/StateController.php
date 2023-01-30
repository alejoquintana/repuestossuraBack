<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\City;
use Illuminate\Support\Facades\Cache;
class StateController extends Controller
{
    //

    public function get()
    {
       return  Cache::rememberForever('states',function(){
            return State::with('cities')->get(); 
        });
    }

    public function getCity($id)
    {
        return City::with('state')->find($id);
    }
}
