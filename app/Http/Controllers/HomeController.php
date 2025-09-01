<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\{Auth, DB};

// use Employee;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(Auth::check()) {

            if(Auth::user()->log_status === "FIRST CREATE"){
                return redirect('first-login');
            }else{
                // $data = \Location::get(Request::ip());

                // Activity::create(['emp_id' => Auth::user()->emp_id, 'region_name' => $data->regionName, 'country_code' => $data->countryCode, 'city_name' => $data->cityName, 'longitude' => $data->longitude, 'latitude' =>  $data->latitude, 'user_agent' => ' ', 'location_ip_addresses' => Request::ip()]);

                $position = DB::table('employees')->select('position')->where('emp_id',Auth::user()->emp_id)->first();

                switch ($position->position) {

                    case "Manager" :
                        return redirect('/manager/home/manager');
                    case "Employee" :
                        return redirect('/employee/home');
                    case "System Administrator" :
                        return redirect('/admin/home/admin');
                    case "Finance Officer" :
                        return redirect('/finance/home/finance');
                    case "Partner" :
                        return redirect('/admin/home/partner-admin');
                    default :
                        return view('auth.login')->with('msg',"Please try again");
                }
            }
        // }

        // return redirect('/');
    }
}
