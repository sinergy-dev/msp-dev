<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use PDF;
use Excel;
use App\Inventory_msp;
use App\SalesProject;
use App\PONumberMSP;
use App\DOMSPNumber;

class WarehouseReportController extends Controller
{
    public function month_report() {

        $do = DB::table('tb_id_project')
                    ->join('inventory_delivery_msp', 'inventory_delivery_msp.id_project', '=', 'tb_id_project.id_pro')
                    ->join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                    ->join('inventory_delivery_msp_transaction','inventory_delivery_msp_transaction.id_transaction','=','inventory_delivery_msp.id_transaction')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                    ->select('tb_do_msp.no_do', 'nama', 'tb_id_project.id_project', 'status_kirim', 'inventory_delivery_msp_transaction.qty_transac', 'inventory_produk_msp.unit', 'kode_barang', 'inventory_delivery_msp.updated_at')
                    ->where('inventory_delivery_msp.status_kirim', 'kosong')
                    ->orderBy('inventory_delivery_msp.updated_at', 'desc')
                    ->get();

        // $po = DB::table('tb_id_project')
        //             ->join('tb_po_msp', 'tb_po_msp.project_id', '=', 'tb_id_project.id_pro')
        //             ->join('tb_po_asset_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no_po')
        //             ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
        //             ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
        //             ->select('tb_po_msp.no_po', 'tb_id_project.id_project', 'tb_pr_product_msp.name_product', 'tb_pr_product_msp.qty_terima', 'tb_pr_product_msp.unit', 'tb_po_asset_msp.status_po', 'tb_pr_product_msp.created_at', 'tb_po_asset_msp.updated_at', 'tb_pr_product_msp.qty', 'no_invoice', 'total_nominal', 'kode_barang', 'no_invoice')
        //             ->orderBy('tb_po_asset_msp.updated_at', 'desc')
        //             ->get();

        $po = DB::table('inventory_produk_msp')
                    ->join('inventory_changelog_msp','inventory_changelog_msp.id_product','=','inventory_produk_msp.id_product')
                    ->select('inventory_produk_msp.kode_barang', 'inventory_produk_msp.nama', 'inventory_changelog_msp.qty', 'inventory_produk_msp.unit', 'inventory_changelog_msp.created_at')
                    /*->where('inventory_changelog_msp.status', '=', 'P')*/
                    ->where('inventory_changelog_msp.status', '=', 'kosong')
                    ->orderBy('inventory_changelog_msp.created_at','desc')
                    ->get();

        $po2 = DB::table('tb_po_msp')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
                    ->select('tb_po_msp.no_po', 'tb_pr_product_msp.name_product', 'tb_pr_product_msp.qty_terima', 'tb_pr_product_msp.unit', 'tb_po_asset_msp.status_po', 'tb_pr_product_msp.created_at', 'tb_po_asset_msp.updated_at', 'tb_pr_product_msp.qty', 'no_invoice', 'total_nominal', 'kode_barang', 'no_invoice')
                    ->orderBy('tb_po_asset_msp.updated_at', 'desc')
                    ->where('tb_po_msp.project_id', null)
                    ->get();

        $dofilter = DB::table('tb_id_project')
                    ->join('inventory_delivery_msp', 'inventory_delivery_msp.id_project', '=', 'tb_id_project.id_pro')
                    ->join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                    ->join('inventory_delivery_msp_transaction','inventory_delivery_msp_transaction.id_transaction','=','inventory_delivery_msp.id_transaction')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                    ->select(DB::raw('sum(qty_transac) as total_transac'), 'inventory_produk_msp.nama', 'inventory_produk_msp.kode_barang', 'inventory_produk_msp.unit', 'inventory_produk_msp.updated_at')
                    // ->orderBy('inventory_delivery_msp_transaction.updated_at', 'desc')
                    ->groupBy('inventory_produk_msp.id_product')
                    ->get();

        $pofilter = DB::table('tb_id_project')
                    ->join('tb_po_msp', 'tb_po_msp.project_id', '=', 'tb_id_project.id_pro')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
                    ->select(DB::raw('sum(qty_terima) as total_terima'), 'inventory_produk_msp.nama', 'inventory_produk_msp.kode_barang', 'inventory_produk_msp.unit', 'inventory_produk_msp.updated_at')
                    // ->orderBy('tb_pr_product_msp.updated_at', 'desc')
                    ->groupBy('inventory_produk_msp.id_product')
                    ->get();

        $po2filter = DB::table('tb_po_msp')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
                    ->select(DB::raw('sum(qty_terima) as total_terima'), 'inventory_produk_msp.nama', 'inventory_produk_msp.kode_barang', 'inventory_produk_msp.unit', 'inventory_produk_msp.updated_at')
                    // ->orderBy('tb_pr_product_msp.updated_at', 'desc')
                    ->where('tb_po_msp.project_id', null)
                    ->groupBy('inventory_produk_msp.id_product')
                    ->get();

        $sum = DB::table('inventory_delivery_msp_transaction')->where('fk_id_product', '=', '1189')->sum('qty_transac');

        $idmt = DB::table('inventory_delivery_msp_transaction')
                    ->select(DB::raw('sum(qty_transac) as total'))
                    ->groupBy(DB::raw('fk_id_product'))
                    ->get();

        return view('gudang/month_inventory_report', compact('do', 'po', 'po2', 'dofilter', 'pofilter', 'po2filter', 'sum', 'idmt'));

    }

