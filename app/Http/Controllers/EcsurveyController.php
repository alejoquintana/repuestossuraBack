<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ecsurvey;

class EcsurveyController extends Controller
{
    //

    public function create(Request $request){

        $data = $request->all();
        Ecsurvey::create($data);

    }

    public function get()
    {
        return Ecsurvey::all();
    }
}
