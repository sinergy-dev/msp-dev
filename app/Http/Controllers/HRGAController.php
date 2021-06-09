<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use Auth;
use DB;
use App\Cuti;
use App\CutiDetil;
use App\Task;
use App\User;
use App\Mail\CutiKaryawan;
use GuzzleHttp\Client;
use Mail;
use Log;

class HRGAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
    	$nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position; 

        if($ter != null){
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name', 'tb_contact.brand_name','sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho')
                ->where('id_territory', $ter)
                ->get();
        } elseif($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_solution_design.nik', 'sales_lead_register.status_sho')
                ->where('sales_solution_design.nik', $nik)
                ->get();
        }elseif($div == 'PMO' && $pos == 'MANAGER') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho')
                ->where('sales_lead_register.result','WIN')
                ->get();
        }elseif($div == 'PMO' && $pos == 'STAFF') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('tb_pmo','sales_lead_register.lead_id','=','tb_pmo.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','tb_pmo.pmo_nik')
                ->where('sales_lead_register.result','WIN')
                ->where('tb_pmo.pmo_nik',$nik)
                ->get();
        }
        elseif($div == 'FINANCE' && $pos == 'MANAGER') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name','sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.nik')
                ->where('sales_lead_register.result','WIN')
                ->get();
        }
        elseif($div == 'FINANCE' && $pos == 'STAFF') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name','sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.nik')
                ->where('sales_lead_register.result','WIN')
                ->get();
        }
        elseif($pos == 'ENGINEER MANAGER') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name','sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.nik','sales_lead_register.status_engineer')
                ->where('sales_lead_register.result','WIN')
                ->where('sales_lead_register.status_sho','PMO')
                ->get();
        }
        elseif($pos == 'ENGINEER STAFF') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('tb_engineer','sales_lead_register.lead_id','=','tb_engineer.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name','sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.nik','sales_lead_register.status_engineer')
                ->where('sales_lead_register.result','WIN')
                 ->where('tb_engineer.nik',$nik)
                ->get();
        }
        else {
              $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name', 'tb_contact.brand_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.nik')
                ->get();
        }

        /*  $presales = DB::table('sales_solution_design')
                    ->join('users','users.nik','=','sales_solution_design.nik')
                    ->select('sales_solution_design.lead_id','sales_solution_design.nik','sales_solution_design.assessment','sales_solution_design.pov','sales_solution_design.pd','sales_solution_design.pb','sales_solution_design.priority','sales_solution_design.project_size','users.name','sales_solution_design.status', 'sales_solution_design.assessment_date', 'sales_solution_design.pd_date', 'sales_solution_design.pov_date')*/
        if ($ter != null) {
            $total_ter = DB::table("sales_lead_register")
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('id_territory', $ter)
                        ->sum('amount');
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $total_ter = DB::table("sales_lead_register")
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                        ->where('sales_solution_design.nik', $nik)
                        ->sum('amount');
        }else{
            $total_ter = DB::table("sales_lead_register")
                        ->sum('amount');
        }

        if ($ter != null) {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notif = DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik')
            ->where('result','OPEN')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }else{
             $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'MANAGER') {
            $notifOpen= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'STAFF') {
            $notifOpen= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'MANAGER') {
            $notifsd= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','SD')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'STAFF') {
            $notifsd= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','SD')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'MANAGER') {
            $notiftp= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','TP')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'STAFF') {
            $notiftp= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','TP')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }

        $datas = Barang::orderBy('id_item', 'DESC')->paginate(5);

        $tasks = DB::table('tb_task')
                ->select('id_task','task_name','description','task_date')
                ->first();

        return view('HRGA/hrga', compact('lead', 'total_ter','notif','notifOpen','notifsd','notiftp','id_pro','datas','tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_cuti()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $cek = User::join('tb_cuti','tb_cuti.nik','=','users.nik','left')
                ->select('users.nik','cuti','cuti2','status_karyawan','status')->where('users.nik',$nik)->first();

        // return $cek;

        if ($cek->status == null) {
            $cek_cuti = User::select('users.nik','status_karyawan')->where('users.nik',$nik)->first();
        }else{
            $cek_cuti = User::join('tb_cuti','tb_cuti.nik','=','users.nik','left')
                ->select('users.nik','cuti','cuti2','status_karyawan','status')->where('users.nik',$nik)->orderBy('tb_cuti.id_cuti','desc')->first();
        }

        $total_cuti = $cek->cuti + $cek->cuti2;

        $client = new Client();
        $api_response = $client->get('https://www.googleapis.com/calendar/v3/calendars/en.indonesian%23holiday%40group.v.calendar.google.com/events?key='.env('GOOGLE_API_YEY'));
        $json = (string)$api_response->getBody();
        $datas_nasional = json_decode($json, true);  

        $bulan = date('F');
        $tahun_ini = date('Y');
        $tahun_lalu = date('Y') - 1;

        if ($ter != NULL) {
            if($div == 'SALES' && $pos == 'MANAGER'){

                $cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.pic', 'tb_cuti.updated_at','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory', 'users.id_company')
                    ->orderBy('date_req','DESC')
                    ->groupby('tb_cuti.id_cuti')
                    // ->where('tb_cuti.status','n')
                    ->where('users.id_division', 'SALES')
                    ->where('users.id_company','2')
                    ->groupby('nik')
                    ->get();

                $cuti2 = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory', 'users.id_company')
                    ->orderBy('date_req','DESC')
                    ->groupby('tb_cuti.id_cuti')
                    ->where('tb_cuti_detail.status','NEW')
                    ->where('users.id_division', 'SALES')
                    ->where('users.id_company','2')
                    ->groupby('nik')
                    ->get();
            } else{

                $cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.pic', 'tb_cuti.updated_at','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory', 'users.id_company')
                    ->orderBy('date_req','DESC')
                    ->groupby('tb_cuti.id_cuti')
                    // ->where('tb_cuti.status','n')
                    ->where('users.nik',$nik)
                    ->groupby('nik')
                    ->get();

                $cuti2 = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory', 'users.id_company')
                    ->orderBy('date_req','DESC')
                    ->groupby('tb_cuti.id_cuti')
                    ->where('tb_cuti_detail.status','NEW')
                    ->where('users.nik',$nik)
                    ->groupby('nik')
                    ->get();
            }
        }else{
            if (Auth::User()->id_company == 2 && Auth::User()->id_position == 'DIRECTOR' || $div == 'TECHNICAL' && $pos == 'MANAGER') {
                $cuti = DB::table('tb_cuti')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.pic', 'tb_cuti.updated_at','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason','users.id_company',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),DB::raw('group_concat(date_off) as date_off'))
                ->groupby('tb_cuti.id_cuti')
                ->where('users.id_company','2')
                ->get();

                $cuti2 = DB::table('tb_cuti')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason','users.id_company',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),DB::raw('group_concat(date_off) as date_off'))
                ->groupby('tb_cuti.id_cuti')
                ->where('tb_cuti_detail.status','NEW')
                ->where('users.id_company','2')
                ->get();
            } 
            // elseif($div == 'TECHNICAL' && $pos == 'MANAGER'){

            //     $cuti = DB::table('tb_cuti')
            //         ->join('users','users.nik','=','tb_cuti.nik')
            //         ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
            //         ->join('tb_position','tb_position.id_position','=','users.id_position')
            //         ->join('tb_division','tb_division.id_division','=','users.id_division')
            //         ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.pic', 'tb_cuti.updated_at','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory', 'users.id_company')
            //         ->orderBy('date_req','DESC')
            //         ->groupby('tb_cuti.id_cuti')
            //         // ->where('tb_cuti.status','n')
            //         ->where('users.id_company','2')
            //         ->groupby('nik')
            //         ->get();

            //     $cuti2 = DB::table('tb_cuti')
            //         ->join('users','users.nik','=','tb_cuti.nik')
            //         ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
            //         ->join('tb_position','tb_position.id_position','=','users.id_position')
            //         ->join('tb_division','tb_division.id_division','=','users.id_division')
            //         ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory', 'users.id_company')
            //         ->orderBy('date_req','DESC')
            //         ->groupby('tb_cuti.id_cuti')
            //         ->where('tb_cuti.status','n')
            //         ->where('users.id_company','2')
            //         ->groupby('nik')
            //         ->get();
            // } 
            else{
               $cuti = DB::table('tb_cuti')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.pic', 'tb_cuti.updated_at','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason','users.id_company',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),DB::raw('group_concat(date_off) as date_off'))
                ->where('users.nik',$nik)
                ->groupby('tb_cuti.id_cuti')
                ->get(); 

                $cuti2 = DB::table('tb_cuti')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason','users.id_company',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),DB::raw('group_concat(date_off) as date_off'))
                ->where('users.nik',$nik)
                ->where('tb_cuti_detail.status','NEW')
                ->groupby('tb_cuti.id_cuti')
                ->get(); 
            }
            
        }

        if ($ter != null) {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }else{
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_lead_register.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_lead_register.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'MANAGER') {
            $notifsd= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','SD')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'STAFF') {
            $notifsd= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','SD')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_lead_register.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'MANAGER') {
            $notiftp= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','TP')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'STAFF') {
            $notiftp= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','TP')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }

        if (Auth::User()->id_position == 'ADMIN') {
            $notifClaim = DB::table('dvg_esm')
                            ->select('nik_admin', 'personnel', 'type')
                            ->where('status', 'ADMIN')
                            ->get();
        } elseif (Auth::User()->id_position == 'HR MANAGER') {
            $notifClaim = DB::table('dvg_esm')
                            ->select('nik_admin', 'personnel', 'type')
                            ->where('status', 'HRD')
                            ->get();
        } elseif (Auth::User()->id_division == 'FINANCE') {
            $notifClaim = DB::table('dvg_esm')
                            ->select('nik_admin', 'personnel', 'type')
                            ->where('status', 'FINANCE')
                            ->get();
        }

        return view('HR/cuti', compact('notif','notifOpen','notifsd','notiftp','cuti', 'notifClaim','total_cuti','cek_cuti','cek', 'bulan','cuti2'));
    }

    public function store_cuti(Request $request)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position; 
        $company = DB::table('users')->select('id_company')->where('nik',$nik)->first();
        $com = $company->id_company;

        $nik = Auth::User()->nik;
        $date_now = date('Y-m-d');

        $array =  explode(',', $_POST['date_start']);

        $hitung = sizeof($array);
        
        $tambah = new Cuti();
        $tambah->nik = $nik;
        $tambah->date_req = $date_now;
        $tambah->reason_leave = $request['reason'];
        $tambah->jenis_cuti = $request['jenis_cuti'];
        $tambah->status = 'n';
        $tambah->save();

        foreach ($array as $dates) {
            $store = new CutiDetil();
            $store->id_cuti = $tambah->id_cuti;
            $format_start_s = strtotime($dates);
            $store->date_off = date("Y-m-d",$format_start_s);
            $store->status      = 'NEW';
            $store->save();
        }

        $id_cuti    = $tambah->id_cuti;
        $getStatus  = Cuti::select('status')->where('id_cuti',$id_cuti)->first();
        $status     = $getStatus->status;

        if ($ter != NULL) { 
            if ($ter == 'SALES MSP' && $pos == 'STAFF') {
                $nik_kirim = DB::table('users')->select('users.email')->where('id_position','MANAGER')->where('id_company','2')->first();
            }else if ($ter == 'OPERATION'){
                $nik_kirim = DB::table('users')->select('users.email')->where('email','sinung@solusindoperkasa.co.id')->where('id_company','2')->first();
            }
            
            // $kirim = User::where('email', $nik_kirim->email)->first()->email;

            // $kirim = User::where('email', 'faiqoh@sinergy.co.id')->first();

            $name_cuti = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->select('users.name','status')
                ->where('id_cuti', $id_cuti)->first();

            $hari_cuti = DB::table('tb_cuti')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.status',DB::raw('group_concat(date_off) as dates'))
                ->groupby('tb_cuti_detail.id_cuti')
                ->where('tb_cuti.id_cuti', $id_cuti)
                ->first();

            $ardetil = explode(',',$hari_cuti->dates);

            $ardetil_after = "";

            $hari = collect(['cuti_accept'=>$hari_cuti]);

            if($ter == 'SALES MSP' && $pos == 'STAFF'){
                Mail::to($nik_kirim)->cc(['yudhi@sinergy.co.id','ferry@solusindoperkasa.co.id'])->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[MSP-App] Permohonan Cuti'));         
            } else {
                Mail::to($nik_kirim)->cc('yudhi@sinergy.co.id')->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[MSP-App] Permohonan Cuti'));            
            }

        
        }else{
            if ($div == 'TECHNICAL' || $div == 'TECHNICAL PRESALES') {
                $nik_kirim = DB::table('users')->select('users.email')->where('email','sinung@solusindoperkasa.co.id')->where('id_company','2')->first();
            }else{
                 $nik_kirim = DB::table('users')->select('users.email')->where('email','ferry@solusindoperkasa.co.id')->where('id_company','2')->first();
            }
            
            //
            // $kirim = User::where('email', $nik_kirim->email)->first()->email;
            // $kirim = User::where('email', 'faiqoh@sinergy.co.id')->first();


            $name_cuti = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->select('users.name','tb_cuti.status')
                ->where('id_cuti', $id_cuti)->first();

            $hari_cuti = DB::table('tb_cuti')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.status',DB::raw('group_concat(date_off) as dates'))
                ->groupby('tb_cuti_detail.id_cuti')
                ->where('tb_cuti.id_cuti', $id_cuti)
                ->first();

            $ardetil = explode(',',$hari_cuti->dates);

            $ardetil_after = "";

            $hari = collect(['cuti_accept'=>$hari_cuti]);
            
            if($div == 'TECHNICAL' || $div == 'TECHNICAL PRESALES'){
                Mail::to($nik_kirim)->cc(['yudhi@sinergy.co.id','ferry@solusindoperkasa.co.id'])->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[MSP-App] Permohonan Cuti'));         
            } else {
                Mail::to($nik_kirim)->cc('yudhi@sinergy.co.id')->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[MSP-App] Permohonan Cuti'));            
            }
        }

        return redirect()->back();
    }

    public function update_done(Request $request){
        $id_cuti = $request['submit'];

        $nik = Cuti::select('nik')->where('id_cuti',$id_cuti)->first();

        $update_cuti = User::where('nik',$nik->nik)->first();
        $update_cuti->cuti = $update_cuti->cuti - $request['days'];
        $update_cuti->update();

        $update = Cuti::where('id_cuti',$id_cuti)->first();
        $update->status = 'v';
        $update->update();

        return redirect()->back();
    }

    public function approve_cuti(Request $request)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position; 
        $company = DB::table('users')->select('id_company')->where('nik',$nik)->first();
        $com = $company->id_company;

        $id_cuti = $request['id_cuti_detil'];
        $nik = $request['nik_cuti'];

        $update = Cuti::where('id_cuti',$id_cuti)->first();
        $update->decline_reason = $request['reason_reject'];
        $update->pic            = Auth::User()->name;
        $update->updated_at     = date('Y-m-d');
        $update->status = 'v';
        $update->update();

        $cuti_accept = explode(',', $request['cuti_fix_accept']);
        $cuti_reject = explode(',', $request['cuti_fix_reject']);

        $hitung = sizeof($cuti_accept);

        $update_cuti = User::where('nik',$nik)->first();
        
        if ($hitung >= $update_cuti->cuti) {
            Log::debug("$hitung >= $update_cuti->cuti");

            $ambil2020 = $hitung - $update_cuti->cuti;
            Log::debug("$ambil2020 = " . $ambil2020);            

            $hasilsisa = $update_cuti->cuti2 - $ambil2020;
            Log::debug("$hasilsisa = " . $hasilsisa); 

            if ($ambil2020 == 0) {
                $update_cuti->cuti = $update_cuti->cuti - $hitung;
            }else{
                $update_cuti->cuti = 0;
                $update_cuti->cuti2 = $hasilsisa;
            }

        }else{
            $update_cuti->cuti = $update_cuti->cuti - $hitung;
        }

        $update_cuti->update();

        $getStatus  = Cuti::select('status')->where('id_cuti',$id_cuti)->first();
        $status     = $getStatus->status;

        $nik_kirim = DB::table('tb_cuti')->join('users','users.nik','=','tb_cuti.nik')->select('users.email')->where('id_cuti',$id_cuti)->first();

        // $kirim = User::where('email','ladinar@sinergy.co.id')
        //                 ->get();

        $name_cuti = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->select('users.name')
                ->where('id_cuti', $id_cuti)->first();  

        if ($cuti_accept[0] != "") {
            foreach ($cuti_accept as $accept_dates) {
                $update = CutiDetil::where('idtb_cuti_detail',$accept_dates)->first();
                $update->status = 'ACCEPT';
                $update->update();
            }

            $cuti_accept_data = DB::table('tb_cuti')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.status',DB::raw('group_concat(date_off) as dates'),"decline_reason")
                ->groupby('tb_cuti_detail.id_cuti')->where('tb_cuti_detail.status','ACCEPT')
                ->where('tb_cuti.id_cuti', $id_cuti)
                ->first();
        }else{
            $ardetil_after = ""; 
        
            $cuti_accept_data = "";  
        }
        

        if ($cuti_reject[0] != "") {
            foreach ($cuti_reject as $reject_dates) {
                $update = CutiDetil::where('idtb_cuti_detail',$reject_dates)->first();
                $update->status = 'REJECT';
                $update->update();
            }

            $cuti_reject_data = DB::table('tb_cuti')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.status',DB::raw('group_concat(date_off) as dates'),"decline_reason")
                ->groupby('tb_cuti_detail.id_cuti')->where('tb_cuti_detail.status','REJECT')
                ->where('tb_cuti.id_cuti', $id_cuti) 
                ->first();

            $ardetil_after = explode(',', $cuti_reject_data->dates);

        }else{
            $ardetil_after = ""; 
        
            $cuti_reject_data = "";  
        }            

        $hari = collect(['cuti_accept'=>$cuti_accept_data,'cuti_reject'=>$cuti_reject_data]);
      
        $ardetil = explode(',', $cuti_accept_data->dates); 

        Mail::to($nik_kirim)->cc('yudhi@sinergy.co.id')->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[MSP-App] Approve - Permohonan Cuti'));        

        return redirect()->back();
    }

    public function decline_cuti(Request $request)
    {
        $id_cuti = $request['id_cuti_decline'];

        $update = Cuti::where('id_cuti',$id_cuti)->first();
        $update->decline_reason = $request['keterangan'];
        $update->status = 'd';
        $update->update();

        $nik_kirim = DB::table('tb_cuti')->join('users','users.nik','=','tb_cuti.nik')->select('users.email')->where('id_cuti',$id_cuti)->first();
            //
        // $kirim = User::where('email', $nik_kirim->email)->first()->email;

        $kirim = User::where('email', 'faiqoh@sinergy.co.id')->first();

        $name_cuti = DB::table('tb_cuti')
            ->join('users','users.nik','=','tb_cuti.nik')
            ->select('users.name')
            ->where('id_cuti', $id_cuti)->first();

        $hari = DB::table('tb_cuti')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.status','tb_cuti.decline_reason',DB::raw('group_concat(date_off) as dates'))
                ->groupby('tb_cuti_detail.id_cuti')
                ->where('tb_cuti.id_cuti', $id_cuti)
                ->first();

        $ardetil = explode(',', $hari->dates); 

        $ardetil_after = "";

        Mail::to($nik_kirim)->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[SIMS-App] Decline - Permohonan Cuti'));

        return redirect()->back();
    }

    public function detil_cuti(Request $request)
    {
        $cuti = $request->cuti;
            
        if ($request->pilih == 'date') {
            return array(DB::table('tb_cuti_detail')
                ->join('tb_cuti','tb_cuti.id_cuti','=','tb_cuti_detail.id_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->select('date_off','reason_leave','date_req','tb_cuti_detail.id_cuti','users.nik')
                ->where('tb_cuti_detail.id_cuti',$cuti)
                ->whereBetween('date_off',array($request->date_start,$request->date_end))
                ->get(),(int)$request->$cuti);
        }else{
            if ($request->status == 'detil') {
                return array(DB::table('tb_cuti_detail')
                ->join('tb_cuti','tb_cuti.id_cuti','=','tb_cuti_detail.id_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->select('date_off','reason_leave','date_req','tb_cuti_detail.id_cuti','users.nik','decline_reason','tb_cuti.status','tb_cuti_detail.status as status_detail','idtb_cuti_detail')
                ->where('tb_cuti_detail.id_cuti',$cuti)
                ->get(),(int)$request->$cuti);
            }else{
                return array(DB::table('tb_cuti_detail')
                ->join('tb_cuti','tb_cuti.id_cuti','=','tb_cuti_detail.id_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->select('date_off','reason_leave','date_req','tb_cuti_detail.id_cuti','users.nik','decline_reason','tb_cuti.status','tb_cuti_detail.status as status_detail','idtb_cuti_detail')
                ->where('tb_cuti_detail.id_cuti',$cuti)
                ->whereRaw("(`tb_cuti_detail`.`status` = 'NEW' OR `tb_cuti_detail`.`status` = 'ACCEPT' OR `tb_cuti_detail`.`status` = 'REJECT')")
                ->get(),(int)$request->$cuti);
            }
        }
        
        
    }

    public function update_cuti(Request $request)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position; 
        $company = DB::table('users')->select('id_company')->where('nik',$nik)->first();
        $com = $company->id_company;

        $id_cuti = $request['id_cuti'];

        $dates_after = $request['dates_after'];

        $dates_before = $request['dates_before'];

        if($dates_after == 'kosong') {
            $update = Cuti::where('id_cuti',$id_cuti)->first();
            $update->reason_leave = $request['reason_edit'];
            $update->status = $request['status_update'];
            $update->update();

        } else {
            $array2 = explode(',', $dates_after);

            $array  = explode(',', $dates_before);

            $resultA = array_diff($array, $array2);
            $resultB = array_diff($array2, $array);


            if ($resultA) {

                foreach ($resultA as $dates) {
                    $update_cuti            = CutiDetil::where('date_off',$dates)->where('id_cuti',$id_cuti)->first();
                    $update_cuti->status    = 'CANCEL';
                    $update_cuti->update();
                }

                foreach ($resultB as $dates) {
                    if (CutiDetil::where('id_cuti',$id_cuti)->whereIn('date_off',$resultB)->get() == '[]') {
                        $add            = new CutiDetil();
                        $add->id_cuti   = $id_cuti;
                        $format_start_s = strtotime($dates);
                        $add->date_off  = date("Y-m-d",$format_start_s);
                        $add->status    = 'NEW';
                        $add->save();  
                    }                                  

                    CutiDetil::where('id_cuti',$id_cuti)->whereIn('date_off',$array2)->update(['status' => 'NEW']);
                }
            }

            $update = Cuti::where('id_cuti',$id_cuti)->first();
            $update->reason_leave = $request['reason_edit'];
            $update->status = $request['status_update'];
            $update->update();

            if ($ter != NULL) { 
                if ($ter == 'SALES MSP' && $pos == 'STAFF') {
                    $nik_kirim = DB::table('users')->select('users.email')->where('id_position','MANAGER')->where('id_company','2')->first();
                }else if ($ter == 'OPERATION'){
                    $nik_kirim = DB::table('users')->select('users.email')->where('email','sinung@solusindoperkasa.co.id')->where('id_company','2')->first();
                }
                
                // $kirim = User::where('email', $nik_kirim->email)->first()->email;

                // $kirim = User::where('email', 'faiqoh@sinergy.co.id')->first();

                $name_cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->select('users.name','status')
                    ->where('id_cuti', $id_cuti)->first();

                $hari_cuti = DB::table('tb_cuti')
                        ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                        ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave',DB::raw("(CASE WHEN (tb_cuti.status = 'n') THEN 'R' ELSE tb_cuti.status END) as status"),DB::raw('group_concat(date_off) as dates'))
                        ->groupby('tb_cuti_detail.id_cuti')
                        ->where('tb_cuti.id_cuti', $id_cuti)
                        ->where('tb_cuti_detail.status','NEW')
                        ->first();

                $hari = collect(['cuti_accept'=>$hari_cuti]);

                $hari_before = $_POST['dates_before'];

                $ardetil = explode(',',$hari_before);

                $hari_after = $_POST['dates_after'];

                $ardetil_after = explode(',',$hari_after);

                if($ter == 'SALES MSP' && $pos == 'STAFF' ){
                    Mail::to($nik_kirim)->cc(['yudhi@sinergy.co.id','ferry@solusindoperkasa.co.id'])->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[MSP-App] Permohonan Cuti'));         
                } else {
                    Mail::to($nik_kirim)->cc('yudhi@sinergy.co.id')->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[MSP-App] Permohonan Cuti'));            
                }  
            
            }else{
                if ($div == 'TECHNICAL' || $div == 'TECHNICAL PRESALES') {
                    $nik_kirim = DB::table('users')->select('users.email')->where('email','sinung@solusindoperkasa.co.id')->where('id_company','2')->first();
                }else{
                     $nik_kirim = DB::table('users')->select('users.email')->where('email','ferry@solusindoperkasa.co.id')->where('id_company','2')->first();
                }
                
                //
                // $kirim = User::where('email', $nik_kirim->email)->first()->email;
                // $kirim = User::where('email', 'faiqoh@sinergy.co.id')->first();


                $name_cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->select('users.name','status')
                    ->where('id_cuti', $id_cuti)->first();

                $hari_cuti = DB::table('tb_cuti')
                        ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                        ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave',DB::raw("(CASE WHEN (tb_cuti.status = 'n') THEN 'R' ELSE tb_cuti.status END) as status"),DB::raw('group_concat(date_off) as dates'))
                        ->groupby('tb_cuti_detail.id_cuti')
                        ->where('tb_cuti.id_cuti', $id_cuti)
                        ->where('tb_cuti_detail.status','NEW')
                        ->first();

                $hari = collect(['cuti_accept'=>$hari_cuti]);

                $hari_before = $_POST['dates_before'];

                $ardetil = explode(',',$hari_before);

                $hari_after = $_POST['dates_after'];

                $ardetil_after = explode(',',$hari_after);

                if( $div == 'TECHNICAL' || $div == 'TECHNICAL PRESALES'){
                    Mail::to($nik_kirim)->cc(['yudhi@sinergy.co.id','ferry@solusindoperkasa.co.id'])->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[MSP-App] Permohonan Cuti'));         
                } else {
                    Mail::to($nik_kirim)->cc('yudhi@sinergy.co.id')->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[MSP-App] Permohonan Cuti'));            
                }
            }
        }

        return redirect()->back();
    }

    public function getCutiUsers(Request $request){

        $getcuti = User::select(
            'nik',
            DB::raw('DATEDIFF(NOW(),date_of_entry) AS date_of_entrys'),
            DB::raw('(CASE WHEN (cuti IS NULL) THEN 0 ELSE cuti END) as cuti'),
            DB::raw('(CASE WHEN (cuti2 IS NULL) THEN 0 ELSE cuti2 END) as cuti2'),
            DB::raw('sum(cuti + cuti2) AS total_cuti'),
            'date_of_entry'
        )->where('nik',$request->nik)
        ->groupby('users.nik')
        ->get();


        $getAllCutiDate = DB::table('tb_cuti_detail')
            ->select('date_off')
            ->whereIn('id_cuti',function($query){
                $query->select('id_cuti')
                    ->from('tb_cuti')
                    ->where('nik','=',Auth::user()->nik)
                    ->where('status', '<>', 'd');
            })
            ->pluck('date_off');

        return collect(["parameterCuti" => $getcuti[0],"allCutiDate" => $getAllCutiDate]);
    }

    public function getCutiAuth(Request $request){

        $getcuti = User::select('nik','name',DB::raw('DATEDIFF(NOW(),date_of_entry) AS date_of_entrys'),DB::raw('(CASE WHEN (cuti IS NULL) THEN 0 ELSE cuti END) as cuti'),DB::raw('(CASE WHEN (cuti2 IS NULL) THEN 0 ELSE cuti2 END) as cuti2'),DB::raw('sum(cuti + cuti2) AS total_cuti'),'date_of_entry','gambar')->where('nik',Auth::User()->nik)->groupby('users.nik')->get();

        return $getcuti;
    }

    public function delete_cuti($id_cuti)
    {
        $hapus = Cuti::find($id_cuti);
        $hapus->delete();

        return redirect()->back();
    }

    public function follow_up($id_cuti)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position; 
        $company = DB::table('users')->select('id_company')->where('nik',$nik)->first();
        $com = $company->id_company;

        if ($ter != NULL) {
            if ($ter == 'SALES MSP' && $pos == 'STAFF') {
                $nik_kirim = DB::table('users')->select('users.email')->where('id_position','MANAGER')->where('id_company','2')->first();
            }else if ($ter == 'OPERATION'){
                $nik_kirim = DB::table('users')->select('users.email')->where('email','sinung@solusindoperkasa.co.id')->where('id_company','2')->first();
            }
            
            // $kirim = User::where('email', $nik_kirim->email)->first()->email;
            // $kirim = User::where('email', 'faiqoh@sinergy.co.id')->first()->email;

            $name_cuti = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->select('users.name')
                ->where('id_cuti', $id_cuti)->first();

            $hari = DB::table('tb_cuti')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.status',DB::raw('group_concat(date_off) as dates'))
                    ->groupby('tb_cuti_detail.id_cuti')
                    ->where('tb_cuti.id_cuti', $id_cuti)
                    ->first();

            $ardetil = explode(',',$hari->dates);

            $ardetil_after = "";

            if($ter == 'SALES MSP' && $pos == 'STAFF'){
                Mail::to($nik_kirim)->cc('ferry@solusindoperkasa.co.id')->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[MSP-App] Permohonan Cuti'));         
            } else {
                Mail::to($nik_kirim)->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[MSP-App] Permohonan Cuti'));            
            }
            
            
        }else{
            if ($div == 'TECHNICAL' || $div == 'TECHNICAL PRESALES') {
                $nik_kirim = DB::table('users')->select('users.email')->where('email','sinung@solusindoperkasa.co.id')->where('id_company','2')->first();
            }else{
                 $nik_kirim = DB::table('users')->select('users.email')->where('email','ferry@solusindoperkasa.co.id')->where('id_company','2')->first();
            }
            
            // $kirim = User::where('email', 'faiqoh@sinergy.co.id')->get();
            
            // $kirim = User::where('email', $nik_kirim->email)->first()->email;

            $name_cuti = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->select('users.name')
                ->where('id_cuti', $id_cuti)->first();

            $hari = DB::table('tb_cuti')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.status',DB::raw('group_concat(date_off) as dates'))
                    ->groupby('tb_cuti_detail.id_cuti')
                    ->where('tb_cuti.id_cuti', $id_cuti)
                    ->first();

            $ardetil = explode(',',$hari->dates);

            $ardetil_after = "";

            if($div == 'TECHNICAL' || $div == 'TECHNICAL PRESALES'){
                Mail::to($nik_kirim)->cc('ferry@solusindoperkasa.co.id')->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[MSP-App] Permohonan Cuti'));         
            } else {
                Mail::to($nik_kirim)->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[MSP-App] Permohonan Cuti'));            
            }

            // Mail::to($nik_kirim)->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[MSP-App] Approve - Permohonan Cuti (Follow Up)'));
        }

        return redirect()->back()->with('success','Cuti Kamu udah di follow up ke Bos! Thanks.');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tambah = new Barang();
        $tambah->id_item = $request['id_item'];
        $tambah->item_name = $request['nama_item'];
        $tambah->quantity = $request['quantity'];
        $tambah->info = $request['info'];
        $tambah->save();

        return view('HRGA/hrga');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapus = Barang::find($id);
                $hapus->delete();

                return redirect()->to('/hrga');
    }

    public function getIdTask()
    {
        return array(DB::table('tb_task')
            ->select('id_task','task_name','description','task_date')
            ->get());
        
    }

}
