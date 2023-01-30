<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use App\User;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    //

    public function create(request $request)
    {
        $authuser = Auth::user();
        if(!$authuser){return;}
        $user = User::find($authuser->id);
        if(!$user){return;}

        Survey::create([
            'option'=>$request->option,
            'comment'=>$request->comment
        ]);
        
        $user->survey_completed = true;
        $user->save();
        return $user;
    }


    public function get()
    {
        return Survey::all();    
    }

}