<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suscription;

class SuscriptionController extends Controller
{
    public function create(Request $request)
    {
        if ($request->email)
        {
            $exists = Suscription::where('email',$request->email)->get()->first();
            if (! $exists){
                Suscription::create(['email'=>$request->email]);
            }
        }
    }
}
