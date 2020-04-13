<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sales;
use App\User;
use DB;
use App\TenderProcess;
use Illuminate\Support\Collection;
use Auth;
use Month;
use PDF;
use Excel;
use App\solution_design;
use App\TB_Contact;
use App\QuoteMSP;
use App\SalesProject;
use App\PMO;
use App\PMOProgress;
use App\SalesHandover;
use App\POCustomer;
use App\PID;
use App\PIDRequest;
use App\PoNota;


use App\SalesChangeLog;

use Mail;
use App\Notifications\NewLead;
use App\Notifications\PresalesAssign;
use App\Notifications\PresalesReAssign;
use App\Notifications\RaiseToTender;
use App\Notifications\Result;
use App\Mail\MailResult;
use Notification;

class SALESController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');

        $year_now = date('Y');
    }
    
    public function index(Request $request)
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

        $cek_note = Sales::count('keterangan');

        $year_now = date('Y');

        if($div == 'TECHNICAL PRESALES' && $pos == 'STAFF' && $com == '2') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('tb_pid', 'tb_pid.lead_id', '=', 'sales_lead_register.lead_id','left')
                ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_solution_design.nik', 'sales_lead_register.status_sho','sales_lead_register.status_handover','sales_lead_register.keterangan', 'sales_lead_register.closing_date', 'sales_lead_register.keterangan', 'sales_lead_register.deal_price','sales_lead_register.year','tb_pid.status')
                ->where('sales_solution_design.nik', $nik)
                ->where('users.id_company','2')
                ->get();

            $leads = DB::table('sales_lead_register')
            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
            ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->join('tb_pid', 'tb_pid.lead_id', '=', 'sales_lead_register.lead_id','left')
            ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name', 'tb_contact.brand_name',
            'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.status_handover','sales_lead_register.nik','sales_lead_register.status_engineer','sales_lead_register.keterangan','sales_lead_register.year', 
                'sales_lead_register.closing_date', 'sales_lead_register.keterangan', 'sales_lead_register.deal_price','tb_pid.status')
            ->where('sales_solution_design.nik', $nik)
            ->where('users.id_company','2')
            ->where('year',$year_now)
            ->where('result','!=','hmm')
            ->get();
            
                $total_lead = count($leads);

                $total_open = DB::table('sales_lead_register')
                            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                            ->where('sales_lead_register.result','')
                            ->where('sales_solution_design.nik', $nik)
                            ->where('sales_lead_register.year',$year_now)
                            ->where('users.id_company','2')
                            ->count('sales_lead_register.lead_id');

                $total_sd = DB::table('sales_lead_register')
                            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                            ->where('sales_lead_register.result','SD')
                            ->where('sales_solution_design.nik', $nik)
                            ->where('sales_lead_register.year',$year_now)
                            ->where('users.id_company','2')
                            ->count('sales_lead_register.lead_id');

                $total_tp = DB::table('sales_lead_register')
                            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                            ->where('sales_lead_register.result','TP')
                            ->where('sales_solution_design.nik', $nik)
                            ->where('sales_lead_register.year',$year_now)
                            ->where('users.id_company','2')
                            ->count('sales_lead_register.lead_id');

                $total_win = DB::table('sales_lead_register')
                            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                            ->where('sales_lead_register.result','WIN')
                            ->where('sales_solution_design.nik', $nik)
                            ->where('sales_lead_register.year',$year_now)
                            ->where('users.id_company','2')
                            ->count('sales_lead_register.lead_id');

                $total_lose = DB::table('sales_lead_register')
                            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                            ->where('sales_lead_register.result','LOSE')
                            ->where('sales_solution_design.nik', $nik)
                            ->where('sales_lead_register.year',$year_now)
                            ->where('users.id_company','2')
                            ->count('sales_lead_register.lead_id');
             
                $total_leads = count($lead);

                $total_opens = DB::table('sales_lead_register')
                            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                            ->where('sales_lead_register.result','')
                            ->where('sales_solution_design.nik', $nik)
                            ->where('sales_lead_register.year','2018')
                            ->where('users.id_company','2')
                            ->count('sales_lead_register.lead_id');

                $total_sds = DB::table('sales_lead_register')
                            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                            ->where('sales_lead_register.result','SD')
                            ->where('sales_solution_design.nik', $nik)
                            ->where('sales_lead_register.year','2018')
                            ->where('users.id_company','2')
                            ->count('sales_lead_register.lead_id');

                $total_tps = DB::table('sales_lead_register')
                            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                            ->where('sales_lead_register.result','TP')
                            ->where('sales_solution_design.nik', $nik)
                            ->where('sales_lead_register.year','2018')
                            ->where('users.id_company','2')
                            ->count('sales_lead_register.lead_id');

                $total_wins = DB::table('sales_lead_register')
                            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                            ->where('sales_lead_register.result','WIN')
                            ->where('sales_solution_design.nik', $nik)
                            ->where('sales_lead_register.year','2018')
                            ->where('users.id_company','2')
                            ->count('sales_lead_register.lead_id');

                $total_loses = DB::table('sales_lead_register')
                            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                            ->where('sales_lead_register.result','LOSE')
                            ->where('sales_solution_design.nik', $nik)
                            ->where('sales_lead_register.year','2018')
                            ->where('users.id_company','2')
                            ->count('sales_lead_register.lead_id');

        } elseif($div == 'SALES' && $pos == 'STAFF' && $ter == 'SALES MSP' && $com == '2' ) {
            $lead = DB::table('sales_lead_register')
            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
            ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
            ->join('tb_pid', 'tb_pid.lead_id', '=', 'sales_lead_register.lead_id','left')
            ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name', 'tb_contact.brand_name',
            'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.status_handover','sales_lead_register.nik','sales_lead_register.status_engineer','sales_lead_register.keterangan', 'sales_lead_register.closing_date', 'sales_lead_register.keterangan', 'sales_lead_register.deal_price','sales_lead_register.year','tb_pid.status')
            ->where('users.id_company','2')
            ->where('sales_lead_register.nik',$nik)
            ->get();

            $leads = DB::table('sales_lead_register')
            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
            ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
            ->join('tb_pid', 'tb_pid.lead_id', '=', 'sales_lead_register.lead_id','left')
            ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name', 'tb_contact.brand_name',
            'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.status_handover','sales_lead_register.nik','sales_lead_register.status_engineer','sales_lead_register.keterangan', 'sales_lead_register.closing_date', 'sales_lead_register.keterangan', 'sales_lead_register.deal_price','tb_pid.status')
            ->where('users.id_company','2')
            ->where('sales_lead_register.nik',$nik)
            ->where('year',$year_now)
            ->where('result','!=','hmm')
            ->get();  

            $total_lead = count($leads);

            $total_open = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','')
                        ->where('users.id_company','2')
                        ->where('year',$year_now)
                        ->where('sales_lead_register.nik',$nik)
                        ->count('lead_id');

            $total_sd = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','SD')
                        ->where('users.id_company','2')
                        ->where('year',$year_now)
                        ->where('sales_lead_register.nik',$nik)
                        ->count('lead_id');

            $total_tp = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','TP')
                        ->where('users.id_company','2')
                        ->where('year',$year_now)
                        ->where('sales_lead_register.nik',$nik)
                        ->count('lead_id');

            $total_win = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','WIN')
                        ->where('users.id_company','2')
                        ->where('year',$year_now)
                        ->where('sales_lead_register.nik',$nik)
                        ->count('lead_id');

            $total_lose = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','LOSE')
                        ->where('users.id_company','2')
                        ->where('year',$year_now)
                        ->where('sales_lead_register.nik',$nik)
                        ->count('lead_id');

            $total_leads = count($lead);

            $total_opens = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','')
                        ->where('users.id_company','2')
                        ->where('year','2018')
                        ->count('lead_id');

            $total_sds = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','SD')
                        ->where('users.id_company','2')
                        ->count('lead_id');

            $total_tps = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','TP')
                        ->where('users.id_company','2')
                        ->where('year','2018')
                        ->count('lead_id');

            $total_wins = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','WIN')
                        ->where('users.id_company','2')
                        ->where('year','2018')
                        ->count('lead_id');

            $total_loses = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','LOSE')
                        ->where('users.id_company','2')
                        ->where('year','2018')
                        ->count('lead_id');

        } elseif($pos == 'DIRECTOR' || $div == 'TECHNICAL' && $pos == 'MANAGER') {

            $lead = DB::table('sales_lead_register')
            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
            ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
            ->join('tb_pid', 'tb_pid.lead_id', '=', 'sales_lead_register.lead_id','left')
            ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name', 'tb_contact.brand_name',
            'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.status_handover','sales_lead_register.nik','sales_lead_register.status_engineer','sales_lead_register.keterangan', 'sales_lead_register.closing_date', 'sales_lead_register.keterangan', 'sales_lead_register.deal_price','sales_lead_register.year','tb_pid.status')
            ->where('users.id_company','2')
            ->where('result','!=','hmm')
            ->get();

            $leads = DB::table('sales_lead_register')
            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
            ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
            ->join('tb_pid', 'tb_pid.lead_id', '=', 'sales_lead_register.lead_id','left')
            ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name', 'tb_contact.brand_name',
            'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.status_handover','sales_lead_register.nik','sales_lead_register.status_engineer','sales_lead_register.keterangan', 'sales_lead_register.closing_date', 'sales_lead_register.keterangan', 'sales_lead_register.deal_price','sales_lead_register.year','tb_pid.status')
            ->where('users.id_company','2')
            ->where('year',$year_now)
            ->where('result','!=','hmm')
            ->get();  

            $total_lead = count($leads);

            $total_open = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','')
                        ->where('users.id_company','2')
                        ->where('year',$year_now)
                        ->count('lead_id');

            $total_sd = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','SD')
                        ->where('users.id_company','2')
                        ->where('year',$year_now)
                        ->count('lead_id');

            $total_tp = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','TP')
                        ->where('users.id_company','2')
                        ->where('year',$year_now)
                        ->count('lead_id');

            $total_win = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','WIN')
                        ->where('users.id_company','2')
                        ->where('year',$year_now)
                        ->count('lead_id');

            $total_lose = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','LOSE')
                        ->where('users.id_company','2')
                        ->where('year',$year_now)
                        ->count('lead_id');

            $total_leads = count($lead);

            $total_opens = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','')
                        ->where('users.id_company','2')
                        ->where('year','2018')
                        ->count('lead_id');

            $total_sds = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','SD')
                        ->where('users.id_company','2')
                        ->count('lead_id');

            $total_tps = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','TP')
                        ->where('users.id_company','2')
                        ->where('year','2018')
                        ->count('lead_id');

            $total_wins = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','WIN')
                        ->where('users.id_company','2')
                        ->where('year','2018')
                        ->count('lead_id');

            $total_loses = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('sales_lead_register.result','LOSE')
                        ->where('users.id_company','2')
                        ->where('year','2018')
                        ->count('lead_id');

        }

        $year = DB::table('sales_lead_register')->select('year')->where('year','!=',NULL)->where('year','!=','2018')->groupBy('year')->get();

        $lead_id = $request['lead_id_edit'];

        $owner_by_lead = DB::table('sales_lead_register')
                        ->select('nik')
                        ->where('lead_id',$lead_id)
                        ->first();

        if ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $total_ter = DB::table("sales_lead_register")
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                        ->where('sales_solution_design.nik', $nik)
                        ->where('year','2018')
                        ->sum('amount');

            $total_ters = DB::table("sales_lead_register")
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                        ->where('sales_solution_design.nik', $nik)
                        ->where('year',$year_now)
                        ->sum('amount');
        }elseif ($div == 'SALES' && $pos == 'STAFF' && $ter == NULL && $com == 2) {
            $total_ter = DB::table("sales_lead_register")
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('id_company','2')
                        ->where('year','2018')
                        ->where('sales_lead_register.nik',$nik)
                        ->sum('amount');

            $total_ters = DB::table("sales_lead_register")
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('year',$year_now)
                        ->where('id_company','2')
                         ->where('sales_lead_register.nik',$nik)
                        ->sum('amount');
        }elseif ($com == 2 || $pos == 'DIRECTOR' && $com == '2' || $div == 'SALES' && $pos == 'MANAGER' && $ter == null) {
            $total_ter = DB::table("sales_lead_register")
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('id_company','2')
                        ->where('year','2018')
                        ->sum('amount');

            $total_ters = DB::table("sales_lead_register")
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('year',$year_now)
                        ->where('id_company','2')
                        ->sum('amount');
        }elseif ($div == 'PMO') {
            $total_ter = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_id_project', 'tb_id_project.lead_id', '=', 'sales_lead_register.lead_id')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.status_handover','users.nik', 'sales_lead_register.deal_price')
                    ->where('sales_lead_register.result','WIN')
                    ->where('year','2018')
                    ->SUM('amount');

            $total_ters = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_id_project', 'tb_id_project.lead_id', '=', 'sales_lead_register.lead_id')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.status_handover','users.nik', 'sales_lead_register.deal_price')
                    ->where('sales_lead_register.result','WIN')
                    ->where('year',$year_now)
                    ->SUM('amount');
        }elseif ($div == 'TECHNICAL' && $ter == 'DPG') {
            $total_ter = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.status_handover','users.nik', 'sales_lead_register.deal_price')
                    ->where('sales_lead_register.result','WIN')
                    ->where('year','2018')
                    ->SUM('amount');

            $total_ters = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.status_handover','users.nik', 'sales_lead_register.deal_price')
                    ->where('sales_lead_register.result','WIN')
                    ->where('year',$year_now)
                    ->SUM('amount');
        }else{
            $total_ter = DB::table("sales_lead_register")
                        ->where('year','2018')
                        ->sum('amount');

            $total_ters = DB::table("sales_lead_register")
                        ->where('year',$year_now)
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

        $users = DB::table('users')
                    ->select('nik','name','id_division')
                    ->where('id_division','PMO')
                    ->get();
        $users = $users->toArray();

        return view('sales/sales', compact('lead','leads', 'total_ter','total_ters','notif','notifOpen','notifsd','notiftp','id_pro','contributes','users','pmo_nik','owner_by_lead','total_lead','total_open','total_sd','total_tp','total_win','total_lose','total_leads','total_opens','total_sds','total_tps','total_wins','total_loses', 'notifClaim','cek_note','cek_initial','datas','rk','gp','st','leadspre','year','year_now'));
    }

    public function year_initial(Request $request)
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

        $years = Sales::select('year')->where('year',$request->product)->first();

        if ($div == 'TECHNICAL' && $pos == 'MANAGER' || $pos== 'DIRECTOR') {
            if ($years == NULL) {
                return array('0');
            }else{
                return  array(DB::table('sales_lead_register')
                ->join('users','users.nik','=','sales_lead_register.nik')
                ->select('year','result')
                ->where('result','!=','hmm')
                ->where('id_company','2')
                ->where('year',$request->product)
                ->get(),$request->product);
            }

        }else if ($div == "SALES" && $pos != 'ADMIN') {
            return  array(DB::table('sales_lead_register')
                ->join('users','users.nik','=','sales_lead_register.nik')
                ->select('year','result')
                ->where('result','!=','hmm')
                ->where('id_company','2')
                ->where('id_territory', $ter)
                ->where('year',$request->product)
                ->get(),$request->product);
        }else if($ter == 'OPERATION') {
            return  array(DB::table('sales_lead_register')
                ->join('users','users.nik','=','sales_lead_register.nik')
                ->select('year','result')
                ->where('result','!=','hmm')
                ->where('id_territory', $ter)
                ->where('id_company','2')
                ->where('year',$request->product)
                ->get(),$request->product);
        }else if ($div == "TECHNICAL PRESALES" && $pos == 'MANAGER') {
            return  array(DB::table('sales_lead_register')
                ->join('users','users.nik','=','sales_lead_register.nik')
                ->select('year','result')
                ->where('result','!=','hmm')
                ->where('id_company','2')
                ->where('year',$request->product)
                ->get(),$request->product);
        }else if ($div == "TECHNICAL PRESALES" && $pos == 'STAFF') {
            return  array(DB::table('sales_lead_register')
                ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                ->join('users','users.nik','=','sales_lead_register.nik')
                ->select('year','result')
                ->where('result','!=','hmm')
                ->where('id_company','2')
                ->where('sales_solution_design.nik',$nik)
                ->where('year',$request->product)
                ->get(),$request->product);
        }
        
    }

    public function year_open(Request $request)
    {
        return  array(DB::table('sales_lead_register')
                ->join('users','users.nik','=','sales_lead_register.nik')
                ->select('year','result')
                ->where('result','')
                ->where('id_company','2')
                ->where('year',$request->product)
                ->get(),$request->product);
    }

    public function year_sd(Request $request)
    {
        return  array(DB::table('sales_lead_register')
                ->join('users','users.nik','=','sales_lead_register.nik')
                ->select('year','result')
                ->where('result','SD')
                ->where('id_company','2')
                ->where('year',$request->product)
                ->get(),$request->product);
    }

    public function year_tp(Request $request)
    {
        return  array(DB::table('sales_lead_register')
                ->join('users','users.nik','=','sales_lead_register.nik')
                ->select('year','result')
                ->where('result','TP')
                ->where('id_company','2')
                ->where('year',$request->product)
                ->get(),$request->product);
    }

    public function year_win(Request $request)
    {
        return  array(DB::table('sales_lead_register')
                ->join('users','users.nik','=','sales_lead_register.nik')
                ->select('year','result')
                ->where('result','WIN')
                ->where('id_company','2')
                ->where('year',$request->product)
                ->get(),$request->product);
    }

    public function year_lose(Request $request)
    {
        return  array(DB::table('sales_lead_register')
                ->join('users','users.nik','=','sales_lead_register.nik')
                ->select('year','result')
                ->where('result','LOSE')
                ->where('id_company','2')
                ->where('year',$request->product)
                ->get(),$request->product);
    }

    public function detail_sales($lead_id)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;
        $company = DB::table('users')->select('id_company')->where('nik', $nik)->first();
        $com = $company->id_company;

        if($ter != null){
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name', 'tb_contact.brand_name','sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.status_handover')
                ->where('id_territory', $ter)
                ->get();
        } elseif($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_solution_design.nik', 'sales_lead_register.status_sho','sales_lead_register.status_handover')
                ->where('sales_solution_design.nik', $nik)
                ->get();
        }elseif($div == 'PMO' && $pos == 'MANAGER') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.status_handover')
                ->where('sales_lead_register.result','WIN')
                ->get();
        }
        elseif($div == 'FINANCE' && $pos == 'MANAGER') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name','sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.status_handover','sales_lead_register.nik')
                ->where('sales_lead_register.result','WIN')
                ->get();
        }
        elseif($pos == 'ENGINEER MANAGER') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name','sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.status_handover','sales_lead_register.nik','sales_lead_register.status_engineer')
                ->where('sales_lead_register.result','WIN')
                ->where('sales_lead_register.status_sho','PMO')
                ->get();
        }
        elseif($pos == 'ENGINEER STAFF') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('tb_engineer','sales_lead_register.lead_id','=','tb_engineer.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name','sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.status_handover','sales_lead_register.nik','sales_lead_register.status_engineer')
                ->where('sales_lead_register.result','WIN')
                 ->where('tb_engineer.nik',$nik)
                ->get();
        }
        else {
              $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name', 'tb_contact.brand_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.status_handover','sales_lead_register.nik')
                ->get();
        }
        
        $tampilkan = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id','sales_lead_register.nik','tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'sales_lead_register.deal_price', 'users.name', 'sales_lead_register.result', 'sales_lead_register.result2','sales_lead_register.result3','sales_lead_register.status_sho','sales_lead_register.status_handover','sales_lead_register.status_engineer', 'sales_lead_register.id_customer', 'deal_price')
                    ->where('lead_id',$lead_id)
                    ->first();

        if ($div == 'SALES' && $ter == null) {
            $tampilkans = DB::table('sales_solution_design')
                    ->join('users','users.nik','=','sales_solution_design.nik')
                    ->select('sales_solution_design.lead_id','sales_solution_design.nik','sales_solution_design.assessment','sales_solution_design.pov','sales_solution_design.pd','sales_solution_design.pb','sales_solution_design.priority','sales_solution_design.project_size','users.name','sales_solution_design.status', 'sales_solution_design.assessment_date', 'sales_solution_design.pd_date', 'sales_solution_design.pov_date')
                    ->where('lead_id',$lead_id)
                    ->first();

            $tampilkan_com = DB::table('sales_lead_register')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->select('users.id_company')
                    ->where('lead_id',$lead_id)
                    ->first();
        }else{
            $tampilkans = DB::table('sales_solution_design')
                    ->join('users','users.nik','=','sales_solution_design.nik')
                    ->select('sales_solution_design.lead_id','sales_solution_design.nik','sales_solution_design.assessment','sales_solution_design.pov','sales_solution_design.pd','sales_solution_design.pb','sales_solution_design.priority','sales_solution_design.project_size','users.name','sales_solution_design.status', 'sales_solution_design.assessment_date', 'sales_solution_design.pd_date', 'sales_solution_design.pov_date')
                    ->where('lead_id',$lead_id)
                    ->first();

            $tampilkan_com = DB::table('sales_lead_register')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->select('users.id_company')
                    ->where('lead_id',$lead_id)
                    ->first();
        }

        $tampilkana = DB::table('sales_solution_design')
                    ->join('users','users.nik','=','sales_solution_design.nik')
                    ->select('sales_solution_design.lead_id','sales_solution_design.nik','sales_solution_design.assessment','sales_solution_design.pov','sales_solution_design.pd','sales_solution_design.pb','sales_solution_design.priority','sales_solution_design.project_size','users.name','sales_solution_design.status', 'sales_solution_design.assessment_date', 'sales_solution_design.pd_date', 'sales_solution_design.pov_date','sales_solution_design.id_sd')
                    ->where('lead_id',$lead_id)
                    ->get();

        $engineer_contribute = DB::table('tb_engineer')
                    ->join('users','users.nik','=','tb_engineer.nik')
                    ->select('tb_engineer.id_engineer','users.name')
                    ->where('lead_id',$lead_id)
                    ->get();

        $tampilkanc = DB::table('sales_tender_process')
                    ->join('sales_lead_register', 'sales_tender_process.lead_id', '=', 'sales_lead_register.lead_id')
                    ->select('sales_tender_process.lead_id','auction_number','submit_price','win_prob','project_name','submit_date','quote_number','status','result','sales_lead_register.nik', 'sales_tender_process.assigned_by','quote_number2', 'sales_lead_register.amount', 'sales_lead_register.deal_price', 'sales_lead_register.deal_price_total', 'sales_lead_register.jumlah_tahun', 'sales_lead_register.project_class','id_tp')
                    ->where('sales_tender_process.lead_id',$lead_id)
                    ->first();

        $tampilkan_po = POCustomer::select('date','no_po','nominal','note','id_tb_po_cus')->where('lead_id',$lead_id)->get();

        $get_quote_number = DB::table('tb_quote_msp')
                            ->join('tb_contact', 'tb_contact.id_customer', '=', 'tb_quote_msp.customer_id')
                            ->select('id_quote', 'quote_number', 'customer_legal_name')
                            ->where('status', null)
                            ->where('customer_id', $tampilkan->id_customer)
                            ->orderBy('quote_number', 'desc')
                            ->get();

        $tampilkan_progress = DB::table('tb_pmo_progress')
                    ->join('tb_pmo','tb_pmo_progress.id_pmo','=','tb_pmo.id_pmo')
                    ->select('tb_pmo.lead_id','tb_pmo_progress.ket','tb_pmo_progress.tanggal','tb_pmo.id_pmo','tb_pmo_progress.updated_at')
                    ->where('tb_pmo.lead_id',$lead_id)
                    ->get();

        $tampilkan_progress_engineer = DB::table('tb_engineer_progress')
                    ->join('tb_engineer','tb_engineer_progress.id_engineer','=','tb_engineer.id_engineer')
                    ->select('tb_engineer.lead_id','tb_engineer_progress.ket','tb_engineer.id_engineer')
                    ->where('tb_engineer.lead_id',$lead_id)
                    ->get();

        // $pmo_id = DB::table('tb_pmo')
        //             ->join('users','tb_pmo.pmo_nik','=','users.nik')
        //             ->select('tb_pmo.id_pmo','users.name')
        //             ->where('lead_id',$lead_id)
        //             ->first();

        $sd_id = DB::table('sales_solution_design')
                ->join('users','users.nik','=','sales_solution_design.nik')
                ->select('sales_solution_design.id_sd','users.name')
                ->where('lead_id',$lead_id)
                ->first();

        if ($com == 1 && $div == 'TECHNICAL PRESALES') {
            $pre_cont = DB::table('users')
                ->select('name')
                ->where('id_company','1')
                ->where('id_division','TECHNICAL PRESALES')
                ->get();
        }else if($com == 2 && $div == 'TECHNICAL PRESALES'){
            $pre_cont = DB::table('users')
                ->select('name')
                ->where('id_company','1')
                ->where('id_division','TECHNICAL PRESALES')
                ->get();
        }
        

        $engineer_id = DB::table('tb_engineer')
                    ->join('users','tb_engineer.nik','=','users.nik')
                    ->select('tb_engineer.id_engineer','users.name')
                    ->where('lead_id',$lead_id)
                    ->first();

        $current_eng = DB::table('tb_engineer')
                    ->join('users','tb_engineer.nik','=','users.nik')
                    ->select('tb_engineer.id_engineer','users.name')
                    ->where('lead_id',$lead_id)
                    ->first();

        $q_num = DB::table('sales_tender_process')
                ->select('quote_number')
                ->where('lead_id',$lead_id)
                ->first();

        $q_num2 = DB::table('sales_tender_process')
                ->join('tb_quote','sales_tender_process.quote_number','=','tb_quote.id_quote')
                ->select('tb_quote.quote_number')
                ->where('lead_id',$lead_id)
                ->first();

        $change_log = DB::table('sales_change_log')
                        ->join('sales_lead_register', 'sales_change_log.lead_id', '=', 'sales_lead_register.lead_id')
                        ->join('users', 'sales_change_log.nik', '=', 'users.nik')
                        ->select('sales_change_log.created_at', 'sales_lead_register.opp_name', 'sales_change_log.status', 'users.name', 'sales_change_log.submit_price')
                        ->where('sales_change_log.lead_id',$lead_id)
                        ->get();

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
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }else{
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }


        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER' ) {
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
            ->select('sales_lead_register.opp_name','sales_solution_design.nik')
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

        return view('sales/detail_sales',compact('pre_cont','lead','tampilkan','tampilkans','tampilkan_com', 'tampilkana', 'tampilkanc','notif','notifOpen','notifsd','notiftp','tampilkan_progress','pmo_id','engineer_id','current_eng','tampilkan_progress_engineer','pmo_contribute','engineer_contribute','q_num','sd_id', 'get_quote_number', 'q_num2', 'change_log','notifClaim', 'tampilkan_po'));
    }

    public function getdatacustomer(Request $request)
    {
        $id_cus = $request['edit_cus'];

        return array(DB::table('tb_contact')
                ->select('id_customer','code','customer_legal_name','brand_name','office_building','street_address','city','province','postal','phone')
                ->where('id_customer',$request->id_cus)
                ->get(),$request->id_cus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getleadpid(Request $request)
    {
        return array(DB::table('sales_lead_register')
                ->join('users','users.nik','=','sales_lead_register.nik')
                ->join('tb_pid','tb_pid.lead_id','=','sales_lead_register.lead_id')
                ->join('tb_quote_msp','tb_quote_msp.id_quote','=','tb_pid.no_quo','left')
                ->where('sales_lead_register.lead_id',$request->lead_sp)
                ->select('amount_pid','no_po','date_po','opp_name','sales_lead_register.lead_id','tb_quote_msp.date','tb_quote_msp.amount')
                ->get(),$request->lead_sp);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        $contact = $request['contact'];
        $name = DB::table('tb_contact')
                    ->select('code')
                    ->where('id_customer', $contact)
                    ->first();
        $inc = DB::table('sales_lead_register')
                    ->select('lead_id')
                    ->where('id_customer', $contact)
                    ->where('month_msp', date("n"))
                    ->where('year',date("Y"))
                    ->get();
        $increment = count($inc);
        $nomor = $increment+1;
        if($nomor < 10){
            $nomor = '0' . $nomor;
        }
        $lead = 'MSP' . $name->code . date('y') . date('m') . $nomor;

        $tambah = new Sales();
        $tambah->lead_id = $lead;
        if(Auth::User()->id_division == 'SALES'){
            $tambah->nik = Auth::User()->nik;
        } else {
            $tambah->nik = $request['owner_sales'];
        }
        $tambah->id_customer = $request['contact'];
        $tambah->opp_name = $request['opp_name'];
        $tambah->month_msp = date("n");
        $tambah->year = date("Y");
        // $tambah->amount = $request['amount'];
        if ($request['amount'] != NULL) {
           $tambah->amount = str_replace(',', '', $request['amount']);
        }else{
            $tambah->amount = $request['amount'];
        }
        $tambah->result     = 'TP';
        $edate              = strtotime($_POST['closing_date']); 
        $edate              = date("Y-m-d",$edate);

        $tambah->closing_date = $edate;
        $tambah->save();

        $tambah_sd          = new solution_design();
        $tambah_sd->lead_id = $lead;
        $tambah_sd->status  = 'closed';
        $tambah_sd->nik     = Auth::User()->nik;
        $tambah_sd->save();

        $tambahtp          = new TenderProcess();
        $tambahtp->status  = 'ready'; 
        $tambahtp->lead_id = $lead;
        $tambahtp->save();

        $tambahcl           = new SalesChangeLog();
        $tambahcl->lead_id  = $lead;
        $tambahcl->nik      = Auth::User()->nik;
        $tambahcl->status   = 'Create Lead';
        $tambahcl->save();

        return redirect('project')->with('success', 'Create Lead Register Successfully!');
    
    }

    public function update_lead_register(Request $request){
        $lead_id = $request['lead_id_edit'];

        $date_edit_year = substr($request['create_date_edit'],2,2);
        $date_edit_month = substr($request['create_date_edit'],5,2);
        $leads = DB::table('sales_lead_register')
                ->select('lead_id')
                ->where('lead_id',$lead_id)
                ->first();
        $inc = substr($leads->lead_id,8);
        $name = $request['contact_edit'];
        $contact = DB::table('tb_contact')
                    ->select('code')
                    ->where('id_customer', $name)
                    ->first();
/*
        $lead_id_edit =  $name . $date_edit_year . $date_edit_month .$inc;*/

        $update = Sales::where('lead_id',$lead_id)->first();
        $update->opp_name   = $request['opp_name_edit'];
        // $update->id_customer = $request['contact_edit'];
        if ($request['amount_edit'] != NULL) {
            $update->amount = str_replace(',', '', $request['amount_edit']);
        }else{
            $update->amount = $request['amount_edit'];
        }
        // $update->created_at = $request['create_date_edit'];
        $edate_edit = strtotime($_POST['closing_date_edit']); 
        $edate_edit = date("Y-m-d",$edate_edit);

        $update->closing_date = $edate_edit;
        $update->keterangan = $request['note_edit'];
        $update->update();

        return redirect()->back(); 
    }

    public function assign_to_presales(Request $request){

        $tambah = new solution_design();
        $tambah->lead_id = $request['coba_lead'];
        $tambah->nik = $request['owner'];
        $tambah->save();

        $tambahtp = new TenderProcess();
        $tambahtp->lead_id = $request['coba_lead'];
        $tambahtp->save();

        $lead_id = $request['coba_lead'];

        $update = Sales::where('lead_id', $lead_id)->first();
        $update->result = '';
        $update->update();

        $tambah = new SalesChangeLog();
        $tambah->lead_id = $request['coba_lead'];
        $tambah->nik = $request['cek_nik'];
        $tambah->status = 'Create Lead';
        $tambah->created_at = $request['cek_created_at'];
        $tambah->save();

        $tambah = new SalesChangeLog();
        $tambah->lead_id = $request['coba_lead'];
        $tambah->nik = Auth::User()->nik;
        $tambah->status = 'Assign Presales';
        $tambah->save();

        $nik_assign = $request['owner'];

        $kirim = User::select('email')->where('nik', $nik_assign)->first();

        $users = User::where('email','arkhab@sinergy.co.id')->first();
        Notification::send($kirim, new PresalesAssign());

        return redirect('project');

        // echo $request['coba_lead'];
    }

    public function reassign_to_presales(Request $request)
    {
        $lead_id = $request['coba_lead_reassign'];

        $update = solution_design::where('lead_id', $lead_id)->first();
        $update->nik = $request['owner_reassign'];
        $update->update();

        $tambah = new SalesChangeLog();
        $tambah->lead_id = $request['coba_lead_reassign'];
        $tambah->nik = Auth::User()->nik;
        $tambah->status = 'Re-Assign Presales';
        $tambah->save();

        $nik_assign = $request['owner_reassign'];

        $kirim = User::select('email')->where('nik', $nik_assign)->first();

        $users = User::where('email','arkhab@sinergy.co.id')->first();
        Notification::send($kirim, new PresalesReAssign());

        return redirect('project');
    }

    public function add_contribute(Request $request)
    {
        $tambah = new solution_design();
        $tambah->lead_id = $request['coba_lead_contribute'];
        $tambah->nik = $request['add_contribute'];
        $tambah->save();

        return redirect()->back();
    }

    public function add_changelog_progress(Request $request) {

        $tambah = new SalesChangeLog();
        $tambah->lead_id = $request['changelog_lead_id'];
        $tambah->nik = Auth::User()->nik;
        $tambah->status = $request['changelog_progress'];
        $tambah->progress_date = $request['changelog_date'];
        $tambah->deal_price = null;
        $tambah->submit_price = null;
        $tambah->save();

        return redirect()->back();

    }

    public function delete_contribute_sd(Request $request)
    {
        $hapus = solution_design::find($request->id_sd);
        $hapus->delete();

        return redirect()->back();
    }

    public function raise_to_tender(Request $request){
        $lead_id = $request['lead_id'];

        $update = TenderProcess::where('lead_id', $lead_id)->first();
        $update->status = 'ready';
        $update->update();

        $update = solution_design::where('lead_id', $lead_id)->first();
        $update->status = 'closed';
        $update->update();

        $update = Sales::where('lead_id', $lead_id)->first();
        $update->result = 'TP';
        $update->update();

        $tambah = new SalesChangeLog();
        $tambah->lead_id = $request['lead_id'];
        $tambah->nik = Auth::User()->nik;
        $tambah->status = 'Raise To Tender';
        $tambah->save();

        $nik_sales = DB::table('sales_lead_register')
                    ->select('nik')
                    ->where('lead_id',$lead_id)
                    ->first();

        $kirim = User::select('email')
                        ->where('nik', $nik_sales->nik)
                        ->orWhere('email', 'nabil@sinergy.co.id')
                        ->get();

        $users = User::where('email','arkhab@sinergy.co.id')->first();
        Notification::send($kirim, new RaiseToTender());

        return redirect()->back();
    }

    public function update_result(Request $request){
            
            $lead_id = $request['lead_id_result'];  

            if ($request['quote_number_final'] != NULL) {
                $id_quotes = QuoteMSP::where('quote_number', $request['quote_number_final'])->first()->id_quote;

                $amount_quo = QuoteMSP::where('quote_number', $request['quote_number_final'])->first()->amount;
            }

            if ($request['result'] == 'WIN' && $request['deal_price_result'] == null) {
                return back()->with('deal-price','Deal Price Wajid Diisi!');
            } else{
                $update = Sales::where('lead_id', $lead_id)->first();
                $update->result = $request['result'];
                $update->keterangan = $request['keterangan'];
                $update->result4    = $request['project_type'];
                $update->update();

                if($request['result'] != 'HOLD'){
                    $update = TenderProcess::where('lead_id', $lead_id)->first();
                    $update->status = 'closed';
                    $update->update();
                }

                $tambah = new SalesChangeLog();
                $tambah->lead_id = $request['lead_id_result'];
                $tambah->nik = Auth::User()->nik;
                if($request['result'] == 'WIN'){

                    $tambah->status = 'Update WIN';
                    $tambahpid              = new PID();
                    $tambahpid->lead_id     = $request['lead_id_result'];
                    $tambahpid->no_po       = $request['no_po'];
                    $tambahpid->no_quo      = $id_quotes;
                    if ($request['amount_pid'] != NULL) {
                        $tambahpid->amount_pid  = str_replace(',', '',$request['amount_pid']);
                    }else{
                        $tambahpid->amount_pid  = $amount_quo;
                    }
                    
                    if ($request['date_po'] != NULL) {
                        $edate                  = strtotime($_POST['date_po']); 
                        $edate                  = date("Y-m-d",$edate);
                        $tambahpid->date_po     = $edate;
                    }                    
                    $tambahpid->status      = 'pending';
                    $tambahpid->save();

                    $update_quo = TenderProcess::where('lead_id', $lead_id)->first();
                    $update_quo->quote_number_final = $request['quote_number_final'];
                    $update_quo->update();

                    $update_status_quo = QuoteMSP::where('quote_number', $request['quote_number_final'])->first();
                    if ($request['quote_number_final'] != NULL) {
                        $update_status_quo->status = 'choosed';
                    }
                    $update_status_quo->update();

                    if ($request['no_po'] != null) {
                        $cek_po = PID::select('no_po')->where('lead_id', $lead_id)->first();
                        $tambah_po = new PoNota();
                        if ($cek_po->no_po != null) {
                            $tambah_po->no_po = $request['no_po'];
                        }
                        $tambah_po->save();
                    }
                    
                    
                } elseif($request['result'] == 'LOSE'){
                    $tambah->status = 'Update LOSE';
                } elseif($request['result'] == 'HOLD'){
                    $tambah->status = 'Update HOLD';
                } elseif($request['result'] == 'CANCEL'){
                    $tambah->status = 'Update CANCEL';
                }
                $tambah->save();

            }  

            $nik_sales = DB::table('sales_lead_register')
                            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                            ->select('sales_lead_register.nik', 'users.id_territory')
                            ->where('lead_id',$lead_id)
                            ->first();

            $current_presales = DB::table('sales_solution_design')
                                    ->join('users','users.nik','=','sales_solution_design.nik')
                                    ->select('sales_solution_design.nik')
                                    ->where('lead_id',$lead_id)
                                    ->first();

            $presales_manager = DB::table('users')
                                    ->select('nik')
                                    ->where('id_position', 'MANAGER')
                                    ->where('id_division', 'TECHNICAL PRESALES')
                                    ->first();

            // if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES' && Auth::User()->id_territory == $nik_sales->id_territory){
            //     $kirim = User::select('email')
            //                     ->where('id_division', 'TECHNICAL PRESALES')
            //                     ->where('nik', $current_presales->nik)
            //                     ->orWhere('nik', $presales_manager->nik)
            //                     ->orWhere('email', 'nabil@sinergy.co.id')
            //                     ->orWhere('email', 'yuliane@sinergy.co.id')
            //                     ->get();
            // } elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'SALES' && Auth::User()->id_territory == $nik_sales->id_territory){
            //     $kirim = User::select('email')
            //                     ->where('id_position', 'MANAGER')
            //                     ->where('id_division', 'SALES')
            //                     ->where('id_territory', $nik_sales->id_territory)
            //                     ->orWhere('nik', $current_presales->nik)
            //                     ->orWhere('nik', $presales_manager->nik)
            //                     ->orWhere('email', 'nabil@sinergy.co.id')
            //                     ->orWhere('email', 'yuliane@sinergy.co.id')
            //                     ->get();
            // } elseif(Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER'){
            //     $kirim = User::select('email')
            //                     ->where('id_position', 'MANAGER')
            //                     ->where('id_division', 'SALES')
            //                     ->where('id_territory', $nik_sales->id_territory)
            //                     ->orWhere('nik', $current_presales->nik)
            //                     ->orWhere('nik', $presales_manager->nik)
            //                     ->orWhere('email', 'nabil@sinergy.co.id')
            //                     ->orWhere('email', 'yuliane@sinergy.co.id')
            //                     ->get();
            // }

            
            // Notification::send($users, new Result()); 
            // Mail::to($users)->send(new MailResult($users));  
            
            

            // return view('mail.MailResult',compact('users')); 

        return redirect()->back();
    }

    public function update_next_status(Request $request){
        $lead_id = $request['lead_id_result2'];        

        $update = Sales::where('lead_id', $lead_id)->first();
        $update->result2 = $request['result2'];
        $update->update();

        return redirect()->back();
    }

    public function update_sd(Request $request, $lead_id)
    {
        $update = solution_design::where('lead_id', $lead_id)->first();

        // if($request['project_budget'] != $request['project_budget_before']){
        //    $update->pb = $request['project_budget'];
        //    $update->update();
        //   }

        // if ($request['assesment'] == $request['assesment']) {
          if($request['assesment'] != $request['assesment_before']){
            $update->assessment = $request['assesment'];
            $update->assessment_date = date('Y-m-d H:i:s');
            $update->update();
          } else {
            $update->assessment = $request['assesment'];
            $update->assessment_date = $request['assesment_date_before'];
            $update->update();
          }

          if($request['propossed_design'] != $request['pd_before']){
            $update->pd = $request['propossed_design'];
            $update->pd_date = date('Y-m-d H:i:s');
            $update->update();
          } else {
            $update->pd = $request['propossed_design'];
            $update->pd_date = $request['pd_date_before'];
            $update->update();
          }

          if($request['pov'] != $request['pov_before']){
            $update->pov = $request['pov'];
            $update->pov_date = date('Y-m-d H:i:s');
            $update->update();
          } else {
            $update->pov = $request['pov'];
            $update->pov_date = $request['pov_date_before'];
            $update->update();
          }

          if(str_replace(',', '',$request['project_budget']) <= $request['amount_check']){
            if($request['project_budget'] != $request['project_budget_before']){
                $update->pb = str_replace(',', '',$request['project_budget']);
                $update->update();
            }
          } else {
            return back()->with('warning','Project Budget melebihi Amount!');
          }

          // if($request['project_budget'] != $request['project_budget_before']){
          //   $update->pb = $request['project_budget'];
          //   $update->update();
          // }

          $update->priority = $request['priority'];
          $update->project_size = $request['proyek_size'];
          $update->update();

        //   elseif($request['assesment'] == TRUE){
        //     $update->assessment = $request['assesment'];
        //     $update->assessment_date = date('Y-m-d H:i:s');
        //     $update->update();
        //   }
        //     $update->assessment = $request['assesment'];
        //     $update->update();
        // }else if ($request['assesment'] == TRUE) {
        //     $update->assessment = $request['assesment'];
        //     $update->assessment_date = date('Y-m-d H:i:s');
        //     $update->update();
        // }

        // if (is_null($request['propossed_design'])) {
        //    $update->pd = $request['propossed_design'];
        //    $update->update();
        // }else if ($request['propossed_design'] == TRUE) {
        //    $update->pd = $request['propossed_design'];
        //    $update->pd_date = date('Y-m-d H:i:s');
        //    $update->update(); 
        // }

        // if ( is_null($request['pov'])) {
        //   $update->pov = $request['pov'];
        //   $update->update();  
        // }else if ( $request['pov'] == TRUE) {
        //    $update->pov = $request['pov'];
        //    $update->pov_date = date('Y-m-d H:i:s');
        //    $update->update();   
        // }

        // if (is_null($request['project_budget'])) {   
        //     // $update->pb = $request['project_budget'];
        //     $update->pb = $format_rupiah;
        //     $update->update();
        // }else if ( $request['project_budget'] == TRUE) {
        //    // $update->pb = $request['project_budget'];
        //    $update->pb = $format_rupiah;
        //    $update->update();
        // }

        // if ( is_null($request['priority'])) {
        //   $update->priority = $request['priority'];
        //   $update->update();  
        // }else if ( $request['priority'] == TRUE) {
        //    $update->priority = $request['priority'];
        //    $update->update();   
        // }

        // if ($request['proyek_size'] == '') {   
        //     $update->project_size = $request['proyek_size'];
        //     $update->update();
        // }else if ( $request['proyek_size'] == TRUE) {
        //    $update->project_size = $request['proyek_size'];
        //    $update->update();   
        // }

        $lead_id = $request['lead_id'];        

        $update = Sales::where('lead_id', $lead_id)->first();
        $update->result = 'SD';
        $update->update();

        $tambah = new SalesChangeLog();
        $tambah->lead_id = $request['lead_id'];
        $tambah->nik = Auth::User()->nik;
        $tambah->status = 'Update SD';
        $tambah->save();

        return redirect()->back();
    }

    public function update_tp(Request $request, $lead_id)
    {
        $update = TenderProcess::where('lead_id', $lead_id)->first();


        if($request['submit_price'] != $request['submit_price_before']){
           $update->submit_price = $request['submit_price'];
           $update->update();
          }

        if (is_null( $request['lelang'])) {
           $update->auction_number = $request['lelang'];
           $update->update();
        }else if ($request['lelang'] == TRUE) {
            $update->auction_number = $request['lelang'];
            $update->update();
        }

        if (is_null($request['submit_price'])) {
           $update->submit_price = str_replace(',', '', $request['submit_price']);
           $update->update();
        }else if ($request['submit_price'] == TRUE) {
           $update->submit_price = str_replace(',', '', $request['submit_price']);
           $update->update(); 
        }

        if ( is_null($request['win_prob'])) {
          $update->win_prob = $request['win_prob'];
          $update->update();  
        }else if ( $request['win_prob'] == TRUE) {
           $update->win_prob = $request['win_prob'];
           $update->update();   
        }

        if (is_null($request['project_name'])) {   
            $update->project_name = $request['project_name'];
            $update->update();
        }else if ( $request['project_name'] == TRUE) {
           $update->project_name = $request['project_name'];
           $update->update();   
        }

        $edate = strtotime($_POST['submit_date']); 
        $edate = date("Y-m-d",$edate);

        if (is_null($request['submit_date'])) {   
            $update->submit_date = $edate;
            $update->update();
        }else if ( $request['submit_date'] == TRUE) {
           $update->submit_date = $edate;
           $update->update();   
        }

        if($request['submit_price'] != $request['submit_price_before']){
            $update->submit_price = str_replace(',', '', $request['submit_price']);
            $update->update();
        }

        if ( is_null($request['assigned_by'])) {
          $update->assigned_by = $request['assigned_by'];
          $update->update();  
        }else if ( $request['assigned_by'] == TRUE) {
           $update->assigned_by = $request['assigned_by'];
           $update->update();   
        }


        if (is_null($request['quote_number'])) {   
            $update->quote_number2 = $request['quote_number'];
            $update->update();
        }else if ( $request['quote_number'] == TRUE) {
           $update->quote_number2 = $request['quote_number'];
           $update->update();   
        }

        $tambah = new SalesChangeLog();
        $tambah->lead_id = $request['lead_id'];
        $tambah->nik = Auth::User()->nik;
        $tambah->status = 'Update TP';
        if ($request['deal_price'] == '') {
           $tambah->deal_price = $request['deal_price'];
        }else{
           $tambah->deal_price = str_replace(',', '', $request['deal_price']); 
        }
        $tambah->submit_price = str_replace(',', '', $request['submit_price']);
        $tambah->save();


        $compare_win_lead = Sales::select('result')->where('lead_id', $lead_id)->first();
        $update_lead = Sales::where('lead_id', $lead_id)->first();

        if($compare_win_lead->result != 'WIN') {
            $update_lead->result = 'TP';
        }

        if ($request['deal_price'] == '') {
           $update_lead->deal_price = $request['deal_price'];
        }else{
           $update_lead->deal_price = str_replace(',', '', $request['deal_price']); 
        }

        if ($request['deal_price'] == '') {
           $update_lead->amount = $request['amount_cek_tp'];
        }else{
           $update_lead->amount = str_replace(',', '', $request['deal_price']); 
        }

        /*if ($request['submit_price'] != '') {
            $update_lead->amount = str_replace(',', '', $request['submit_price']);
        } elseif ($request['submit_price'] == '') {
            $update_lead->amount = $request['amount_before'];
        }*/

        if ( is_null($request['project_class'])) {
            $update_lead->project_class = $request['project_class'];
        }else if ( $request['project_class'] == TRUE) {
            $update_lead->project_class = $request['project_class'];
                if($request['project_class'] == 'multiyears' || $request['project_class'] == 'blanket') {

                    if ( is_null($request['jumlah_tahun'])) {
                        $update_lead->jumlah_tahun = $request['jumlah_tahun'];
                    }else if ( $request['jumlah_tahun'] == TRUE) {
                        $update_lead->jumlah_tahun = $request['jumlah_tahun'];
                    }

                    if ($request['deal_price_total'] == '') {
                        $update_lead->deal_price_total = $request['deal_price_total'];
                    }else{
                        $update_lead->deal_price_total = str_replace(',', '', $request['deal_price_total']); 
                    }
                } else {
                    $update_lead->jumlah_tahun = NULL;
                    $update_lead->deal_price_total = NULL;
                }
        }
        $update_lead->update();


        return redirect()->back();
    }

    public function update_result_request_id(Request $request)
    {
        $id = $request['lead_id'];

        $update = PID::where('lead_id', $id)->first();
        $update->status = 'requested';
        $update->update();

        // $users = User::select('name')->where('id_division','FINANCE')->where('id_position','MANAGER')->first();

        $pid_info = DB::table('sales_lead_register')
            ->join('sales_tender_process','sales_tender_process.lead_id','=','sales_lead_register.lead_id')
            ->join('tb_pid','tb_pid.lead_id','=','sales_lead_register.lead_id')
            ->join('users','users.nik','=','sales_lead_register.nik')
            ->where('sales_lead_register.lead_id',$id)
            ->select(
                'sales_lead_register.lead_id',
                'sales_lead_register.opp_name',
                'users.name',
                'tb_pid.amount_pid',
                'tb_pid.id_pid',
                'tb_pid.no_po',
                'sales_tender_process.quote_number2'
            )->first();

        $pid_req = PIDRequest::join('tb_quote_msp','tb_quote_msp.quote_number','=','tb_pid_request.no_quotation')
            ->join('users','users.nik','=','tb_quote_msp.nik')
            ->join('tb_company','tb_company.id_company','=','users.id_company')->first();

        if($pid_info->lead_id == "MSPQUO"){
            $pid_info->url_create = "/salesproject";
        }else {
            $pid_info->url_create = "/salesproject#acceptProjectID?" . $pid_info->id_pid;
        }

        $users = User::select('name','email')->where('id_division','FINANCE')->where('id_position','MANAGER')->first();
        
       /* Mail::to('faiqoh@sinergy.co.id')->send(new MailResult($users,$pid_info,$pid_req));
        Mail::to('ladinar@sinergy.co.id')->send(new MailResult($users,$pid_info,$pid_req));*/

        Mail::to($users->email)->send(new MailResult($users,$pid_info,$pid_req));


        return redirect()->to('/project')->with('success', 'Create PID Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lead_id)
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
    public function destroy($lead_id)
    {
        $hapus = Sales::find($lead_id);
        $hapus->delete();

        return redirect()->back();   
    }

    public function add_po(Request $request)
    {
        $edate = strtotime($_POST['date_po']); 
        $edate = date("Y-m-d",$edate);

        $tambah = new POCustomer;
        $tambah->lead_id = $request['lead_id_po'];
        $tambah->id_tp   = $request['id_tp_po'];
        $tambah->no_po   = $request['no_po'];
        $tambah->date    = $edate;
        $tambah->note    = $request['note_po'];
        $tambah->nominal = str_replace(',', '', $request['nominal_po']);
        $tambah->save();

        return redirect()->back();
    }

    public function update_po(Request $request)
    {
        $update = POCustomer::where('id_tb_po_cus',$request['id_po_customer_edit'])->first();
        $update->no_po   = $request['no_po_edit'];
        $update->date    = $request['date_po_edit'];
        $update->note    = $request['note_po_edit'];
        $update->nominal = str_replace(',', '', $request['nominal_po_edit']);
        $update->update();

        return redirect()->back();
    }

     public function delete_po($id_tb_po_cus)
    {
        $delete = POCustomer::find($id_tb_po_cus);
        $delete->delete();

        return redirect()->back();
    }

    public function customer_index()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        if ($ter != null) {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','')
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

        $data = TB_Contact::all();  

        return view('sales/customer',compact('data', 'notif','notifOpen','notifsd','notiftp', 'notifClaim'));
    }

    public function customer_store(Request $request)
    {
        $request->validate([
            'code_name' => 'required|unique:tb_contact,code',
        ]);

        $tambah = new TB_Contact();
        $tambah->code = $request['code_name'];
        $tambah->customer_legal_name = $request['name_contact'];
        $tambah->brand_name = $request['brand_name'];
        $tambah->office_building = $request['office_building'];
        $tambah->street_address = $request['street_address'];
        $tambah->city = $request['city'];
        $tambah->province = $request['province'];
        $tambah->postal = $request['postal'];
        $tambah->phone = $request['phone'];
        $tambah->save();

        return redirect('customer');
    }

    public function update_customer(Request $request)
    {   
        $id_contact = $request['id_contact'];

        $update = TB_Contact::where('id_customer', $id_contact)->first();
        $update->code = $request['code_name'];
        $update->customer_legal_name = $request['name_contact'];
        $update->brand_name = $request['brand_name'];
        $update->office_building = $request['office_building'];
        $update->street_address = $request['street_address'];
        $update->city = $request['city'];
        $update->province = $request['province'];
        $update->postal = $request['postal'];
        $update->phone = $request['phone'];
        $update->update();//

        return redirect('customer')->with('update', 'Update Contact Successfully!');;
    }

    /*public function total_amount()
    {
       $total_amount = DB::table('sales_lead_register')
                        ->sum('amount')
                        ->get();
        print_r($total_amount);
    }*/

    public function destroy_customer($id_customer)
    {
        $hapus = TB_Contact::find($id_customer);
        $hapus->delete();

        return redirect()->back();
    }

    public function import_id_pro(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        $data = Excel::load($path)->get();
 
        if($data->count()){
            foreach ($data as $key => $value) {
                $arr[] = ['id_pro' => $value->id_pro, 'id_project' => $value->id_project, 'lead_id' => $value->lead_id, 'date' => $value->date];
            }
 
            if(!empty($arr)){
                SalesProject::insert($arr);
            }
        }
 
        return back()->with('success', 'Insert Record successfully.');
    }

    public function sales_project_index(){
        $year_now = date('Y');

        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $pops = SalesProject::select('id_project')->orderBy('id_project','desc')->first();

        if ($div == 'SALES' && $pos != 'ADMIN') {
            $salessp = DB::table('tb_id_project')
                    ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->join('tb_contact','tb_contact.id_customer','=','sales_lead_register.id_customer')
                    ->select('tb_contact.customer_legal_name','tb_id_project.id_project','tb_id_project.date','tb_id_project.no_po_customer','sales_lead_register.opp_name','users.name','tb_id_project.amount_idr','tb_id_project.amount_usd','sales_lead_register.lead_id','sales_lead_register.opp_name','tb_id_project.note','tb_id_project.id_pro')
                    ->where('sales_lead_register.nik',$nik)
                    ->where('id_company','1')
                    ->get();

            $salesmsp = DB::table('tb_id_project')
                    ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->join('tb_pid','tb_pid.lead_id','=','tb_id_project.lead_id','left')
                    ->join('tb_quote_msp','tb_quote_msp.id_quote','=','tb_pid.no_quo','left')
                    ->join('tb_company','tb_company.id_company','=','users.id_company')
                    ->join('tb_contact','tb_contact.id_customer','=','sales_lead_register.id_customer')
                    ->select('tb_id_project.customer_name','tb_id_project.id_project','tb_id_project.date','tb_id_project.no_po_customer','sales_lead_register.opp_name','users.name','tb_id_project.amount_idr',DB::raw('(`tb_id_project`.`amount_idr`*10)/11 as `amount_idr_before_tax` '),'tb_id_project.amount_usd','sales_lead_register.lead_id','sales_lead_register.opp_name','tb_id_project.note','tb_id_project.id_pro','tb_id_project.invoice','tb_id_project.status','name_project','tb_id_project.created_at','sales_name','customer_legal_name','users.id_company','tb_quote_msp.quote_number','tb_pid.no_po','sales_lead_register.id_customer', 'tb_id_project.id_pro')
                    ->where('users.id_company','2')
                    ->where('sales_name',Auth::User()->name)
                    ->orWhere('sales_lead_register.nik',$nik)
                    ->whereYear('tb_id_project.created_at',date('Y'))
                    ->where('tb_id_project.status','!=','WO')
                    ->get();
        }elseif ($div == 'TECHNICAL' && $pos == 'MANAGER' || $pos == 'DIRECTOR') {
            $salessp = DB::table('tb_id_project')
                    ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->join('tb_contact','tb_contact.id_customer','=','sales_lead_register.id_customer')
                    ->select('tb_contact.customer_legal_name','tb_id_project.id_project','tb_id_project.date','tb_id_project.no_po_customer','sales_lead_register.opp_name','users.name','tb_id_project.amount_idr','tb_id_project.amount_usd','sales_lead_register.lead_id','sales_lead_register.opp_name','tb_id_project.note','tb_id_project.id_pro')
                    ->where('id_company','1')
                    ->get(); 

            $salesmsp = DB::table('tb_id_project')
                    ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->join('tb_pid','tb_pid.lead_id','=','tb_id_project.lead_id','left')
                    ->join('tb_quote_msp','tb_quote_msp.id_quote','=','tb_pid.no_quo','left')
                    ->join('tb_company','tb_company.id_company','=','users.id_company')
                    ->join('tb_contact','tb_contact.id_customer','=','sales_lead_register.id_customer')
                    ->select('tb_id_project.customer_name','tb_id_project.id_project','tb_id_project.date','tb_id_project.no_po_customer','sales_lead_register.opp_name','users.name','tb_id_project.amount_idr',DB::raw('(`tb_id_project`.`amount_idr`*10)/11 as `amount_idr_before_tax` '),'tb_id_project.amount_usd','sales_lead_register.lead_id','sales_lead_register.opp_name','tb_id_project.note','tb_id_project.id_pro','tb_id_project.invoice','tb_id_project.status','name_project','tb_id_project.created_at','sales_name','customer_legal_name','users.id_company','tb_quote_msp.quote_number','tb_pid.no_po', 'tb_id_project.id_pro')
                    ->where('users.id_company','2')
                    ->whereYear('tb_id_project.created_at',date('Y'))
                    ->where('tb_id_project.status','!=','WO')
                    ->get();
        }elseif($div == 'FINANCE'){
            if ($pos == 'MANAGER') {
                $salessp = DB::table('tb_id_project')
                    ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->join('tb_contact','tb_contact.id_customer','=','sales_lead_register.id_customer')
                    ->select('tb_contact.customer_legal_name','tb_id_project.id_project','tb_id_project.date','tb_id_project.no_po_customer','sales_lead_register.opp_name','users.name','tb_id_project.amount_idr','tb_id_project.amount_usd','sales_lead_register.lead_id','sales_lead_register.opp_name','tb_id_project.note','tb_id_project.id_pro','tb_id_project.invoice')
                    ->where('id_company','1')
                    ->get(); 

                $salesmsp = DB::table('tb_id_project')
                    ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->join('tb_pid','tb_pid.lead_id','=','tb_id_project.lead_id','left')
                    ->join('tb_quote_msp','tb_quote_msp.id_quote','=','tb_pid.no_quo','left')
                    ->join('tb_company','tb_company.id_company','=','users.id_company')
                    ->join('tb_contact','tb_contact.id_customer','=','sales_lead_register.id_customer')
                    ->select('tb_id_project.customer_name','tb_id_project.id_project','tb_id_project.date','tb_id_project.no_po_customer','sales_lead_register.opp_name','users.name','tb_id_project.amount_idr',DB::raw('(`tb_id_project`.`amount_idr`*10)/11 as `amount_idr_before_tax` '),'tb_id_project.amount_usd','sales_lead_register.lead_id','sales_lead_register.opp_name','tb_id_project.note','tb_id_project.id_pro','tb_id_project.invoice','tb_id_project.status','name_project','tb_id_project.created_at','sales_name','customer_legal_name','users.id_company','tb_quote_msp.quote_number','tb_pid.no_po', 'tb_id_project.id_pro')
                    ->where('users.id_company','2')
                    ->whereYear('tb_id_project.created_at',date('Y'))
                    ->where('tb_id_project.status','!=','WO')
                    ->get(); 
            }elseif ($pos == 'STAFF') {
                $salessp = DB::table('tb_id_project')
                    ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->join('tb_contact','tb_contact.id_customer','=','sales_lead_register.id_customer')
                    ->select('tb_contact.customer_legal_name','tb_id_project.id_project','tb_id_project.date','tb_id_project.no_po_customer','sales_lead_register.opp_name','users.name','sales_lead_register.lead_id','sales_lead_register.opp_name','tb_id_project.note','tb_id_project.id_pro','tb_id_project.invoice')
                    ->where('id_company','1')
                    ->get();

                $salesmsp = DB::table('tb_id_project')
                    ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->join('tb_pid','tb_pid.lead_id','=','tb_id_project.lead_id','left')
                    ->join('tb_quote_msp','tb_quote_msp.id_quote','=','tb_pid.no_quo','left')
                    ->join('tb_company','tb_company.id_company','=','users.id_company')
                    ->join('tb_contact','tb_contact.id_customer','=','sales_lead_register.id_customer')
                    ->select('tb_id_project.customer_name','tb_id_project.id_project','tb_id_project.date','tb_id_project.no_po_customer','sales_lead_register.opp_name','users.name','tb_id_project.amount_idr',DB::raw('(`tb_id_project`.`amount_idr`*10)/11 as `amount_idr_before_tax` '),'tb_id_project.amount_usd','sales_lead_register.lead_id','sales_lead_register.opp_name','tb_id_project.note','tb_id_project.id_pro','tb_id_project.invoice','tb_id_project.status','name_project','tb_id_project.created_at','sales_name','customer_legal_name','users.id_company','tb_quote_msp.quote_number','tb_pid.no_po', 'tb_id_project.id_pro')
                    ->where('users.id_company','2')
                    ->whereYear('tb_id_project.created_at',date('Y'))
                    ->where('tb_id_project.status','!=','WO')
                    ->get();
            }
        }
        else{
            $salessp = DB::table('tb_id_project')
                    ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->join('tb_contact','tb_contact.id_customer','=','sales_lead_register.id_customer')
                    ->select('tb_contact.customer_legal_name','tb_id_project.id_project','tb_id_project.date','tb_id_project.no_po_customer','sales_lead_register.opp_name','users.name','sales_lead_register.lead_id','sales_lead_register.opp_name','tb_id_project.note','tb_id_project.id_pro','tb_id_project.invoice')
                    ->where('id_company','1')
                    ->get();

            $salesmsp = DB::table('tb_id_project')
                    ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->join('tb_pid','tb_pid.lead_id','=','tb_id_project.lead_id','left')
                    ->join('tb_quote_msp','tb_quote_msp.id_quote','=','tb_pid.no_quo','left')
                    ->join('tb_company','tb_company.id_company','=','users.id_company')
                    ->join('tb_contact','tb_contact.id_customer','=','sales_lead_register.id_customer')
                    ->select('tb_id_project.customer_name','tb_id_project.id_project','tb_id_project.date','tb_id_project.no_po_customer','sales_lead_register.opp_name','users.name','tb_id_project.amount_idr',DB::raw('(`tb_id_project`.`amount_idr`*10)/11 as `amount_idr_before_tax` '),'tb_id_project.amount_usd','sales_lead_register.lead_id','sales_lead_register.opp_name','tb_id_project.note','tb_id_project.id_pro','tb_id_project.invoice','tb_id_project.status','name_project','tb_id_project.created_at','sales_name','customer_legal_name','users.id_company','tb_quote_msp.quote_number','tb_pid.no_po','sales_lead_register.id_customer', 'tb_id_project.id_pro')
                    ->where('users.id_company','2')
                    ->whereYear('tb_id_project.created_at',date('Y'))
                    ->where('tb_id_project.status','!=','WO')
                    ->get();
        }

        //Buat yang sekali pakai

      /*  $lead_sp = DB::table('sales_lead_register')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->select('lead_id','opp_name')
                    ->where('result','WIN')
                    ->where('year',$year_now)
                    ->where('id_company','1')
                    ->where('status_sho',null)
                    ->get();

        $lead_msp = DB::table('sales_lead_register')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->select('lead_id','opp_name')
                    ->where('result','WIN')
                    ->where('year',$year_now)
                    ->where('id_company','2')
                    ->where('status_sho',null)
                    ->get();*/


        $lead_sp = DB::table('sales_lead_register')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->select('sales_lead_register.lead_id','opp_name','pid')
                    ->where('result','WIN')
                    ->where('year',$year_now)
                    ->where('id_company','1')
                    ->get();

        $lead_msp = DB::table('sales_lead_register')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->select('lead_id','opp_name','pid')
                    ->where('result','WIN')
                    ->where('year',$year_now)
                    ->where('id_company','2')
                    ->get();

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

        $quote_number = QuoteMSP::join('users', 'users.nik', '=', 'tb_quote_msp.nik')
            ->whereNotIn('quote_number',DB::table('tb_pid_request')->pluck('no_quotation'))
            ->select(
                'id_quote',
                'quote_number',
                'position',
                'type_of_letter',
                'date',
                'to',
                'attention',
                'title',
                'project',
                'description', 
                'status', 
                'tb_quote_msp.nik', 
                'name', 
                'month'
            )
            ->get();

        $pid_request = PIDRequest::select(
            'tb_pid_request.created_at',
            'tb_quote_msp.project',
            'tb_quote_msp.quote_number',
            'users.name',
            'tb_quote_msp.date',
            'tb_pid_request.amount',
            'tb_pid_request.note',
            'tb_pid_request.status'
        )->join('tb_quote_msp','tb_quote_msp.quote_number','=','tb_pid_request.no_quotation')
        ->join('users','users.nik','=','tb_quote_msp.nik')
        ->where('users.nik',Auth::User()->nik)->get();

      return view('sales/sales_project',compact('salessp','salesmsp','lead_sp','lead_msp','notif','notifOpen','notifsd','notiftp', 'notifClaim','pops','datas','quote_number','pid_request'));
    }

    public function getidproject(Request $request)
    {
        $id_project = DB::table('tb_id_project')
                ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                ->join('tb_pid', 'sales_lead_register.lead_id', '=', 'tb_pid.lead_id')
                ->select('tb_id_project.id_pro', 'id_project','name_project', 'no_po', 'tb_pid.id_pid')
                ->where('tb_id_project.id_pro',$request->id_project)
                ->get();

        return $id_project;
    }

    public function store_po(Request $request)
    {
        $id_pid = $request['id_pid'];
        $update = PID::where('id_pid',$id_pid)->first();
        $update->no_po = $request['inputNoPo'];
        $update->update();

        $tambah_po = new PoNota();
        $tambah_po->no_po = $request['inputNoPo'];
        $tambah_po->save();

        return redirect('salesproject')->with('success', 'Update PO Successfully!');
    }

    public function saveRequestID(Request $request){
        
        $tambah = new PIDRequest();
        $tambah->date_quotation = $request->date;
        $tambah->no_quotation = QuoteMSP::where('id_quote',$request->quote)->value('quote_number');
        $tambah->amount = str_replace(",","",$request->amount);
        $tambah->status = 'requested';
        $tambah->note = $request->note;
        $tambah->save();

        $pid_info = DB::table('sales_lead_register')
            ->join('users','users.nik','=','sales_lead_register.nik')
            ->where('sales_lead_register.lead_id','MSPQUO')
            ->select(
                'sales_lead_register.lead_id',
                'sales_lead_register.opp_name',
                'users.name'
            )->first();

        $pid_req = PIDRequest::join('tb_quote_msp','tb_quote_msp.quote_number','=','tb_pid_request.no_quotation')
            ->join('users','users.nik','=','tb_quote_msp.nik')
            ->join('tb_company','tb_company.id_company','=','users.id_company')
            ->where('tb_pid_request.no_quotation',$tambah->no_quotation)
            ->select(
                'tb_quote_msp.project',
                'tb_quote_msp.quote_number',
                'users.name',
                'tb_pid_request.date_quotation',
                'tb_pid_request.amount',
                'tb_pid_request.note',
                'tb_pid_request.status',
                'tb_pid_request.no_quotation',
                'tb_company.code_company',
                'tb_pid_request.id_pid_request'
            )->first();

        $pid_req->url_create = "/salesproject#acceptProjectID?" . $pid_req->id_pid_request;
        
        $users = User::where('email','ladinar@sinergy.co.id')->first();

        Mail::to($users)->send(new MailResult($users,$pid_info,$pid_req));  

    }

    public function getQuoteDetail(Request $request){
        return $quote_number = QuoteMSP::join('users', 'users.nik', '=', 'tb_quote_msp.nik')
            ->select(
                'id_quote',
                'quote_number',
                'amount',
                'date',
                'name',
                'project',
                'to'
            )
            ->where('id_quote',$request->id)
            ->first();
    }

    public function store_sales_project(Request $request){
        $array_bln = array(1 => "I" ,"II","III","IV","V","VI","VII","VIII","IX","X","XI","XII");
        $bln = $array_bln[date('n')];

        $sales = $request['sales'];
        $contact = $request['customer_name'];
        $name = substr($contact, 0,4);
        $company = DB::table('tb_company')
                    ->join('users','users.id_company','=','tb_company.id_company')
                    ->select('code_company')
                    ->where('nik', $sales)
                    ->first();
        $hitung_sip = DB::table('tb_id_project')
                    ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->select('id_project','users.id_company')
                    ->orderBy('id_project','desc')
                    ->where('users.id_company','1')
                    ->first();

        $hitung_msp = DB::table('tb_id_project')
                    ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->select('id_project','users.id_company')
                    ->orderBy('id_project','desc')
                    ->where('users.id_company','2')
                    ->first();

        $cek_sip = Sales::join('users','users.nik','=','sales_lead_register.nik')
                ->select('id_company')
                ->where('lead_id',$request['customer_name'])
                ->first();

   /*     $inc_sip = DB::table('tb_id_project')
                    ->select('id_project')
                    ->where('id_company','1')
                    ->orderBy('id_project','desc')
                    ->first();

        $inc_msp = DB::table('tb_id_project')
                    ->select('id_project')
                    ->where('id_company','2')
                    ->orderBy('id_project','desc')
                    ->first();*/
        $cek_pid = Salesproject::select('lead_id')->where('lead_id',$contact)->count('lead_id');
        $counts = count($hitung_sip);

        $countss = count($hitung_msp);

        if ($cek_sip->id_company == '1') {
            if ($counts > 0) {
                $increment = round($hitung_sip->id_project);
            }else{
              $increment = round($hitung_sip);
            }
            $nomor = $increment+1;

            if($nomor <= 9){
                $nomor = '00' . $nomor;
            }elseif($nomor > 9 && $nomor < 99){
                $nomor = '0' . $nomor;
            }

            $project = $nomor.'/'.$name .'/'. $bln .'/'. date('Y');

            $lead_id = $request['customer_name'];

            $update = Sales::where('lead_id', $lead_id)->first();
            $update->status_sho = 'SHO';
            $update->pid = $cek_pid + 1;
            $update->update();

            $tambah = new SalesProject();
            $tambah->date = $request['date'];
            $tambah->id_project = $project;
            $tambah->nik = $request['sales'];
            $tambah->no_po_customer = $request['po_customer'];
            $tambah->lead_id = $request['customer_name'];
            $tambah->name_project = $request['name_project'];
            $tambah->amount_idr = str_replace(',', '', $request['amount']);
            $tambah->amount_usd = $request['kurs'];
            $tambah->note = $request['note'];
            $tambah->save();

            return redirect('salesproject')->with('success', 'Create PID Successfully!');

        }else if($cek_sip->id_company == '2'){
            if ($countss > 0) {
            $increment = round($hitung_msp->id_project);
            }else{
              $increment = round($hitung_msp);
            }
            $nomor = $increment+1;

            if($nomor <= 9){
                $nomor = '00' . $nomor;
            }elseif($nomor > 9 && $nomor < 99){
                $nomor = '0' . $nomor;
            }

            $project = $nomor.'/'.$name .'/'. $bln .'/'. date('Y');

            $lead_id = $request['customer_name'];

            $update = Sales::where('lead_id', $lead_id)->first();
            $update->status_sho = 'SHO';
            $update->pid = $cek_pid + 1;
            $update->update();

            $tambah = new SalesProject();
            $tambah->date = $request['date'];
            $tambah->id_project = $project;
            $tambah->nik = $request['sales'];
            $tambah->no_po_customer = $request['po_customer'];
            $tambah->lead_id = $request['customer_name'];
            $tambah->name_project = $request['name_project'];
            $tambah->amount_idr = str_replace(',', '', $request['amount']);
            $tambah->amount_usd = $request['kurs'];
            $tambah->note = $request['note'];
            $tambah->save();

            return redirect('salesproject')->with('success', 'Create PID Successfully!');
        }
        
    }

    public function add_idpro_manual(Request $request) {

        $get_user = DB::table('sales_lead_register')
                        ->select('nik', 'opp_name')
                        ->where('lead_id', $request['lead_id_manual'])
                        ->first();

        $tambah = new SalesProject();
        $tambah->date = $request['date_manual'];
        $tambah->lead_id = $request['lead_id_manual'];
        $tambah->id_project = $request['idpro_manual'];
        $tambah->no_po_customer = $request['po_customer_manual'];
        $tambah->note = $request['note_manual'];
        $tambah->nik = $get_user->nik;
        $tambah->name_project = $get_user->opp_name;
        $tambah->save();

        return redirect('salesproject')->with('success', 'Create PID Successfully!');

    }

    public function getDatalead(Request $request)
    {
         return array(DB::table('sales_lead_register')
                ->select('lead_id,opp_name')
                ->where('result','WIN')
                ->get());
    }

    public function update_sp(Request $request)
    {
        $id_project = $request['id_project_edit'];

        $update = SalesProject::where('id_project', $id_project)->first();
        $update->no_po_customer = $request['po_customer_edit'];
        $update->name_project = $request['name_project_edit'];
        if (Auth::User()->id_position == 'MANAGER') {
            $update->amount_idr = str_replace(',', '', $request['amount_edit']);
            $update->amount_usd = $request['kurs_edit'];
        }else{

        }
        $update->note = $request['note_edit'];
        $update->invoice = $request['invoice'];
        $update->update();//

        return redirect('salesproject');
    }

    public function destroy_sp(Request $request)
    {
        $lead_id = $request['id_pro'];
        $id_pro = $request['lead_id'];

        $cek_pid = Salesproject::select('lead_id')->where('lead_id',$lead_id)->count('lead_id');

        $update = Sales::where('lead_id', $lead_id)->first();
        $update->pid = $cek_pid - 1;
        $update->update();

        $hapus = Salesproject::find($id_pro);
        $hapus->delete();

        return redirect()->back()->with('error', 'Deleted PID Successfully!');
    }

    public function getDropdown(Request $request)
    {
        if($request->id_assign=='DIR'){
            return array(DB::table('tb_quote')
                ->select('id_quote', 'quote_number')
                ->where('position','DIR')
                ->where('status','F')
                ->get(),$request->id_assign);
        } else if ($request->id_assign == 'AM') {
            return array(DB::table('tb_quote')
                ->select('id_quote', 'quote_number')
                ->where('position', 'AM')
                ->where('status','F')
                ->get(),$request->id_assign);
        }
    }

    public function export(Request $request)
    {
        $nama = 'ID PROJECT '.date('Y-m-d');
        Excel::create($nama, function ($excel) use ($request) {
        $excel->sheet('Data ID Project', function ($sheet) use ($request) {
        
        $sheet->mergeCells('A1:H1');

       // $sheet->setAllBorders('thin');
        $sheet->row(1, function ($row) {
            $row->setFontFamily('Calibri');
            $row->setFontSize(12);
            $row->setAlignment('center');
            $row->setFontWeight('bold');
        });

        $sheet->row(1, array('Data ID Project SIP'));

        $sheet->row(2, function ($row) {
            $row->setFontFamily('Calibri');
            $row->setFontSize(12);
            $row->setFontWeight('bold');
        });

        $datas = Salesproject::join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
            ->join('users','users.nik','=','sales_lead_register.nik')
            ->join('tb_contact','tb_contact.id_customer','=','sales_lead_register.id_customer')
            ->select('date', 'id_project', 'no_po_customer',  'sales_lead_register.opp_name', 'amount_idr', 'users.name', 'tb_contact.customer_legal_name')
            ->where('year',$year_now)
            ->where('id_company','1')
            ->orderBy('id_project','asc')
            ->get();

       // $sheet->appendRow(array_keys($datas[0]));
            $sheet->row($sheet->getHighestRow(), function ($row) {
                $row->setFontWeight('bold');
            });

             $datasheet = array();
             $datasheet[0]  =   array("No", "Date", "ID Project", "No. PO customer", "Customer Name", "Project Name",  "Sales", "Amount IDR");
             $i=1;

            foreach ($datas as $data) {

               // $sheet->appendrow($data);
              $datasheet[$i] = array(
                            $i,
                            $data['date'],
                            $data['id_project'],
                            $data['no_po_customer'],
                            $data['customer_legal_name'],
                            $data['opp_name'],
                            $data['name'],
                            $data['amount_idr']
                        );
              
              $i++;
            }

            $sheet->fromArray($datasheet);
        });

        })->export('xls');
    }

    public function export_msp(Request $request)
    {
         $nama = 'ID PROJECT '.date('Y-m-d');
        Excel::create($nama, function ($excel) use ($request) {
        $excel->sheet('Data ID Project', function ($sheet) use ($request) {
        
        $sheet->mergeCells('A1:H1');

       // $sheet->setAllBorders('thin');
        $sheet->row(1, function ($row) {
            $row->setFontFamily('Calibri');
            $row->setFontSize(12);
            $row->setAlignment('center');
            $row->setFontWeight('bold');
        });

        $sheet->row(1, array('Data ID Project MSP'));

        $sheet->row(2, function ($row) {
            $row->setFontFamily('Calibri');
            $row->setFontSize(12);
            $row->setFontWeight('bold');
        });

        $datas = Salesproject::join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
            ->join('users','users.nik','=','sales_lead_register.nik')
            ->join('tb_contact','tb_contact.id_customer','=','sales_lead_register.id_customer')
            ->select('date', 'id_project', 'no_po_customer',  'sales_lead_register.opp_name', 'amount_idr', 'users.name', 'tb_contact.customer_legal_name')
            ->where('year',$year_now)
            ->where('id_company','2')
            ->orderBy('id_project','asc')
            ->get();

       // $sheet->appendRow(array_keys($datas[0]));
            $sheet->row($sheet->getHighestRow(), function ($row) {
                $row->setFontWeight('bold');
            });

             $datasheet = array();
             $datasheet[0]  =   array("No", "Date", "ID Project", "No. PO customer", "Customer Name", "Project Name",  "Sales", "Amount IDR");
             $i=1;

            foreach ($datas as $data) {

               // $sheet->appendrow($data);
              $datasheet[$i] = array(
                            $i,
                            $data['date'],
                            $data['id_project'],
                            $data['no_po_customer'],
                            $data['customer_legal_name'],
                            $data['opp_name'],
                            $data['name'],
                            $data['amount_idr']
                        );
              
              $i++;
            }

            $sheet->fromArray($datasheet);
        });

        })->export('xls');
    }
}