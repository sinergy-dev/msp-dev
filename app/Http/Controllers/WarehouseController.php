<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Warehouse;
use Auth;
// use App\Category_in;
// use App\Type_in;
use App\User;
use App\Inventory;
use App\Detail_inventory;
use App\PONumber;
use App\PONumberMSP;
use App\ChangelogInventory;
use App\Inventory_msp;
use App\pam_produk_msp;
use App\pam_msp;
use App\POAssetMSP;
use App\POAsset;
use App\Inventory_msp_changelog;
use App\WarehouseDetailProduk;
use App\pamProduk;
use App\KatInvenMSP;
use DB;

use Maatwebsite\Excel\Facades\Excel;

class WarehouseController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request) {
      
        $tambah = new KatInvenMSP();
        $tambah->name = $request['nama_kategori'];
        $tambah->status = 'project';
        $tambah->save();
    
        return redirect()->back();

    }

    public function import(Request $request) 
    {
        $path = $request->file('file')->getRealPath();
        $data = Excel::load($path)->get();
 
        if($data->count()){
            foreach ($data as $key => $value) {
                $arr[] = ['id_product' => $value->id_product, 'kode_barang' => $value->kode_barang, 'sn' => $value->sn, 'nama' => $value->nama, 'qty' => $value->qty, 'unit' => $value->unit, 'kategori' => $value->kategori, 'tipe' => $value->tipe, 'merk' => $value->merk];
            }
 
            if(!empty($arr)){
                Inventory_msp::insert($arr);
            }
        }

        // updated data with import excel
        // $data = Excel::toArray(new Inventory_msp, request()->file('file')); 

        // return collect(head($data))
        //     ->each(function ($row, $key) {
        //         DB::table('inventory_produk_msp')
        //             ->where('id_product', $row['id_product'])
        //             ->update(array_except($row, ['id_product']));
        //     });
 
        return back()->with('success', 'Insert Record successfully.');
    }

    public function getDropdownKategori(Request $request)
    {
        return array(DB::table('inventory_produk_msp')
            ->select('nama','qty','unit','inventory_produk_msp.note','inventory_produk_msp.id_product','inventory_produk_msp.status','inventory_produk_msp.id_po','inventory_produk_msp.kode_barang','status2','kategori')
            ->join('cat_inventory_produk_msp','cat_inventory_produk_msp.id','=','inventory_produk_msp.kategori')
            ->where('cat_inventory_produk_msp.status','project')
            ->where('inventory_produk_msp.kategori',$request->kategori)
            ->get(),$request->kategori);
    }   

    //buat halaman report di dashboard
    public function view_inventory(request $request)
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

        $datas = DB::table('inventory_changelog_msp')
                ->join('inventory_produk_msp','inventory_produk_msp.id_product','=','inventory_changelog_msp.id_product')
                ->select('inventory_produk_msp.nama','inventory_produk_msp.kode_barang','inventory_changelog_msp.created_at','inventory_changelog_msp.note','inventory_changelog_msp.status')
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

        return view('report/inventory_msp', compact('lead', 'total_ter','notif','notifOpen','notifsd','notiftp','datas','datam', 'notifClaim'));
    }
    
    public function category_index()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position; 

        $data = DB::table('tb_warehouse')
                        ->select('item_code','name_item', 'quantity', 'information')
                        ->get();

        // $category = category_in::select('id_category','category')->get();

        // $type = type_in::select('id_type','type')->get();

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

        if ($ter != null) {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();

             $notifc = count($notif);
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notif = DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_lead_register.lead_id')
            ->where('result','OPEN')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();

             $notifc = count($notif);
        }else{
             $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();

            $notifc = count($notif);        
        }

        if ($pos == 'DIRECTOR') {
            $notifem= DB::table('users')
            ->select('name','nik')
            ->where('status','D')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES') {
            $notifem= DB::table('users')
            ->select('name','nik')
            ->where('status','D')
            ->get();
        }elseif (Auth::User()->id_division == '2') {
            $notifem= DB::table('users')
            ->select('name','nik')
            ->where('status','D')
            ->get();
        }elseif ($ter != null) {
            $notifem= DB::table('users')
            ->select('name','nik')
            ->where('status','D')
            ->get();
        }else{
            $notifem= DB::table('users')
            ->select('name','nik')
            ->where('status','D')
            ->get();
        }

        return view('gudang/kategori', compact('notif','notifOpen','notifsd','notiftp','data','notifc','notifem','category','type'));
    }

    public function inventory_msp()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $data = DB::table('inventory_produk_msp')
                ->select('nama','qty','unit','inventory_produk_msp.note','inventory_produk_msp.id_product','inventory_produk_msp.status','inventory_produk_msp.id_po','inventory_produk_msp.kode_barang','status2','kategori','name','inventory_produk_msp.tipe')
                ->join('cat_inventory_produk_msp','cat_inventory_produk_msp.id','=','inventory_produk_msp.kategori')
                ->where('cat_inventory_produk_msp.status','project')
                ->get();

        $datas = POAssetMSP::join('tb_po_msp','tb_po_msp.no','=','tb_po_asset_msp.no_po')
                ->select('tb_po_msp.no','tb_po_msp.no_po','tb_po_asset_msp.subject', 'id_po_asset','to_agen')
                ->where('tb_po_asset_msp.status_po','PENDING')
                ->orWhere('tb_po_asset_msp.status_po','FINANCE')
                ->get();

        $datam = POAssetMSP::select('no_do_sup','subject','id_pr_asset')
                ->where('tb_po_asset_msp.status_do_sup','FINANCE')
                ->orWhere('tb_po_asset_msp.status_do_sup','PENDING')
                ->get();

        $categorys = DB::table('cat_inventory_produk_msp')
                            ->select('id','name','status')
                            ->where('status','project')
                            ->get();

        $com_categorys = DB::table('cat_inventory_produk_msp')
                        ->select('id')
                        ->first();

        // $category = category_in::select('id_category','category')->where('id_category','!=','5')->get();

        $po = PONumber::select('no','no_po')->get();

        // $type = type_in::select('id_type','type')->where('id_type','!=','8')->get();

      

        return view('gudang/gudang_msp', compact('notif','notifOpen','notifsd','notiftp','notifClaim','data','notifc','notifem','category','type','po','datas','categorys','com_categorys','datam'));
    }

    public function getdatawarehouse(Request $request) {

        $nama = 'STOCK '.date("d-m-Y");
        Excel::create($nama, function ($excel) use ($request) {
            $excel->sheet('Data Warehouse', function ($sheet) use ($request) {

                $sheet->mergeCells('A1:G1');

                $sheet->row(1, function ($row) {
                    $row->setFontFamily('Calibri');
                    $row->setFontSize(11);
                    $row->setAlignment('center');
                    $row->setFontWeight('bold');
                });

                $sheet->row(1, array('DATA WAREHOUSE'));

                $sheet->row(2, function ($row) {
                    $row->setFontFamily('Calibri');
                    $row->setFontSize(11);
                    $row->setAlignment('center');
                    $row->setFontWeight('bold');
                });

                $data = Inventory_msp::join('cat_inventory_produk_msp','cat_inventory_produk_msp.id','=','inventory_produk_msp.kategori')
                            ->select('kode_barang', 'name', 'sn', 'nama', 'qty', 'unit')
                            ->where('cat_inventory_produk_msp.status','project')
                            ->get();

                    $datasheetpo = array();
                    $datasheetpo[0] = array("NO", "MSP CODE", "MEREK BARANG", "SERIAL NUMBER", "NAMA PRODUK", "STOK", "KETERANGAN");
                    $i=1;

                    foreach ($data as $datas) {

                        $datasheetpo[$i] = array($i,
                                    $datas['kode_barang'],
                                    $datas['name'],
                                    $datas['sn'],
                                    $datas['nama'],
                                    $datas['qty'],
                                    $datas['unit']
                                );
                        $i++;
                    }

                    $sheet->fromArray($datasheetpo);
                    
            });
        })->export('xls');

    }

    // public function turunkan_jml(Request $request) {

    //     $dapat_id_m = $request['ipro'];

    //     $ipro = $dapat_id_m - 1;

    //     $tambah_qty_m = $request['jml_roll'] * 300;
        
    //     $current_stock = Inventory_msp::select('qty')->where('id_product',$ipro)->first();
    //     $current_stock_m = Inventory_msp::select('qty_m')->where('id_product',$ipro)->first();

    //     $stock_id_m = Inventory_msp::select('qty','status2')->where('id_product',$dapat_id_m)->first();

    //     if ($request['jml_roll'] != '') {
    //        if($request['jml_roll'] > $current_stock->qty) {
    //             return redirect()->back()->with('danger', 'Jumlah roll tidak mencukupi!');
    //         } else {
    //             $update = Inventory_msp::where('id_product',$ipro)->first();
    //             $update->qty = $current_stock->qty - $request['jml_roll'];
    //             $update->qty_m = $current_stock_m->qty_m + $tambah_qty_m;
    //             $update->update();

    //             $update = Inventory_msp::where('id_product',$dapat_id_m)->first();
    //             $update->qty = $stock_id_m->qty + $tambah_qty_m;
    //             $update->update();

    //             return back()->with('alert', 'Update Record successfully.');
    //         }
    //     }else if ($request['jml_meter'] != '') {
    //         $update_c      = Inventory_msp::where('id_product',$dapat_id_m)->first();
    //         // $update_c->qty = $stock_id_m->qty - $request['jml_meter'];
    //         if ($stock_id_m->status2 != '') {
    //             $update_c->status2 = $stock_id_m->status2 + $request['jml_meter'];
    //         }else{
    //             $update_c->status2 = $request['jml_meter'];
    //         }
    //         $update_c->update();

    //         return redirect()->back()->with('alert', 'Wait for Director Confirmation!.');
    //     }else{
    //         $update_b           = Inventory_msp::where('id_product',$dapat_id_m)->first();
    //         $update_b->qty      = $stock_id_m->qty - $stock_id_m->status2;
    //         $update_b->status2  = '';
    //         $update_b->update();

    //         $tambah             = new Inventory_msp_changelog();
    //         $tambah->qty        = $stock_id_m->status2;
    //         $tambah->id_product = $request['ipro'];
    //         $tambah->status     = 'D';
    //         $tambah->note       = 'Stock Revision';
    //         $tambah->save();

    //         return redirect()->back()->with('alert', 'Stock revision has been confirmed!.');
    //     }

    // }

    public function do_sup_index()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;


        $pam = DB::table('tb_po_asset_msp')
                ->select('tb_po_asset_msp.date_handover','tb_po_asset_msp.to_agen','tb_po_asset_msp.status_do_sup','tb_po_asset_msp.subject', 'tb_po_asset_msp.attention', 'tb_po_asset_msp.project', 'tb_po_asset_msp.project_id', 'term', 'tb_po_asset_msp.id_po_asset', 'tb_po_asset_msp.id_pr_asset','tb_po_asset_msp.no_do_sup')
                ->get();

        $no_pr = DB::table('tb_pr_msp')
                ->select('result','no_pr','no')
                ->where('result','T')
                ->get();

        $pams = DB::table('tb_pam_msp')
            ->select('id_pam')
            ->get();

        $produks = DB::table('tb_pam_msp')
            ->join('tb_pr_product_msp','tb_pr_product_msp.id_pam','=','tb_pam_msp.id_pam')
            ->select('tb_pr_product_msp.name_product','tb_pr_product_msp.qty','tb_pr_product_msp.id_pam','tb_pr_product_msp.nominal')
            ->get();

        $sum = DB::table('tb_pam_msp')
            ->select('id_pam')
            ->sum('id_pam');

        $count_product = DB::table('tb_pr_product_msp')
            ->select('id_product')
            ->sum('id_product');

        $total_amount = DB::table('tb_pr_product_msp')
                    ->select('nominal')
                    ->sum('nominal');

        $from = DB::table('users')
                ->select('nik', 'name')
                ->where('id_company', '2')
                ->get();

        $project_id = DB::table('tb_id_project')
                        ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                        ->join('users','users.nik','=','sales_lead_register.nik')
                        ->select('id_project')
                        ->where('id_company', '2')
                        ->get();

        $msp_code = DB::table('inventory_produk_msp')
                    ->select('kode_barang')
                    ->get();

        return view('gudang/gudang2',compact('notif','notifOpen','notifsd','notiftp','notifClaim','pam','produks','pams','sum','id_pam','count_product','total_amount','no_pr','$total_amount','from', 'project_id', 'msp_code'));
    }

     public function detail_do_sup($id_po_asset)
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

        if ($ter != null) {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();

             $notifc = count($notif);
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notif = DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_lead_register.lead_id')
            ->where('result','OPEN')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();

             $notifc = count($notif);
        }else{
             $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();

            $notifc = count($notif);        
        }

        $detail = DB::table('tb_po_asset_msp')
            ->select('date_handover','subject','to_agen','attention','project','project_id','address','telp','fax','email','status_do_sup','term','no_do_sup')
            ->where('id_po_asset',$id_po_asset)
            ->first();

        $barang_detail = DB::table('tb_pr_product_msp')
                        ->select('msp_code','name_product','unit','qty','nominal','total_nominal','description')
                        ->where('id_po_asset',$id_po_asset)
                        ->get();

        $from = DB::table('users')
                ->select('nik', 'name')
                ->where('id_company', '2')
                ->get();

        $project_id = DB::table('tb_id_project')
                        ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                        ->join('users','users.nik','=','sales_lead_register.nik')
                        ->select('id_project')
                        ->where('id_company', '2')
                        ->get();

        $msp_code = DB::table('inventory_produk_msp')
                    ->select('kode_barang')
                    ->get();

        return view('gudang/add_gudang2', compact('detail','notif','notifOpen','notifsd','notiftp','notifc','notifem','from','project_id','msp_code','barang_detail')); 
    }


    public function add_do_sup()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        if ($div == 'FINANCE' && $pos == 'STAFF') {
            $pam = DB::table('tb_pam_msp')
                ->join('users','users.nik','=','tb_pam_msp.personel')
                ->join('tb_pr_msp','tb_pr_msp.no','=','tb_pam_msp.no_pr')
                ->select('tb_pam_msp.id_pam','tb_pr_msp.date','tb_pr_msp.no_pr','tb_pam_msp.ket_pr','tb_pam_msp.note_pr','tb_pam_msp.to_agen','tb_pam_msp.status','users.name','tb_pam_msp.subject','tb_pam_msp.amount', 'ppn', 'terms')
                ->get();
        } elseif ($pos == 'ADMIN') {
            $pam = DB::table('tb_pam_msp')
                ->join('users','users.nik','=','tb_pam_msp.personel')
                ->join('tb_po_asset_msp', 'tb_po_asset_msp.id_pr_asset', '=', 'tb_pam_msp.id_pam')
                ->join('tb_pr_msp','tb_pr_msp.no','=','tb_pam_msp.no_pr')
                ->select('tb_pam_msp.id_pam','tb_pam_msp.date_handover','tb_pr_msp.no_pr','tb_pam_msp.ket_pr','tb_pam_msp.note_pr','tb_pam_msp.to_agen','tb_pam_msp.status','users.name','tb_pam_msp.subject', 'tb_pr_msp.no', 'tb_pr_msp.date', 'tb_pam_msp.attention', 'tb_pam_msp.project', 'tb_pam_msp.project_id', 'ppn', 'terms', 'tb_po_asset_msp.id_po_asset', 'tb_po_asset_msp.id_pr_asset')
                ->where('tb_pam_msp.nik_admin',$nik)
                ->get();

        }

        $no_pr = DB::table('tb_pr_msp')
                ->select('result','no_pr','no')
                ->where('result','T')
                ->get();

        $pams = DB::table('tb_pam_msp')
            ->select('id_pam')
            ->get();

        $produks = DB::table('tb_pam_msp')
            ->join('tb_pr_product_msp','tb_pr_product_msp.id_pam','=','tb_pam_msp.id_pam')
            ->select('tb_pr_product_msp.name_product','tb_pr_product_msp.qty','tb_pr_product_msp.id_pam','tb_pr_product_msp.nominal')
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

        $sum = DB::table('tb_pam_msp')
            ->select('id_pam')
            ->sum('id_pam');

        $count_product = DB::table('tb_pr_product_msp')
            ->select('id_product')
            ->sum('id_product');

        $total_amount = DB::table('tb_pr_product_msp')
                    ->select('nominal')
                    ->sum('nominal');

        $from = DB::table('users')
                ->select('nik', 'name')
                ->where('id_company', '2')
                ->get();

        $project_id = DB::table('tb_id_project')
                        ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                        ->join('users','users.nik','=','sales_lead_register.nik')
                        ->select('id_project')
                        ->where('id_company', '2')
                        ->get();

        $msp_code = DB::table('inventory_produk_msp')
                    ->select('kode_barang')
                    ->get();

        $detail = NULL;


        return view('gudang/add_gudang2',compact('notif','notifOpen','notifsd','notiftp','notifClaim','pam','produks','pams','sum','id_pam','count_product','total_amount','no_pr','$total_amount','from', 'project_id', 'msp_code','detail'));
    }


    public function Detail_inventory_msp($id_product)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position; 
       
        $detail = DB::table('inventory_produk_msp')
            ->join('inventory_changelog_msp','inventory_changelog_msp.id_product','=','inventory_produk_msp.id_product')
            ->select('inventory_changelog_msp.id_changelog','inventory_produk_msp.nama','inventory_produk_msp.qty','inventory_changelog_msp.id_product','inventory_changelog_msp.qty','inventory_changelog_msp.status','inventory_changelog_msp.note','inventory_changelog_msp.status','inventory_produk_msp.kode_barang','inventory_changelog_msp.created_at','inventory_produk_msp.unit')
            ->where('inventory_changelog_msp.id_product',$id_product)
            ->orderBy('inventory_changelog_msp.created_at','desc')
            ->get();

        $datak = DB::table('inventory_produk_msp')
            ->select('kode_barang','nama','qty','status','unit','created_at')
            ->where('id_product',$id_product)
            ->first();

        $keg = DB::table('inventory_changelog_msp')
            ->select('status','note','created_at')->where('id_product',$id_product)->orderBy('created_at','desc')->first();

        if (isset($keg)) {
           $notes = substr($keg->note,5,2);
            
           $dating = $keg->created_at;
        }
         
        $sn = DB::table('detail_inventory_produk_msp')
            ->join('inventory_produk_msp','inventory_produk_msp.id_product','=','detail_inventory_produk_msp.id_barang')
            ->select('serial_number','inventory_produk_msp.nama')
            ->where('detail_inventory_produk_msp.id_product',$id_product)
            ->get();

        $cek = Inventory_msp::select('status2')->where('id_product',$id_product)->first();


        return view('gudang/detail_gudang_msp', compact('cek','sn','detail','notif','notifOpen','notifsd','notiftp','notifc','notifem','datak','keg','notes','dating','notifClaim','count_keg'));
    }    

    public function getDropdownPO(Request $request)
    {   
        /*return array(DB::table('tb_pr_product_msp')
                ->join('tb_pam_msp','tb_pam_msp.id_pam','=','tb_pr_product_msp.id_pam')
                ->select('name_product','msp_code','unit','qty','description')
                ->where('tb_pr_product_msp.id_pam',$request->product)
                ->get(),$request->product);*/

  /*      return array(DB::table('tb_pam_msp')
            ->join('tb_pr_product_msp','tb_pr_product_msp.id_pam','=','tb_pam_msp.id_pam')
            ->join('tb_po_asset_msp', 'tb_po_asset_msp.id_pr_asset', '=', 'tb_pam_msp.id_pam')
            ->join('tb_pr_msp', 'tb_pr_msp.no', '=', 'tb_pam_msp.no_pr')
            ->join('tb_po_msp', 'tb_po_msp.no', '=', 'tb_pr_msp.no_po')
            ->join('inventory_produk_msp','inventory_produk_msp.id_product','=','tb_pr_product_msp.id_barang')
            ->select('tb_pr_product_msp.name_product','tb_pr_product_msp.qty','tb_pr_product_msp.id_pam','tb_pr_product_msp.nominal','tb_pr_product_msp.total_nominal', 'tb_pr_product_msp.description', 'tb_pr_product_msp.unit', 'tb_pr_product_msp.msp_code','tb_po_msp.no_po','tb_pr_product_msp.id_product','tb_po_asset_msp.id_po_asset','tb_po_asset_msp.status_po','tb_pr_product_msp.status','inventory_produk_msp.qty as qty_katalog')
            ->where('tb_pr_product_msp.id_pam',$request->product)
            ->get(),$request->product);*/

        return array(DB::table('tb_po_asset_msp')
            ->join('tb_pr_product_msp','tb_pr_product_msp.id_po_asset','=','tb_po_asset_msp.id_po_asset')
            ->join('inventory_produk_msp','inventory_produk_msp.id_product','=','tb_pr_product_msp.id_barang')
            ->select('tb_pr_product_msp.name_product','tb_pr_product_msp.qty','tb_pr_product_msp.id_pam','tb_pr_product_msp.nominal','tb_pr_product_msp.total_nominal', 'tb_pr_product_msp.description', 'tb_pr_product_msp.unit', 'tb_pr_product_msp.msp_code','tb_pr_product_msp.id_product','tb_po_asset_msp.id_po_asset','tb_po_asset_msp.status_po','tb_pr_product_msp.status','tb_pr_product_msp.id_barang','tb_pr_product_msp.qty_terima','inventory_produk_msp.qty as qty_master','inventory_produk_msp.qty_sisa_submit as qty_sisa')
            ->where('tb_pr_product_msp.id_po_asset',$request->product)
            ->where('tb_pr_product_msp.qty','!=',0)
            ->get(),$request->product);
    }

    public function getDropdownPoSip(Request $request)
    {   
        $product = $request['po_number']; 

        return array(DB::table('dvg_pam')
            ->join('dvg_pr_product','dvg_pr_product.id_pam','=','dvg_pam.id_pam')
            ->join('tb_po_asset', 'tb_po_asset.id_pr_asset', '=', 'dvg_pam.id_pam')
            ->join('tb_pr', 'tb_pr.no', '=', 'dvg_pam.no_pr')
            ->join('tb_po', 'tb_po.no', '=', 'tb_pr.no_po')
            ->select('dvg_pr_product.name_product','dvg_pr_product.qty','dvg_pr_product.id_pam','dvg_pr_product.total_nominal','dvg_pr_product.nominal','dvg_pr_product.total_nominal', 'dvg_pr_product.description','tb_po.no_po','dvg_pr_product.id_product','tb_po_asset.id_po_asset','tb_po_asset.status_po')
            ->where('dvg_pr_product.id_pam',$request->product)
            ->where('dvg_pr_product.qty','!=',0)
            ->get(),$request->product);

    }

    public function getbtnSN(Request $request)
    {
        $product = $request['btn_sn']; 

        return array(DB::table('inventory_produk')
            ->join('inventory_change_log','inventory_change_log.id_product','=','inventory_produk.id_product')
            ->select('inventory_change_log.qty','inventory_produk.id_barang','inventory_produk.id_product')
            ->orderBy('inventory_change_log.created_at','desc')
            ->where('inventory_change_log.id_product',$request->product)
            ->first(),$request->product);
    }

    public function getDropdownSubmitPO(Request $request){
        return array(DB::table('tb_po_asset_msp')->select('status_po','status_do_sup')->where('tb_po_asset_msp.id_pr_asset',$request->product)->first(),$request->product);
    }

    public function getDropdownSubmitPoSIP(Request $request){
        return array(DB::table('tb_po_asset')->select('status_po')->where('tb_po_asset.id_pr_asset',$request->product)->get(),$request->product);
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
    public function store_katalog_inventory(Request $request)
    {
        // $arr = explode("\r\n", trim($_POST['barang_katalog']));
        $barango = trim(preg_replace('/\s+/', ' ', $_POST['barang_katalog']));

        $tambah = new Inventory_msp();
        if ($request['optradio'] == 'return') {
            $cek_kode       = $request['kode_barang_katalog'];
            $kode_barang    = Inventory_msp::select('kode_barang')->where('kode_barang', $cek_kode)->first();

            // return var_dump($kode_barang->kode_barang);

            if (is_null($kode_barang)) {
                $tambah->nama = $barango;
                $tambah->note = $request['desc_katalog'];
                $tambah->qty = $request['stock'];
                $tambah->unit = $request['unit'];
                $tambah->kode_barang = $request['kode_barang_katalog'];
                $tambah->kategori = $request['kategori'];
                $tambah->tipe = $request['optradio'];
                $tambah->qty_sisa_submit = $request['stock'];
                $tambah->save();

                return redirect('/inventory/msp')->with('success', 'Created Product Successfully!');
                
            }else {
                return redirect('inventory/msp')->with('sukses','Kode Barang Return sudah ada!');
            }  
            
        }else{
            $tambah->nama = $barango;
            $tambah->note = $request['desc_katalog'];
            $tambah->qty = $request['stock'];
            $tambah->unit = $request['unit'];
            $tambah->kode_barang = $request['kode_barang_katalog'];
            $tambah->kategori = $request['kategori'];
            $tambah->tipe = $request['optradio'];
            $tambah->qty_sisa_submit = $request['stock'];
            $tambah->save();

            return redirect('/inventory/msp')->with('success', 'Created Product Successfully!');
        }
        

        
    }


    public function terima_store_msp(Request $request)
    {
       
        $nama       = $request['name'];
        $kategori   = $request['caty'];
        $tipe       = $request['type'];
        $qty        = $request['quantity'];
        $po         = $request['po'];
        $note       = $request['information'];
        $id         = $request['id_barang'];

        if(count($nama) > count($qty))
            $count = count($qty);
        else $count = count($nama);

        for($i = 0; $i < $count; $i++){
            $data = array(
                'kode_barang' => $id[$i],
                'nama'      => $nama[$i],
                'kategori'  => $kategori[$i],
                'tipe'      => $tipe[$i],
                'qty'       => $qty[$i],
                'note'      => $note[$i],
                'id_po'     => $po[$i],
            );
            $insertData[] = $data;
        };
        Inventory_msp::insert($insertData);

        return redirect('/inventory/msp')->with('success', 'Created Product Successfully!');
    }

    public function inventory_store_msp(Request $request)
    {
       
        $qty        = $request['qty_terima'];
        $nama       = $request['name_product_edit'];
        $code       = $request['msp_code_edit'];
        $desc       = $request['desc_edit'];
        $unit       = $request['unit_edit'];
        $po         = $request['no_po_edit'];
        $id_product = $request['id_product_edit'];
        $id_pam     = $request['id_pam'];/*
        $sn         = $request['sn_edit'];*/

        if(count($nama) > count($qty))
            $count = count($qty);
        else $count = count($nama);

        for($i = 0; $i < $count; $i++){
            $data = array(
                'kode_barang'   => $code[$i],
                'nama'          => $nama[$i],
                'unit'          => $unit[$i],
                'qty'           => $qty[$i],
                'note'          => $desc[$i],
                'id_po'         => $po[$i],
                'id_product'    => $id_product[$i],/* 
                'status2'       => $sn[$i],*/
            );
            $insertData[] = $data;

            $datas = array(
                'qty'           => $qty[$i],
                'id_product'    => $id_product[$i],
                'note'          => $po[$i],
                'status'        => 'P',
                );
            $insertDatas[] = $datas;
        };
        Inventory_msp::insert($insertData);
        Inventory_msp_changelog::insert($insertDatas);


        foreach ($id_product as $produk) {
            $qty_awal   = pam_produk_msp::select('qty')->where('id_product',$produk)->get();
            $qty_akhir  = Inventory_msp_changelog::select('qty')->where('id_product',$produk)->orderBy('created_at','asc')->get();/*
            $sn_edit    = Inventory_msp::select('status2')->where('id_product',$produk)->orderBy('created_at','asc')->get();*/
            /*$qty_awal       = $_POST['qty_awal'];
            $qty_terima     = $_POST['qty_terima'];*/

            foreach ($qty_awal as $qty_awal) {
                foreach ($qty_akhir as $qty_akhir) {
                    $update_qty = pam_produk_msp::where('id_product',$produk)->first();
                    $update_qty->qty = $qty_awal->qty - $qty_akhir->qty; 
                    $update_qty->qty_terima = $qty_akhir->qty;    
                    $update_qty->update(); 
                }               
            }  

            /*foreach ($sn as $sn_edit) {
                $update_status = pam_produk_msp::where('id_product',$produk)->first();
                $update_status->status = $sn_edit;  
                $update_status->update();
            }
            */

            if ($request['qty_awal'] == $request['qty_terima']) {
                $update3 = POAssetMSP::where('id_po_asset',$id_pam)->first();
                $update3->status_po = 'DONE';
                $update3->update();
            }elseif ($request['qty_awal'] != $request['qty_terima']) {
                $update3 = POAssetMSP::where('id_po_asset',$id_pam)->first();
                $update3->status_po = 'PENDING';
                $update3->update();
            }

        }

        return redirect('/inventory/msp')->with('success', 'Created Product Successfully!');
    }

    public function inventory_detail_store_msp(Request $request)
    {        
        $id_product = $request['id_product_detil'];
        $id_barang = $request['id_barang_detail'];

        $qty_produk = Inventory_msp::select('qty')->where('id_product',$id_product)->first();
        $qty_pr = pam_produk_msp::select('qty')->where('id_product',$id_product)->first();

        $data = DB::table('inventory_produk_msp')->select('status2')->where('id_product',$id_product)->first();

        $qty_now = $qty_produk->qty + $qty_pr->qty;

        for ($i=0; $i < $qty_now ; $i++) { 
        $tambah = new WarehouseDetailProduk();
        $tambah->id_barang      = $id_barang;
        $tambah->id_product     = $id_product;
        $tambah->serial_number  = null;
        $tambah->save();  
        }

        $update = Inventory_msp::where('id_product',$id_product)->first();
        $update->status = 'v';
        $update->update();

        return redirect('/inventory/msp');
    }

    public function inventory_detail_produk(Request $request)
    {
        $qty        = $request['qty']; 

        $id_barang  = $request['id_barang_detail']; 

        $date = Inventory::select('created_at')
                ->where('id_barang',$id_barang)
                ->first();

        $dates = $date->created_at;    

        for ($i=0; $i < $qty ; $i++) { 
            $store = new Detail_inventory();
            $store->id_barang = $id_barang;
            $store->serial_number = $request['sn'];
            $store->tgl_masuk = $dates;
            $store->save();  
        }

        $update = Inventory::where('id_barang',$id_barang)->first();
        $update->status = 'P';
        $update->update(); 

        return redirect('/inventory');
    }

    public function store_do_sup_msp(Request $request)
    {    
        
        $tambah_pam = new pam_msp();
        $tambah_pam->to_agen        = $request['to_agen'];
        $tambah_pam->address        = $request['add'];
        $tambah_pam->telp           = $request['telp'];
        $tambah_pam->fax            = $request['fax'];
        $tambah_pam->attention      = $request['att'];
        $tambah_pam->subject        = $request['subj'];
        $tambah_pam->date_handover  = date("Y-m-d H:i:s");
        $tambah_pam->project_id     = $request['project_id'];
        $tambah_pam->terms          = nl2br($request['term']);
        $tambah_pam->ppn           = $request['ppn'];
        $tambah_pam->pph           = $request['pph'];
        $tambah_pam->save();

        $id_pam = $tambah_pam->id_pam;

        $tambah = new POAssetMSP();
        $tambah->no_do_sup      = $request['do_sup'];
        $tambah->to_agen        = $request['to_agen'];
        $tambah->address        = $request['add'];
        $tambah->telp           = $request['telp'];
        $tambah->fax            = $request['fax'];
        $tambah->attention      = $request['att'];
        $tambah->subject        = $request['subject'];
        $tambah->project        = $request['project'];
        $tambah->email          = $request['email'];
        $tambah->date_handover  = date("Y-m-d H:i:s");
        $tambah->status_do_sup  = 'NEW';
        $tambah->project_id     = $request['project_id'];
        $tambah->term           = nl2br($request['term']);
        $tambah->id_pr_asset    = $id_pam;
        $tambah->save();

        $lastinsertid = $tambah->id_po_asset;

        $produk     = $request->name_product;
        $msp_code   = $request->msp_code;
        $qty        = $request->qty;
        $unit       = $request->unit;
        $nominal    = $request->nominal;
        $ket        = $request->ket;
        $id_barangs = $request->id_barangs;

        if(count($produk) > count($qty))
            $count = count($qty);
        else $count = count($produk);

        for($i = 0; $i < $count; $i++){
            $data = array(
                'id_barang'     => $id_barangs[$i],
                'id_pam'        => $id_pam,
                'name_product'  => $produk[$i],
                'msp_code'      => $msp_code[$i],
                'qty'           => $qty[$i],
                'qty_terima'    => 0,
                'unit'          => $unit[$i],
                'nominal'       => str_replace(',', '', $nominal[$i]),
                'total_nominal' => $qty[$i] * str_replace(',', '', $nominal[$i]),
                'description'   => $ket[$i],
                'id_po_asset'   => $lastinsertid,
            );

            $insertData[] = $data;
        }
        pam_produk_msp::insert($insertData);

        return redirect('/do-sup/index')->with('success', 'Successfully Add Barang with DO Supplier');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     
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
    public function update_warehouse(Request $request)
    {
        $item_code = $request['edit_item_code_before'];

        $update = Warehouse::where('item_code',$item_code)->first();
        $update->name_item = $request['edit_name'];
        $update->quantity  = $request['edit_quantity']; 
        $update->information = $request['edit_information'];

        $update->update();

        return redirect()->back();
    }


    public function inventory_msp_update(Request $request)
    {
        $id         = $_POST['id_product_edit'];
        $id_pam     = $_POST['id_pam'];
        // $qty        = $_POST['qty_terima'];
        // $id_po      = $_POST['no_po_edit'];
        $qty_awal   = $_POST['qty_awal'];
        $qty_katalog= $_POST['qty_katalog'];
        $qty_terima = $_POST['qty_terima'];
        $unit       = $_POST['unit_edit'];
        $id_product = $_POST['id_product_pam'];
        $qty_master = $_POST['qty_master'];
        $qty_sisa   = $_POST['qty_sisa'];

        // $cek_po = pam_msp::select('no_po')->where('id_pam',$id_pam)->first();

        // $id_po_asset = POAssetMSP::select('no_do_sup')->where('id_pr_asset',$id_pam)->first();

        $id_po = DB::table('tb_po_asset_msp')->join('tb_po_msp','tb_po_msp.no','=','tb_po_asset_msp.no_po')->select('tb_po_msp.no_po')->where('id_po_asset',$id_pam)->first();

        if(count($id_product) > count($qty_terima))
            $count = count($qty_terima);
        else $count = count($id_product);

        for($i = 0; $i < $count; $i++){
            
            if ($qty_terima[$i] != 0) {
               $datas = array(
                'qty'           => $qty_terima[$i],
                'id_product'    => $id[$i],
                'note'          => $id_po->no_po,
                'status'        => 'P',
                );
                $insertDatas[] = $datas;
            }

            $datam = array(
                'qty'  => $qty_terima[$i] + $qty_master[$i],
                'qty_sisa_submit' => $qty_terima[$i] + $qty_sisa[$i],
                'unit' => $unit[$i],
                'status' => 'Y',
            );
            Inventory_msp::where('id_product',$id[$i])->update($datam);

            $datak = array(
                'qty' => $qty_awal[$i] - $qty_terima[$i],
                'qty_terima' => $qty_terima[$i] + $qty_katalog[$i],
            );
            pam_produk_msp::where('id_product',$id_product[$i])->update($datak);

            if ($request['qty_awal'] != $request['qty_terima']) {
            $update3 = POAssetMSP::where('id_po_asset',$id_pam)->first();
            $update3->status_po = 'PENDING';
            // $update3->status_do_sup = 'PENDING';
            $update3->update();
            }elseif ($request['qty_awal'] == $request['qty_terima']) {
                $update3 = POAssetMSP::where('id_po_asset',$id_pam)->first();
                $update3->status_po = 'DONE';
                // $update3->status_do_sup = 'DONE';
                $update3->update();
            }

            
        }
        Inventory_msp_changelog::insert($insertDatas);

       /* $id         = $_POST['id_product_edit'];
        $id_pam     = $_POST['id_pam'];
        $qty        = $_POST['qty_terima'];
        $id_po      = $_POST['no_po_edit'];
        $qty_awal   = $_POST['qty_awal'];
        $qty_terima = $_POST['qty_terima'];

        if(count($id) > count($qty))
            $count = count($qty);
        else $count = count($id);

        
        for($i = 0; $i < $count; $i++){
            $datas = array(
                'qty'           => $qty[$i],
                'id_product'    => $id[$i],
                'note'          => $id_po[$i],
                'status'        => 'P',
                );
            $insertDatas[] = $datas;
        }
        Inventory_msp_changelog::insert($insertDatas);

        foreach ($id as $produk) {
            $qty_awal  = Inventory_msp::select('qty')->where('id_product',$produk)->get();
            $qty_akhir = Inventory_msp_changelog::select('qty')->where('id_product',$produk)->orderBy('created_at','asc')->get();
            $update = Inventory_msp::where('id_product',$produk)->first();
            foreach ($qty_awal as $qty_awal) {
                foreach ($qty_akhir as $qty_last ) {
                    $update->qty = $qty_awal->qty + $qty_last->qty; 
                    $update->update(); 
                }                
            }
        }

        foreach ($id as $produk) {
            $qty_awal = pam_produk_msp::select('qty')->where('id_product',$produk)->get();
            $qty_akhir = Inventory_msp_changelog::select('qty')->where('id_product',$produk)->orderBy('created_at','asc')->get();
            $update2 = pam_produk_msp::where('id_product', $produk)->first();
            foreach ($qty_awal as $qty_awal) {
                foreach ($qty_akhir as $qty_akhir ) {
                    $update2->qty = $qty_awal->qty - $qty_akhir->qty; 
                        if ($request['qty_awal'] != $request['qty_terima']) {
                            $update3 = POAssetMSP::where('id_po_asset',$id_pam)->first();
                            $update3->status_po = 'PENDING';
                            $update3->update();
                        }elseif ($request['qty_awal'] == $request['qty_terima']) {
                            $update3 = POAssetMSP::where('id_po_asset',$id_pam)->first();
                            $update3->status_po = 'DONE';
                            $update3->update();
                        }
                    
                }
                            
            }
            $update2->update();
        }*/

        return redirect('/inventory/msp')->with('update', 'Updated Product Successfully!');
    }

    public function terima_msp_update(Request $request)
    {
        $id = $request['edit_id_barang'];

        $id_po = $request['po_detail_edit'];

        if ($request['edit_quantity'] != null) {
            $qty_lama   = Inventory_msp::select('qty')->where('id_barang',$id)->first();
            $qty_old    = $qty_lama->qty;
            $qty_new    = $request['edit_quantity'];

            $counts = $qty_new;

            $qty_last = $qty_old + $counts;

            $store = new Inventory_msp_changelog();
            $store->qty       = $counts;
            $store->id_barang = $id;
            $store->note      = $id_po;
            $store->status    = 'P';
            $store->save();  
            
        }

        $update = Inventory_msp::where('id_barang',$id)->first();
        $update->nama = $request['edit_name'];
        if ($request['edit_quantity'] != null) {   
            $update->qty = $qty_last;
        } 
        $update->note = $request['edit_information'];
        $update->update(); 

        return redirect('/inventory/msp')->with('update', 'Updated Product Successfully!');
    }

    public function update_serial_number(Request $request)
    {
        /*$id = $request['id_detail_edit'];
    
        $update = Detail_inventory::where('id_detail',$id)->first();
        $update->serial_number = $request['edit_serial_number'];
        
        $update->note = $request['note_edit'];

        $update->update();*/

        $id = $request['sn_barang'];

        $datas      = Inventory::select('qty','id_po','created_at','id_barang')->where('id_barang',$id)->first();
        $qty        = $datas->qty;
        $id_po      = $datas->id_po;
        $id_barang  = $datas->id_barang;
        $date       = $datas->created_at;

        if(count($id) > count($qty))
            $count = count($qty);
        else $count = count($id);

        $arr = explode("\r\n", trim($_POST['serial_number']));

        for ($i = 0; $i < count($arr); $i++) {
                $line = $arr[$i];

                $datas = array(
                    'id_barang'     => $id,
                    'serial_number' => $line,
                    'note'          => $id_po,
                    'status'        => 'P',
                    'tgl_masuk'     => $date,
                    );
                $insertDatas[] = $datas;
        }
        Detail_inventory::insert($insertDatas);

        /*$arr = explode("\r\n", trim($_POST['serial_number']));

        for ($i = 0; $i < count($arr); $i++) {
                $line = $arr[$i];

                $datas = array(
                    'id_barang'     => $id,
                    'serial_number' => $line,
                    'note'          => $id_po,
                    'status'        => 'P',
                    'tgl_masuk'     => $date,
                    );
                $insertDatas[] = $datas;
        }
        Detail_inventory::where('id_barang',$id)->update($datas);*/
/*
        $textAr = explode("\n", trim($_POST['serial_number']));

        foreach ($textAr as $line) {
            $data = [
                'id_barang'     => $id,
                'serial_number' => $line,
                'note'          => $id_po,
                'status'        => 'P',
                'tgl_masuk'     => $date,
            ];
        }
        Detail_inventory::where('id_barang',$id)->update($data); */

        $update = Inventory::where('id_barang',$id)->first();
        $update->qty_status = 'F';
        $update->status     = 'P';
        $update->update();

        return redirect()->back()->with('alert', 'Successfully!');
        
    }


    public function update_serial_number_msp(Request $request)
    {
        $id_product     = $request['id_product_edit'];
        $id_detail      = WarehouseDetailProduk::select('id_product')->where('id_product',$id_product)->where('serial_number',null)->get();
        $serial_number  = $_POST['serial_number'];
    
        $data = [];
        foreach ($id_detail as $id_detail) {
            foreach ($serial_number as $sn) {
                $textAr = explode("\n", $sn); // remove any extra \r chars

                foreach ($textAr as $line) {
                    $data[] = [
                        'serial_number'      => $line, 
                    ];
                }
            }
        }
        DB::table('detail_inventory_produk_msp')->where('id_product',$id_detail->id_product)->update($data);  
        

        return redirect()->back();
    }

    public function update_category(Request $request)
    {
        $id = $request['id_category_edit'];

        $update = Category_in::where('id_category',$id)->first();
        $update->category = $request['category_edit'];

        $update->update();

        return redirect()->back();
    }

    public function update_tipe(Request $request)
    {
        $id = $request['id_type_edit'];

        $update = Type_in::where('id_type',$id)->first();
        $update->type = $request['type_edit'];

        $update->update();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($item_code)
    {
        $hapus = Warehouse::find($item_code);
        $hapus->delete();

        return redirect()->back()->with('alert', 'Deleted!');
    }

    public function destroy_produk($id_barang)
    {
        $hapus = inventory::find($id_barang);
        $hapus->delete();

        return redirect()->back()->with('alert', 'Deleted!');
    }

    public function destroy_detail_produk(Request $request)
    {
        $id_detail = $request['id_detail_hapus'];
        $id_barang = $request['id_barang_hapus'];

        $qty_barang = inventory::select('qty')
                    ->where('id_barang',$id_barang)
                    ->first();

        $hapus = Detail_inventory::find($id_detail);
        $hapus->delete();

        $store = new ChangelogInventory();
        $store->id_detail_barang = $id_detail;
        $store->note             = $request['note_hapus'];
        $store->hapus();

        $update = inventory::where('id_barang',$id_barang);
        $update->qty = $qty_barang->qty - 1;
        $update->update(); 

        return redirect()->back()->with('alert', 'Deleted!');
    }

    public function destroy_category($id_category)
    {
        $hapus = Warehouse::find($id_category);
        $hapus->delete();

        return redirect()->back()->with('alert', 'Deleted!');
    }

    public function destroy_type($id_type)
    {
        $hapus = Warehouse::find($id_type);
        $hapus->delete();

        return redirect()->back()->with('alert', 'Deleted!');
    }
}
