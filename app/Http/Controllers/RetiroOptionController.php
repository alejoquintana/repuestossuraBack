<?php

namespace App\Http\Controllers;

use App\RetiroOption;
use Illuminate\Http\Request;

class RetiroOptionController extends Controller
{
    //
    public function get(){
        return RetiroOption::all();
    }

    public function create(request $request)
    {
        $new =RetiroOption::create($request->all());
        return $new;
    }

    public function update(request $request){
        $row = RetiroOption::find($request->id);
        if(!$row){return;}
        $field = $request->field;
        $row->$field = $request->value;
        $row->save();
        return $row;
    }

    public function destroy($id){
        if($id == 1){return;}
        RetiroOption::destroy($id);
    }
}
