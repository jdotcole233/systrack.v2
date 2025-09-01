<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\{Employee, Activity};
use Request;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $data = \Location::get(Request::ip());
            
            if($data != null){
                Activity::create(['emp_id' => Auth::user()->emp_id, 'region_name' => $data->regionName, 'country_code' => $data->countryCode, 'city_name' => $data->cityName, 'longitude' => $data->longitude, 'latitude' =>  $data->latitude, 'user_agent' => $request->headers->get('user_agent'), 'location_ip_addresses' => Request::ip()]);
            } else {
                Activity::create(['emp_id' => Auth::user()->emp_id, 'region_name' => "", 'country_code' => "", 'city_name' => "", 'longitude' => "", 'latitude' =>  "", 'user_agent' => $request->headers->get('user_agent'), 'location_ip_addresses' => Request::ip()]);
            }
            return redirect('/home');
        }

        return $next($request);
        // if(Auth::guard($guard)->check()) {
        //     else{



        //         // $position = DB::table('employees')->select('position')->where('emp_id',Auth::user()->emp_id)->first();


        //         // switch ($position->position) {
        //         //     case "Manager" :
        //         //         return redirect('/manager-home/manager');
        //         //     case "Employee" :
        //         //         return redirect('/employee-home');
        //         //     case "System Administrator" :
        //         //         return redirect('/admin-home/admin');
        //         //     case "Finance Officer" :
        //         //         return redirect('/finance-home');
        //         //     case "Partner" :
        //         //         return redirect('/admin/home/partner-admin');
        //         //     default :
        //         //         return redirect('/')->with('msg',"Please try again");
        //         // }
        //         return redirect('/home');
        //     }
        // }
        // return $next($request);
    }
}
