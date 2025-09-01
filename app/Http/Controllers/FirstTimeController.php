<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\{Auth, DB};

class FirstTimeController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function employee_confirm_password(Request $request)
	{

		$length = strlen($request->password);
		$name_avt = DB::table('employees')->select('first_name')->where('emp_id', Auth::user()->emp_id)->where('delete_status', 'NOT DELETED')->get();
		$check = 0;
		if ($length < 8) {
			$check = 1;
			return view('auth.first-login', compact('name_avt', 'check'));
		} else {
			if (strcmp($request->password, $request->confirm_password) == 0) {
				$emp_id_find = Auth::user()->id;
				$find_user = User::findOrFail($emp_id_find);
				$find_user->password = bcrypt($request->password);
				$find_user->log_status = "UPDATED";
				$find_user->save();
			} else {
				$check = 2;
				return view('auth.first-login', compact('name_avt', 'check'));
			}
		}

		return redirect('/')->with('success', 'You can log in with your new password');
	}

	public function first_page_show()
	{
		$check = 0;
		$name_avt = DB::table('employees')->select('first_name')->where('emp_id', Auth::user()->emp_id)->where('delete_status', 'NOT DELETED')->get();

		return view('auth.first-login', compact('name_avt', 'check'));
	}

	public function reset_user_password($user_id)
	{
		$default_password = '123456';

		User::where('emp_id', $user_id)->where('delete_status', 'NOT DELETED')->update(['password' => bcrypt($default_password), 'log_status' => 'FIRST CREATE']);

		return response()->json(['success' => 'password reset']);
	}
}