    public function getDataMonth(Request $request) {

        $reportpo = DB::table('inventory_produk_msp')
                    ->join('inventory_changelog_msp','inventory_changelog_msp.id_product','=','inventory_produk_msp.id_product')
                    ->select(DB::raw('sum(inventory_changelog_msp.qty) as total_terima'), 'inventory_produk_msp.kode_barang', 'inventory_produk_msp.nama', 'inventory_produk_msp.unit', 'inventory_produk_msp.created_at')
                    ->whereBetween('inventory_changelog_msp.created_at', [$request->start, $request->end])
                    ->where('inventory_changelog_msp.status', '=', 'P')
                    ->groupBy('inventory_changelog_msp.id_product')
                    ->get();

        $reportdo = DB::table('tb_id_project')
                    ->join('inventory_delivery_msp', 'inventory_delivery_msp.id_project', '=', 'tb_id_project.id_pro')
                    ->join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                    ->join('inventory_delivery_msp_transaction','inventory_delivery_msp_transaction.id_transaction','=','inventory_delivery_msp.id_transaction')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                    ->select(DB::raw('sum(qty_transac) as total_transac'), 'inventory_produk_msp.nama', 'inventory_produk_msp.kode_barang', 'inventory_produk_msp.unit', 'inventory_produk_msp.updated_at')
                    ->where('inventory_delivery_msp.updated_at', '>=', $request->start)
                    ->where('inventory_delivery_msp.updated_at', '<=', $request->end)
                    ->where('inventory_delivery_msp.status_kirim', '=', 'kirim')
                    ->orWhere('inventory_delivery_msp.status_kirim', '=', 'SENT')
                    ->groupBy('inventory_produk_msp.id_product')
                    ->get();

        $pdf = PDF::loadView('gudang.pdf_month_inventory_report', compact('reportpo', 'reportdo'));
        return $pdf->download('data-inventory-per-bulan'.date("d-m-Y").'.pdf');

    }

    public function getDataMonthExcel(Request $request) {

        $nama = 'data-inventory-per-bulan'.date("d-m-Y");
        Excel::create($nama, function ($excel) use ($request) {
            $excel->sheet('Inventory Data In', function ($sheet) use ($request) {
        
                $sheet->mergeCells('A1:E1');

                $sheet->row(1, function ($row) {
                    $row->setFontFamily('Calibri');
                    $row->setFontSize(11);
                    $row->setAlignment('center');
                    $row->setFontWeight('bold');
                });

                $sheet->row(1, array('IN'));

                $sheet->row(2, function ($row) {
                    $row->setFontFamily('Calibri');
                    $row->setFontSize(11);
                    $row->setFontWeight('bold');
                });

                $reportpo = Inventory_msp::join('inventory_changelog_msp','inventory_changelog_msp.id_product','=','inventory_produk_msp.id_product')
                                ->select(DB::raw('sum(inventory_changelog_msp.qty) as total_terima'), 'inventory_produk_msp.kode_barang', 'inventory_produk_msp.nama', 'inventory_produk_msp.unit', 'inventory_produk_msp.created_at')
                                ->whereBetween('inventory_changelog_msp.created_at', [$request->start, $request->end])
                                ->where('inventory_changelog_msp.status', '=', 'P')
                                ->groupBy('inventory_changelog_msp.id_product')
                                ->get();

                    $datasheetpo = array();
                    $datasheetpo[0] = array("NO", "MSP CODE", "NAMA BARANG", "QTY", 'UNIT');
                    $i=1;

                    foreach ($reportpo as $data) {

                        $datasheetpo[$i] = array($i,
                                    $data['kode_barang'],
                                    $data['nama'],
                                    $data['total_terima'],
                                    $data['unit']
                                );
                        $i++;
                    }

                    $sheet->fromArray($datasheetpo);
                    
            });

            $excel->sheet('Inventory Data Out', function ($sheet) use ($request) {
        
                $sheet->mergeCells('A1:E1');

                $sheet->row(1, function ($row) {
                    $row->setFontFamily('Calibri');
                    $row->setFontSize(11);
                    $row->setAlignment('center');
                    $row->setFontWeight('bold');
                });

                $sheet->row(1, array('OUT'));

                $sheet->row(2, function ($row) {
                    $row->setFontFamily('Calibri');
                    $row->setFontSize(11);
                    $row->setFontWeight('bold');
                });

                $reportdo = SalesProject::join('inventory_delivery_msp', 'inventory_delivery_msp.id_project', '=', 'tb_id_project.id_pro')
                                ->join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                                ->join('inventory_delivery_msp_transaction','inventory_delivery_msp_transaction.id_transaction','=','inventory_delivery_msp.id_transaction')
                                ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                                ->select(DB::raw('sum(qty_transac) as total_transac'), 'inventory_produk_msp.nama', 'inventory_produk_msp.kode_barang', 'inventory_produk_msp.unit', 'inventory_produk_msp.updated_at')
                                ->where('inventory_delivery_msp.updated_at', '>=', $request->start)
                                ->where('inventory_delivery_msp.updated_at', '<=', $request->end)
                                ->where('inventory_delivery_msp.status_kirim', '=', 'kirim')
                                ->orWhere('inventory_delivery_msp.status_kirim', '=', 'SENT')
                                ->groupBy('inventory_produk_msp.id_product')
                                ->get();

                    

                    $datasheetdo = array();
                    $datasheetdo[0] = array("NO", "MSP CODE", "NAMA BARANG", "QTY", 'UNIT');
                    $i=1;

                    foreach ($reportdo as $data) {

                        $datasheetdo[$i] = array($i,
                                    $data['kode_barang'],
                                    $data['nama'],
                                    $data['total_transac'],
                                    $data['unit']
                                );
                        $i++;
                    }

                    $sheet->fromArray($datasheetdo);
                    
            });

        })->export('xls');

    }

