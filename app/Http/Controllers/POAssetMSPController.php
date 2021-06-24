<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\PONumberMSP;
use App\POAssetMSP;
use App\pam_msp;
use App\pam_produk_msp;
use App\pam_progress_msp;
use PDF;
use Excel;
use App\PR_MSP;
use App\Inventory_msp;

class POAssetMSPController extends Controller
{
    public function index(Request $request)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        /*$pam = DB::table('tb_pam_msp')
            ->join('users','users.nik','=','tb_pam_msp.personel')
            ->join('tb_pr_msp','tb_pr_msp.no','=','tb_pam_msp.no_pr')
            ->select('tb_pam_msp.id_pam','tb_pam_msp.date_handover','tb_pr_msp.no_pr','tb_pam_msp.ket_pr','tb_pam_msp.note_pr','tb_pam_msp.to_agen','tb_pam_msp.status','users.name','tb_pam_msp.subject', 'tb_pr_msp.no', 'tb_pr_msp.date', 'tb_pam_msp.attention', 'tb_pam_msp.project', 'tb_pam_msp.project_id', 'ppn', 'terms')
            ->get();*/

        $pam = DB::table('tb_po_asset_msp')
                // ->join('users', 'users.nik', '=', 'tb_po_asset_msp.nik_admin')
                ->join('tb_po_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no')
                ->join('tb_pr_msp', 'tb_pr_msp.no', '=', 'tb_po_asset_msp.no_pr')
                ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_pr_msp.project_id')
                ->select('tb_id_project.id_project', 'tb_pr_msp.no_pr','tb_po_asset_msp.status_po', 'tb_pr_msp.no', 'tb_pr_msp.date', 'tb_po_asset_msp.term', 'tb_po_msp.no_po', 'tb_po_asset_msp.project_id', 'tb_po_asset_msp.id_po_asset', 'tb_po_asset_msp.date_handover','tb_po_asset_msp.no_invoice', 'tb_po_asset_msp.to_agen', 'tb_po_asset_msp.id_po_asset')
                ->orderBy('tb_po_asset_msp.created_at', 'desc')
                // ->orderBy('tb_po_asset_msp.status_po', 'NEW')
                // ->where('tb_po_msp.no', '!=', '1')
                ->get();

        $pam2 = DB::table('tb_po_asset_msp')
                // ->join('users', 'users.nik', '=', 'tb_po_asset_msp.nik_admin')
                ->join('tb_po_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no')
                ->join('tb_pr_msp', 'tb_pr_msp.no', '=', 'tb_po_asset_msp.no_pr')
                ->select('tb_pr_msp.no_pr','tb_po_asset_msp.status_po', 'tb_pr_msp.no', 'tb_pr_msp.date', 'tb_po_asset_msp.term', 'tb_po_msp.no_po', 'tb_po_asset_msp.project_id', 'tb_po_asset_msp.id_po_asset', 'tb_po_asset_msp.date_handover','tb_po_asset_msp.no_invoice', 'tb_po_asset_msp.to_agen', 'tb_po_asset_msp.id_po_asset')
                ->where('tb_po_asset_msp.project_id', null)
                ->where('tb_po_msp.no', '!=', '1')
                ->get();

        $datas = DB::table('tb_pam_msp')
                ->join('tb_po_asset_msp', 'tb_pam_msp.id_pam', '=', 'tb_po_asset_msp.id_pr_asset')
                ->join('tb_pr_msp', 'tb_pr_msp.no', '=', 'tb_pam_msp.no_pr')
                ->select('id_pam', 'tb_pr_msp.no_pr', 'tb_pam_msp.subject', 'status_po')
                ->where('status_po', 'FNC')
                ->get();

        $project_id = DB::table('tb_id_project')
                        ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                        ->join('users','users.nik','=','sales_lead_register.nik')
                        ->select('id_project', 'tb_id_project.id_pro')
                        ->where('id_company', '2')
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

