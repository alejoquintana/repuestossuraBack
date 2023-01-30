<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LinktreeLinks;

class LinktreeLinksController extends Controller
{
    //

    public function get(){
        return LinktreeLinks::get();
    }

    public function create(Request $request){

        $link = LinktreeLinks::create([
            'name' => $request->name,
            'url' => $request->url
        ]);

        if (property_exists($request, "code")) {
            $link->code = $request->code;
            $link->save();
        }

        return $link;
    }
    
    public function update(Request $request){
        $link = LinktreeLinks::where("id",$request->id)->get()->first();
        $link[$request->field] = $request->value;
        $link->save();
    }
    
    public function destroy($id){
        LinktreeLinks::destroy($id);
    }
}