    public function getdofilter(Request $request) {

        $dofilter = DB::table('tb_id_project')
                    ->join('inventory_delivery_msp', 'inventory_delivery_msp.id_project', '=', 'tb_id_project.id_pro')
                    ->join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                    ->join('inventory_delivery_msp_transaction','inventory_delivery_msp_transaction.id_transaction','=','inventory_delivery_msp.id_transaction')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                    ->select(DB::raw('sum(qty_transac) as total_transac'), 'inventory_produk_msp.nama', 'inventory_produk_msp.kode_barang', 'inventory_produk_msp.unit', 'inventory_produk_msp.updated_at')
                    // ->select('qty_transac', 'inventory_produk_msp.nama', 'inventory_produk_msp.kode_barang', 'inventory_produk_msp.unit', 'inventory_produk_msp.updated_at')
                    ->where('inventory_delivery_msp.updated_at', '>=', $request->start)
                    ->where('inventory_delivery_msp.updated_at', '<=', $request->end)
                    ->where('inventory_delivery_msp.status_kirim', '=', 'kirim')
                    ->orWhere('inventory_delivery_msp.status_kirim', '=', 'SENT')
                    ->groupBy('inventory_produk_msp.id_product')
                    ->get();

        $docoba = DB::table('tb_id_project')
                    ->join('inventory_delivery_msp', 'inventory_delivery_msp.id_project', '=', 'tb_id_project.id_pro')
                    ->join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                    ->join('inventory_delivery_msp_transaction','inventory_delivery_msp_transaction.id_transaction','=','inventory_delivery_msp.id_transaction')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                    ->select('tb_do_msp.no_do', 'nama', 'tb_id_project.id_project', 'status_kirim', 'inventory_delivery_msp_transaction.qty_transac', 'inventory_delivery_msp_transaction.unit', 'kode_barang', 'inventory_delivery_msp_transaction.updated_at')
                    ->where('inventory_delivery_msp.updated_at', '>=', $request->start)
                    ->where('inventory_delivery_msp.updated_at', '<=', $request->end)
                    ->get();

        return $dofilter;

    }

    public function getpofilter(Request $request) {

        // $pofilter = DB::table('tb_id_project')
        //             ->join('tb_po_msp', 'tb_po_msp.project_id', '=', 'tb_id_project.id_pro')
        //             ->join('tb_po_asset_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no_po')
        //             ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
        //             ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
        //             ->select(DB::raw('sum(qty_terima) as total_terima'), 'inventory_produk_msp.nama', 'inventory_produk_msp.kode_barang', 'inventory_produk_msp.unit', 'inventory_produk_msp.updated_at')
        //             // ->select('qty_terima', 'inventory_produk_msp.nama', 'inventory_produk_msp.kode_barang', 'inventory_produk_msp.unit', 'inventory_produk_msp.updated_at')
        //             ->where('tb_pr_product_msp.updated_at', '>=', $request->start)
        //             ->where('tb_pr_product_msp.updated_at', '<=', $request->end)
        //             ->groupBy('inventory_produk_msp.id_product')
        //             ->get();

        $pofilter = DB::table('inventory_produk_msp')
                    ->join('inventory_changelog_msp','inventory_changelog_msp.id_product','=','inventory_produk_msp.id_product')
                    ->select(DB::raw('sum(inventory_changelog_msp.qty) as total_terima'), 'inventory_produk_msp.kode_barang', 'inventory_produk_msp.nama', 'inventory_produk_msp.unit', 'inventory_produk_msp.created_at')
                    // ->where('inventory_changelog_msp.created_at', '>=', $request->start)
                    // ->where('inventory_changelog_msp.created_at', '<=', $request->end)
                    ->whereBetween('inventory_changelog_msp.created_at', [$request->start, $request->end])
                    ->where('inventory_changelog_msp.status', '=', 'P')
                    ->groupBy('inventory_changelog_msp.id_product')
                    ->get();

        $pocoba = DB::table('tb_id_project')
                    ->join('tb_po_msp', 'tb_po_msp.project_id', '=', 'tb_id_project.id_pro')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
                    ->select('tb_po_msp.no_po', 'tb_id_project.id_project', 'tb_pr_product_msp.name_product', 'tb_pr_product_msp.qty_terima', 'tb_pr_product_msp.unit', 'tb_po_asset_msp.status_po', 'tb_pr_product_msp.created_at', 'tb_pr_product_msp.updated_at', 'tb_pr_product_msp.qty', 'no_invoice', 'total_nominal', 'kode_barang', 'no_invoice')
                    ->where('tb_pr_product_msp.updated_at', '>=', $request->start)
                    ->where('tb_pr_product_msp.updated_at', '<=', $request->end)
                    ->get();

        return $pofilter;

    }

