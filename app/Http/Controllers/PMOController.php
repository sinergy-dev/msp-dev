<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PMO;
use App\PMOProgress;
use App\Sales;
use App\Sales2;
use Session;
use Auth;
use DB;
use PDF;

use Excel;

class PMOController extends Controller
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
        //
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
    public function store(Request $request)
    {
        $tambah = new PMO();
        $tambah->pmo_nik = $request['pmo_nik'];
        $tambah->lead_id = $request['coba_lead_pmo'];
        $tambah->save();

        $lead_id = $request['coba_lead_pmo'];

        $update = Sales::where('lead_id', $lead_id)->first();
        $update->status_sho = 'PMO';
        $update->update();

        return redirect()->back();
    }

    public function update_pmo(Request $request)
    {
        $lead_pmo = $request['pmo_reassign'];

        $update = PMO::where('lead_id',$lead_pmo)->first();
        $update->pmo_nik = $request['upadte_pmo_nik'];
        $update->update();

        return redirect()->back();
    }

    public function progress_store(Request $request)
    {
        $tambah = new PMOProgress();
        $tambah->id_pmo = $request['id_pmo'];
        $tambah->tanggal = $request['tanggal'];
        $tambah->ket = $request['keterangan'];
        $tambah->save();

        return redirect()->back();
    }

    public function add_contribute(Request $request)
    {
        $tambah = new PMO();
        $tambah->lead_id = $request['coba_lead_contribute_pmo'];
        $tambah->pmo_nik = $request['add_contribute_pmo'];
        $tambah->save();

        return redirect()->back();
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
    public function destroy($id_pmo)
    {
        $hapus = PMO::find($id_pmo);
        $hapus->delete();

        return redirect()->back();
    }

    public function exportExcel(Request $request)
    {
        $nama = 'Lead Register '.date('Y-m-d');
        Excel::create($nama, function ($excel) use ($request) {
        $excel->sheet('Lead Register', function ($sheet) use ($request) {
        
        $sheet->mergeCells('A1:H1');

       // $sheet->setAllBorders('thin');
        $sheet->row(1, function ($row) {
            $row->setFontFamily('Calibri');
            $row->setFontSize(11);
            $row->setAlignment('center');
            $row->setFontWeight('bold');
        });

        $sheet->row(1, array('LEAD REGISTER'));

        $sheet->row(2, function ($row) {
            $row->setFontFamily('Calibri');
            $row->setFontSize(11);
            $row->setFontWeight('bold');
        });

        $datas = Sales2::join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','users.nik','tb_contact.code')
                    ->where('sales_lead_register.result','WIN')
                    ->get();

       // $sheet->appendRow(array_keys($datas[0]));
            $sheet->row($sheet->getHighestRow(), function ($row) {
                $row->setFontWeight('bold');
            });

             $datasheet = array();
             $datasheet[0]  =   array("NO", "LEAD ID", "CUSTOMER", "OPTY NAME", "CREATE DATE",  "OWNER", "AMOUNT", "STATUS");
             $i=1;

            foreach ($datas as $data) {

               // $sheet->appendrow($data);
              $datasheet[$i] = array($i,
                            $data['lead_id'],
                            $data['code'],
                            $data['opp_name'],
                            $data['created_at'],
                            $data['name'],
                            $data['amount'],
                            $data['result']
                        );
              
              $i++;
            }

            $sheet->fromArray($datasheet);
        });

        })->export('xls');
    }

    // public function downloadPDF()
    // {
    //     $nik = Auth::User()->nik;
    //     $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
    //     $ter = $territory->id_territory;
    //     $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
    //     $div = $division->id_division;
    //     $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
    //     $pos = $position->id_position;

    //     if($div == 'PMO'){
    //         $win = DB::table('sales_lead_register')
    //             ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
    //             ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
    //             ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.brand_name',
    //             'sales_lead_register.created_at', 'sales_lead_register.amount', 'sales_lead_register.result', 'users.name')
    //             ->where('result', 'win')
    //             ->get();
    //     }
    //     $pdf = PDF::loadView('report.win_pdf', compact('win'));
    //     return $pdf->download('exportpdfPMO-'.date("d-m-Y").'.pdf');
    // }

}
