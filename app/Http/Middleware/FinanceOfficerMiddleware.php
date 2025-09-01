<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;
use Session;
use Redirect;

class FinanceOfficerMiddleware
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

        if(Auth::check()){
            $position = DB::table('employees')->select('position')->where('emp_id',Auth::user()->emp_id)->first();
            if($position->position != 'Finance Officer' && $position->position != 'Partner') {
                Auth::logout();
                Session::flush();
                return Redirect::to('/');
            } else {
                return $next($request);
            }
        }

        //  return $next($request);
        return Redirect::to('/login');
    }
}
