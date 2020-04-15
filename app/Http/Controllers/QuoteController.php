<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuoteMSP;
use DB;
use Auth;
use Excel;
use App\PR_MSP;
use App\TB_Contact;

class QuoteController extends Controller
{
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

        $pops = QuoteMSP::select('quote_number')->orderBy('quote_number','desc')->first();

        // $pops2 = QuoteMSP::select('quote_number')->where('status_backdate', 'F')->orderBy('quote_number', 'desc')->first();

		$datas = QuoteMSP::join('users', 'users.nik', '=', 'tb_quote_msp.nik')
                        ->join('tb_contact', 'tb_contact.id_customer', '=', 'tb_quote_msp.customer_id')
                        ->select('id_quote','quote_number','position','type_of_letter','date','to','attention','title','project','status', 'description', 'amount','note', 'tb_quote_msp.nik', 'name', 'month', 'customer_legal_name')
                        ->get();

       /* $count = QuoteMSP::where('status_backdate', 'T')
                    ->get();

        $counts = count($count);*/

        $customer = TB_Contact::select('brand_name', 'customer_legal_name','id_customer')->get();

        // if ($ter != null) {
        //     $notif = DB::table('sales_lead_register')
        //     ->select('opp_name')
        //     ->orderBy('created_at','desc')->first();
        // }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
        //     $notif = DB::table('sales_lead_register')
        //     ->select('opp_name')
        //     ->orderBy('created_at','desc')->first();
        // }else{
        //     $notif = DB::table('sales_lead_register')
        //     ->select('opp_name')
        //     ->orderBy('created_at','desc')->first();
        // }

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

