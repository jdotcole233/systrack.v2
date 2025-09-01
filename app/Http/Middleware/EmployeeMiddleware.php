<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;
use Session;
use Redirect;

class EmployeeMiddleware
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

            if($position->position != 'Employee' && $position->position != 'Manager' && $position->position != 'Partner') {
              dd($position);

                Auth::logout();
                Session::flush();
                return Redirect::to('/');
            } else {
                return $next($request);
            }
        }

        // if(Auth::check()) {
        //      $position = DB::table('employees')->select('position')->where('emp_id',Auth::user()->value('emp_id'))->first();
        //      if($position->position == 'Employee')
        //             return $next($request);
        // }

        // Auth::logout();
        // Session::flush();
        // return Redirect::to('/');
    }
}
