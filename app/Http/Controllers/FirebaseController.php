<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseController extends Controller
{
	public function index(){
		return view('firebase'); 
	}

	public function SetFirebaseUpdate(Request $request){
	    //
	    $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/notif1-363bf-firebase-adminsdk-mcskt-3af7d98bf6.json');
	    $firebase = (new Factory)
	    ->withServiceAccount($serviceAccount)
	    // ->withDatabaseUri('https://notif1-363bf.firebaseio.com/')
	    ->withDatabaseUri('https://sales-notif.firebaseio.com')
	    ->create();

	    $database = $firebase->getDatabase();

	    $newPost = $database
	    ->getReference('/sales/sales_lead/')
	    ->push([
	    'lead_id' => $request->customer,
	    ]);
	    echo '<pre>';
	    print_r($newPost->getvalue());	

	    /*$updateDashboard = $database
		->getReference('/project/project_dashboard')
		->set([
			"approching_end" => '28',
			"finish_project" => '13',
			"occurring_now"  => '11',
			"due_this_month" => '53',
		]);*/
	}
    
}