    public function getpostockfilter(Request $request) {

        $postockfilter = DB::table('tb_po_msp')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
                    ->select(DB::raw('sum(qty_terima) as total_terima'), 'inventory_produk_msp.nama', 'inventory_produk_msp.kode_barang', 'inventory_produk_msp.unit', 'inventory_produk_msp.updated_at')
                    ->where('tb_pr_product_msp.updated_at', '>=', $request->start)
                    ->where('tb_pr_product_msp.updated_at', '<=', $request->end)
                    ->where('tb_po_msp.project_id', null)
                    ->groupBy('inventory_produk_msp.id_product')
                    ->get();

        return $postockfilter;

    }

    public function index_inventory_report() 
    {
        /*$dropdown = DB::table('tb_id_project')
                        ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                        ->join('users','users.nik','=','sales_lead_register.nik')
                        ->select('id_project')
                        ->where('id_company', '2')
                        ->get();*/

        $do = DB::table('tb_id_project')
                    ->join('inventory_delivery_msp', 'inventory_delivery_msp.id_project', '=', 'tb_id_project.id_pro')
                    ->join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                    ->join('inventory_delivery_msp_transaction','inventory_delivery_msp_transaction.id_transaction','=','inventory_delivery_msp.id_transaction')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                    ->select('tb_do_msp.no_do', 'nama', 'tb_id_project.id_project', 'status_kirim', 'inventory_delivery_msp_transaction.qty_transac', 'inventory_delivery_msp_transaction.unit', 'kode_barang', 'inventory_delivery_msp_transaction.updated_at')
                    ->orderBy('inventory_delivery_msp_transaction.updated_at', 'desc')
                    ->get();

        $po = DB::table('tb_id_project')
                    ->join('tb_po_msp', 'tb_po_msp.project_id', '=', 'tb_id_project.id_pro')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
                    ->select('tb_po_msp.no_po', 'tb_id_project.id_project', 'tb_pr_product_msp.name_product', 'tb_pr_product_msp.qty_terima', 'tb_pr_product_msp.unit', 'tb_po_asset_msp.status_po', 'tb_pr_product_msp.created_at', 'tb_pr_product_msp.updated_at', 'tb_pr_product_msp.qty', 'no_invoice', 'total_nominal', 'kode_barang', 'no_invoice')
                    ->orderBy('tb_pr_product_msp.updated_at', 'desc')
                    ->get();

        $po2 = DB::table('tb_po_msp')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
                    ->select('tb_po_msp.no_po', 'tb_pr_product_msp.name_product', 'tb_pr_product_msp.qty_terima', 'tb_pr_product_msp.unit', 'tb_po_asset_msp.status_po', 'tb_pr_product_msp.created_at', 'tb_pr_product_msp.updated_at', 'tb_pr_product_msp.qty', 'no_invoice', 'total_nominal', 'kode_barang', 'no_invoice')
                    ->orderBy('tb_pr_product_msp.updated_at', 'desc')
                    ->where('tb_po_msp.project_id', null)
                    ->get();

        // $do = DB::table('tb_id_project')
        //             ->join('inventory_delivery_msp', 'inventory_delivery_msp.id_project', '=', 'tb_id_project.id_pro')
        //             ->join('inventory_delivery_msp_transaction','inventory_delivery_msp_transaction.id_transaction','=','inventory_delivery_msp.id_transaction')
        //             ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
        //             ->select(DB::raw('group_concat(DISTINCT(nama)) as namas'), DB::raw('group_concat(DISTINCT(kode_barang)) as kode_barangs'), DB::raw("group_concat(qty_transac,' ',inventory_delivery_msp_transaction.unit) as qty_transacs"), 'tb_id_project.id_project')
        //             ->groupBy('id_pro')
                   
        //             ->get();

        // $do = DB::table('inventory_delivery_msp')
        //             ->join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
        //             ->join('inventory_delivery_msp_transaction','inventory_delivery_msp_transaction.id_transaction','=','inventory_delivery_msp.id_transaction')
        //             ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
        //             ->select('tb_do_msp.no_do','nama', 'id_project', 'status_kirim', 'inventory_delivery_msp_transaction.qty_transac', 'inventory_delivery_msp_transaction.unit')
        //             ->orderBy('inventory_delivery_msp_transaction.created_at', 'desc')
        //             ->get();

        $nopo = DB::table('tb_po_msp')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
                    ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_po_msp.project_id')
                    ->select('tb_po_msp.no_po', 'tb_pr_product_msp.name_product', 'tb_pr_product_msp.qty_terima', 'tb_pr_product_msp.unit', 'tb_po_asset_msp.status_po', 'tb_pr_product_msp.created_at', 'tb_pr_product_msp.updated_at', 'tb_pr_product_msp.qty', 'no_invoice', 'total_nominal', 'kode_barang', 'no_invoice', 'tb_id_project.id_project')
                    // ->where('tb_po_asset_msp.project_id', '046/CER/I/2019asd')
                    ->orderBy('tb_po_msp.no_po', 'desc')
                    ->orderBy('tb_pr_product_msp.updated_at', 'desc')
                    ->get();

        $nopo2 = DB::table('tb_po_msp')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
                    ->select('tb_po_msp.no_po', 'tb_pr_product_msp.name_product', 'tb_pr_product_msp.qty_terima', 'tb_pr_product_msp.unit', 'tb_po_asset_msp.status_po', 'tb_pr_product_msp.created_at', 'tb_pr_product_msp.updated_at', 'tb_pr_product_msp.qty', 'no_invoice', 'total_nominal', 'kode_barang', 'no_invoice')
                    ->orderBy('tb_pr_product_msp.updated_at', 'desc')
                    ->where('tb_po_msp.project_id', null)
                    ->get();

        $nodo = DB::table('tb_do_msp')
                    ->join('inventory_delivery_msp', 'inventory_delivery_msp.no_do', '=', 'tb_do_msp.no')
                    ->join('inventory_delivery_msp_transaction', 'inventory_delivery_msp_transaction.id_transaction', '=', 'inventory_delivery_msp.id_transaction')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                    ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_do_msp.project_id')
                    ->select('tb_do_msp.no_do', 'inventory_produk_msp.nama', 'inventory_delivery_msp_transaction.qty_transac', 'inventory_delivery_msp_transaction.unit', 'inventory_delivery_msp_transaction.updated_at', 'kode_barang', 'tb_id_project.id_project')
                    ->orderBy('tb_do_msp.no_do', 'desc')
                    ->orderBy('inventory_delivery_msp_transaction.created_at', 'desc')
                    ->get();

        return view('gudang/inventory_report', compact('po', 'po2', 'do', 'nopo', 'nopo2', 'nodo', 'penerimaan'));
    }

