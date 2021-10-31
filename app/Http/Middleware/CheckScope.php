<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckScope
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
        if ( $request->user()->scope == 1 || $request->user()->scope == 2 ){
            return $next($request);
        }else {
            Auth::logout();
            toastr()->error('Akun ini tidak berlaku untuk Web.');
            return redirect()->back();
        }
    }
}
