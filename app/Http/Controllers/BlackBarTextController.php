<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlackBarText;
use Illuminate\Support\Facades\Cache;

class BlackBarTextController extends Controller
{
    //

    private function forgetCaches(){
        Cache::forget('blackBarText');
       
    }


    public function get()
    {
        return Cache::rememberForever('blackBarText', function () {
            return BlackBarText::get();
        });
    }

    public function create(Request $request)
    {
        $this->forgetCaches();
        return BlackBarText::create([
            'text'=>$request->text,
        ]);
    }

    public function update(Request $request)
    {   
        $this->forgetCaches();
        
        $blackBarText= BlackBarText::find($request->id);
        $field = $request->field;
        $blackBarText->$field = $request->value;
        $blackBarText->save();

    }

    public function destroy($id)
    {
        $this->forgetCaches();
        BlackBarText::destroy($id);
    }
    
}
