<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\PoNota;
use Auth;
use App\PoIdProject;
use App\SalesProject;

class IdProNotaController extends Controller
{
    public function index()
    {
    	$data = PoIdProject::join('tb_po_nota', 'tb_po_nota.id', '=', 'tb_po_id_project.id_po')->select('tb_po_nota.id', 'id_project', 'tb_po_nota.no_po', 'tb_po_id_project.id_po')->get();

    	$no_po = PoNota::all();

    	$id_pro = SalesProject::join('sales_lead_register','sales_lead_register.lead_id','=','tb_id_project.lead_id')
                    ->join('users','users.nik','=','sales_lead_register.nik')
                    ->select('tb_id_project.id_project')
                    ->where('users.id_company', '2')
                    ->whereYear('tb_id_project.created_at',date('Y'))
                    ->where('status', '!=', 'WO')
                    ->get();

    	return view('sales/id_project_nota',compact('data', 'no_po', 'id_pro'));
    }

    public function store(Request $request)
    {
    	$tambah = new PoIdProject();
    	$tambah->id_po = $request['no_po'];
    	$tambah->id_project = $request['id_project'];
    	$tambah->lokasi = $request['lokasi'];
    	$tambah->save();

    	return redirect('po_id_pro')->with('success', 'Successfully!');
    }

    public function getdata(Request $request)
    {
    	return array("data" => PoIdProject::join('tb_po_nota', 'tb_po_nota.id', '=', 'tb_po_id_project.id_po')->select('tb_po_nota.id', 'id_project', 'tb_po_nota.no_po', 'tb_po_id_project.id_po', 'lokasi')->get());
    }
}
