<?php

namespace App\Http\Controllers;

use App\TemporalImport;
use App\Imports\TemporalImportsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

Class TemporalImportController extends Controller {

    public function tempImport(Request $request ){

       $path = $request->file('file')->getRealPath();
       $originalExtension = $request->file('file')->getClientOriginalExtension();
       //return $path;
       if(!$path){return "no file";}

       Excel::import(new TemporalImportsImport, $request->file('file'),'',\Maatwebsite\Excel\Excel::CSV);

       return TemporalImport::all();
        
    }
}