        return view('quote/quote',compact('notif','datas','notifOpen','notifsd','notiftp', 'notifClaim', 'counts', 'count','pops', 'pops2', 'customer'));
	}

	public function create()
	{

	}

    public function store(Request $request)
    {
        $tahun = date("Y");
        $cek = QuoteMSP::where('date','like',$tahun."%")
                ->count('id_quote');

        if ($cek > 0) {
            $posti = 'AM';
            $type = 'QO';
            $edate = strtotime($_POST['date']); 
            $edate = date("Y-m-d",$edate);
            $month_pr = substr($edate,5,2);
            $year_pr = substr($edate,0,4);

            $array_bln = array('01' => "I",
                                '02' => "II",
                                '03' => "III",
                                '04' => "IV",
                                '05' => "V",
                                '06' => "VI",
                                '07' => "VII",
                                '08' => "VIII",
                                '09' => "IX",
                                '10' => "X",
                                '11' => "XI",
                                '12' => "XII");
            $bln = $array_bln[$month_pr];

            $getnumber = QuoteMSP::orderBy('id_quote', 'desc')->where('date','like',$tahun."%")->count();

            $getnumbers = QuoteMSP::orderBy('id_quote', 'desc')->first();

            if($getnumber == NULL){
                $getlastnumber = 1;
                $lastnumber = $getlastnumber;
            } else{
                $lastnumber = $getnumber+1;
            }

            if($lastnumber < 10){
               $akhirnomor = '00' . $lastnumber;
            }elseif($lastnumber > 9 && $lastnumber < 100){
               $akhirnomor = '0' . $lastnumber;
            }elseif($lastnumber >= 100){
               $akhirnomor = $lastnumber;
            }

            $no = $akhirnomor.'/'.$posti .'/'. $type.'/' . $bln .'/'. $year_pr;
            $nom = QuoteMSP::select('id_quote')->orderBy('id_quote','desc')->first();

            $edate = strtotime($_POST['date']); 
            $edate = date("Y-m-d",$edate);

            $tambah = new QuoteMSP();
            $tambah->id_quote = $nom->id_quote+1;
            $tambah->quote_number = $no;
            $tambah->position = $posti;
            $tambah->type_of_letter = $type;
            $tambah->month = $bln;
            $tambah->date = $edate;
            $tambah->customer_id = $request['to'];
            $tambah->attention = $request['attention'];
            $tambah->title = $request['title'];
            $tambah->project = $request['project'];
            $tambah->description = $request['description'];
            $tambah->nik = Auth::User()->nik;
            $tambah->amount = str_replace(',', '', $request['amount']);
            $tambah->project_type = $request['project_type'];
            $tambah->save();

            return redirect('quote')->with('success', 'Created Quote Number Successfully!');
        } else{
            $posti = 'AM';
            $type = 'QO';
            $edate = strtotime($_POST['date']); 
            $edate = date("Y-m-d",$edate);
            $month_pr = substr($edate,5,2);
            $year_pr = substr($edate,0,4);

            $array_bln = array('01' => "I",
                                '02' => "II",
                                '03' => "III",
                                '04' => "IV",
                                '05' => "V",
                                '06' => "VI",
                                '07' => "VII",
                                '08' => "VIII",
                                '09' => "IX",
                                '10' => "X",
                                '11' => "XI",
                                '12' => "XII");
            $bln = $array_bln[$month_pr];

            $getnumber = QuoteMSP::orderBy('id_quote', 'desc')->where('date','like',$tahun."%")->count();

            $getnumbers = QuoteMSP::orderBy('id_quote', 'desc')->first();

            if($getnumber == NULL){
                $getlastnumber = 1;
                $lastnumber = $getlastnumber;
            } else{
                $lastnumber = $getnumber+1;
            }

            if($lastnumber < 10){
               $akhirnomor = '00' . $lastnumber;
            }elseif($lastnumber > 9 && $lastnumber < 100){
               $akhirnomor = '0' . $lastnumber;
            }elseif($lastnumber >= 100){
               $akhirnomor = $lastnumber;
            }

            $no = $akhirnomor.'/'.$posti .'/'. $type.'/' . $bln .'/'. $year_pr;

            $tambah = new QuoteMSP();
            $tambah->no = $getnumbers->id_quote+1;
            $tambah->position = $posti;
            $tambah->month = $bln;
            $tambah->date = $edate;
            $tambah->customer_id = $request['to'];
            $tambah->attention = $request['attention'];
            $tambah->title = $request['title'];
            $tambah->project = $request['project'];
            $tambah->description = $request['description'];
            $tambah->from = Auth::User()->nik;
            // $tambah->result = 'T';
            $tambah->project_type = $request['project_type'];
            $tambah->save();

            return redirect('quote')->with('success', 'Created Quote Number Successfully!');
        }
    }

    public function store_backdate(Request $request)
    {
        $type = 'QO';
        $posti = $request['position'];
        $month_quote = substr($request['date'],5,2);
        $year_quote = substr($request['date'],0,4);

        $array_bln = array('01' => "I",
                            '02' => "II",
                            '03' => "III",
                            '04' => "IV",
                            '05' => "V",
                            '06' => "VI",
                            '07' => "VII",
                            '08' => "VIII",
                            '09' => "IX",
                            '10' => "X",
                            '11' => "XI",
                            '12' => "XII");
        $bln = $array_bln[$month_quote];

        $query = QuoteMSP::select('id_quote')
                        ->where('status_backdate','T')
                        ->orderBy('id_quote','asc')
                        ->first();
        
        $lastnumber = $query->id_quote;

        if($lastnumber < 10){
           $akhirnomor = '00' . $lastnumber;
        }elseif($lastnumber > 9 && $lastnumber < 100){
           $akhirnomor = '0' . $lastnumber;
        }elseif($lastnumber >= 100){
           $akhirnomor = $lastnumber;
        }

        $no = $akhirnomor.'/'. 'AM' .'/'. $type.'/' . $bln .'/'. $year_quote;

        $angka7 = QuoteMSP::select('id_quote')
                ->where('status_backdate','T')
                ->orderBy('id_quote','asc')
                ->first();
        $angka = $angka7->id_quote;

        $update = QuoteMSP::where('id_quote',$angka)->first();
        $update->quote_number = $no;
        $update->position = 'AM';
        $update->type_of_letter = $type;
        $update->month = $bln;
        $update->date = $request['date'];
        $update->to = $request['to'];
        $update->attention = $request['attention'];
        $update->title = $request['title'];
        $update->project = $request['project'];
        $update->description = $request['description'];
        $update->nik = Auth::User()->nik;
        $update->amount = str_replace(',', '', $request['amount']);
        $update->status_backdate = 'F';
        $update->update();

        return redirect('quote')->with('sukses', 'Create Quote Number Successfully!');
    }

	public function update(Request $request)
	{
        $quote_number = $request['quote_number'];

        $update = QuoteMSP::where('quote_number', $quote_number)->first();
        $update->quote_number = $request['quote_number'];
        
        $update->to = $request['edit_to'];
        $update->attention = $request['edit_attention'];
        $update->title = $request['edit_title'];
        $update->project = $request['edit_project'];
        $update->description = $request['edit_description'];
        $update->note = $request['edit_note'];
        $update->update();

        return redirect('quote')->with('update', 'Update Quote Number Successfully!');
	}

    public function destroy_quote(Request $request)
    {
        $hapus = QuoteMSP::find($request->id_quote);
        $hapus->delete();

        return redirect()->back();
    }

    /*public function report_quote()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $datas = QuoteMSP::join('users', 'users.nik', '=', 'tb_quote_msp.nik')
                        ->select('id_quote','quote_number','position','type_of_letter','date','to','attention','title','project')
                        ->where('tb_quote_msp.nik', $nik)
                        ->get();

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
        
        return view('report/quote',compact('notif','datas','notifOpen','notifsd','notiftp', 'notifClaim'));
    }*/

    public function donwloadExcelQuote(Request $request)
    {
    	$nama = 'Data Admin (Quotation) '.date('Y');
        Excel::create($nama, function ($excel) use ($request) {
        $excel->sheet('Quote Number', function ($sheet) use ($request) {
        
        $sheet->mergeCells('A1:O1');

        $sheet->row(1, function ($row) {
            $row->setFontFamily('Calibri');
            $row->setFontSize(11);
            $row->setAlignment('center');
            $row->setFontWeight('bold');
        });

        $sheet->row(1, array('Quote Number'));

        $sheet->row(2, function ($row) {
            $row->setFontFamily('Calibri');
            $row->setFontSize(11);
            $row->setFontWeight('bold');
        });

        $datas = QuoteMSP::join('users', 'users.nik', '=', 'tb_quote_msp.nik')
                    ->select('quote_number','position','type_of_letter', 'month', 'date', 'to', 'attention', 'title','project','description','name','project_type', 'amount')
                    ->get();

       // $sheet->appendRow(array_keys($datas[0]));
            $sheet->row($sheet->getHighestRow(), function ($row) {
                $row->setFontWeight('bold');
            });

             $datasheet = array();
             $datasheet[0]  =   array("No", "No Quote", "Position", "Type of Letter", "Month",  "Date", "To" , "Attention", "Title", "Project", "Description", "From", "Amount","Project Type");
             $i=1;

            foreach ($datas as $data) {

               // $sheet->appendrow($data);
              $datasheet[$i] = array(
                            $i,
                            $data['quote_number'],
                            $data['position'],
                            $data['type_of_letter'],
                            $data['month'],
                            $data['date'],
                            $data['to'],
                            $data['attention'],
                            $data['title'],
                            $data['project'],
                            $data['description'],
                            $data['name'],
                            $data['amount'],
                            $data['project_type']
                        );
              
              $i++;
            }

            $sheet->fromArray($datasheet);
        });

        })->export('xls');
    }
}
