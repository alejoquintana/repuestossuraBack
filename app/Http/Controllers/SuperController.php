<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class SuperController extends Controller
{
    public function panel()
    {
        $user = Auth::user();
        return view('admin.super',compact('user'));
    }

    public function failedJobsView()
    {
        return view('admin.failedJobs');
    }
}

