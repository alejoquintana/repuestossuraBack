<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SearchHistory;


class SearchHistoryController extends Controller
{
    //

    public function get(){
        return SearchHistory::all();
    }

    public function save(request $request)
    {
        SearchHistory::create(['term'=>$request->term]);
    }
}
