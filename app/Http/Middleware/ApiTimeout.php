<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class ApiTimeout
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
        if ( $request->user()->expired_at < Carbon::now() ) {
            $logout = \App\User::find($request->user()->id);
            $logout->api_token = null;
            $logout->expired_at = null;
            $logout->save();
            return response()->json(['error'=>'Unauthorised'], 401);
        }else {
            $logout = \App\User::find($request->user()->id);
            $logout->expired_at = Carbon::now()->addMinutes(5);
            $logout->save();
            return $next($request);
        }
    }
}
