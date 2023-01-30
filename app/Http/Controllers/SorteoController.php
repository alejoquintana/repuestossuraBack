<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sorteo;

class SorteoController extends Controller
{
    //
    public function get()
    {
        return Sorteo::all();
    }

    public function create(Request $request)
    {
        $sorteo = Sorteo::create([
            'dni'=>$request->dni,
            'wha'=>$request->wha,
            'name'=>$request->name,
            'lastname'=>$request->lastname
        ]);
    }
}