        $notifClaim = '';

        $from = DB::table('users')
                ->select('nik', 'name')
                ->where('id_company', '2')
                ->get();

        return view('admin_msp/po_asset',compact('notif','notifOpen','notifsd','notiftp','notifClaim','pam','from', 'datas', 'pam2', 'project_id'));
    }

    public function add_po(Request $request)
    {

        $from = DB::table('users')
                ->select('nik', 'name')
                ->where('id_company', '2')
                ->get();

        $no_pr = DB::table('tb_pr_msp')
                ->select('no_pr', 'subject', 'no')
                ->orderBy('created_at', 'desc')
                ->get();

        $project_id = DB::table('tb_id_project')
                        ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                        ->join('users','users.nik','=','sales_lead_register.nik')
                        ->select('id_project', 'tb_id_project.id_pro')
                        ->where('id_company', '2')
                        ->get();


        $msp_code = Inventory_msp::select("kode_barang","qty","nama","unit")->get();

        return view('admin_msp/add_po', compact('from', 'msp_code', 'no_pr', 'project_id'));
    }

    public function add_produk($id_po_asset)
    {
        $datas = DB::table('tb_po_asset_msp')
                ->join('tb_po_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no')
                ->join('tb_pr_msp', 'tb_pr_msp.no', '=', 'tb_po_asset_msp.no_pr')
                ->select('tb_po_msp.no_po', 'tb_po_asset_msp.id_po_asset', 'tb_po_asset_msp.to_agen', 'tb_pr_msp.subject')
                ->where('id_po_asset', $id_po_asset)
                ->first();

        $msp_code = Inventory_msp::select("kode_barang","qty","nama","unit")->get();

        // return $datas;
        return view('admin_msp/add_produk_po', compact('msp_code', 'datas'));
    }

    public function detail_po($id_po_asset)
    {
        $tampilkan = DB::table('tb_po_asset_msp')
                ->join('tb_po_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no')
                ->join('tb_pr_product_msp', 'tb_po_asset_msp.id_po_asset', '=', 'tb_pr_product_msp.id_po_asset')
                ->select('tb_po_asset_msp.status_po', 'tb_po_msp.no_po', 'tb_po_asset_msp.project_id', 'tb_po_asset_msp.id_po_asset', 'tb_po_asset_msp.date_handover','tb_po_asset_msp.no_invoice', 'tb_po_asset_msp.to_agen', 'tb_po_asset_msp.subject')
                ->where('tb_po_asset_msp.id_po_asset', $id_po_asset)
                ->first();

        $produks = DB::table('tb_po_asset_msp')
            ->join('tb_pr_product_msp','tb_pr_product_msp.id_po_asset','=','tb_po_asset_msp.id_po_asset')
            ->join('inventory_produk_msp','inventory_produk_msp.id_product','=','tb_pr_product_msp.id_barang')
            ->select('tb_pr_product_msp.id_product','tb_pr_product_msp.name_product','tb_pr_product_msp.qty','tb_pr_product_msp.id_pam','tb_pr_product_msp.description', 'inventory_produk_msp.kode_barang', 'tb_pr_product_msp.nominal', 'tb_pr_product_msp.total_nominal', 'tb_po_asset_msp.id_po_asset', 'tb_po_asset_msp.status_po', 'tb_pr_product_msp.qty_awal', 'tb_pr_product_msp.qty_terima')
            ->where('tb_po_asset_msp.id_po_asset',$id_po_asset)
            ->get();

        $total_amount = DB::table('tb_pr_product_msp')
                    ->select('total_nominal')
                    ->where('id_po_asset',$id_po_asset)
                    ->sum('total_nominal');

        $count_po = DB::table('tb_pr_product_msp')
                    ->where('id_po_asset',$id_po_asset)
                    ->count('name_product');

        return view('admin_msp/detail_po',compact('tampilkan', 'produks', 'total_amount', 'count_po'));
    }

    public function copy_po($id_po_asset)
    {
        $tampilkan = DB::table('tb_po_asset_msp')
                ->join('tb_po_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no')
                ->join('tb_pr_msp', 'tb_pr_msp.no', '=', 'tb_po_asset_msp.no_pr')
                ->join('tb_pr_product_msp', 'tb_po_asset_msp.id_po_asset', '=', 'tb_pr_product_msp.id_po_asset')
                ->select('tb_po_asset_msp.status_po', 'tb_po_msp.no_po', 'tb_po_asset_msp.project_id', 'tb_po_asset_msp.id_po_asset', 'tb_po_asset_msp.date_handover','tb_po_asset_msp.no_invoice', 'tb_po_asset_msp.to_agen', 'tb_po_asset_msp.subject','tb_pr_msp.no_pr','address','fax','telp','email','tb_po_asset_msp.project','tb_po_asset_msp.attention','tb_po_asset_msp.subject')
                ->where('tb_po_asset_msp.id_po_asset', $id_po_asset)
                ->first();

        $produks = DB::table('tb_po_asset_msp')
            ->join('tb_pr_product_msp','tb_pr_product_msp.id_po_asset','=','tb_po_asset_msp.id_po_asset')
            ->join('inventory_produk_msp','inventory_produk_msp.id_product','=','tb_pr_product_msp.id_barang')
            ->select('inventory_produk_msp.id_product','tb_pr_product_msp.name_product','tb_pr_product_msp.qty','tb_pr_product_msp.id_pam','tb_pr_product_msp.description', 'tb_pr_product_msp.msp_code', 'tb_pr_product_msp.nominal', 'tb_pr_product_msp.total_nominal', 'tb_po_asset_msp.id_po_asset', 'tb_po_asset_msp.status_po', 'tb_pr_product_msp.qty_awal', 'tb_pr_product_msp.qty_terima','inventory_produk_msp.unit','inventory_produk_msp.kode_barang')
            ->where('tb_po_asset_msp.id_po_asset',$id_po_asset)
            ->get();

        $total_amount = DB::table('tb_pr_product_msp')
                    ->select('total_nominal')
                    ->where('id_po_asset',$id_po_asset)
                    ->sum('total_nominal');

        $count_po = DB::table('tb_pr_product_msp')
                    ->where('id_po_asset',$id_po_asset)
                    ->count('name_product');

        $no_pr = DB::table('tb_pr_msp')
                ->select('no_pr', 'subject', 'no')
                ->orderBy('no_pr', 'desc')
                ->get();

        $project_id = DB::table('tb_id_project')
                    ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->select('id_project', 'tb_id_project.id_pro')
                    ->where('id_company', '2')
                    ->get();

        $msp_code = Inventory_msp::select('id_product','nama','note','qty','kode_barang')->where('qty','!=','')->where('tipe','!=','return')->get();

        return view('admin_msp/copy_po',compact('tampilkan', 'produks', 'total_amount', 'count_po','no_pr','msp_code','project_id'));
    }

    public function store_copy_po(Request $request)
    {
        $month_pr = date("m");
        $year_pr  = date("Y");

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

        $getnumber_po = PONumberMSP::orderBy('no', 'desc')->first();

        if($getnumber_po == NULL){
            $getlastnumber_po = 1;
            $lastnumber_po = $getlastnumber_po;
        } else{
            $lastnumber_po = $getnumber_po->no+1;
        }

        // $lastnumber_po = $request['no_po'];

        if($lastnumber_po < 10){
           $akhirnomor_po = '000' . $lastnumber_po;
        }elseif($lastnumber_po > 9 && $lastnumber_po < 100){
           $akhirnomor_po = '00' . $lastnumber_po;
        }elseif($lastnumber_po >= 100){
           $akhirnomor_po = '0' . $lastnumber_po;
        }

        $no_po = $akhirnomor_po.'/'. 'FA' . '/' . 'PO' .'/'. $bln . '/' . $year_pr;
        // $lastnopr = PR_MSP::select('no')->orderby('created_at','desc')->first();
        $lastnopr = $request['no_pr'];

        $tambah_nopo = new PONumberMSP();
        $tambah_nopo->no = $lastnumber_po;
        $tambah_nopo->no_po = $no_po;
        $tambah_nopo->month = $bln;
        $tambah_nopo->position = 'FA';
        $tambah_nopo->type_of_letter = 'PO';
        $tambah_nopo->date = date("Y-m-d");
        $tambah_nopo->to = $request['to_agen'];
        $tambah_nopo->attention = $request['att'];
        $tambah_nopo->project = $request['project'];
        $tambah_nopo->from = Auth::User()->nik;
        $tambah_nopo->project_id = $request['project_id'];
        $tambah_nopo->save();

        $lastnopo = PONumberMSP::select('no')->orderby('created_at','desc')->first(); 

        $tambah_poasset = new POAssetMSP();
        $tambah_poasset->nik_admin     = Auth::User()->nik;
        $tambah_poasset->date_handover = date("Y-m-d");
        $tambah_poasset->no_pr         = $lastnopr;
        $tambah_poasset->no_po         = $lastnopo->no;
        $tambah_poasset->to_agen       = $request['to_agen'];
        $tambah_poasset->subject       = $request['subject'];
        $tambah_poasset->status_po     = 'SAVED';
        $tambah_poasset->address       = $request['address'];
        $tambah_poasset->telp          = $request['telp'];
        $tambah_poasset->fax           = $request['fax'];
        $tambah_poasset->email         = $request['email'];
        $tambah_poasset->attention     = $request['att'];
        $tambah_poasset->project_id    = $request['project_id'];
        $tambah_poasset->save();
        

        $id_pam     = $tambah_poasset->id_po_asset;
        $produk     = $request->information;
        $msp_code   = $request->msp_code;
        $qty        = $request->ket_aja;
        $unit       = $request->unit;
        $id_barangs = $request->product;

        if(count($produk) > count($qty))
            $count = count($qty);
        else $count = count($produk);

        for($i = 0; $i < $count; $i++){
            $data = array(
                'id_barang'     => $id_barangs[$i],
                'id_po_asset'   => $id_pam,
                'name_product'  => $produk[$i],
                'qty'           => $qty[$i],
                'qty_awal'      => $qty[$i],
                'unit'          => $unit[$i],
                'qty_terima'    => '0',
            );

            $insertData[] = $data;
        }
        pam_produk_msp::insert($insertData);

        return redirect('po_asset_msp')->with('success', 'Created Delivery Order Successfully!');

    }

    public function publish_status(Request $request)
    {
        $id_po = $request['id_po']; 

        $update = POAssetMSP::where('id_po_asset', $id_po)->first();
        $update->status_po = 'FINANCE';
        $update->update();

         return redirect()->back();
    }

    public function store_produk(Request $request)
    {
        $id_pam = $request['id_pam'];
        
        $produk     = $request->name_product;
        $msp_code   = $request->msp_code;
        $qty        = $request->qty;
        $unit       = $request->unit;
        // $nominal    = $request->nominal;
        // $ket        = $request->ket;
        $id_barangs = $request->id_barangs;

        if(count($produk) > count($qty))
            $count = count($qty);
        else $count = count($produk);

        for($i = 0; $i < $count; $i++){
            $data = array(
                'id_barang'     => $id_barangs[$i],
                'id_po_asset'   => $id_pam,
                'name_product'  => $produk[$i],
                'msp_code'      => $msp_code[$i],
                'qty'           => $qty[$i],
                'qty_awal'      => $qty[$i],
                'unit'          => $unit[$i],
                'qty_terima'    => '0',
                /*'nominal'       => str_replace(',', '', $nominal[$i]),
                'total_nominal' => $qty[$i] * str_replace(',', '', $nominal[$i]),*/
                /*'description'   => $ket[$i],*/
            );

            $insertData[] = $data;
        }
        pam_produk_msp::insert($insertData);

        $update = POAssetMSP::where('id_po_asset',$id_pam)->first();
        $update->status_po     = 'SAVED';
        $update->update();

        return redirect('po_asset_msp')->with('success', 'Add Product Successfully!');
    }

    public function store_po(Request $request)
    {
        // $lastnumber_po = $request['no_po'];
        // $month_pr = date("m");
        // $year_pr  = date("Y");
        $month_pr = substr($request['create_date'], 5,2);
        $year_pr = substr($request['create_date'], 0,4);

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

        // $getnumber_po = PONumberMSP::orderBy('no', 'desc')->first();

        // if($getnumber_po == NULL){
        //     $getlastnumber_po = 1;
        //     $lastnumber_po = $getlastnumber_po;
        // } else{
        //     $lastnumber_po = $getnumber_po->no+1;
        // }

        $lastnumber_po = $request['no_po'];

        if($lastnumber_po < 10){
           $akhirnomor_po = '000' . $lastnumber_po;
        }elseif($lastnumber_po > 9 && $lastnumber_po < 100){
           $akhirnomor_po = '00' . $lastnumber_po;
        }elseif($lastnumber_po >= 100){
           $akhirnomor_po = '0' . $lastnumber_po;
        }

        $no_po = $akhirnomor_po .'/'. 'FA' . '/' . 'PO' .'/'. $bln . '/' . $year_pr;
        // $lastnopr = PR_MSP::select('no')->orderby('created_at','desc')->first();
        $lastnopr = $request['no_pr'];
        $lastpo = PONumberMSP::select('no')->orderby('no','desc')->first(); 


        $tambah_nopo = new PONumberMSP();
        $tambah_nopo->no = $lastpo->no+1;
        $tambah_nopo->no_po = $no_po;
        $tambah_nopo->month = $bln;
        $tambah_nopo->position = 'FA';
        $tambah_nopo->type_of_letter = 'PO';
        $tambah_nopo->date = $request['create_date'];
        $tambah_nopo->to = $request['to_agen'];
        $tambah_nopo->attention = $request['att'];
        $tambah_nopo->project = $request['project'];
        $tambah_nopo->from = Auth::User()->nik;
        $tambah_nopo->project_id = $request['project_id'];
        $tambah_nopo->save();

        $lastnopo = PONumberMSP::select('no')->orderby('created_at','desc')->first(); 

        $tambah_poasset = new POAssetMSP();
        $tambah_poasset->nik_admin     = Auth::User()->nik;
        $tambah_poasset->date_handover = date("Y-m-d");
        $tambah_poasset->no_pr         = $lastnopr;
        $tambah_poasset->no_po         = $lastnopo->no;
        // $tambah_poasset->id_pr_asset   = $last_id_pam->id_pam;
        $tambah_poasset->to_agen       = $request['to_agen'];
        $tambah_poasset->subject       = $request['subject'];
        $tambah_poasset->status_po     = 'NEW';
        $tambah_poasset->address       = $request['address'];
        $tambah_poasset->telp          = $request['telp'];
        $tambah_poasset->fax           = $request['fax'];
        $tambah_poasset->email         = $request['email'];
        $tambah_poasset->attention     = $request['att'];
        $tambah_poasset->project_id    = $request['project_id'];
        $tambah_poasset->save();

        return redirect('po_asset_msp')->with('success', 'Create PO Asset Successfully!');
    }

    public function delete_produk(Request $request)
    {
    	$hapus = pam_produk_msp::find($request->id_product);
        $hapus->delete();

        return redirect()->back();
    }

    public function update_produk(Request $request)
    {
        $id_product = $request['id_product_update'];

        /*$msp_code   = $request['msp_code_update'];
        $qty_awal   = $request['qty_update'];
        $qty        = $request['qty_update'];

        if(count($msp_code) > count($qty_awal)) 
            $count = count($qty_awal);
        else $count = count($msp_code);

        for($i = 0; $i < $count; $i++){
            $data = array(
                'msp_code'  => $msp_code[$i],
                'qty_awal'  => $qty_awal[$i],
                'qty'       => $qty[$i],
            );

            $insertData[] = $data;
        }

        DB::table('tb_pr_product_msp')->whereIn('id_product', $id_product)->update($insertData[]);*/

        $update = pam_produk_msp::where('id_product', $id_product)->first();
        $update->qty_awal = $request['qty_update'];
        $update->qty = $request['qty_update'];
        $update->update();

        return redirect()->back();
    }


    public function update_invoice(Request $request)
    {
        $id_po_asset = $request['id_invoice_po'];

        $enter = '<br />';

        $update = POAssetMSP::where('id_po_asset', $id_po_asset)->first();
        $invoice = DB::table('tb_po_asset_msp')->select('no_invoice')->where('id_po_asset',$id_po_asset)->first();
        $update->no_invoice = $invoice->no_invoice . $enter . $request['invoice_number'];
        $update->update();

        return redirect('po_asset_msp')->with('update', 'Successfully!');
    }

    public function update(Request $request)
    {
        $id_po_asset = $request['id_po_asset'];

        $update = POAssetMSP::where('id_po_asset', $id_po_asset)->first();
        $update->term          = nl2br($request['term']);
        $update->status_po     = 'FINANCE';
        $update->date_handover = date("Y-m-d H:i:s");
        $update->update();

        return redirect('po_asset_msp')->with('update', 'Successfully!');
    }

    public function getdropdownPR(Request $request)
    {
        return array(DB::table('tb_po_asset_msp')
                ->join('tb_po_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no')
                ->join('tb_pr_msp', 'tb_pr_msp.no', '=', 'tb_po_asset_msp.no_pr')
                ->join('tb_pam_msp', 'tb_pam_msp.id_pam', '=', 'tb_po_asset_msp.id_pr_asset')
                ->select('id_pam', 'tb_pr_msp.no', 'tb_pam_msp.subject', 'tb_pr_msp.no_pr', 'tb_pam_msp.to_agen', 'tb_pam_msp.attention', 'tb_po_asset_msp.term', 'tb_po_msp.no_po', 'tb_po_asset_msp.id_po_asset')
                ->where('tb_po_asset_msp.status_po', 'FNC')
                ->where('tb_pam_msp.id_pam',$request->no_pr)
                ->get(),$request->no_pr);
    }

    public function getdatapr(Request $request)
    {

        $cek_pro  = PR_MSP::select('project_id')->where('no',$request->Product)->first();

        if ($cek_pro->project_id == NULL) {
            return array(DB::table('tb_pr_msp')
                ->join('users', 'users.nik', '=', 'tb_pr_msp.from')
                ->select('id_project', 'no','no_pr', 'position', 'type_of_letter', 'month', 'tb_pr_msp.date', 'to', 'attention', 'title', 'project', 'description', 'from', 'issuance', 'project_id', 'name', 'subject')
                ->where('no',$request->Product)
                ->get(),$request->Product);
        }else{
            return array(DB::table('tb_pr_msp')
                ->join('tb_id_project','tb_id_project.id_pro','=','tb_pr_msp.project_id')
                ->join('users', 'users.nik', '=', 'tb_pr_msp.from')
                ->select('tb_id_project.id_project', 'no','no_pr', 'position', 'type_of_letter', 'month', 'tb_pr_msp.date', 'to', 'attention', 'title', 'project', 'description', 'from', 'issuance', 'project_id', 'name', 'subject')
                ->where('no',$request->Product)
                ->get(),$request->Product);
        }
        
    }

    public function getdropdownSubmitPR(Request $request)
    {
        return array(DB::table('tb_po_asset_msp')
            ->select('status_po')
            ->where('status_po', 'FNC')
            ->first(),$request->no_pr);
    }

    /*public function update_po(Request $request)
    {
        $id_po_asset = $request['id_po_asset'];

        $update = POAssetMSP::where('id_po_asset', $id_po_asset)->first();
        $update->term = nl2br($request['term']); 
        $update->status = 'FINANCE';
        $update->update();
    }*/

    public function downloadPDF2($id_po_asset)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $datas = DB::table('tb_po_asset_msp')
                ->join('users', 'users.nik', '=', 'tb_po_asset_msp.nik_admin')
                ->join('tb_po_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no')
                ->join('tb_pr_msp', 'tb_pr_msp.no', '=', 'tb_po_asset_msp.no_pr')
                ->join('tb_pam_msp', 'tb_pam_msp.id_pam', '=', 'tb_po_asset_msp.id_pr_asset')
                ->select('tb_pam_msp.date_handover','tb_pr_msp.no_pr','tb_po_asset_msp.to_agen','tb_pam_msp.status','tb_po_asset_msp.status_po','users.name','tb_po_asset_msp.subject', 'tb_pr_msp.no', 'tb_pr_msp.date', 'tb_po_asset_msp.attention', 'tb_po_asset_msp.project', 'tb_po_asset_msp.project_id', 'ppn', 'tb_po_asset_msp.term', 'tb_po_msp.no_po', 'tb_po_asset_msp.project_id', 'tb_po_asset_msp.id_po_asset', 'ppn', 'tb_po_asset_msp.term', 'tb_po_asset_msp.address', 'tb_po_asset_msp.telp', 'tb_po_asset_msp.fax', 'tb_po_asset_msp.email', 'tb_po_asset_msp.id_po_asset')
                ->where('tb_po_asset_msp.id_po_asset', $id_po_asset)
                ->first();

        $produks = DB::table('tb_pam_msp')
            ->join('tb_pr_product_msp','tb_pr_product_msp.id_pam','=','tb_pam_msp.id_pam')
            ->join('tb_po_asset_msp', 'tb_po_asset_msp.id_pr_asset', '=', 'tb_pam_msp.id_pam')
            ->select('tb_pr_product_msp.name_product','tb_pr_product_msp.qty','tb_pr_product_msp.id_pam','tb_pr_product_msp.nominal','tb_pr_product_msp.total_nominal', 'tb_pr_product_msp.description', 'tb_pr_product_msp.unit', 'tb_pr_product_msp.msp_code')
            ->where('tb_po_asset_msp.id_po_asset',$id_po_asset)
            ->get();

    	$total_amounts = DB::table('tb_pam_msp')
            ->join('tb_pr_product_msp','tb_pr_product_msp.id_pam','=','tb_pam_msp.id_pam')
            ->join('tb_po_asset_msp', 'tb_po_asset_msp.id_pr_asset', '=', 'tb_pam_msp.id_pam')
            ->select('total_nominal')
            ->where('tb_po_asset_msp.id_po_asset', $id_po_asset)
            ->sum('total_nominal');

        $total_amount = "Rp " . number_format($total_amounts,0,'','.');

        $ppns = $total_amounts * (10/100);

        $ppn   = "Rp " . number_format($ppns,0,'','.');

        $grand_total = $total_amounts + $ppns;

        $grand_total2 =  "Rp " . number_format($grand_total,0,'','.');

        return view('admin_msp.po_pdf', compact('datas','produks','total_amount', 'nominal', 'ppn', 'grand_total2'));
        // return $pdf->download('Purchase Order '.$datas->no_po.' '.'.pdf');
    }
    
}
