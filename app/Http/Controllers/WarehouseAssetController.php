<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Inventory_msp;
use App\WarehouseAssetTransactionMSP;
use App\KatInvenMSP;
use App\InventoryAssetMSP;
use Excel;
use PDF;
use App\PONumberMSP;
use App\DOMSPNumber;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class WarehouseAssetController extends Controller
{

    public function store(Request $request) {

        $tambah = new InventoryAssetMSP();
        $tambah->nama = $request['barang_katalog'];
        $tambah->kode_barang = $request['kode_barang_katalog'];
        $tambah->kategori = $request['kategori'];
        $tambah->qty = $request['qty'];
        $tambah->note = $request['desc_katalog'];
        $tambah->save();
    
        return redirect()->back();

    }

    public function store_kat(Request $request) {

        $tambah = new KatInvenMSP();
        $tambah->name = $request['nama_kategori'];
        $tambah->status = 'asset';
        $tambah->save();
    
        return redirect()->back();

    }

    public function view_asset(request $request)
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

        $datas = DB::table('inventory_asset_msp')
                    ->select('nama','kode_barang','qty','note')
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

        return view('report/asset_msp', compact('lead', 'total_ter','notif','notifOpen','notifsd','notiftp','datas','notifClaim'));
    }

    public function index_msp(Request $request)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $kembali = '';
        $assets = '';
        $lead = '';
        $notifClaim = '';
        $notifem = '';
        $peminjaman = '';
        $list_pinjaman = '';

        if ($ter != null) {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();

            $notifc = count($notif);
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notif = DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();

            $notifc = count($notif);
        }else{
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();

            $notifc = count($notif);
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

        $assetsd    = DB::table('inventory_asset_transaction_msp')
                    ->join('users','users.nik','=','inventory_asset_transaction_msp.nik_peminjam')
                    ->join('inventory_asset_msp', 'inventory_asset_msp.id','=','inventory_asset_transaction_msp.id_barang')
                    ->select('inventory_asset_transaction_msp.id_transaksi','inventory_asset_transaction_msp.id_barang','inventory_asset_msp.nama','inventory_asset_transaction_msp.qty_pinjam','inventory_asset_transaction_msp.keterangan','users.name','inventory_asset_transaction_msp.qty_awal','inventory_asset_transaction_msp.nik_peminjam','inventory_asset_transaction_msp.status', 'tgl_peminjaman', 'tgl_pengembalian', 'inventory_asset_msp.id','inventory_asset_transaction_msp.note','inventory_asset_transaction_msp.note_acc')
                    ->orderBy('inventory_asset_transaction_msp.created_at', 'desc')
                    ->get();

        $pinjaman = DB::table('inventory_asset_transaction_msp')
                    ->join('users','users.nik','=','inventory_asset_transaction_msp.nik_peminjam')
                    ->join('inventory_asset_msp', 'inventory_asset_msp.id','=','inventory_asset_transaction_msp.id_barang')
                    ->select('inventory_asset_transaction_msp.id_transaksi','inventory_asset_transaction_msp.id_barang','inventory_asset_msp.nama','inventory_asset_transaction_msp.qty_pinjam','inventory_asset_transaction_msp.keterangan','users.name','inventory_asset_transaction_msp.qty_awal','inventory_asset_transaction_msp.nik_peminjam','inventory_asset_transaction_msp.status', 'inventory_asset_msp.id', 'tgl_peminjaman', 'tgl_pengembalian', 'inventory_asset_transaction_msp.note', 'inventory_asset_transaction_msp.note_acc')
                    ->where('nik_peminjam', Auth::User()->nik)
                    ->orderBy('inventory_asset_transaction_msp.created_at', 'desc')
                    ->get();

        // $id_barang = $request['id_barang'];

        $asset = DB::table('inventory_produk_msp')
                ->select('nama', 'qty','inventory_produk_msp.note','inventory_produk_msp.id_product','inventory_produk_msp.id_po', 'kode_barang', 'unit', 'id_product')
                ->get();

        $peminjam = DB::table('users')
                    ->select('name', 'nik')
                    ->where('id_company', '2')
                    ->get();

        $catalogs = DB::table('inventory_asset_msp')
                    ->join('cat_inventory_produk_msp','cat_inventory_produk_msp.id','=','inventory_asset_msp.kategori')
                    ->select('inventory_asset_msp.id','nama','kode_barang','kategori','qty','note')
                    ->where('cat_inventory_produk_msp.status','asset')
                    ->get();

        $categorys = DB::table('cat_inventory_produk_msp')
                        ->select('id','name','status')
                        ->where('status','asset')
                        ->get();

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

        // if ($pos == 'DIRECTOR') {
        //     $notifem= DB::table('users')
        //     ->select('name','nik')
        //     ->where('status','D')
        //     ->get();
        // }elseif ($div == 'TECHNICAL PRESALES') {
        //     $notifem= DB::table('users')
        //     ->select('name','nik')
        //     ->where('status','D')
        //     ->get();
        // }elseif (Auth::User()->id_company == '2') {
        //     $notifem= DB::table('users')
        //     ->select('name','nik')
        //     ->where('status','D')
        //     ->get();
        // }elseif ($ter != null) {
        //     $notifem= DB::table('users')
        //     ->select('name','nik')
        //     ->where('status','D')
        //     ->get();
        // }elseif ($div == 'TECHNICAL' && $pos == 'MANAGER') {
        //     $notifem= DB::table('users')
        //     ->select('name','nik')
        //     ->where('status','D')
        //     ->get();
        // }else{
        //     $notifem= DB::table('users')
        //     ->select('name','nik')
        //     ->where('status','D')
        //     ->get();
        // }

        return view('gudang.asset.asset_msp', compact('notifc','pinjaman','kembali','assets','assetsd','asset','lead','notif','notifOpen','notifsd','notiftp','notifClaim','notifc','notifem', 'peminjaman', 'peminjam', 'list_pinjaman','categorys','catalogs'));
    }

    public function pinjam_msp(Request $request)
    {
        $id_product = $request['id_product'];

        $qty_pinjam = DB::table('inventory_asset_msp')
                        ->select('qty')
                        ->where('id',$id_product)
                        ->first();

        $qtys = $qty_pinjam->qty;

        $qtyd = $request['quantity'];

        $update_qty = InventoryAssetMSP::where('id', $id_product)->first();

        if ($qtys >= $qtyd) {
            $update_qty->qty = $qtys - $qtyd;
        } else {
            return back()->with('warning', 'Kebutuhan melebihi stock!');
        }
        $update_qty->update();

        $store_trans                   = new WarehouseAssetTransactionMSP();
        $store_trans->id_barang        = $id_product; 
        $store_trans->nik_peminjam     = Auth::User()->nik;
        $store_trans->qty_pinjam       = $request['quantity'];
        $store_trans->tgl_pengembalian = $request['tgl_kembali'];
        $store_trans->tgl_peminjaman   = $request['tgl_peminjaman'];
        $store_trans->qty_awal         = $qtys;
        $store_trans->status           = 'PENDING';
        $store_trans->keterangan       = $request['description'];
        $store_trans->save();   

        return redirect()->back()->with('update', 'Peminjaman Akan di Proses!');

    }

    public function detail_asset_msp($id)
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

            $notifc = count($notif);
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notif = DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();

            $notifc = count($notif);
        }else{
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();

            $notifc = count($notif);
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

        /*if ($pos == 'DIRECTOR') {
            $notifem= DB::table('users')
            ->select('name','nik')
            ->where('status','D')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES') {
            $notifem= DB::table('users')
            ->select('name','nik')
            ->where('status','D')
            ->get();
        }elseif (Auth::User()->id_company == '2') {
            $notifem= DB::table('users')
            ->select('name','nik')
            ->where('status','D')
            ->get();
        }elseif ($ter != null) {
            $notifem= DB::table('users')
            ->select('name','nik')
            ->where('status','D')
            ->get();
        }elseif ($div == 'TECHNICAL' && $pos == 'MANAGER') {
            $notifem= DB::table('users')
            ->select('name','nik')
            ->where('status','D')
            ->get();
        }else{
            $notifem= DB::table('users')
            ->select('name','nik')
            ->where('status','D')
            ->get();
        }*/

        $notifClaim = '';

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

        $detail_asset = DB::table('inventory_asset_transaction_msp')
                        ->join('users', 'users.nik', '=', 'inventory_asset_transaction_msp.nik_peminjam')
                        ->join('inventory_asset_msp', 'inventory_asset_transaction_msp.id_barang', '=', 'inventory_asset_msp.id')
                        ->select('users.name', 'tgl_peminjaman', 'tgl_pengembalian', 'inventory_asset_transaction_msp.keterangan', 'inventory_asset_msp.id', 'inventory_asset_transaction_msp.id_transaksi', 'inventory_asset_transaction_msp.status', 'nama', 'qty_pinjam', 'inventory_asset_transaction_msp.note', 'inventory_asset_transaction_msp.created_at')
                        ->where('inventory_asset_msp.id', $id)
                        ->orderBy('created_at','desc')
                        ->get();

        return view('gudang.asset.detail_asset_msp', compact('notifc','notif','notifOpen','notifsd','notiftp','notifc','notifClaim','detail_asset'));
    }

    public function accept_pinjam_msp(Request $request)
    {
        $id_transaction = $request['id_transaction_update'];

        $id_barang   = $request['id_barang_update'];                

        $update             = WarehouseAssetTransactionMSP::where('id_transaksi',$id_transaction)->first();
        $update->note_acc   = $request['note_accept'];
        $update->status     = 'ACCEPT';
        $update->update();

        return redirect()->back()->with('success', 'Peminjaman Telah di verifikasi!');; 
    }

    public function reject_msp(Request $request)
    {
        $id_transaction = $request['id_transaction_reject'];

        $id_barang   = $request['id_barang_reject'];

        $hmm   = DB::table('inventory_asset_transaction_msp')
                    ->select('qty_pinjam')
                    ->where('id_transaksi',$id_transaction)
                    ->first();

        $qtys       = $hmm->qty_pinjam;

        $hum   = DB::table('inventory_asset_msp')
                    ->select('qty')
                    ->where('id',$id_barang)
                    ->first();

        $qtyd       = $hum->qty;

        /*$update_qty = Tech_asset_transaction::firstOrNew(array('id_barang' => $id_barang));
        $update_qty->qty_awal     = $qtyd - $qtys;
        $update_qty->save();
*/
        $update_asset       = InventoryAssetMSP::where('id',$id_barang)->first();
        $update_asset->qty  = $qtyd + $qtys;
        $update_asset->update();
                

        $update         = WarehouseAssetTransactionMSP::where('id_transaksi',$id_transaction)->first();
        $update->status = 'REJECT';
        $update->note   = $request['note'];
        $update->update();

        return redirect()->back()->with('danger', 'Peminjaman Telah di Reject!');; 
    }

    public function diambil_msp(Request $request)
    {
        $id_transaction = $request['id_transaction_diambil'];

        $update             = WarehouseAssetTransactionMSP::where('id_transaksi',$id_transaction)->first();
        $update->status     = 'SUDAH DIAMBIL';
        $update->update();

        return redirect()->back()->with('success', 'Peminjaman Telah di verifikasi!');; 
    }

    public function kembali_msp(Request $request)
    {
        $id_barang = $request['id_barang_kembali'];

        $id_transaction   = $request['id_transaction_kembali'];

        $update         = WarehouseAssetTransactionMSP::where('id_transaksi',$id_transaction)->first();
        $update->status = 'RETURN';
        $update->update();

        return redirect()->back()->with('success', 'Barang Telah di Kembalikan !');
    }

    public function confirm_kembali_msp(Request $request)
    {
        $id_barang = $request['confirm_id_barang_kembali'];

        $id_transaction   = $request['confirm_id_transaction_kembali'];

        $hmm   = DB::table('inventory_asset_transaction_msp')
                    ->select('qty_pinjam')
                    ->where('id_transaksi',$id_transaction)
                    ->first();

        $qtys       = $hmm->qty_pinjam;

        $hum   = DB::table('inventory_asset_msp')
                    ->select('qty')
                    ->where('id',$id_barang)
                    ->first();

        $qtyd       = $hum->qty;

        $update_asset       = InventoryAssetMSP::where('id',$id_barang)->first();
        $update_asset->qty  = $qtyd + $qtys;
        $update_asset->update();
                

        $update         = WarehouseAssetTransactionMSP::where('id_transaksi',$id_transaction)->first();
        $update->status = 'RETURNED';
        $update->update();

        return redirect()->back()->with('success', 'Barang Telah di Kembalikan !');
    }

    public function idpro_report(Request $request)
    {
        $dropdown = DB::table('tb_id_project')
                        ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                        ->join('users','users.nik','=','sales_lead_register.nik')
                        ->select('id_project', 'tb_id_project.id_pro')
                        ->where('id_company', '2')
                        ->get();

        $nopo = DB::table('tb_po_msp')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
                    ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_po_msp.project_id')
                    ->select('tb_po_msp.no_po', 'tb_pr_product_msp.name_product', 'tb_pr_product_msp.qty_terima', 'tb_pr_product_msp.unit', 'tb_po_asset_msp.status_po', 'tb_pr_product_msp.created_at', 'tb_pr_product_msp.updated_at', 'tb_pr_product_msp.qty', 'no_invoice', 'total_nominal', 'kode_barang', 'no_invoice', 'tb_id_project.id_project')
                    ->where('tb_po_asset_msp.status_po', 'kosong')
                    ->get();

        $nopo2 = DB::table('tb_po_msp')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
                    ->select('tb_po_msp.no_po', 'tb_pr_product_msp.name_product', 'tb_pr_product_msp.qty_terima', 'tb_pr_product_msp.unit', 'tb_po_asset_msp.status_po', 'tb_pr_product_msp.created_at', 'tb_pr_product_msp.updated_at', 'tb_pr_product_msp.qty', 'no_invoice', 'total_nominal', 'kode_barang', 'no_invoice')
                    ->where('tb_po_asset_msp.status_po', 'kosong')
                    ->get();

        $nodo = DB::table('tb_do_msp')
                    ->join('inventory_delivery_msp', 'inventory_delivery_msp.no_do', '=', 'tb_do_msp.no')
                    ->join('inventory_delivery_msp_transaction', 'inventory_delivery_msp_transaction.id_transaction', '=', 'inventory_delivery_msp.id_transaction')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                    ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_do_msp.project_id')
                    ->select('tb_do_msp.no_do', 'inventory_produk_msp.nama', 'inventory_delivery_msp_transaction.qty_transac', 'inventory_produk_msp.unit', 'inventory_delivery_msp_transaction.updated_at', 'kode_barang', 'tb_id_project.id_project')
                    ->where('inventory_delivery_msp.status_kirim', 'kosong')
                    ->get();

        $sum_po = DB::table('tb_po_msp')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
                    ->select('qty_terima')
                    ->sum('qty_terima');

        $sum_do = DB::table('tb_do_msp')
                    ->join('inventory_delivery_msp', 'inventory_delivery_msp.no_do', '=', 'tb_do_msp.no')
                    ->join('inventory_delivery_msp_transaction', 'inventory_delivery_msp_transaction.id_transaction', '=', 'inventory_delivery_msp.id_transaction')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                    ->select('qty_transac')
                    ->sum('qty_transac');

        $no_po = DB::table('tb_po_msp')
                ->select('no_po')
                ->where('project', 'K')
                ->get();

        $no_do = DB::table('tb_do_msp')
                ->select('no_do')
                ->where('type_of_letter', 'PJ')
                ->get();

        return view('gudang.inventory_report_id_pro', compact('dropdown', 'nopo', 'nopo2', 'nodo', 'sum_po', 'sum_do', 'no_po', 'no_do'));
    }

    public function getdataidpro(Request $request)
    {
        $id_pro = DB::table('tb_id_project')
                    ->where('id_pro', $request->data)
                    ->value('id_pro');

        $id_project = DB::table('inventory_produk_msp')
                        ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_barang', '=', 'inventory_produk_msp.id_product')
                        ->join('tb_po_asset_msp', 'tb_po_asset_msp.id_po_asset', '=', 'tb_pr_product_msp.id_po_asset')
                        ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_po_asset_msp.project_id')
                        ->select(DB::raw('sum(tb_pr_product_msp.qty_terima) as total_terima'), 'inventory_produk_msp.nama', 'inventory_produk_msp.unit', 'inventory_produk_msp.kode_barang')
                        ->where('tb_po_asset_msp.status_po', '!=', 'NEW')
                        ->where('tb_po_asset_msp.status_po', '!=', 'PENDING')
                        ->where('tb_pr_product_msp.updated_at', '>=', $request->start)
                        ->where('tb_pr_product_msp.updated_at', '<=', $request->end)
                        ->where('tb_po_asset_msp.project_id', $id_pro)
                        ->groupBy('tb_pr_product_msp.id_barang')
                        ->get();

        return $id_project;
    }

    public function getdataidpro2(Request $request)
    {

        $id_pro = DB::table('tb_id_project')
                        ->where('id_pro', $request->data)
                        ->value('id_pro');

        $nodoo = DB::table('inventory_produk_msp')
                    ->join('inventory_delivery_msp_transaction', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                    ->join('inventory_delivery_msp', 'inventory_delivery_msp.id_transaction', '=', 'inventory_delivery_msp_transaction.id_transaction')
                    ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'inventory_delivery_msp.id_project')
                    ->select(DB::raw('sum(inventory_delivery_msp_transaction.qty_transac) as total_transac'), 'inventory_produk_msp.nama', 'inventory_produk_msp.unit', 'inventory_produk_msp.kode_barang')
                    ->where('inventory_delivery_msp.status_kirim', 'kirim')
                    ->orWhere('inventory_delivery_msp.status_kirim', 'SENT')
                    ->where('inventory_delivery_msp_transaction.updated_at', '>=', $request->start)
                    ->where('inventory_delivery_msp_transaction.updated_at', '<=', $request->end)
                    ->where('inventory_delivery_msp.id_project', $id_pro)
                    ->groupBy('inventory_delivery_msp_transaction.fk_id_product')
                    ->get();

        return $nodoo;
    }

    /*public function getqtypo(Request $request)
    {

        $id_pro = DB::table('tb_id_project')
                        ->where('id_pro', $request->data)
                        ->value('id_pro');

        $sum_po = DB::table('tb_po_msp')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
                    ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_po_msp.project_id')
                    ->select(DB::raw('sum(qty_terima) as total_terima'))
                    ->where('tb_id_project.id_pro', $id_pro)
                    ->where('tb_pr_product_msp.updated_at', '>=', $request->start)
                    ->where('tb_pr_product_msp.updated_at', '<=', $request->end)
                    ->get();

        return $sum_po;
    }

    public function getqtydo(Request $request)
    {
        $id_pro = DB::table('tb_id_project')
                        ->where('id_pro', $request->data)
                        ->value('id_pro');

        $sum_do = DB::table('tb_do_msp')
                    ->join('inventory_delivery_msp', 'inventory_delivery_msp.no_do', '=', 'tb_do_msp.no')
                    ->join('inventory_delivery_msp_transaction', 'inventory_delivery_msp_transaction.id_transaction', '=', 'inventory_delivery_msp.id_transaction')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                    ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_do_msp.project_id')
                    ->select(DB::raw('sum(qty_transac) as total_transac'))
                    ->where('tb_id_project.id_pro', $id_pro)
                    ->where('inventory_delivery_msp_transaction.updated_at', '>=', $request->start)
                    ->where('inventory_delivery_msp_transaction.updated_at', '<=', $request->end)
                    ->get();

        return $sum_do;
    }*/

    public function getnopo(Request $request)
    {
        $id_pro = DB::table('tb_id_project')
                        ->where('id_pro', $request->data)
                        ->value('id_pro');

        $no_po = DB::table('tb_po_msp')
                ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_po_msp.project_id')
                ->join('tb_po_asset_msp', 'tb_po_msp.no', '=', 'tb_po_asset_msp.no_po')
                ->select('tb_po_msp.no_po')
                ->where('tb_po_asset_msp.status_po', '!=', 'NEW')
                ->where('tb_po_asset_msp.status_po', '!=', 'PENDING')
                ->where('tb_po_asset_msp.updated_at', '>=', $request->start)
                ->where('tb_po_asset_msp.updated_at', '<=', $request->end)
                ->where('tb_po_asset_msp.project_id', $id_pro)
                ->get();

        return $no_po;
    }

    public function getnodo(Request $request)
    {
        $id_pro = DB::table('tb_id_project')
                        ->where('id_pro', $request->data)
                        ->value('id_pro');

        $no_do = DB::table('tb_do_msp')
                ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_do_msp.project_id')
                ->join('inventory_delivery_msp', 'inventory_delivery_msp.no_do', '=', 'tb_do_msp.no_do')
                ->select('tb_do_msp.no_do')
                ->where('inventory_delivery_msp.status_kirim', 'kirim')
                ->orWhere('inventory_delivery_msp.status_kirim', 'SENT')
                ->where('inventory_delivery_msp.updated_at', '>=', $request->start)
                ->where('inventory_delivery_msp.updated_at', '<=', $request->end)
                ->where('inventory_delivery_msp.id_project', $id_pro)
                ->get();

        return $no_do;
    }

    public function getdataidproexcelbydate(Request $request)
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->removeSheetByIndex(0);
        $spreadsheet->addSheet(new Worksheet($spreadsheet,'Inventory Data In'));
        $spreadsheet->addSheet(new Worksheet($spreadsheet,'Inventory Data Out'));
        $spreadsheet->addSheet(new Worksheet($spreadsheet,'No Purchase Order'));
        $spreadsheet->addSheet(new Worksheet($spreadsheet,'No Delivery Order'));
        $InSheet = $spreadsheet->setActiveSheetIndex(0);
        $OutSheet = $spreadsheet->setActiveSheetIndex(1);
        $PoSheet = $spreadsheet->setActiveSheetIndex(2);
        $DoSheet = $spreadsheet->setActiveSheetIndex(3);

        $InSheet->mergeCells('A1:E1');
        $OutSheet->mergeCells('A1:E1');
        $PoSheet->mergeCells('A1:B1');
        $DoSheet->mergeCells('A1:B1');
        $normalStyle = [
            'font' => [
                'name' => 'Calibri',
                'size' => 11
            ],
        ];

        $titleStyle = $normalStyle;
        $titleStyle['alignment'] = ['horizontal' => Alignment::HORIZONTAL_CENTER];
        $titleStyle['borders'] = ['outline' => ['borderStyle' => Border::BORDER_THIN]];
        $titleStyle['fill'] = ['fillType' => Fill::FILL_SOLID, 'startColor' => ["argb" => "FFFCD703"]];
        $titleStyle['font']['bold'] = true;

        $headerStyle = $normalStyle;
        $headerStyle['font']['bold'] = true;

        $InSheet->getStyle('A1:E1')->applyFromArray($titleStyle);
        $InSheet->setCellValue('A1','Data Inventory In');

        $id_pro = DB::table('tb_id_project')
                        ->where('id_pro', $request->type)
                        ->value('id_pro');

        $nopoo = Inventory_msp::join('tb_pr_product_msp', 'tb_pr_product_msp.id_barang', '=', 'inventory_produk_msp.id_product')
                        ->join('tb_po_asset_msp', 'tb_po_asset_msp.id_po_asset', '=', 'tb_pr_product_msp.id_po_asset')
                        ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_po_asset_msp.project_id')
                        ->select('inventory_produk_msp.kode_barang', 'inventory_produk_msp.nama', DB::raw('sum(tb_pr_product_msp.qty_terima) as total_terima'), 'inventory_produk_msp.unit')
                        ->where('tb_pr_product_msp.updated_at', '>=', $request->start)
                        ->where('tb_pr_product_msp.updated_at', '<=', $request->end)
                        ->where('tb_po_asset_msp.project_id', $id_pro)
                        ->groupBy('tb_pr_product_msp.id_barang')
                        ->get();

        $headerContent = ["No", "MSP Code", "Nama Barang", "Quantity", "Unit"];
        $InSheet->getStyle('A2:E2')->applyFromArray($headerStyle);
        $InSheet->fromArray($headerContent,NULL,'A2');

        $nopoo->map(function($item,$key) use ($InSheet){
            $InSheet->fromArray(array_merge([$key + 1],array_values($item->toArray())),NULL,'A' . ($key + 3));
        });

        $InSheet->getColumnDimension('A')->setAutoSize(true);
        $InSheet->getColumnDimension('B')->setAutoSize(true);
        $InSheet->getColumnDimension('C')->setAutoSize(true);
        $InSheet->getColumnDimension('D')->setAutoSize(true);
        $InSheet->getColumnDimension('E')->setAutoSize(true);

        $OutSheet->getStyle('A1:E1')->applyFromArray($titleStyle);
        $OutSheet->setCellValue('A1','Data Inventory Out');

        $id_pro = DB::table('tb_id_project')
                        ->where('id_pro', $request->type)
                        ->value('id_pro');

        $nodoo = Inventory_msp::join('inventory_delivery_msp_transaction', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
            ->join('inventory_delivery_msp', 'inventory_delivery_msp.id_transaction', '=', 'inventory_delivery_msp_transaction.id_transaction')
            ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'inventory_delivery_msp.id_project')
            ->select( 'inventory_produk_msp.kode_barang', 'inventory_produk_msp.nama', DB::raw('sum(inventory_delivery_msp_transaction.qty_transac) as total_transac'), 'inventory_produk_msp.unit')
            ->where('inventory_delivery_msp.id_project', $id_pro)
            ->where('inventory_delivery_msp_transaction.updated_at', '>=', $request->start)
            ->where('inventory_delivery_msp_transaction.updated_at', '<=', $request->end)
            ->groupBy('inventory_delivery_msp_transaction.fk_id_product')
            ->get();

        $headerContent = ["No","MSP Code", "Nama Barang","Quantity", "Unit"];
        $OutSheet->getStyle('A2:E2')->applyFromArray($headerStyle);
        $OutSheet->fromArray($headerContent,NULL,'A2');

        foreach ($nodoo as $key => $eachOut) {
            $OutSheet->fromArray(array_merge([$key + 1],array_values($eachOut->toArray())),NULL,'A' . ($key + 3));
        }

        $OutSheet->getColumnDimension('A')->setAutoSize(true);
        $OutSheet->getColumnDimension('B')->setAutoSize(true);
        $OutSheet->getColumnDimension('C')->setAutoSize(true);
        $OutSheet->getColumnDimension('D')->setAutoSize(true);
        $OutSheet->getColumnDimension('E')->setAutoSize(true);

        $PoSheet->getStyle('A1:B1')->applyFromArray($titleStyle);
        $PoSheet->setCellValue('A1','Report No Purchase Order');

        $id_pro = DB::table('tb_id_project')
                        ->where('id_pro', $request->type)
                        ->value('id_pro');

        $no_po = PONumberMSP::join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_po_msp.project_id')
                ->join('tb_po_asset_msp', 'tb_po_msp.no', '=', 'tb_po_asset_msp.no_po')
                ->select('tb_po_msp.no_po')
                ->where('tb_po_asset_msp.updated_at', '>=', $request->start)
                ->where('tb_po_asset_msp.updated_at', '<=', $request->end)
                ->where('tb_po_asset_msp.project_id', $id_pro)
                ->get();

        $headerContent = ["No", "No Purchase Order"];
        $PoSheet->getStyle('A2:B2')->applyFromArray($headerStyle);
        $PoSheet->fromArray($headerContent,NULL,'A2');

        foreach ($no_po as $key => $eachPo) {
            $PoSheet->fromArray(array_merge([$key + 1],array_values($eachPo->toArray())),NULL,'A' . ($key + 3));
        }

        $PoSheet->getColumnDimension('A')->setAutoSize(true);
        $PoSheet->getColumnDimension('B')->setAutoSize(true);

        $normalStyle = [
            'font' => [
                'name' => 'Calibri',
                'size' => 8
            ],
        ];

        $DoSheet->getStyle('A1:B1')->applyFromArray($titleStyle);
        $DoSheet->setCellValue('A1','Report No Delivery Order');

        $headerContent = ["No","No Delivery Order"];
        $DoSheet->getStyle('A2:B2')->applyFromArray($headerStyle);
        $DoSheet->fromArray($headerContent,NULL,'A2');

        $itemStyle = $normalStyle;
        $itemStyle['fill'] = ['fillType' => Fill::FILL_SOLID, 'startColor' => ["argb" => "FFFFFE9F"]];
        $itemStyle['borders'] = ['allBorders' => ['borderStyle' => Border::BORDER_THIN]];

        $id_pro = DB::table('tb_id_project')
                        ->where('id_pro', $request->type)
                        ->value('id_pro');

        $no_do = DOMSPNumber::join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_do_msp.project_id')
                ->join('inventory_delivery_msp', 'inventory_delivery_msp.no_do', '=', 'tb_do_msp.no_do')
                ->select('tb_do_msp.no_do')
                ->where('inventory_delivery_msp.updated_at', '>=', $request->start)
                ->where('inventory_delivery_msp.updated_at', '<=', $request->end)
                ->where('inventory_delivery_msp.id_project', $id_pro)
                ->get();

        foreach ($no_do as $key => $eachDo) {
            $DoSheet->fromArray(array_merge([$key + 1],array_values($eachDo->toArray())),NULL,'A' . ($key + 3));
        }

        $DoSheet->getColumnDimension('A')->setAutoSize(true);
        $DoSheet->getColumnDimension('B')->setAutoSize(true);

        $spreadsheet->setActiveSheetIndex(0);

        $fileName = 'Data inventory per idproject '. date('Y-m-d'). '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);
        return $writer->save("php://output");
    }

    public function getdataidpropdfbydate(Request $request)
    {
        $id_pro = DB::table('tb_id_project')
                    ->where('id_pro', $request->type)
                    ->value('id_pro');

        $nopoo = DB::table('inventory_produk_msp')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_barang', '=', 'inventory_produk_msp.id_product')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.id_po_asset', '=', 'tb_pr_product_msp.id_po_asset')
                    ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_po_asset_msp.project_id')
                    ->select(DB::raw('sum(tb_pr_product_msp.qty_terima) as total_terima'), 'inventory_produk_msp.nama', 'inventory_produk_msp.unit', 'inventory_produk_msp.kode_barang')
                    ->where('tb_pr_product_msp.updated_at', '>=', $request->start)
                    ->where('tb_pr_product_msp.updated_at', '<=', $request->end)
                    ->where('tb_po_asset_msp.project_id', $id_pro)
                    ->groupBy('tb_pr_product_msp.id_barang')
                    ->get();


        $nodoo = DB::table('inventory_produk_msp')
                    ->join('inventory_delivery_msp_transaction', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                    ->join('inventory_delivery_msp', 'inventory_delivery_msp.id_transaction', '=', 'inventory_delivery_msp_transaction.id_transaction')
                    ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'inventory_delivery_msp.id_project')
                    ->select(DB::raw('sum(inventory_delivery_msp_transaction.qty_transac) as total_transac'), 'inventory_produk_msp.nama', 'inventory_produk_msp.unit', 'inventory_produk_msp.kode_barang')
                    ->where('inventory_delivery_msp.id_project', $id_pro)
                    ->groupBy('inventory_delivery_msp_transaction.fk_id_product')
                    ->get();


        $no_po = DB::table('tb_po_msp')
                    ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_po_msp.project_id')
                    ->join('tb_po_asset_msp', 'tb_po_msp.no', '=', 'tb_po_asset_msp.no_po')
                    ->select('tb_po_msp.no_po')
                    ->where('tb_po_asset_msp.updated_at', '>=', $request->start)
                    ->where('tb_po_asset_msp.updated_at', '<=', $request->end)
                    ->where('tb_po_asset_msp.project_id', $id_pro)
                    ->get();


        $no_do = DB::table('tb_do_msp')
                    ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_do_msp.project_id')
                    ->join('inventory_delivery_msp', 'inventory_delivery_msp.no_do', '=', 'tb_do_msp.no_do')
                    ->select('tb_do_msp.no_do')
                    ->where('inventory_delivery_msp.updated_at', '>=', $request->start)
                    ->where('inventory_delivery_msp.updated_at', '<=', $request->end)
                    ->where('inventory_delivery_msp.id_project', $id_pro)
                    ->get();


        $pdf = PDF::loadView('gudang.pdf_idpro_inventory_report_bydate', compact('no_do', 'no_po', 'nodoo', 'nopoo'));
        return $pdf->download('data-inventory-per-idproject '.date("d-m-Y").'.pdf');
    }

}
