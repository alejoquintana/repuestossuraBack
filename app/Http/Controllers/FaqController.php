<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faq;
use Illuminate\Support\Facades\Cache;

class FaqController extends Controller
{
    //

     public function forgetCaches(){
        Cache::forget('faq');
       
    }


    public function get()
    {
         return Cache::rememberForever('faq', function () {
            return Faq::orderBy('order')->get();
         });
    }

    public function create(Request $request)
    {
        Cache::forget('faq');
        return Faq::create([
            'question'=>$request->question,
            'answer'=>$request->answer
        ]);
    }

    public function update(Request $request)
    {   
        Cache::forget('faq');
        
        $faq= Faq::find($request->id);
        $field = $request->field;
        $faq->$field = $request->value;
        $faq->save();

    }

    public function destroy($id)
    {
        Cache::forget('faq');
        Faq::destroy($id);
    }
    
}
