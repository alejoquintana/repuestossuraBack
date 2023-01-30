<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if(Auth::check())
      {
        if(auth()->user()->isAdmin())
        {
          return $next($request);
        }
      }
        return response()->json(['error' => 'Not authorized.'],403);
    }
}
