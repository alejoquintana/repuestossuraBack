<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;

class LocationController extends Controller
{
    //
    public function get(){
        return Location::all();
    }

    public function update(request $request){
        $location  = Location::find($request->id);
        if(!$location){return;}
        $field = $request->field;
        $location->$field = $request->value;
        $location->save();
        return $location;
    }

    public function create(){
        return Location::create(['name' => 'NUEVA SUCURSAL']);
    }

    public function destroy($id)
    {
        return Location::destroy($id);
    }

}