    public function nopoo(Request $request) {

        $id_pro = DB::table('tb_id_project')
                        ->where('id_project', $request->data)
                        ->value('id_project');

        $nopoo = DB::table('tb_id_project')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.project_id', '=', 'tb_id_project.id_pro')
                    ->join('tb_po_msp', 'tb_po_msp.no', '=', 'tb_po_asset_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
                    ->select('tb_id_project.id_project', 'tb_po_asset_msp.project_id', 'tb_po_msp.no_po', 'tb_pr_product_msp.name_product', 'tb_pr_product_msp.qty_terima', 'tb_pr_product_msp.unit', 'tb_pr_product_msp.created_at', 'tb_pr_product_msp.updated_at', 'tb_pr_product_msp.qty', 'no_invoice', 'total_nominal', 'kode_barang', 'no_invoice')
                    ->where('tb_id_project.id_project', $id_pro)
                    ->orderBy('tb_pr_product_msp.updated_at', 'desc')
                    ->get();

        return $nopoo;

    }

    public function nodoo(Request $request) {

        $id_pro = DB::table('tb_id_project')
                        ->where('id_project', $request->data)
                        ->value('id_project');

        $nodoo = DB::table('tb_id_project')
                    ->join('inventory_delivery_msp', 'inventory_delivery_msp.id_project', '=', 'tb_id_project.id_pro')
                    ->join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                    ->join('inventory_delivery_msp_transaction','inventory_delivery_msp_transaction.id_transaction','=','inventory_delivery_msp.id_transaction')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                    ->select('tb_do_msp.no_do','nama', 'tb_id_project.id_project', 'status_kirim', 'inventory_delivery_msp_transaction.qty_transac', 'inventory_delivery_msp_transaction.unit', 'inventory_delivery_msp_transaction.updated_at', 'kode_barang')
                    ->where('tb_id_project.id_project', $id_pro)
                    ->orderBy('inventory_delivery_msp_transaction.created_at', 'desc')
                    ->get();

        return $nodoo;

    }

    public function getDropdown(Request $request)
    {
        if ($request->id_client == 'id_project') {
            return array(DB::table('tb_id_project')
                ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                ->join('users','users.nik','=','sales_lead_register.nik')
                ->select('id_project')
                ->where('id_company', '2')
                ->get(),$request->id_client);
        } else if ($request->id_client == 'delivery_order') {
            return array(DB::table('tb_do_msp')
            ->select('no_do', 'no')
            ->orderBy('no_do','desc')
            ->get(),$request->id_client);
        }
    }

    public function getdatadropdown_do(Request $request)
    {
        $id_pro = DB::table('tb_id_project')
                    ->where('id_project', $request->data)
                    ->value('id_project');

        $id_project = DB::table('tb_id_project')
                ->join('inventory_delivery_msp', 'inventory_delivery_msp.id_project', '=', 'tb_id_project.id_pro')
                ->join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                ->join('inventory_delivery_msp_transaction','inventory_delivery_msp_transaction.id_transaction','=','inventory_delivery_msp.id_transaction')
                ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                ->select('tb_do_msp.no_do','nama', 'tb_id_project.id_project', 'status_kirim', 'inventory_delivery_msp_transaction.qty_transac', 'inventory_delivery_msp_transaction.unit', 'kode_barang', 'inventory_delivery_msp_transaction.updated_at')
                ->where('tb_id_project.id_project', $id_pro)
                ->orderBy('inventory_delivery_msp_transaction.created_at', 'desc')
                ->get();

        return $id_project;
    }

    public function getdatadropdown_do2(Request $request) {

        $po2 = DB::table('tb_id_project')
                    ->join('tb_po_msp', 'tb_po_msp.project_id', '=', 'tb_id_project.id_pro')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
                    ->select('tb_po_msp.no_po', 'tb_id_project.id_project', 'tb_pr_product_msp.name_product', 'tb_pr_product_msp.qty_terima', 'tb_pr_product_msp.unit', 'tb_po_asset_msp.status_po', 'tb_pr_product_msp.created_at', 'tb_pr_product_msp.updated_at', 'tb_pr_product_msp.qty', 'no_invoice', 'total_nominal', 'kode_barang', 'no_invoice')
                    ->orderBy('tb_pr_product_msp.updated_at', 'desc')
                    ->get();

        return $po2;

    }

    public function getdatadropdown_po(Request $request)
    {
        $id_pro = DB::table('tb_id_project')
                    ->where('id_project', $request->data)
                    ->value('id_project');

        $id_project = DB::table('tb_id_project')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.project_id', '=', 'tb_id_project.id_pro')
                    ->join('tb_po_msp', 'tb_po_msp.no', '=', 'tb_po_asset_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->select('tb_po_asset_msp.project_id', 'tb_po_msp.no_po', 'tb_pr_product_msp.name_product', 'tb_pr_product_msp.qty_terima', 'tb_pr_product_msp.unit', 'tb_pr_product_msp.created_at', 'tb_pr_product_msp.updated_at', 'no_invoice', 'qty', 'status_po', 'total_nominal')
                    ->where('tb_id_project.id_project', $id_pro)
                    ->orderBy('tb_pr_product_msp.updated_at', 'desc')
                    ->get();

        return $id_project;
    }

    public function getdatadropdown2(Request $request)
    {
        if ($request->type == 'id_project') {
            $id_pro = DB::table('tb_id_project')
                        ->where('id_project', $request->data)
                        ->value('id_project');

            // $report = DB::table('inventory_delivery_msp')
            //         ->join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
            //         ->join('inventory_delivery_msp_transaction','inventory_delivery_msp_transaction.id_transaction','=','inventory_delivery_msp.id_transaction')
            //         ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
            //         ->select('tb_do_msp.no_do','nama', 'id_project', 'status_kirim')
            //         ->where('inventory_delivery_msp.id_project', $id_pro)
            //         ->get();

            $report = DB::table('tb_id_project')
                    ->join('inventory_delivery_msp', 'inventory_delivery_msp.id_project', '=', 'tb_id_project.id_pro')
                    ->join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                    ->join('inventory_delivery_msp_transaction','inventory_delivery_msp_transaction.id_transaction','=','inventory_delivery_msp.id_transaction')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.project_id', '=', 'tb_id_project.id_pro')
                    ->join('tb_po_msp', 'tb_po_msp.no', '=', 'tb_po_asset_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->select('tb_do_msp.no_do','nama', 'tb_id_project.id_project', 'status_kirim', 'inventory_delivery_msp_transaction.qty_transac', 'inventory_delivery_msp_transaction.unit as unit_do', 'tb_po_msp.no_po', 'tb_pr_product_msp.name_product', 'tb_pr_product_msp.qty_terima', 'tb_pr_product_msp.unit as unit_po', 'tb_pr_product_msp.created_at', 'tb_pr_product_msp.updated_at','status_po','status_kirim')
                    ->where('tb_id_project.id_project', $id_pro)
                    ->orderBy('inventory_delivery_msp_transaction.created_at', 'desc')
                    ->get();

        } elseif ($request->type == 'delivery_order') {
            $no_do = DB::table('tb_do_msp')
                    ->where('no', $request->data)
                    ->value('no');

            $report = DB::table('inventory_delivery_msp')
                    ->join('tb_do_msp','tb_do_msp.no','=','inventory_delivery_msp.no_do')
                    ->join('inventory_delivery_msp_transaction','inventory_delivery_msp_transaction.id_transaction','=','inventory_delivery_msp.id_transaction')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                    ->select('tb_do_msp.no_do', 'id_project', 'status_kirim', 'inventory_produk_msp.nama', 'inventory_delivery_msp_transaction.qty_transac', 'inventory_produk_msp.unit')
                    ->where('inventory_delivery_msp.no_do', $no_do)
                    ->get();
        }

        $pdf = PDF::loadView('gudang.report_inventory_pdf', compact('report'));
        return $pdf->download('report'.date("d-m-Y").'.pdf');

    }

    public function getdatadropdownpo(Request $request) {

        $id_pro = DB::table('tb_id_project')
                    ->where('id_project', $request->data)
                    ->value('id_project');

        $report = DB::table('tb_id_project')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.project_id', '=', 'tb_id_project.id_pro')
                    ->join('tb_po_msp', 'tb_po_msp.no', '=', 'tb_po_asset_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->select('tb_po_asset_msp.project_id', 'tb_po_msp.no_po', 'tb_pr_product_msp.name_product', 'tb_pr_product_msp.qty_terima', 'tb_pr_product_msp.unit', 'tb_pr_product_msp.created_at', 'tb_pr_product_msp.updated_at')
                    ->where('tb_id_project.id_project', $id_pro)
                    ->orderBy('tb_pr_product_msp.updated_at', 'desc')
                    ->get();

        $pdf = PDF::loadView('gudang.report_po_pdf', compact('report'));
        return $pdf->download('report'.date("d-m-Y").'.pdf');

    }

    public function idpro_report(Request $request)
    {
        $dropdown = DB::table('tb_id_project')
                        ->join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                        ->join('users','users.nik','=','sales_lead_register.nik')
                        ->select('id_project', 'tb_id_project.id_pro')
                        ->where('id_company', '2')
                        ->get();

        $poo = DB::table('tb_po_msp')
                    ->join('tb_po_asset_msp', 'tb_po_asset_msp.no_po', '=', 'tb_po_msp.no_po')
                    ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_po_asset', '=', 'tb_po_asset_msp.id_po_asset')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'tb_pr_product_msp.id_barang')
                    ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_po_msp.project_id')
                    ->select('tb_pr_product_msp.name_product', 'tb_pr_product_msp.qty_terima', 'tb_pr_product_msp.unit', 'tb_pr_product_msp.msp_code')
                    ->where('tb_po_asset_msp.status_po', 'kosong')
                    ->get();

        $doo = DB::table('tb_do_msp')
                    ->join('inventory_delivery_msp', 'inventory_delivery_msp.no_do', '=', 'tb_do_msp.no')
                    ->join('inventory_delivery_msp_transaction', 'inventory_delivery_msp_transaction.id_transaction', '=', 'inventory_delivery_msp.id_transaction')
                    ->join('inventory_produk_msp', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                    ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_do_msp.project_id')
                    ->select('inventory_produk_msp.nama', 'inventory_produk_msp.unit','inventory_produk_msp.kode_barang', 'inventory_produk_msp.id_product', 'qty_transac')
                    ->where('inventory_delivery_msp.status_kirim', 'kosong')
                    ->get();

        $no_po = DB::table('tb_po_msp')
                ->select('no_po')
                ->where('project', 'K')
                ->get();

        $no_do = DB::table('tb_do_msp')
                ->select('no_do')
                ->where('type_of_letter', 'PJ')
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

        return view('gudang.inventory_report_id_pro2', compact('dropdown', 'poo', 'doo', 'sum_po', 'sum_do', 'no_po', 'no_do'));
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
                        ->where('tb_po_asset_msp.project_id', $id_pro)
                        ->groupBy('tb_pr_product_msp.id_barang')
                        ->get();

        return $id_project;
    }

    public function getdataidpropdf(Request $request)
    {
        $id_pro = DB::table('tb_id_project')
                    ->where('id_pro', $request->type)
                    ->value('id_pro');

        $nopoo = DB::table('inventory_produk_msp')
                        ->join('tb_pr_product_msp', 'tb_pr_product_msp.id_barang', '=', 'inventory_produk_msp.id_product')
                        ->join('tb_po_asset_msp', 'tb_po_asset_msp.id_po_asset', '=', 'tb_pr_product_msp.id_po_asset')
                        ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_po_asset_msp.project_id')
                        ->select(DB::raw('sum(tb_pr_product_msp.qty_terima) as total_terima'), 'inventory_produk_msp.nama', 'inventory_produk_msp.unit', 'inventory_produk_msp.kode_barang')
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
                ->where('tb_po_asset_msp.project_id', $id_pro)
                ->get();


        $no_do = DB::table('tb_do_msp')
                ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_do_msp.project_id')
                ->join('inventory_delivery_msp', 'inventory_delivery_msp.no_do', '=', 'tb_do_msp.no_do')
                ->select('tb_do_msp.no_do')
                ->where('inventory_delivery_msp.id_project', $id_pro)
                ->get();


        $pdf = PDF::loadView('gudang.pdf_idpro_inventory_report', compact('no_do', 'no_po', 'nodoo', 'nopoo'));
        return $pdf->download('data-inventory-per-idproject '.date("d-m-Y").'.pdf');
    }

    public function getdataidproexcel(Request $request)
    {
        $nama = 'data-inventory-per-idproject '.date("d-m-Y");
        Excel::create($nama, function ($excel) use ($request) {
            $excel->sheet('Inventory Data In', function ($sheet) use ($request) {
        
                $sheet->mergeCells('A1:E1');

                $sheet->row(1, function ($row) {
                    $row->setFontFamily('Calibri');
                    $row->setFontSize(11);
                    $row->setAlignment('center');
                    $row->setFontWeight('bold');
                });

                $sheet->row(1, array('IN'));

                $sheet->row(2, function ($row) {
                    $row->setFontFamily('Calibri');
                    $row->setFontSize(11);
                    $row->setFontWeight('bold');
                });

                $id_pro = DB::table('tb_id_project')
                        ->where('id_pro', $request->type)
                        ->value('id_pro');

                $nopoo = Inventory_msp::join('tb_pr_product_msp', 'tb_pr_product_msp.id_barang', '=', 'inventory_produk_msp.id_product')
                            ->join('tb_po_asset_msp', 'tb_po_asset_msp.id_po_asset', '=', 'tb_pr_product_msp.id_po_asset')
                            ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_po_asset_msp.project_id')
                            ->select(DB::raw('sum(tb_pr_product_msp.qty_terima) as total_terima'), 'inventory_produk_msp.nama', 'inventory_produk_msp.unit', 'inventory_produk_msp.kode_barang')
                            ->where('tb_po_asset_msp.project_id', $id_pro)
                            ->groupBy('tb_pr_product_msp.id_barang')
                            ->get();


                    $datasheetpo = array();
                    $datasheetpo[0] = array("NO", "MSP CODE", "NAMA BARANG", "QTY", 'UNIT');
                    $i=1;

                    foreach ($nopoo as $data) {

                        $datasheetpo[$i] = array($i,
                                    $data['kode_barang'],
                                    $data['nama'],
                                    $data['total_terima'],
                                    $data['unit']
                                );
                        $i++;
                    }

                    $sheet->fromArray($datasheetpo);
                    
            });

            $excel->sheet('Inventory Data Out', function ($sheet) use ($request) {
        
                $sheet->mergeCells('A1:E1');

                $sheet->row(1, function ($row) {
                    $row->setFontFamily('Calibri');
                    $row->setFontSize(11);
                    $row->setAlignment('center');
                    $row->setFontWeight('bold');
                });

                $sheet->row(1, array('Out'));

                $sheet->row(2, function ($row) {
                    $row->setFontFamily('Calibri');
                    $row->setFontSize(11);
                    $row->setFontWeight('bold');
                });

                $id_pro = DB::table('tb_id_project')
                        ->where('id_pro', $request->type)
                        ->value('id_pro');

                $nodoo = Inventory_msp::join('inventory_delivery_msp_transaction', 'inventory_produk_msp.id_product', '=', 'inventory_delivery_msp_transaction.fk_id_product')
                    ->join('inventory_delivery_msp', 'inventory_delivery_msp.id_transaction', '=', 'inventory_delivery_msp_transaction.id_transaction')
                    ->join('tb_id_project', 'tb_id_project.id_pro', '=', 'inventory_delivery_msp.id_project')
                    ->select(DB::raw('sum(inventory_delivery_msp_transaction.qty_transac) as total_transac'), 'inventory_produk_msp.nama', 'inventory_produk_msp.unit', 'inventory_produk_msp.kode_barang')
                    ->where('inventory_delivery_msp.id_project', $id_pro)
                    ->groupBy('inventory_delivery_msp_transaction.fk_id_product')
                    ->get();


                    $datasheetdo = array();
                    $datasheetdo[0] = array("NO", "MSP CODE", "NAMA BARANG", "QTY", 'UNIT');
                    $i=1;

                    foreach ($nodoo as $data) {

                        $datasheetdo[$i] = array($i,
                                    $data['kode_barang'],
                                    $data['nama'],
                                    $data['total_transac'],
                                    $data['unit']
                                );
                        $i++;
                    }

                    $sheet->fromArray($datasheetdo);
                    
            });

            $excel->sheet('No Purchase Order', function ($sheet) use ($request) {
        
                $sheet->mergeCells('A1:B1');

                $sheet->row(1, function ($row) {
                    $row->setFontFamily('Calibri');
                    $row->setFontSize(11);
                    $row->setAlignment('center');
                    $row->setFontWeight('bold');
                });

                $sheet->row(1, array('Purchase Order'));

                $sheet->row(2, function ($row) {
                    $row->setFontFamily('Calibri');
                    $row->setFontSize(11);
                    $row->setFontWeight('bold');
                });

                $id_pro = DB::table('tb_id_project')
                        ->where('id_pro', $request->type)
                        ->value('id_pro');

                $no_po = PONumberMSP::join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_po_msp.project_id')
                        ->join('tb_po_asset_msp', 'tb_po_msp.no', '=', 'tb_po_asset_msp.no_po')
                        ->select('tb_po_msp.no_po')
                        ->where('tb_po_asset_msp.project_id', $id_pro)
                        ->get();

                    $datasheetnopo = array();
                    $datasheetnopo[0] = array("NO", "NO Purchase Order");
                    $i=1;

                    foreach ($no_po as $data) {

                        $datasheetnopo[$i] = array($i,
                                    $data['no_po']
                                );
                        $i++;
                    }

                    $sheet->fromArray($datasheetnopo);
                    
            });

            $excel->sheet('No Delivery Order', function ($sheet) use ($request) {
        
                $sheet->mergeCells('A1:B1');

                $sheet->row(1, function ($row) {
                    $row->setFontFamily('Calibri');
                    $row->setFontSize(11);
                    $row->setAlignment('center');
                    $row->setFontWeight('bold');
                });

                $sheet->row(1, array('Delivery Order'));

                $sheet->row(2, function ($row) {
                    $row->setFontFamily('Calibri');
                    $row->setFontSize(11);
                    $row->setFontWeight('bold');
                });

                $id_pro = DB::table('tb_id_project')
                        ->where('id_pro', $request->type)
                        ->value('id_pro');

                $no_do = DOMSPNumber::join('tb_id_project', 'tb_id_project.id_pro', '=', 'tb_do_msp.project_id')
                        ->join('inventory_delivery_msp', 'inventory_delivery_msp.no_do', '=', 'tb_do_msp.no_do')
                        ->select('tb_do_msp.no_do')
                        ->where('inventory_delivery_msp.id_project', $id_pro)
                        ->get();


                    $datasheetnodo = array();
                    $datasheetnodo[0] = array("NO", "NO Delivery Order");
                    $i=1;

                    foreach ($no_do as $data) {

                        $datasheetnodo[$i] = array($i,
                                    $data['no_do']
                                );
                        $i++;
                    }

                    $sheet->fromArray($datasheetnodo);
                    
            });

        })->export('xls');
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
                ->where('inventory_delivery_msp.id_project', $id_pro)
                ->groupBy('inventory_delivery_msp_transaction.fk_id_product')
                ->get();

        return $nodoo;
    }

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
                ->where('inventory_delivery_msp.id_project', $id_pro)
                ->get();

        return $no_do;
    }

}
