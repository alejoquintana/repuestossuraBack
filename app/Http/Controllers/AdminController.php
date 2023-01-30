<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\FailedJob;
class AdminController extends Controller
{
    
    public function tableView()
    {
        $user = Auth::user();
        return view('admin.tableView',compact('user'));
    }

    public function cotizador()
    {
        $user = Auth::user();
        return view('admin.cotizer',compact('user'));
    }

    public function orders()
    {
        $user = Auth::user();
        return view('admin.orders',compact('user'));
    }

    public function failedJobs()
    {
        return FailedJob::all()->orderby('failed_at','desc');
    }

    public function searchHistory()
    {
        return view('admin.searchStatics');
    }
}
