<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Mail;
use App\Mail\MailResult;
use App\Notifications\Testing;
use Notification;
use App\Notifications\NewLead;
use App\PID;
use App\Sales;
use DB;
// use App\Notifications\Result;


class TestController extends Controller
{
	public function send_mail(){
		// $email = 'faiqoh@sinergy.co.id';
  //       Notification::route('mail', $email)->notify(new NewLead($email));  

  			$to = User::select('email','name')->where('id_position', 'STAFF')->where('id_division', 'TECHNICAL')->where('id_territory', 'DVG')->get();

  			$users = User::select('name')->where('id_division','FINANCE')->where('id_position','MANAGER')->first();

  			$pid_info = DB::table('sales_lead_register')->join('users','users.nik','=','sales_lead_register.nik')->join('sales_tender_process','sales_tender_process.lead_id','=','sales_lead_register.lead_id')->join('tb_pid','tb_pid.lead_id','=','sales_lead_register.lead_id')->select('sales_lead_register.lead_id','opp_name','name','no_po','amount_pid','quote_number2')->first();  

        foreach ($to as $data) {
        	Mail::to($data->email)->send(new MailResult($users,$pid_info));
        }
            
	}
}
