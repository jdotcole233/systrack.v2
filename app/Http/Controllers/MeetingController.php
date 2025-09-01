<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Meeting, Meeting_Attend};

class MeetingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

     public function meeting_information_display($user){
        
        return view('meeting.meeting',compact('user'));
    }


    
    public function create_meeting (Request $request) {
        $meetings = json_decode($request->input('jsonData'));

        $meeting_id = Meeting::create($request->except('_token', 'jsonData', 'removed_employees'))->id;

        foreach ($meetings as $meet_name) {
            Meeting_Attend::create(['attendant_name' => $meet_name, 'meeting_id' =>  $meeting_id]);
        }

        $data = Meeting_Attend::where('meeting_id', $meeting_id)->get();

        $meeting = Meeting::where('meeting_id', $meeting_id)->first();

        return response()->json(['message' => 'success', 'data' => $data, 'meeting' => $meeting]);
    }

    public function get_meeting_back($id){
        $meeting_back = Meeting::where('meeting_id',$id)->where('delete_status', 'NOT DELETED')->first();
        $meeting_back_people = Meeting_Attend::where('meeting_id', $id)->where('delete_status', 'NOT DELETED')->get();

        return response()->json(['m_b' => $meeting_back, 'm_b_p' => $meeting_back_people]);
    }

     public function update_meeting_minute(Request $request, $id){
       // print_r($request->all());

        $meeting_back = Meeting::where('meeting_id',$id)->where('delete_status', 'NOT DELETED')->update($request->except('jsonData', 'removed_employees'));

        $meetings = json_decode($request->input('jsonData'));
        $removed_employees = json_decode($request->input('removed_employees'));

        if($request->input('jsonData') != "}"){
            $meeting_id = $id;
            foreach ($meetings as $id_meet => $meet_name ) {
                Meeting_Attend::create(['attendant_name' => $meet_name, 'meeting_id' =>  $meeting_id]);
            }
        }

        if($request->input('removed_employees') != "}"){
            foreach ($removed_employees as $meet_id => $value) {
                Meeting_Attend::where('meeting_attends_id', $meet_id)->update(['delete_status' => 'DELETED']);
            }
        }

        return response()->json(['success' => 'Updated Minutes']);
    }

    public function update_meeting_status(Request $request,$id){

        $meeting_back = Meeting::where('meeting_id',$id)->where('delete_status', 'NOT DELETED')->update(['meeting_status' => 'CANCELLED']);

        $data = Meeting_Attend::where('meeting_id', $id)->get();

        $meeting = Meeting::where('meeting_id', $id)->first();


        return response()->json(['success' => 'Updated Status', 'data' => $data, 'meeting' => $meeting]);
    }

}
