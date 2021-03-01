<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class PresenceController extends Controller
{
    //
    public function index() {
	    $presenceStatus = DB::table('presence__history')->where('nik',Auth::User()->nik)
            ->whereRaw('DATE(`presence_actual`) = "' . now()->toDateString() . '"');


        if($presenceStatus->count() == 0){
            $presenceStatus = "not-yet";
        } else if ($presenceStatus->count() == 1) {
            $presenceStatus = "done-checkin";
        } else {
            $presenceStatus = "done-checkout";
        }

	    return view('presence.presence',compact('presenceStatus'));
	}

    public function personalHistory(){
        return view('presence.personal_history');
    }
}
