<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;
use Session;
use Redirect;

class ManagerMiddleware
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

            // dd($position);

            if($position->position != 'Manager' && $position->position != 'Partner') {
                Auth::logout();
                Session::flush();
                return Redirect::to('/');
            } else {
                return $next($request);
            }
        }

    }
}
