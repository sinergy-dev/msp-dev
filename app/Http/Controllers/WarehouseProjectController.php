<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Warehouse;
use Auth;
use App\Category_in;
use App\Type_in;
use App\User;
use App\Inventory_msp;
use App\Inventory;
use App\Detail_inventory;
use App\WarehouseProject;
use App\WarehouseProjectDetail;
use App\WarehouseProjectMSP;
use App\WarehouseProjectMSPDetail;
use App\Inventory_msp_changelog;
use App\DONumber;
use App\DOMSPNumber;
use App\projectInventory;
use App\Project_msp_changelog;
use App\POAssetMSP;
use App\pam_produk_msp;
use App\SalesProject;
use DB;
use PDF;
use Excel;

use Mail;
use App\Notifications\EmailSubmitDO;
use Notification;

class WarehouseProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function add_id_project(Request $request)
	{
		$tambah 			= new SalesProject();
        $tambah->status     = 'WO';
		$tambah->id_pro 	= (int)$request['last_idpro'] - 1;
		$tambah->lead_id 	= 'MSPCOBA190102';
		$tambah->id_project = $request['input_id_project'];
		$tambah->date 	 	= date('Y-m-d');
		$tambah->save();

		return redirect()->back()->with('alert', 'Created Project Id Successfully!');
	}

    public function tambah_meter_do(Request $request) 
    {

        $iprom = $request['iprom'];
        $ipro = $request['ipro'];

        $current_stock_m = Inventory_msp::select('qty_m')->where('id_product',$ipro)->first(); // 300
        $current_stock = Inventory_msp::select('qty')->where('id_product',$ipro)->first(); // 13

        $req_m = $request['jml_roll'] * 300; // 300

        $update = Inventory_msp::where('id_product',$iprom)->first();
        $update->qty = $current_stock_m->qty_m + $req_m;
        $update->update();

        $update_m = Inventory_msp::where('id_product',$ipro)->first();
        $update_m->qty = $current_stock->qty - $request['jml_roll'];
        $update_m->qty_m = $current_stock_m->qty_m + $req_m;
        $update_m->update();

        return back()->with('success', 'Update Record successfully.');

    }

    public function view_do()
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

        $datas = DB::table('tb_do_msp')
                        ->select('no','no_do','type_of_letter', 'month', 'date', 'to', 'attention', 'title', 'project', 'description','project_id')
                        ->where('updated_at', '>=', '2019-08-05')
                        ->get();

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

        return view('report/do_msp', compact('lead', 'total_ter','notif','notifOpen','notifsd','notiftp','datas', 'notifClaim'));
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

        $data = WarehouseProject::join('tb_do','tb_do.no','=','inventory_project_transaction.no_do')
                ->join('inventory_produk','inventory_produk.id_barang','=','inventory_project_transaction.fk_id_barang')
                ->select('tb_do.no_do','inventory_produk.nama','inventory_produk.note','inventory_project_transaction.id_transaction')
                ->get();

        $barang = Inventory::select('id_barang','nama','note','qty')->get();

        $do_number = DONumber::select('no_do','no')->get();

        $category = category_in::select('id_category','category')->get();

        $type = type_in::select('id_type','type')->get();

      
        return view('gudang/project/project', compact('notif','notifOpen','notifsd','notiftp','barang','notifc','notifem','category','type','do_number','data'));
    }

    public function add_project_delivery(Request $request)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $idpro = SalesProject::select('id_pro')->orderBy('id_pro','asc')->first();

        $datas = WarehouseProjectMSP::join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                ->select('inventory_delivery_msp.to_agen','inventory_delivery_msp.from','inventory_delivery_msp.address','inventory_delivery_msp.id_transaction','inventory_delivery_msp.telp','inventory_delivery_msp.fax','inventory_delivery_msp.attn','inventory_delivery_msp.subj','inventory_delivery_msp.date','inventory_delivery_msp.id_transaction','tb_do_msp.no_do','inventory_delivery_msp.id_transaction','inventory_delivery_msp.status_kirim','inventory_delivery_msp.created_at')
                ->get();

        $no_po = POAssetMSP::join('tb_po_msp','tb_po_msp.no','=','tb_po_asset_msp.no_po')
                // ->join('tb_pam_msp','tb_pam_msp.no_po','=','tb_po_msp.no')
                ->select('tb_po_msp.no','tb_po_msp.no_po','tb_po_asset_msp.subject', 'id_po_asset','to_agen')
                ->where('tb_po_asset_msp.status_po','DONE')
                ->get();

        $barang = Inventory_msp::select('kode_barang','id_product','nama','note','qty','qty_sisa_submit')->where('qty','!=',0)
        ->where('qty_sisa_submit','!=',0)
        ->get();

        $id_product = $request['product'];

        $compares = Inventory_msp::select('unit')->where('id_product',$id_product)->first();

        $project_id = DB::table('tb_id_project')
                        ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                        ->join('users','users.nik','=','sales_lead_register.nik')
                        ->select('id_project', 'tb_id_project.id_pro')
                        // ->where('status','!=','WO')
                        ->where('id_company', '2')
                        ->get();

        $do_number = DONumber::select('no_do','no')->get();

        $category = category_in::select('id_category','category')->get();

        $type = type_in::select('id_type','type')->get();

        $detail = NULL;
  
        return view('gudang/project/add_project_msp', compact('notif','notifOpen','notifsd','notiftp','barang','notifc','notifem','category','type',
            'do_number','datas','barangs','project_id','detail','compares','no_po','idpro'));
    }

    public function getDropdownPO(Request $request)
    {  
        return array(DB::table('tb_po_asset_msp')
            ->join('tb_pr_product_msp','tb_pr_product_msp.id_po_asset','=','tb_po_asset_msp.id_po_asset')
            ->join('inventory_produk_msp','inventory_produk_msp.id_product','=','tb_pr_product_msp.id_barang')
            ->select('tb_pr_product_msp.name_product','tb_pr_product_msp.qty', 'tb_pr_product_msp.unit', 'tb_pr_product_msp.msp_code','tb_pr_product_msp.id_product','tb_po_asset_msp.id_po_asset','tb_po_asset_msp.status_po','tb_pr_product_msp.id_barang','tb_pr_product_msp.qty_terima','inventory_produk_msp.qty as qty_master', 'inventory_produk_msp.id_product as id_product_inventory', 'inventory_produk_msp.qty_sisa_submit', 'tb_pr_product_msp.qty_do')
            ->where('tb_pr_product_msp.id_po_asset',$request->product)
            // ->where('tb_pr_product_msp.qty','!=',0)
            ->where('tb_po_asset_msp.status_po', 'DONE')
            ->get(),$request->product);
    }

    public function update_view_project_delivery($id_transaction)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $datas = WarehouseProjectMSP::join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                ->select('inventory_delivery_msp.to_agen','inventory_delivery_msp.from','inventory_delivery_msp.address','inventory_delivery_msp.id_transaction','inventory_delivery_msp.telp','inventory_delivery_msp.fax','inventory_delivery_msp.attn','inventory_delivery_msp.subj','inventory_delivery_msp.date','inventory_delivery_msp.id_transaction','tb_do_msp.no_do','inventory_delivery_msp.id_transaction','inventory_delivery_msp.status_kirim')
                ->where('inventory_delivery_msp.id_transaction',$id_transaction)
                ->get();

        $detail = DB::table('inventory_delivery_msp')
            ->select('date','subj','from','to_agen','attn','id_project','address','telp','fax','id_transaction')
            ->where('id_transaction',$id_transaction)
            ->first();

        $barang = Inventory_msp::select('kode_barang','id_product','nama','note','qty')->where('qty','!=',0)->get();

        $project_id = DB::table('tb_id_project')
                        ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                        ->join('users','users.nik','=','sales_lead_register.nik')
                        ->select('id_project')
                        ->where('id_company', '2')
                        ->get();

        $do_number = DONumber::select('no_do','no')->get();

        $category = category_in::select('id_category','category')->get();

        $type = type_in::select('id_type','type')->get();

   
        return view('gudang/project/add_project_msp', compact('notif','notifOpen','notifsd','notiftp','barang','notifc','notifem','category','type',
            'do_number','datas','barangs','project_id','detail'));
    }

    public function return_produk_delivery()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $id_pro = DB::table('inventory_delivery_msp')
                        ->select('id_project')
                        ->where('status_kirim', 'kirim')
                        ->first();

        $datas = WarehouseProjectMSP::join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                ->select('inventory_delivery_msp.to_agen','inventory_delivery_msp.from','inventory_delivery_msp.address','inventory_delivery_msp.id_transaction','inventory_delivery_msp.telp','inventory_delivery_msp.fax','inventory_delivery_msp.attn','inventory_delivery_msp.subj','inventory_delivery_msp.date','inventory_delivery_msp.id_transaction','tb_do_msp.no_do','inventory_delivery_msp.id_transaction','inventory_delivery_msp.status_kirim')
                ->get();

        $barang = Inventory_msp::select('kode_barang','id_product','nama','note','qty')->where('qty','!=',0)->get();

        $project_id = DB::table('inventory_delivery_msp')
                        ->join('tb_id_project','tb_id_project.id_pro','=','inventory_delivery_msp.id_project')
        				->select('tb_id_project.id_project','tb_id_project.id_pro')
                        ->where('status_kirim', 'kirim')
                        ->orWhere('status_kirim','SENT')
                        ->groupBy('inventory_delivery_msp.id_project')
                        ->get();

        $msp_code = DB::table('inventory_produk_msp')
                    ->join('inventory_delivery_msp_transaction','inventory_delivery_msp_transaction.fk_id_product','=','inventory_produk_msp.id_product')
                    ->join('inventory_delivery_msp','inventory_delivery_msp.id_transaction','=','inventory_delivery_msp_transaction.id_transaction')
                    ->select('inventory_produk_msp.kode_barang','inventory_produk_msp.nama','inventory_produk_msp.id_product')
                    ->where('inventory_delivery_msp.status_kirim','kirim')
                    ->orWhere('status_kirim','SENT')
                    ->where('tipe','!=','return')
                    ->groupBy('inventory_delivery_msp_transaction.fk_id_product')
                    ->get();

        $do_number = DONumber::select('no_do','no')->get();

        $category = category_in::select('id_category','category')->get();

        $type = type_in::select('id_type','type')->get();

        return view('gudang/project/return_produk_msp', compact('notif','notifOpen','notifsd','notiftp','barang','notifc','notifem','category','type',
            'do_number','datas','barangs','project_id','msp_code'));
    }

    public function inventory_index_msp(Request $request)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position; 

        if ($pos == 'PM') {
            $datas = WarehouseProjectMSP::join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                ->join('users','users.nik','=','inventory_delivery_msp.nik_pm')
                ->select('inventory_delivery_msp.to_agen','inventory_delivery_msp.from','inventory_delivery_msp.address','inventory_delivery_msp.id_transaction','inventory_delivery_msp.telp','inventory_delivery_msp.fax','inventory_delivery_msp.attn','inventory_delivery_msp.subj','inventory_delivery_msp.date','inventory_delivery_msp.id_transaction','tb_do_msp.no_do','inventory_delivery_msp.id_transaction','inventory_delivery_msp.status_kirim','users.name')
                ->where('nik_pm',$nik)
                ->orderBy('tb_do_msp.no_do','desc')
                ->where('inventory_delivery_msp.updated_at', '>=', '2019-08-06')
                ->get();

        }else{
            $datas = WarehouseProjectMSP::join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                ->join('tb_id_project','tb_id_project.id_pro','=','inventory_delivery_msp.id_project')
                ->join('users','users.nik','=','inventory_delivery_msp.nik_pm')
                ->select('inventory_delivery_msp.to_agen','inventory_delivery_msp.from','inventory_delivery_msp.address','inventory_delivery_msp.id_transaction','inventory_delivery_msp.telp','inventory_delivery_msp.fax','inventory_delivery_msp.attn','inventory_delivery_msp.subj','inventory_delivery_msp.date','inventory_delivery_msp.id_transaction','tb_do_msp.no_do','inventory_delivery_msp.id_transaction','inventory_delivery_msp.status_kirim','users.name','tb_id_project.id_project')
                // ->orderBy('tb_do_msp.no_do','desc')
                ->where('inventory_delivery_msp.updated_at', '>=', '2019-08-06')
                ->orderBy('tb_do_msp.created_at', 'desc')
                ->get();

        }
        
        $barang = Inventory_msp::select('id_product','nama','note','qty')->where('qty','!=',0)->get();

        $do_number = DONumber::select('no_do','no')->get();

        $category = category_in::select('id_category','category')->get();

        $type = type_in::select('id_type','type')->get();

        return view('gudang/project/project_msp', compact('notif','notifOpen','notifsd','notiftp','barang','notifc','notifem','category','type','do_number','datas','barangs'));
    }

    public function publish_status(Request $request)
    {
        $id_transaction = $request['id_transac_edit'];

        $update = WarehouseProjectMSP::where('id_transaction',$id_transaction)->first();
        if(Auth::User()->id_division == 'PMO') {
        $update->status_kirim = 'PM';
        $update->date = date("Y-m-d H:i:s");
        }elseif(Auth::User()->id_position == 'ADMIN') {
            $update->status_kirim = 'kirim';
            $update->date         = date("Y-m-d H:i:s");
            $produk         = $_POST['id_produks'];
            $qty_before     = $_POST['qty_before'];
            $qty_awal       = $_POST['qty_stock'];

            $unit_publish	= $_POST['unit_publish'];

            $qty_last = (float)$qty_before / 300.0;

            if(count($produk) > count($unit_publish))
            $count = count($unit_publish);
            else $count = count($produk);

            $qty_submit = Inventory_msp::select('qty_sisa_submit')->where('id_product', $produk)->first();
            $qty_submits = $qty_submit->qty_sisa_submit;

            for($i = 0; $i < $count; $i++){

                if ($qty_before == $qty_submits) {
                    $datak = array(
                        'qty' => (float)$qty_awal[$i] - (float)$qty_before[$i],
                        'status' => 'Y',
                        'qty_sisa_submit' => '',
                    );
                }else{
                    $datak = array(
                        'qty' => (float)$qty_awal[$i] - (float)$qty_before[$i],
                        'status' => 'Y',
                    );
                }
                
                Inventory_msp::where('id_product',$produk[$i])->update($datak);

                $datas = array(
                'qty'           => $qty_before[$i],
                'id_product'    => $produk[$i],
                'note'          => $request['no_do_publish'],
                'status'        => 'D',
                );

                $insertDatas[] = $datas;
            }

            Inventory_msp_changelog::insert($insertDatas);

            // $users = User::where('email','arkhab@sinergy.co.id')->first();
            // Notification::send($users, new EmailSubmitDO());
            
        }elseif(Auth::User()->id_division == 'WAREHOUSE'){
            $update->status_kirim = 'SENT';
            $update->date = date("Y-m-d H:i:s");
        }
        $update->update(); 
        
        return redirect('/inventory/do/msp')->with('alert', 'Products Delivery Order Published!');
    }

    public function update_project_do(Request $request)
    {
        $id_transaction = $request['id_transac_edit'];

        $update = WarehouseProjectMSP::where('id_transaction',$id_transaction)->first();
        $update->to_agen        = $request['to_agen'];
        $update->address        = $request['add'];
        $update->telp           = $request['telp'];
        $update->fax            = $request['fax'];
        $update->attn           = $request['att'];
        $update->from           = $request['from'];
        $update->subj           = $request['subj'];
        $update->date           = $request['date'];
        if (Auth::User()->id_division == 'PMO') {
            $update->id_project     = $request['id_project'];
        }
        $update->update();

        $update_id  = Project_msp_changelog::where('id_transaction',$id_transaction)->first();
        $update_id->id_project  = $request['id_project'];
        $update_id->update();

        return redirect()->back()->with('update', 'Delivery Order has been Updated!');
    }

    public function getDropdown(Request $request)
    {
        $product = $request['product'];

        return array(DB::table('detail_inventory_produk')
                ->join('inventory_produk','inventory_produk.id_barang','=','detail_inventory_produk.id_barang')
                ->select('nama','serial_number','id_detail')
                ->where('detail_inventory_produk.id_barang',$request->product)
                ->get(),$request->product);
    }

    public function getDropdownSubmit(Request $request){
        return array(DB::table('inventory_delivery_msp_transaction')
        	->join('inventory_produk_msp','inventory_produk_msp.id_product','=','inventory_delivery_msp_transaction.fk_id_product')
        	->select('inventory_produk_msp.nama','inventory_produk_msp.qty')->where('inventory_delivery_msp_transaction.fk_id_product','!=',$request->product)->get(),$request->product);
    }

    public function getDetailProduk(Request $request)
    {            
        $product = $request['serial_number_produk'];

        return array(DB::table('detail_inventory_project_transaction')
                ->join('detail_inventory_produk','detail_inventory_produk.id_detail','=','detail_inventory_project_transaction.id_detail_barang')
                ->select('serial_number')
                ->where('detail_inventory_project_transaction.id_transaction',$product)
                ->get(),$request->product);
    }

    public function getQtyMsp(Request $request)
    {            
        $product = $request['product'];
        
        $kode = Inventory_msp::select('kode_barang','id_product')->where('id_product',$product)->first();

        $select_unit = $request['select-unit'];

        $id_product = $kode->id_product - 1;

        $kodem = $kode->kode_barang.'M';

        $kodems = Inventory_msp::select('kode_barang','id_product')->where('kode_barang',$kodem)->first();

        return array(DB::table('inventory_produk_msp')
                ->select('qty','unit','nama','kode_barang','id_product','qty_sisa_submit','status2')
                ->where('id_product',$product)
                ->get(),$request->product);
    }

    public function dropdownidpro(Request $request)
    {
    	$product = $request['product'];

    	return array(DB::table('inventory_delivery_msp_transaction')
    			->join('inventory_delivery_msp','inventory_delivery_msp.id_transaction','=','inventory_delivery_msp_transaction.id_transaction')
    			->join('tb_id_project','tb_id_project.id_pro','inventory_delivery_msp.id_project')
                ->select('tb_id_project.id_project')
                ->where('fk_id_product',$product)
                ->groupBy('tb_id_project.id_project')
                ->get(),$request->product);
    }


    public function Detail_do_msp(Request $request, $id_transaction)
    {

        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position; 

      
        $datas = WarehouseProjectMSP::join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                ->select('inventory_delivery_msp.to_agen','inventory_delivery_msp.from','inventory_delivery_msp.address','inventory_delivery_msp.id_transaction','inventory_delivery_msp.telp','inventory_delivery_msp.fax','inventory_delivery_msp.attn','inventory_delivery_msp.subj','inventory_delivery_msp.date','inventory_delivery_msp.id_transaction','tb_do_msp.no_do','inventory_delivery_msp.id_transaction','inventory_delivery_msp.status_kirim')
                ->get();


        $detail_c_head = Project_msp_changelog::join('tb_id_project','tb_id_project.id_pro','=','change_log_project_msp.id_project')
                    ->join('inventory_produk_msp','inventory_produk_msp.id_product','=','change_log_project_msp.fk_id_product')
                    ->select('inventory_produk_msp.nama','inventory_produk_msp.kode_barang','change_log_project_msp.qty_transac','unit','change_log_project_msp.date','subj','from','to_agen','attn','tb_id_project.id_project','address','telp','fax')
                    ->where('change_log_project_msp.id_transaction',$id_transaction)
                    ->where('change_log_project_msp.created_at','desc')
                    ->first();

        $detail_c = Project_msp_changelog::join('tb_id_project','tb_id_project.id_pro','=','change_log_project_msp.id_project')
                    ->join('inventory_delivery_msp_transaction','inventory_delivery_msp_transaction.id_detail_do_msp','=','change_log_project_msp.id_detail_do')
                    ->join('inventory_produk_msp','inventory_produk_msp.id_product','=','change_log_project_msp.fk_id_product')
                    ->select('inventory_produk_msp.nama','inventory_produk_msp.kode_barang','change_log_project_msp.qty_transac','change_log_project_msp.date','inventory_delivery_msp_transaction.unit','change_log_project_msp.status')
                    ->where('change_log_project_msp.id_transaction',$id_transaction)
                    ->orderBy('change_log_project_msp.created_at','desc')
                    ->get();

        $to = WarehouseProjectMSP::join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')->join('tb_id_project','tb_id_project.id_pro','=','inventory_delivery_msp.id_project')->join('users','users.nik','=','inventory_delivery_msp.nik_pm')->select('inventory_delivery_msp.to_agen','inventory_delivery_msp.from','tb_id_project.id_project','inventory_delivery_msp.address','inventory_delivery_msp.subj','users.name','tb_do_msp.no_do')->where('inventory_delivery_msp.id_transaction',$id_transaction)->first();

        $detail = WarehouseProjectMSPDetail::join('inventory_delivery_msp','inventory_delivery_msp.id_transaction','=',
                'inventory_delivery_msp_transaction.id_transaction')
                ->join('inventory_produk_msp','inventory_produk_msp.id_product','=','inventory_delivery_msp_transaction.fk_id_product')
                ->select('inventory_produk_msp.nama','inventory_produk_msp.kode_barang','inventory_delivery_msp_transaction.created_at','inventory_produk_msp.id_po','inventory_delivery_msp_transaction.note','inventory_delivery_msp_transaction.qty_transac','inventory_produk_msp.unit','inventory_delivery_msp_transaction.unit as unit_publish','inventory_delivery_msp.to_agen','inventory_produk_msp.id_product','inventory_delivery_msp.to_agen','inventory_delivery_msp.id_transaction','inventory_delivery_msp_transaction.id_detail_do_msp','inventory_produk_msp.qty','inventory_delivery_msp.id_project','inventory_delivery_msp.created_at', 'inventory_produk_msp.qty_sisa_submit')
                ->where('inventory_delivery_msp_transaction.id_transaction',$id_transaction)
                ->orderBy('inventory_delivery_msp_transaction.created_at','desc')
                ->get();

        $details = WarehouseProjectMSP::join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                ->join('tb_id_project','tb_id_project.id_pro','=','inventory_delivery_msp.id_project')
                ->select('inventory_delivery_msp.to_agen','inventory_delivery_msp.to_agen','inventory_delivery_msp.id_transaction','tb_do_msp.no','inventory_delivery_msp.id_project','inventory_delivery_msp.created_at','inventory_delivery_msp.status_kirim','tb_id_project.id_pro','tb_id_project.id_project','tb_do_msp.no_do')
                ->where('inventory_delivery_msp.id_transaction',$id_transaction)
                ->first();

        $changelog = Inventory_msp_changelog::select('created_at','qty','note')->where('id_detail_do_msp',$id_transaction)->where('status','W')->get();

        $cek_product = WarehouseProjectMSPDetail::where('id_transaction',$id_transaction)->count('id_transaction');

        $barang_transaction = WarehouseProjectMSPDetail::join('inventory_produk_msp','inventory_produk_msp.id_product','=','inventory_delivery_msp_transaction.fk_id_product')->select('fk_id_product')->where('id_transaction',$id_transaction)->get();

        $barang_transaction->toArray('fk_id_product');


        $datak = $request['fk_id_product'];

        $cek = DB::table('inventory_delivery_msp')
            ->join('tb_id_project','tb_id_project.id_pro','=','inventory_delivery_msp.id_project')
            ->select('inventory_delivery_msp.date','subj','from','to_agen','attn','tb_id_project.id_pro','tb_id_project.id_project','address','telp','fax','id_transaction')
            ->where('id_transaction',$id_transaction)
            ->first();

        $cek_barang = WarehouseProjectMSPDetail::where('id_transaction',$id_transaction)->count('id_detail_do_msp');

        $project_id = DB::table('tb_id_project')
                        ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                        ->join('users','users.nik','=','sales_lead_register.nik')
                        ->select('id_project','tb_id_project.id_pro')
                        ->where('id_company', '2')
                        ->get();


        $barang = Inventory_msp::select('id_product','nama','note','qty','kode_barang')->where('qty','!=',0)->whereNotIn('id_product',function($query) use ($id_transaction) {
            $query->select('fk_id_product')->where('id_transaction',$id_transaction)->from('inventory_delivery_msp_transaction');
        })->get();

        return view('gudang/project/detail_project_msp', compact('array','cek_product','datas','datak','to','detail','details','barang','barang_transaction','notif','notifOpen','notifsd','notiftp','notifc','notifem','ids','result','changelog','datas','cek','project_id','detail_c','detail_c_head','cek_barang'));
    }

    public function copy_do_msp(Request $request, $id_transaction)
    {

        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position; 

      
        $datas = WarehouseProjectMSP::join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                ->select('inventory_delivery_msp.to_agen','inventory_delivery_msp.from','inventory_delivery_msp.address','inventory_delivery_msp.id_transaction','inventory_delivery_msp.telp','inventory_delivery_msp.fax','inventory_delivery_msp.attn','inventory_delivery_msp.subj','inventory_delivery_msp.date','inventory_delivery_msp.id_transaction','tb_do_msp.no_do','inventory_delivery_msp.id_transaction','inventory_delivery_msp.status_kirim')
                ->get();


        $detail_c_head = Project_msp_changelog::join('tb_id_project','tb_id_project.id_pro','=','change_log_project_msp.id_project')
                    ->join('inventory_produk_msp','inventory_produk_msp.id_product','=','change_log_project_msp.fk_id_product')
                    ->select('inventory_produk_msp.nama','inventory_produk_msp.kode_barang','change_log_project_msp.qty_transac','unit','change_log_project_msp.date','subj','from','to_agen','attn','tb_id_project.id_project','address','telp','fax')
                    ->where('change_log_project_msp.id_transaction',$id_transaction)
                    ->first();

        $detail_c = Project_msp_changelog::join('tb_id_project','tb_id_project.id_pro','=','change_log_project_msp.id_project')
                    ->join('inventory_delivery_msp_transaction','inventory_delivery_msp_transaction.id_detail_do_msp','=','change_log_project_msp.id_detail_do')
                    ->join('inventory_produk_msp','inventory_produk_msp.id_product','=','change_log_project_msp.fk_id_product')
                    ->select('inventory_produk_msp.nama','inventory_produk_msp.kode_barang','change_log_project_msp.qty_transac','inventory_produk_msp.unit')
                    ->where('change_log_project_msp.id_transaction',$id_transaction)
                    ->get();

        $to = WarehouseProjectMSP::join('tb_id_project','tb_id_project.id_pro','=','inventory_delivery_msp.id_project')->join('users','users.nik','=','inventory_delivery_msp.nik_pm')->select('inventory_delivery_msp.to_agen','inventory_delivery_msp.from','tb_id_project.id_project','inventory_delivery_msp.address','inventory_delivery_msp.subj','users.name','nik_pm')->where('inventory_delivery_msp.id_transaction',$id_transaction)->first();

        $detail = WarehouseProjectMSPDetail::join('inventory_delivery_msp','inventory_delivery_msp.id_transaction','=',
                'inventory_delivery_msp_transaction.id_transaction')
                ->join('inventory_produk_msp','inventory_produk_msp.id_product','=','inventory_delivery_msp_transaction.fk_id_product')
                ->select('inventory_produk_msp.nama','inventory_produk_msp.kode_barang','inventory_delivery_msp_transaction.created_at','inventory_produk_msp.id_po','inventory_delivery_msp_transaction.note','inventory_delivery_msp_transaction.qty_transac','inventory_produk_msp.unit','inventory_delivery_msp_transaction.unit as unit_publish','inventory_delivery_msp.to_agen','inventory_produk_msp.id_product','inventory_delivery_msp.to_agen','inventory_delivery_msp.id_transaction','inventory_delivery_msp_transaction.id_detail_do_msp','inventory_produk_msp.qty','inventory_produk_msp.qty_sisa_submit')
                ->where('inventory_produk_msp.qty_sisa_submit','!=',0)
                ->where('inventory_produk_msp.qty','!=',0)
                ->where('inventory_delivery_msp_transaction.id_transaction',$id_transaction)
                ->orderBy('inventory_delivery_msp_transaction.created_at','desc')
                ->get();

        $details = WarehouseProjectMSP::join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                ->join('tb_id_project','tb_id_project.id_pro','=','inventory_delivery_msp.id_project')
                ->select('inventory_delivery_msp.to_agen','inventory_delivery_msp.to_agen','inventory_delivery_msp.id_transaction','tb_do_msp.no','inventory_delivery_msp.id_project','inventory_delivery_msp.created_at','inventory_delivery_msp.status_kirim','tb_id_project.id_pro','tb_id_project.id_project','tb_do_msp.no_do')
                ->where('inventory_delivery_msp.id_transaction',$id_transaction)
                ->first();

        $changelog = Inventory_msp_changelog::select('created_at','qty','note')->where('id_detail_do_msp',$id_transaction)->where('status','W')->get();

        $cek_product = WarehouseProjectMSPDetail::where('id_transaction',$id_transaction)->count('id_transaction');

        $barang_transaction = WarehouseProjectMSPDetail::join('inventory_produk_msp','inventory_produk_msp.id_product','=','inventory_delivery_msp_transaction.fk_id_product')->select('fk_id_product')->where('id_transaction',$id_transaction)->get();

        $barang_transaction->toArray('fk_id_product');


        $datak = $request['fk_id_product'];

        $cek = DB::table('inventory_delivery_msp')
            ->join('tb_id_project','tb_id_project.id_pro','=','inventory_delivery_msp.id_project')
            ->select('inventory_delivery_msp.date','subj','from','to_agen','attn','tb_id_project.id_pro','tb_id_project.id_project','address','telp','fax','id_transaction')
            ->where('id_transaction',$id_transaction)
            ->first();

        $cek_barang = WarehouseProjectMSPDetail::where('id_transaction',$id_transaction)->count('id_detail_do_msp');

        $project_id = DB::table('tb_id_project')
                        ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                        ->join('users','users.nik','=','sales_lead_register.nik')
                        ->select('id_project','tb_id_project.id_pro')
                        ->where('id_company', '2')
                        ->get();


        $barang = Inventory_msp::select('id_product','nama','note','qty','kode_barang')->where('qty','!=',0)->whereNotIn('id_product',function($query) use ($id_transaction) {
            $query->select('fk_id_product')->where('id_transaction',$id_transaction)->from('inventory_delivery_msp_transaction');
        })->get();

        $barang_copy = Inventory_msp::select('id_product','nama','note','qty','kode_barang')->where('qty','!=',0)->get();

        return view('gudang/project/copy_project_msp', compact('array','cek_product','datas','datak','to','detail','details','barang','barang_transaction','notif','notifOpen','notifsd','notiftp','notifc','notifem','ids','result','changelog','datas','cek','project_id','detail_c','detail_c_head','cek_barang','barang_copy'));
    }

    public function filterTableWarehouse(Request $request){
        
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_delivery_msp(Request $request)
    {  
        $type = 'SJ';
        $month_pr = substr($request->date_today, 5,2);

        $year_pr = substr($request->date_today, 0,4);
        // return $month_pr;
        $nomor_do = $request['no_do'];

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

        if($nomor_do < 10){
           $akhirnomor = '000' . $nomor_do;
        }elseif($nomor_do > 9 && $nomor_do < 100){
           $akhirnomor = '00' . $nomor_do;
        }elseif($nomor_do >= 100){
           $akhirnomor = '0' . $nomor_do;
        }

        $no = $akhirnomor .'/'. $type .'/' . $bln .'/'. $year_pr;
        $lastnumberdo = DOMSPNumber::select('no')->orderBy('no', 'desc')->first();
        
        $store = new DOMSPNumber();
        $store->no              = $lastnumberdo->no+1;
        $store->no_do           = $no;
        $store->type_of_letter  = $type;
        $store->month           = $bln;
        $store->date            = $request['date_today'];
        $store->to              = $request['to_agen'];
        $store->attention       = $request['att'];
        $store->project_id      = $request['id_project'];
        $store->save();

        $no_do = DOMSPNumber::select('no','no_do')->orderBy('created_at','desc')->first();

        $tambah = new WarehouseProjectMSP();
        $tambah->to_agen        = $request['to_agen'];
        $tambah->address        = $request['add'];
        $tambah->telp           = $request['telp'];
        $tambah->fax            = $request['fax'];
        $tambah->attn           = $request['att'];
        $tambah->from           = $request['from'];
        $tambah->subj           = $request['subj'];
        // $tambah->date           = date("Y-m-d H:i:s");
        $tambah->date 			= $request['date_today'];
        $tambah->no_do          = $no_do->no;
        $tambah->id_project     = $request['id_project'];
        if (Auth::User()->id_position == 'ADMIN' || Auth::User()->email == 'budigunawan@solusindoperkasa.co.id') {
            $tambah->status_kirim   = 'PM'; 
            $tambah->nik_pm         = $request['pm_nik'];
        }else{
            $tambah->status_kirim   = NULL;
            $tambah->nik_pm         = Auth::User()->nik;
        }
        $tambah->save();
        
        $lastInsertedId = WarehouseProjectMSP::select('id_transaction')->orderBy('created_at','desc')->first();

        $produk         = $_POST['product'];
        $qty            = $_POST['qty'];
        $unit           = $_POST['unit'];
        $note           = $_POST['information'];
        $qty_awal       = $_POST['ket_aja'];
        $unite 			= $_POST['unite'];
        /*$unitee         = $_POST['unitee'];
        $new_unit       = array_push($unite, $unitee);*/
        if ($request['po-number'] != NULL) {
            $qty_terima     = $_POST['qty_terima'];
            $qty_awal_po    = $_POST['qty_awal_po'];
            $id_po_asset    = $_POST['po-number'];
        }

        $qty_stock      = (float)$qty / 300.0;

        if(count($produk) > count($qty))
            $count = count($qty);
        else $count = count($produk);

        for($i = 0; $i < $count; $i++){
            if ($unite[$i] == 'meter') {
                $data = array(
                    'id_transaction' => $lastInsertedId->id_transaction,
                    'fk_id_product'  => $produk[$i],
                    'qty_transac'    => $qty[$i] / 300.0,
                    'unit'           => $unit[$i],
                    'note'           => $note[$i],

                );

                $datak = array(
                    'qty_sisa_submit' => (float)$qty_awal[$i] - (float)$qty[$i] / 300.0,
                );
                
                Inventory_msp::where('id_product',$produk[$i])->update($datak);

                if ($request['po-number'] != NULL) {

                $datas = array(
                    'qty_do' => (float)$qty_terima[$i] - (float)$qty_awal_po[$i] / 300.0,
                );   
                pam_produk_msp::where('id_po_asset', $id_po_asset)->where('id_barang', $produk[$i])->update($datas);

                }

            } else {
                $data = array(
                    'id_transaction' => $lastInsertedId->id_transaction,
                    'fk_id_product'  => $produk[$i],
                    'qty_transac'    => $qty[$i],
                    'unit'           => $unit[$i],
                    'note'           => $note[$i],
                );

                $datak = array(
                    'qty_sisa_submit' => (float)$qty_awal[$i] - (float)$qty[$i],
                );
                
                Inventory_msp::where('id_product',$produk[$i])->update($datak);

                if ($request['po-number'] != NULL) {

                $datas = array(
                    'qty_do' => (float)$qty_terima[$i] - (float)$qty_awal_po[$i],
                    );   
                pam_produk_msp::where('id_po_asset', $id_po_asset)->where('id_barang', $produk[$i])->update($datas);

                }
            }
            
            $insertData[] = $data;
        }
        WarehouseProjectMSPDetail::insert($insertData);
        

        $lastIds = WarehouseProjectMSPDetail::select('fk_id_product','qty_transac','id_detail_do_msp')->where('id_transaction',$lastInsertedId->id_transaction)->orderBy('created_at','desc')->get(); 


        foreach ($lastIds as $data) {
            $tambah_ch = new Project_msp_changelog();
            $tambah_ch->id_transaction = $lastInsertedId->id_transaction;
            $tambah_ch->to_agen        = $request['to_agen'];
            $tambah_ch->address        = $request['add'];
            $tambah_ch->telp           = $request['telp'];
            $tambah_ch->fax            = $request['fax'];
            $tambah_ch->attn           = $request['att'];
            $tambah_ch->from           = $request['from'];
            $tambah_ch->subj           = $request['subj'];
            $tambah_ch->date           = date("Y-m-d H:i:s");
            $tambah_ch->no_do          = $no_do->no;
            $tambah_ch->id_project     = $request['id_project'];
            $tambah_ch->fk_id_product  = $data->fk_id_product;
            $tambah_ch->id_detail_do   = $data->id_detail_do_msp;
            $tambah_ch->qty_transac    = $data->qty_transac;
            $tambah_ch->save();
        }

        return redirect('/inventory/do/msp')->with('alert', 'Created Delivery Order Successfully!');
    }

    public function store_copy_do(Request $request)
    {
    	$type = 'SJ';
        $month_pr = date("m");
        $year_pr = date("Y");

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

        $getnumber = DOMSPNumber::orderBy('no', 'desc')->first();

        if($getnumber == NULL){
            $getlastnumber = 1;
            $lastnumber = $getlastnumber;
        } else{
            $lastnumber = $getnumber->no+1;
        }

        if($lastnumber < 10){
           $akhirnomor = '000' . $lastnumber;
        }elseif($lastnumber > 9 && $lastnumber < 100){
           $akhirnomor = '00' . $lastnumber;
        }elseif($lastnumber >= 100){
           $akhirnomor = '0' . $lastnumber;
        }

        $no = $akhirnomor .'/'. $type .'/' . $bln .'/'. $year_pr;
        
        $store = new DOMSPNumber();
        $store->no              = $lastnumber;
        $store->no_do           = $no;
        $store->type_of_letter  = $type;
        $store->month           = $bln;
        $store->date            = date("Y-m-d H:i:s");
        $store->to              = $request['to_agen'];
        $store->attention       = $request['att'];
        $store->project_id      = $request['id_project'];
        $store->save();

        $no_do = DOMSPNumber::select('no','no_do')->orderBy('created_at','desc')->first();

        $tambah = new WarehouseProjectMSP();
        $tambah->to_agen        = $request['to_agen'];
        $tambah->address        = $request['add'];
        $tambah->telp           = $request['telp'];
        $tambah->fax            = $request['fax'];
        $tambah->attn           = $request['att'];
        $tambah->from           = $request['from'];
        $tambah->subj           = $request['subj'];
        $tambah->date           = date("Y-m-d H:i:s");
        $tambah->no_do          = $no_do->no;
        $tambah->id_project     = $request['id_project'];
        if (Auth::User()->id_position == 'ADMIN') {
            $tambah->status_kirim   = 'PM'; 
            $tambah->nik_pm         = $request['pm_nik'];
        }else{
            $tambah->status_kirim   = NULL;
            $tambah->nik_pm         = Auth::User()->nik;
        }
        $tambah->save();
        
        $lastInsertedId = WarehouseProjectMSP::select('id_transaction')->orderBy('created_at','desc')->first();

        $produk         = $_POST['product'];
        $qty            = $_POST['qty'];
        $ket_qty        = $_POST['ket_aja'];
        $unit           = $_POST['unit'];
        $note           = $_POST['information'];

        if(count($produk) > count($qty))
            $count = count($qty);
        else $count = count($produk);

        for($i = 0; $i < $count; $i++){
            if ($unit[$i] == 'meter') {
                $data = array(
                    'id_transaction' => $lastInsertedId->id_transaction,
                    'fk_id_product'  => $produk[$i],
                    'qty_transac'    => $qty[$i] / 300.0,
                    'unit'           => $unit[$i],
                    'note'           => $note[$i],
                );

                $datam = array(
                	'qty_sisa_submit' => $ket_qty[$i] - $qty[$i],
                );
                Inventory_msp::where('id_product',$produk[$i])->update($datam);  

              
            } else {
                $data = array(
                    'id_transaction' => $lastInsertedId->id_transaction,
                    'fk_id_product'  => $produk[$i],
                    'qty_transac'    => $qty[$i],
                    'unit'           => $unit[$i],
                    'note'           => $note[$i],
                );

                $datam = array(
                	'qty_sisa_submit' => $ket_qty[$i] - $qty[$i],
                );
            }
            $insertData[] = $data;
        }
        WarehouseProjectMSPDetail::insert($insertData);
        

        $lastIds = WarehouseProjectMSPDetail::select('fk_id_product','qty_transac','id_detail_do_msp')->where('id_transaction',$lastInsertedId->id_transaction)->orderBy('created_at','desc')->get(); 


        foreach ($lastIds as $data) {
            $tambah_ch = new Project_msp_changelog();
            $tambah_ch->id_transaction = $lastInsertedId->id_transaction;
            $tambah_ch->to_agen        = $request['to_agen'];
            $tambah_ch->address        = $request['add'];
            $tambah_ch->telp           = $request['telp'];
            $tambah_ch->fax            = $request['fax'];
            $tambah_ch->attn           = $request['att'];
            $tambah_ch->from           = $request['from'];
            $tambah_ch->subj           = $request['subj'];
            $tambah_ch->date           = date("Y-m-d H:i:s");
            $tambah_ch->no_do          = $no_do->no;
            $tambah_ch->id_project     = $request['id_project'];
            $tambah_ch->fk_id_product  = $data->fk_id_product;
            $tambah_ch->id_detail_do   = $data->id_detail_do_msp;
            $tambah_ch->qty_transac    = $data->qty_transac;
            $tambah_ch->save();
        }

        return redirect('/inventory/do/msp')->with('alert', 'Created Delivery Order Successfully!');

    }

    public function store_product_do_msp(Request $request)
    {
        $no_do          = $request['no_do_edit'];
        $id_pro         = $request['id_pro_edit'];
        $id_transac     = $request['id_transaction_product'];
        $produk         = $_POST['product'];
        $qty            = $_POST['qty'];
        $unit           = $_POST['unit'];
        // $note           = $_POST['information'];
        $qty_awal       = $_POST['ket_aja'];
        $unite 			= $_POST['unite'];

        $qty_stock      = (float)$qty / 300.0;


        if(count($produk) > count($qty))
            $count = count($qty);
        else $count = count($produk);

            if ($unite == 'meter') {
                $data = array(
                    'id_transaction' => $id_transac,
                    'fk_id_product'  => $produk,
                    'qty_transac'    => $qty / 300.0,
                    'unit'           => $unit,
                );
            } else {
                $data = array(
                    'id_transaction' => $id_transac,
                    'fk_id_product'  => $produk,
                    'qty_transac'    => $qty,
                    'unit'           => $unit,
                );
            }
                $insertData[] = $data;

                WarehouseProjectMSPDetail::insert($insertData);

            if ($unite == 'meter') {
                $datak = array(
                    'qty_sisa_submit' => (float)$qty_awal - (float)$qty / 300.0,
                );
                
                Inventory_msp::where('id_product',$produk)->update($datak);  
            } else{
                $datak = array(
                    'qty_sisa_submit' => (float)$qty_awal - (float)$qty,
                );
                
                Inventory_msp::where('id_product',$produk)->update($datak); 
            }
            
            $lastIds = WarehouseProjectMSPDetail::select('fk_id_product','qty_transac','id_detail_do_msp')->where('id_transaction',$id_transac)->first(); 

            $tambah_ch = new Project_msp_changelog();
            $tambah_ch->id_transaction = $id_transac;
            $tambah_ch->to_agen        = $request['to_agen'];
            $tambah_ch->address        = $request['add'];
            $tambah_ch->telp           = $request['telp'];
            $tambah_ch->fax            = $request['fax'];
            $tambah_ch->attn           = $request['att'];
            $tambah_ch->from           = $request['from'];
            $tambah_ch->subj           = $request['subj'];
            $tambah_ch->date           = date("Y-m-d H:i:s");
            $tambah_ch->no_do          = $no_do;
            if ($request['id_project'] != '') {
                $tambah_ch->id_project     = $request['id_project'];
            }else{
                $tambah_ch->id_project     = $request['id_pro_edit'];
            }
            $tambah_ch->fk_id_product  = $produk;
            $tambah_ch->id_detail_do   = $lastIds->id_detail_do_msp;
            $tambah_ch->qty_transac    = $qty;
            $tambah_ch->save();
        
        return redirect()->back()->with('update', 'Updated Delivery Order Successfully!');

    }

    public function return_do_product_msp(Request $request)
    {
        if (Auth::User()->id_division == 'PMO') {
            $qtys           = $request['qty_tras_kurang'];
            $id_product     = $request['id_product_edit'];
            $qtyd           = $request['qty_produk'];
            $id_transac     = $request['id_transaction_edit'];
            $id_detail_do   = $request['id_detail_do'];

            $qty_2 = Inventory_msp::select('qty')->where('id_product',$id_product)->first();

            $no_do = WarehouseProjectMSPDetail::join('inventory_delivery_msp','inventory_delivery_msp.id_transaction','=','inventory_delivery_msp_transaction.id_transaction')
                        ->join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                        ->select('tb_do_msp.no_do','inventory_delivery_msp_transaction.id_transaction')
                        ->where('inventory_delivery_msp_transaction.id_transaction',$id_transac)
                        ->first();

              $update_qty2                 = WarehouseProjectMSPDetail::where('id_detail_do_msp',$id_detail_do)->first();
              $update_qty2->qty_transac    = floatval($qtys) - floatval($qtyd);
              $update_qty2->update();

              $update_qty3                 = Project_msp_changelog::where('id_detail_do',$id_detail_do)->first();
              $update_qty3->qty_transac    = floatval($qtys) - floatval($qtyd);
              $update_qty3->update();

          /*    $tambah_log               = new Inventory_msp_changelog();
              $tambah_log->qty          = $qtyd;
              $tambah_log->id_detail_do_msp = $no_do->id_transaction;
              $tambah_log->id_product   = $id_product;
              $tambah_log->note         = $no_do->no_do;
              $tambah_log->status       = 'P';
              $tambah_log->save();*/


        }else if (Auth::User()->id_position == 'ADMIN') {

            $qtys           = $request['qty_tras_kurang'];
            $id_product     = $request['id_product_edit'];
            $qtyd           = $request['qty_produk'];
            $id_transac     = $request['id_transaction_edit'];
            $id_detail_do   = $request['id_detail_do'];

            $qty_2 = Inventory_msp::select('qty')->where('id_product',$id_product)->first();

            $no_do = WarehouseProjectMSPDetail::join('inventory_delivery_msp','inventory_delivery_msp.id_transaction','=','inventory_delivery_msp_transaction.id_transaction')
                        ->join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                        ->select('tb_do_msp.no_do','inventory_delivery_msp_transaction.id_transaction')
                        ->where('inventory_delivery_msp_transaction.id_transaction',$id_transac)
                        ->first();

              $update_qty2                 = WarehouseProjectMSPDetail::where('id_detail_do_msp',$id_detail_do)->first();
              $update_qty2->qty_transac    = $qtys - $qtyd;
              $update_qty2->update();

           /*   $tambah_log               = new Inventory_msp_changelog();
              $tambah_log->qty          = $qtyd;
              $tambah_log->id_detail_do_msp = $no_do->id_transaction;
              $tambah_log->id_product   = $id_product;
              $tambah_log->note         = $no_do->no_do;
              $tambah_log->status       = 'P';
              $tambah_log->save();*/
        }
        

	      return redirect()->back()->with('update', 'Re-stock Product Successfully!');

    }

    public function revisi_stok(Request $request)
    {
            $qtys            = $request['qty_before_revisi'];
            $id_product      = $request['id_product_revisi'];
            $qtyd            = $request['qty_revisi'];
            $id_transac      = $request['id_transaction_revisi'];
            $id_detail_do    = $request['id_detail_do_revisi'];
            $qty_sisa_submit = $request['qty_sisa_submit_edit']; 
            $qty_akhir       = $request['qty_akhir_revisi'];

            $qty_2 = Inventory_msp::select('qty')->where('id_product',$id_product)->first();

            $no_do = WarehouseProjectMSPDetail::join('inventory_delivery_msp','inventory_delivery_msp.id_transaction','=','inventory_delivery_msp_transaction.id_transaction')
                        ->join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                        ->select('tb_do_msp.no','inventory_delivery_msp_transaction.id_transaction')
                        ->where('inventory_delivery_msp_transaction.id_transaction',$id_transac)
                        ->first();

            $update_qty2                 = WarehouseProjectMSPDetail::where('id_detail_do_msp',$id_detail_do)->first();
            $update_qty2->qty_transac    = $qtyd;
            $update_qty2->update();  

            $comma = number_format($qtys,1);
            $comma2 = number_format($qtyd,1);
            $sisa = substr($qty_sisa_submit, -2);


            $update_qty_sisa_submit     = Inventory_msp::where('id_product', $id_product)->first();
            $update_qty_sisa_submit->qty_sisa_submit = $qty_akhir;
            $update_qty_sisa_submit->update();

            $lastIds = WarehouseProjectMSPDetail::select('fk_id_product','qty_transac','id_detail_do_msp')->where('id_transaction',$id_transac)->first(); 

            // $get_qty_submit = Inventory_msp::select('qty_sisa_submit')->where('id_product', $id_product)->first();
       
            $tambah_ch = new Project_msp_changelog();
            $tambah_ch->id_transaction = $id_transac;
            $tambah_ch->to_agen        = $request['to_agen'];
            $tambah_ch->address        = $request['add'];
            $tambah_ch->telp           = $request['telp'];
            $tambah_ch->fax            = $request['fax'];
            $tambah_ch->attn           = $request['att'];
            $tambah_ch->from           = $request['from'];
            $tambah_ch->subj           = $request['subj'];
            $tambah_ch->date           = date("Y-m-d H:i:s");
            $tambah_ch->no_do          = $no_do->no;
            if ($request['id_project'] != '') {
                $tambah_ch->id_project     = $request['id_project'];
            }else{
                $tambah_ch->id_project     = $request['id_pro_edit'];
            }
            $tambah_ch->id_project     = $request['id_project_revisi'];
            $tambah_ch->status         = 'Rev';
            $tambah_ch->fk_id_product  = $id_product;
            $tambah_ch->id_detail_do   = $lastIds->id_detail_do_msp;
            $tambah_ch->qty_transac    = $qtyd;
            $tambah_ch->save();

            return redirect()->back()->with('update', 'Revisi Stock Delivery Order Successfully!');

    }

    public function return_product_delivery(Request $request)
    {
        $qty            = $request['qty'];
        $id_product     = $request['product'];
        $note           = $request['id_project'];
        $id_transaction = $request['id_transaction'];

        // $qty_2 = Inventory_msp::select('qty')->where('id_product',$id_product)->first();

        // $notes = DB::table('tb_id_project')->select('id_project')->where('id_pro',$note)->first();

        if(count($id_product) > count($qty))
            $count = count($qty);
        else $count = count($id_product);

        for($i = 0; $i < $count; $i++){
            $new_code  = Inventory_msp::select('nama','kode_barang','unit','sn','kategori')->where('id_product',$id_product[$i])->first();

            $code_next = Inventory_msp::select('id_product','qty')->where('kode_barang','R'.$new_code->kode_barang)->first();

            $count_code_next = Inventory_msp::select('id_product')->where('kode_barang','R'.$new_code->kode_barang)->count('id_product');
            
 /*           $datam = array(
                'qty'  => $qty_2->qty + $qty[$i],
                'status' => 'Y',
            );

            Inventory_msp::where('id_product',$id_product[$i])->update($datam);*/           
            if ($count_code_next > 0) {
                $datam = array(
                    'qty'    => $code_next->qty + $qty[$i],
                    'status' => 'Y',
                    'qty_sisa_submit' =>$qty[$i],
                );

                Inventory_msp::where('id_product',$code_next->id_product)->update($datam);

                $datas = array(
                'qty'               => $qty[$i],
                'note'              => $note[$i],
                'id_product'        => $code_next->id_product,
                'id_detail_do_msp'  => $id_transaction, 
                'status'            => 'W',
                );  

                $insertDatas[] = $datas;
            }else{
                $datam = array(
                    'kode_barang'   => 'R'. $new_code->kode_barang,
                    'nama'          => $new_code->nama,
                    'unit'          => $new_code->unit,
                    'sn'            => $new_code->sn,
                    'kategori'      => $new_code->kategori,
                    'qty'           => $qty[$i],
                    'tipe'          => 'return',
                    'status'        => NULL,
                    'qty_sisa_submit' =>$qty[$i],
                );

                $insertData = $datam;
            }

        }

        if ($count_code_next > 0) {
            Inventory_msp_changelog::insert($insertDatas);
        }else{
            Inventory_msp::insert($insertData); 
        }
       

        return redirect('/inventory/msp')->with('update', 'Return Product Successfully!');

    }

    public function edit_qty_do(Request $request)
    {
        if (Auth::User()->id_division == 'PMO') {
            $qtys           = $request['qty_tras'];
            $id_product     = $request['id_product_edit'];
            $qtyd           = $request['qty_produk'];
            $id_transac     = $request['id_transaction_edit'];
            $id_detail_do   = $request['id_detail_do'];

            $qty_2 = Inventory_msp::select('qty','id_po')->where('id_product',$id_product)->first();

            $qty_3 = WarehouseProjectMSPDetail::select('qty_transac')->where('id_detail_do_msp',$id_detail_do)->first();

            $update_qty2                 = WarehouseProjectMSPDetail::where('id_detail_do_msp',$id_detail_do)->first();
            $update_qty2->qty_transac    = (float)$qtys + (float)$qtyd; 
            $update_qty2->update();

            $update_qty3                 = Project_msp_changelog::where('id_detail_do',$id_detail_do)->first();
            $update_qty3->qty_transac    = (float)$qtys + (float)$qtyd;
            $update_qty3->update();

           // $tambah_log               = new Inventory_msp_changelog();
           //  $tambah_log->qty          = $qtyd;
           //  $tambah_log->id_product   = $id_product;
           //  $tambah_log->note         = $qty_2->id_po;
           //  $tambah_log->status       = 'D';
           //  $tambah_log->save();
        }
        else if(Auth::User()->id_position == 'ADMIN')
        {
            $qtys           = $request['qty_tras'];
            $id_product     = $request['id_product_edit'];
            $qtyd           = $request['qty_produk'];
            $id_transac     = $request['id_transaction_edit'];
            $id_detail_do   = $request['id_detail_do'];

            $qty_2 = Inventory_msp::select('qty','id_po')->where('id_product',$id_product)->first();

            $qty_3 = WarehouseProjectMSPDetail::select('qty_transac')->where('id_detail_do_msp',$id_detail_do)->first();

            $update_qty2                 = WarehouseProjectMSPDetail::where('id_detail_do_msp',$id_detail_do)->first();
            $update_qty2->qty_transac    = $qtys + $qtyd;
            $update_qty2->update();

            $tambah_log               = new Inventory_msp_changelog();
            $tambah_log->qty          = $qtyd;
            $tambah_log->id_product   = $id_product;
            $tambah_log->note         = $qty_2->id_po;
            $tambah_log->status       = 'D';
            $tambah_log->save();
        }
    	

	    return redirect()->back()->with('update', 'Re-stock Product Successfully!');
    }

    public function project_store(Request $request)
    {
        $type = 'SJ';
        $month_pr = date("m");
        $year_pr = date("Y");

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

        $getnumber = DONumber::orderBy('no', 'desc')->first();

        if($getnumber == NULL){
            $getlastnumber = 1;
            $lastnumber = $getlastnumber;
        } else{
            $lastnumber = $getnumber->no+1;
        }

        if($lastnumber < 10){
           $akhirnomor = '000' . $lastnumber;
        }elseif($lastnumber > 9 && $lastnumber < 100){
           $akhirnomor = '00' . $lastnumber;
        }elseif($lastnumber >= 100){
           $akhirnomor = '0' . $lastnumber;
        }

        $no = $akhirnomor .'/'. $type .'/' . $bln .'/'. $year_pr;
        
        $store = new DONumber();
        $store->no              = $lastnumber;
        $store->no_do           = $no;
        $store->type_of_letter  = $type;
        $store->month           = $bln;
        $store->date            = date("Y-m-d H:i:s");
        $store->to              = $request['to_agen'];
        $store->attention       = $request['att'];
        $store->project_id      = $request['id_project'];
        $store->title           = $request['title'];
        $store->project         = $request['project'];
        $store->description     = $request['description'];
        $store->save();

        $no_do = DONumber::select('no','no_do')->orderBy('created_at','desc')->first();

        $tambah = new projectInventory();
        $tambah->to        = $request['to_agen'];
        $tambah->address        = $request['add'];
        $tambah->telp           = $request['telp'];
        $tambah->fax            = $request['fax'];
        $tambah->att            = $request['att'];
        $tambah->from           = $request['from'];
        $tambah->subj           = $request['subj'];
        $tambah->date           = date("Y-m-d H:i:s");
        $tambah->ref            = $no_do->no;
        $tambah->id_project     = $request['id_project'];
        $tambah->save();

        $produks = $request['detail_product'];

        $inputs  = $request->all();

        $tambah_wp = new WarehouseProject();
        $tambah_wp->fk_id_barang         = $request['product'];
        $tambah_wp->tgl_keluar           = date("Y-m-d H:i:s");
        $tambah_wp->no_do                = $no_do;
        $tambah_wp->qty                  = count($produks);
        $tambah_wp->save();


       /* $lastInsertedId = $tambah->id_transaction;

        $data = [];
        foreach ($produks as $produk) {
            $data[] = [
                'id_transaction'      => $lastInsertedId, 
                'id_detail_barang'    => $produk,
            ];
        }

        DB::table('detail_inventory_project_transaction')->insert($data);       


        $id_barang = $request['product'];

        $qty_awal = Inventory::select('qty')
                    ->where('id_barang',$id_barang)
                    ->first();
        $qty_transac = WarehouseProject::select('qty_awal')
                    ->where('fk_id_barang',$id_barang)
                    ->first();
        
        $update = Inventory::where('id_barang',$id_barang)->first();
        $update->qty  = $qty_awal->qty - $qty_transac->qty_awal;
        $update->update();

        foreach ($produks as $produk) {
            $update2 = Detail_inventory::where('id_detail', $produk)->first();
            $update2->status = 'PROJECT';
            $update2->update();
        }*/

        return redirect('/inventory/project')->with('success', 'Created Inventory Project Successfully!');
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
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function destroy($id_detail_do_msp)
    {
      
        $hapus = WarehouseProjectMSPDetail::find($id_detail_do_msp);
        $hapus->delete();

        return redirect()->back()->with('alert', 'Product has been Deleted!');
    }*/

    public function delete_produk(Request $request)
    {
        $produk             = $request['id_product_delete'];
        $qty_transac        = $request['qty_before_delete'];
        $qty_sisa_submit    = $request['qty_sisa_submit_delete'];
        $id_detail_do_msp   = $request['id_detail_do_delete'];
      
        $hapus = WarehouseProjectMSPDetail::where('id_detail_do_msp', $id_detail_do_msp)->delete();

        $update                     = Inventory_msp::where('id_product', $produk)->first();
        $update->qty_sisa_submit    = (float)$qty_sisa_submit + (float)$qty_transac;
        $update->update();

        return redirect()->back()->with('alert', 'Product has been Deleted!');
    }

    public function downloadPdfDO($id_transaction)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $datas = WarehouseProjectMSP::join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                ->join('tb_id_project','tb_id_project.id_pro','=','inventory_delivery_msp.id_project')
                ->select('inventory_delivery_msp.to_agen','inventory_delivery_msp.from','inventory_delivery_msp.address','inventory_delivery_msp.id_transaction','inventory_delivery_msp.telp','inventory_delivery_msp.fax','inventory_delivery_msp.attn','inventory_delivery_msp.subj','inventory_delivery_msp.date','inventory_delivery_msp.id_transaction','tb_do_msp.no_do','inventory_delivery_msp.id_transaction','tb_id_project.id_project')
                ->where('id_transaction', $id_transaction)
                ->first();

        $produk = WarehouseProjectMSPDetail::join('inventory_delivery_msp','inventory_delivery_msp.id_transaction','=',
                'inventory_delivery_msp_transaction.id_transaction')
                ->join('inventory_produk_msp','inventory_produk_msp.id_product','=','inventory_delivery_msp_transaction.fk_id_product')
                ->select('inventory_produk_msp.nama','inventory_produk_msp.kode_barang','inventory_delivery_msp_transaction.created_at','inventory_produk_msp.id_po','inventory_delivery_msp_transaction.note','inventory_delivery_msp_transaction.qty_transac','inventory_produk_msp.unit','inventory_delivery_msp.to_agen','inventory_produk_msp.id_product', 'inventory_delivery_msp.id_project', 'inventory_delivery_msp_transaction.note','kg','vol')
                ->where('inventory_delivery_msp_transaction.id_transaction',$id_transaction)
                ->get();

        return view('gudang.project.do_pdf', compact('datas','produk'));
        // return $pdf->download('Delivery Order '.$datas->no_do.' '.'.pdf');
    }

    public function downloadExcel($id_transaction)
    {
        $nama = 'Delivery Order '.date('Y');
        Excel::create($nama, function ($excel) use ($id_transaction) {
        $excel->sheet('Delivery Order', function ($sheet) use ($id_transaction) {

        $data = WarehouseProjectMSP::join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                ->select('inventory_delivery_msp.to_agen','inventory_delivery_msp.from','inventory_delivery_msp.address','inventory_delivery_msp.id_transaction','inventory_delivery_msp.telp','inventory_delivery_msp.fax','inventory_delivery_msp.attn','inventory_delivery_msp.subj','inventory_delivery_msp.date','inventory_delivery_msp.id_transaction','tb_do_msp.no_do','inventory_delivery_msp.id_transaction')
                ->where('id_transaction', $id_transaction)
                ->first();
        
        $sheet->mergeCells('A1:G1');

       // $sheet->setAllBorders('thin');
        $sheet->row(1, function ($row) {
            $row->setFontFamily('Calibri');
            $row->setFontSize(11);
            $row->setAlignment('center');
            $row->setFontWeight('bold');
        });

        $sheet->row(1, array('Delivery Order'));

        $sheet->setCellValue('A3', 'some value');


        $sheet->row(2, function ($row) {
            $row->setFontFamily('Calibri');
            $row->setFontSize(11);
            $row->setFontWeight('bold');
        });

        
        $produks = WarehouseProjectMSPDetail::join('inventory_delivery_msp','inventory_delivery_msp.id_transaction','=',
                'inventory_delivery_msp_transaction.id_transaction')
                ->join('inventory_produk_msp','inventory_produk_msp.id_product','=','inventory_delivery_msp_transaction.fk_id_product')
                ->select('inventory_produk_msp.nama','inventory_produk_msp.kode_barang','inventory_delivery_msp_transaction.created_at','inventory_produk_msp.id_po','inventory_delivery_msp_transaction.note','inventory_delivery_msp_transaction.qty_transac','inventory_delivery_msp_transaction.unit','inventory_delivery_msp.to_agen','inventory_produk_msp.id_product', 'inventory_delivery_msp.id_project', 'inventory_delivery_msp_transaction.note','kg','vol')
                ->where('inventory_delivery_msp_transaction.id_transaction',$id_transaction)
                ->get();



       // $sheet->appendRow(array_keys($datas[0]));
            $sheet->row($sheet->getHighestRow(), function ($row) {
                $row->setFontWeight('bold');
            });

             $datasheet = array();
             $datasheet[]  =   array("No", "MSP Code", "Description", "Qty", "Kg",  "Vol", "Unit");
             $i=1;

            foreach ($produks as $data) {

               // $sheet->appendrow($data);
              $datasheet[$i] = array($i,
                    $data['kode_barang'],
                    $data['nama'],
                    $data['qty_transac'],
                    $data['kg'],
                    $data['vol'],
                    $data['unit'],
                );
              
              $i++;
            }

            $sheet->fromArray($datasheet);
        });

        })->export('xls');
    }
}
