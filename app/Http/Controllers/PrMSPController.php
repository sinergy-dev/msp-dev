<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\PR_MSP;
use Illuminate\Support\Facades\Route;
use Excel;
use App\SalesProject;

class PrMSPController extends Controller
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

        $datas = DB::table('tb_pr_msp')
                        ->join('users', 'users.nik', '=', 'tb_pr_msp.from')
                        ->select('no','no_pr', 'type_of_letter', 'month', 'tb_pr_msp.date', 'to', 'attention', 'title', 'project', 'description', 'name', 'issuance', 'id_project', 'project_id', 'name', 'subject')
                        // ->where('project_id', '=', null)
                        // ->where('tb_pr_msp.updated_at_copy', '>=', '2019-07-19')
                        ->orderBy('tb_pr_msp.created_at', 'desc')
                        ->get();

        $tahun = date("Y");

        $datas2 = DB::table('tb_pr_msp')
                    ->join('users', 'users.nik', '=', 'tb_pr_msp.from')
                    ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_pr_msp.project_id')
                    ->select('name', 'no', 'no_pr', 'type_of_letter', 'month', 'tb_pr_msp.date', 'to', 'attention', 'title', 'project', 'description', 'issuance', 'project_id', 'subject', 'tb_id_project.id_project')
                    ->orderBy('tb_pr_msp.created_at', 'desc')
                    // ->where('tb_pr_msp.date','like',$tahun."%")
                    ->get();
        

        $id_pro_stock = DB::table('tb_id_project')
                    ->select('id_pro', 'id_project')
                    ->where('lead_id', 'STOCK')
                    ->get();

        $id_pro = DB::table('tb_id_project')
                    ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->select('id_project', 'tb_id_project.id_pro')
                    ->where('id_company', '2')
                    ->get();

        /*$id_pro_no_lead = DB::table('tb_id_project')
                        ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                        ->join('users', 'users.nik', '=', 'tb_id_project.nik')
                        ->select('id_project', 'tb_id_project.id_pro')
                        ->where('id_company', '2')
                        ->get();*/

        return view('admin_msp/pr', compact('lead', 'total_ter','notif','notifOpen','notifsd','notiftp','id_pro', 'datas','notifClaim', 'id_pro', 'id_pro_stock', 'datas2'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function add_id_project(Request $request)
    {
        $tambah             = new SalesProject();
        $tambah->id_pro     = (int)$request['last_idpro'] - 1;
        $tambah->lead_id    = 'MSPCOBA190102';
        $tambah->id_project = $request['input_id_project'];
        $tambah->date       = date('Y-m-d');
        $tambah->save();

        return redirect()->back()->with('alert', 'Created Project Id Successfully!');
    }

    public function add_pr(Request $request)
    {
        $project_id = DB::table('tb_id_project')
                        ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                        ->join('users','users.nik','=','sales_lead_register.nik')
                        ->select('id_project', 'tb_id_project.id_pro')
                        ->where('id_company', '2')
                        ->get();

        $idpro = SalesProject::select('id_pro')->orderBy('id_pro','asc')->first();

        // if (Auth::User()->email == 'putri@siergy.co.id') {
        	
        // }
        if (Auth::User()->email == "putri@sinergy.co.id") {
        	
	        if ($_GET['submit_tipe_pr'] == "Internal") {
	        	return view('admin_msp/add_pr_internal', compact('project_id', 'idpro'));
		    }else{
		      	return view('admin_msp/add_pr', compact('project_id', 'idpro'));
		    }# code...
        }else{
        	return view('admin_msp/add_pr', compact('project_id', 'idpro'));
        }


       
    }

    public function add_pr_internal()
    {

       
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
    public function store_pr(Request $request)
    {
        $month_pr = substr($request['date'],5,2);
        $year_pr = substr($request['date'],0,4);

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

        $getnumber = PR_MSP::orderBy('no', 'desc')->first();

        if ($request['tipe_pr'] == 'internal') {
        	if($getnumber == NULL){
	            $getlastnumber = 1;
	            $lastnumber = $getlastnumber;
	        } else{
	            $lastnumber = $getnumber->no+1;
	        }
        }else{
        	$lastnumber = $request['no_pr'];
        }
       

        if($lastnumber < 10){
           $akhirnomor = '000' . $lastnumber;
        }elseif($lastnumber > 9 && $lastnumber < 100){
           $akhirnomor = '00' . $lastnumber;
        }elseif($lastnumber >= 100){
           $akhirnomor = '0' . $lastnumber;
        }

        $no = $akhirnomor.'/'. 'MSP' . '/' . $bln .'/'. $year_pr;
        $lastno = PR_MSP::select('no')->orderBy('created_at', 'desc')->first();

        $tambah = new PR_MSP();
        $tambah->no = $lastno->no+1;
        $tambah->no_pr = $no;
        $tambah->month = $bln;
        $tambah->date = $request['date'];
        $tambah->to = $request['to'];
        $tambah->attention = $request['attention'];
        $tambah->title = $request['title'];
        $tambah->project = $request['project'];
        $tambah->description = $request['description'];
        $tambah->from = Auth::User()->nik;
        // $tambah->division = $request['division'];
        $tambah->issuance = $request['issuance'];
        // $tambah->id_project = $request['id_project'];
        if ($request['tipe_pr'] == 'internal') {
        	# code...
        }else{
        	$tambah->project_id = $request['id_project'];	
        }
        
        $tambah->subject = $request['subject'];
        $tambah->result = 'T';
        $tambah->save();

        return redirect('pr_msp')->with('success', 'Created Purchase Request Successfully!');
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
    public function update_pr(Request $request)
    {
        $no = $request['edit_no_pr'];

        $update = PR_MSP::where('no',$no)->first();
        $update->to = $request['edit_to'];
        $update->attention = $request['edit_attention'];
        $update->title = $request['edit_title'];
        $update->project = $request['edit_project'];
        $update->description = $request['edit_description'];
        $update->from = Auth::User()->nik;
        $update->issuance = $request['edit_issuance'];
        $update->id_project = $request['edit_project_id'];

        $update->update();

        return redirect('pr_msp')->with('update', 'Updated Purchase Request Data Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

   /* public function updatepr(Request $request)
    {
        $no = $request['edit_no_pr'];

        $update = PR_MSP::where('no', $no)->first();
        $update->to = $request['edit_to'];
        $update->attention = $request['edit_attention'];
        $update->title = $request['edit_title'];
        $update->project = $request['edit_project'];
        $update->description = $request['edit_description'];
        $update->from = Auth::User()->nik;
        $update->issuance = $request['issuance'];
        $update->id_project = $request['edit_project_id'];
        $update->update();
    }*/

    public function destroy_pr($no)
    {
        $hapus = PR_MSP::find($no);
        $hapus->delete();

        return redirect('pr_msp')->with('alert', 'Deleted!');
    }


    public function downloadExcelPr(Request $request)
    {
        $nama = 'Rekap Purchase Request '.date('Y');
        Excel::create($nama, function ($excel) use ($request) {
        $excel->sheet('Rekap Purchase Request', function ($sheet) use ($request) {
        
        $sheet->mergeCells('A1:O1');

       // $sheet->setAllBorders('thin');
        $sheet->row(1, function ($row) {
            $row->setFontFamily('Calibri');
            $row->setFontSize(11);
            $row->setAlignment('center');
            $row->setFontWeight('bold');
        });

        $sheet->row(1, array('Rekap Purchase Request'));

        $sheet->row(2, function ($row) {
            $row->setFontFamily('Calibri');
            $row->setFontSize(11);
            $row->setFontWeight('bold');
        });

        $datas = PR::join('users', 'users.nik', '=', 'tb_pr.from')
                    ->select('no_pr','position','type_of_letter', 'month', 'date', 'to', 'attention', 'title','project','description','from','division','issuance','project_id', 'name')
                    ->get();

       // $sheet->appendRow(array_keys($datas[0]));
            $sheet->row($sheet->getHighestRow(), function ($row) {
                $row->setFontWeight('bold');
            });

             $datasheet = array();
             $datasheet[0]  =   array("NO", "No Letter", "Position", "Type of Letter", "Month",  "Date", "To", "Attention", "Title", "Project", "Description", "From", "Division", "Issuance", "Project ID");
             $i=1;

            foreach ($datas as $data) {

               // $sheet->appendrow($data);
              $datasheet[$i] = array($i,
                            $data['no_pr'],
                            $data['position'],
                            $data['type_of_letter'],
                            $data['month'],
                            $data['date'],
                            $data['to'],
                            $data['attention'],
                            $data['title'],
                            $data['project'],
                            $data['description'],
                            $data['from'],
                            $data['division'],
                            $data['issuance'],
                            $data['project_id'],
                        );
              
              $i++;
            }

            $sheet->fromArray($datasheet);
        });

        })->export('xls');
    }

    public function import_pr_msp(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        $data = Excel::load($path)->get();
 
        if($data->count()){
            foreach ($data as $key => $value) {
                $arr[] = ['no_pr' => $value->no_pr, 'month' => $value->month, 'date' => $value->date, 'to' => $value->to,'attention' => $value->attention,'title' => $value->title,'project' => $value->project,'description' => $value->description,'subject' => $value->subject,'from' => $value->from,'issuance' => $value->issuance,'project_id' => $value->project_id, 'result' => 'T'];
            }
 
            if(!empty($arr)){
                PR_MSP::insert($arr);
            }
        }
 
        return back()->with('success', 'Insert Record successfully.');
    }
}
