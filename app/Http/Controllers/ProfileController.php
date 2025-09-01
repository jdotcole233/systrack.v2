<?php

namespace App\Http\Controllers;
use App\Models\{Employee};
use Image;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index($user){
       $information = Employee::where('emp_id', Auth::user()->emp_id)->where('delete_status','NOT DELETED')->first();


    	return view('profile.index',compact('user', 'information'));
    }

    public function update(Request $request) {
    	Employee::where('emp_id', Auth::user()->emp_id)->update($request->except('_token'));
    	$emp = Employee::where('emp_id', Auth::user()->emp_id)->first();
        DB::table('users')->where('emp_id',  Auth::user()->emp_id)->update(['username' => $emp->company_email]);
    	return back();
    }

    public function uploadProfilePic(Request $request) {
    	if($request->hasFile('profile_photo'))
        {
            $image = $request->file('profile_photo');
            $filename  = Auth::user()->username. '.' . $image->getClientOriginalExtension();
            $path = public_path('images/profile_photo');
            $image->move($path, $filename);
            Employee::where('emp_id', Auth::user()->emp_id)->update(['profile_pic' => $filename]);
        }
    	return back();
    }
}
//C:\Users\Muhammad Kassim Jr\PhpstormProjects\firmus\firmusadvisory\public\images/profile_photo/Ole4093.jpg