<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class MSP
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
        if ( Auth::check() && Auth::User()->id_company == '2' ) {
          
            return $next($request);

        } else {

            if( Auth::check() && Auth::User()->id_position == 'DIRECTOR' ) {

                return $next($request);

            } elseif( Auth::check() && Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' ) {

                return $next($request);
                
            } elseif( Auth::check() && Auth::User()->email == 'finance@sinergy.co.id' ) {

                return $next($request);
                
            } else {

                Auth::logout();
                return redirect()->back()->with('message', 'You are not allowed to login in this application!');

            }
        }
    }
}
