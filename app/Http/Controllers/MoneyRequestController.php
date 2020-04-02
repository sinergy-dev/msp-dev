<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MoneyRequest;
use App\DetailMoneyRequest;
use App\UpdateCogs;
use DB;
use Auth;
use Excel;
use PDF;
use App\Model\Notification;

class MoneyRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datas = DB::table('money_req')
                ->join('users','users.nik', '=', 'money_req.nik')
                ->select('id_money_req', 'id_project', 'project_name', 'name', 'cogs', 'cogs_akhir', 'cogs_note', 'cogs_update')
                ->get();

        return view ('MoneyReq/money_req')->with('datas', $datas);
    }


    public function detail_money($id_money_req)
    {
        $datas = DB::table('money_req')
                ->join('users', 'users.nik', '=', 'money_req.nik')
                ->select('id_money_req','name', 'id_project', 'project_name', 'cogs','cogs_akhir', 'cogs_note', 'cogs_update')
                ->where('id_money_req',$id_money_req)
                ->first();

        $data = DB::table('detail_money_req')
                ->join('money_req', 'money_req.id_money_req', '=', 'detail_money_req.id_money_req')
                ->select('tipe', 'transfer', 'note', 'total_tf','date','cogs', 'cogs_akhir', 'nama')
                ->where('money_req.id_money_req',$id_money_req)
                ->get();

        return view ('MoneyReq/detail_money_req', compact('datas', 'data'));
    }

    public function update_cogs($id_money_req)
    {
        $datas = DB::table('money_req')
                ->join('users', 'users.nik', '=', 'money_req.nik')
                ->select('id_money_req', 'name', 'id_project', 'project_name', 'cogs', 'cogs_akhir', 'cogs_note', 'cogs_update')
                ->where('id_money_req', $id_money_req)
                ->first();

        $data = DB::table('change_log_cogs')
                ->join('money_req', 'money_req.id_money_req', '=', 'change_log_cogs.id_money_req')
                ->select('cogs_edit', 'note_edit')
                ->where('money_req.id_money_req', $id_money_req)
                ->get();

        return view ('MoneyReq/money_req', compact('datas', 'data'));
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
        /*$this->validate($request, [
            'id_project' => 'required',
            'project_name' => 'required',
            'cogs' => 'required'
        ]);*/

        $tambah = new MoneyRequest();
        $tambah->id_project = $request['id_project'];
        $tambah->project_name = $request['project_name'];
        $tambah->cogs = str_replace(',', '', $request['cogs']);
        $tambah->cogs_akhir = $request['cogs_akhir'];
        $tambah->cogs_note = $request['cogs_note'];
        $tambah->nik = Auth::User()->nik;
        $tambah->save();

        $tambah_detail = new DetailMoneyRequest();
        $tambah_detail->id_money_req = $tambah->id_money_req;
        $tambah_detail->save();

        $noti = new Notification;
        $token = 'foH8Uf12fKo:APA91bEnPBBXn0sJbZ_aH6mF9n3R2pSiIUkIqQWqMMv2svH2g-Ldr8fsp2jYeLHvh59SINlnaDn3Udv5DD9KBKlYBhRs3SNUHG-meq_Pq5bAH7HJWLViflXW-t1pjouzp5_XvU2Ze7cR';
        $noti->toSingleDevice($token,'title','body',null,null);

     return redirect()->to('/money_req');
    }

    public function changelog_money_req(Request $request)
    {
        $id_detail = $request['id_money_req'];

        $id_money_req = MoneyRequest::select('cogs','cogs_akhir')->where('id_money_req', $id_detail)->first();

        $total_cogs = $id_money_req->cogs;
        $total_cogs2 = (int)$total_cogs;
        
        $date = $request->date;
        $tipe = $request->tipe;
        $transfer = $request->transfer;
        $note = $request->note;
        $total_tf = $request->total_transfer;
        $total_tf2 = str_replace(',', '', $total_tf);
        $total_tf3 = (int)$total_tf2;
        $nama = $request->nama;

        if(count($nama) > count($total_tf))
            $count = count($nama) + count($total_tf);
        else $count = count($total_tf);

        for($i = 0; $i < $count; $i++){
            $data = array(
                'id_money_req' => $id_detail,
                'date' => $date,
                'tipe' => $tipe,
                'transfer' => $transfer[$i],
                'note' => $note,
                'total_tf' => str_replace(',', '', $total_tf[$i]),
                'nama' => $nama[$i],
                /*'nominal'         => str_replace(',', '', $nominal[$i]),
                'total_nominal' => $qty[$i] * str_replace(',', '', $nominal[$i]),
                'description'   => $ket[$i],*/
            );

            $insertData[] = $data;
        }

        DetailMoneyRequest::insert($insertData);

        $getlastcogs = DetailMoneyRequest::select('total_tf')->orderBy('created_at','desc')->first();

        if($id_money_req->cogs_akhir == null){
            $update = MoneyRequest::where('id_money_req', $id_detail)->first();
            $update->cogs_akhir = $total_cogs - $getlastcogs->total_tf;
            $update->update();
        }elseif ($id_money_req->cogs_akhir != null) {
            $update = MoneyRequest::where('id_money_req', $id_detail)->first();
            $update->cogs_akhir = $id_money_req->cogs_akhir - $getlastcogs->total_tf;
            $update->update();
        }


        $cogsplus = DetailMoneyRequest::select('total_tf')->orderBy('created_at', 'desc')->first();

        if ($id_detail->total_tf == count($total_tf)) {
            $update = DetailMoneyRequest::where('id_detail', $id_detail)->first();
            $update->total_tf = $total_tf + $cogsplus->total_tf;
            $update->update();
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_money_req)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_money_req)
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
    public function update(Request $request)
    {
        $id_money_req = $request['edit_id_money'];

        
        $update = MoneyRequest::where('id_money_req', $id_money_req)->first();
        $update->id_project = $request['edit_id_project'];
        $update->project_name = $request['edit_project_name'];
        $update->cogs = $request['edit_cogs'];
        $update->cogs_note = $request['edit_cogs_note'];
        $update->update();

        $tambah = new UpdateCogs();
        $tambah->cogs_edit = $request['cogs_edit'];
        $tambah->note_edit = $request['note_edit'];
        $tambah->save();

        // if ($id_money_req->cogs = update($cogs))
        // {
        //     $id_money_req->cogs_akhir = reset($cogs_akhir);
        // } else {
        //     $id_money_req->cogs_akhir;
        // }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_money_req)
    {
        $hapus = MoneyRequest::find($id_money_req);
        $hapus->delete();

        return redirect()->back()->with('alert', 'Deleted!');
    }

    public function export_excel(Request $request)
    {
        $nama = 'Money Request'.date('Y-m-d');
        Excel::create($nama, function ($excel) use ($request) {
        $excel->sheet('Money Request', function ($sheet) use ($request) {
        
        $sheet->mergeCells('A1:J1');

       // $sheet->setAllBorders('thin');
        $sheet->row(1, function ($row) {
            $row->setFontFamily('Calibri');
            $row->setFontSize(11);
            $row->setAlignment('center');
            $row->setFontWeight('bold');
        });

        $sheet->row(1, array('Money Request'));

        $sheet->row(2, function ($row) {
            $row->setFontFamily('Calibri');
            $row->setFontSize(11);
            $row->setFontWeight('bold');
        });


        $datas = DetailMoneyRequest::select('id_detail','id_money_req','date','tipe','transfer','note','total_tf','nama')
                    ->get();

        // $produks = pamProduk::select('id_pam','name_product','qty')
        //         ->get()

            // $sheet->appendRow(array_keys($datas[0]));
            $sheet->row($sheet->getHighestRow(), function ($row) {
                $row->setFontWeight('bold');
            });

             $datasheet = array();
             $datasheet[0]  =   array("NO","ID Detail","ID Money Req","Date","Tipe","Transfer","Note","Total Transfer","Nama");
             $i=1;

                       // $sheet->appendrow($data);
                foreach ($datas as $data) {
                    if($data->no == $data->no)
                     $datasheet[$i] = array($i,

                        $data['id_detail'],
                        $data['id_money_req'],
                        $data['date'],
                        $data['tipe'],
                        $data['transfer'],
                        $data['note'],
                        $data['total_tf'],
                        $data['nama'],
                    );
                  $i++;
                }        

            $sheet->fromArray($datasheet);
        });

        })->export('xls');
    }

    public function export_pdf($id_money_req)
    {
        $datal = DB::table('money_req')
                ->join('users', 'users.nik', '=', 'money_req.nik')
                ->select('id_money_req','name', 'id_project', 'project_name', 'cogs','cogs_akhir')
                ->where('id_money_req',$id_money_req)
                ->first();

        $datas = DB::table('detail_money_req')
                        ->select('id_detail','id_money_req','date','tipe','transfer','note','total_tf','nama')
                        ->where('id_money_req',$id_money_req)
                        ->get();

        $datasatu = DB::table('detail_money_req')
                        ->select('id_detail','id_money_req','date','tipe','transfer','note','total_tf','nama')
                        ->first();

        // $pdf = PDF::loadView('MoneyReq.money_pdf', compact('datas'));
        return view('/MoneyReq/money_pdf', compact('datas','datasatu','datal'));
    }

    public function export_pdf2($id_money_req)
    {
        $datal = DB::table('money_req')
                ->join('users', 'users.nik', '=', 'money_req.nik')
                ->select('id_money_req','name', 'id_project', 'project_name', 'cogs','cogs_akhir')
                ->where('id_money_req',$id_money_req)
                ->first();

        $datas = DB::table('detail_money_req')
                        ->select('id_detail','id_money_req','date','tipe','transfer','note','total_tf','nama')
                        ->where('id_money_req',$id_money_req)
                        ->get();

        $datasatu = DB::table('detail_money_req')
                        ->select('id_detail','id_money_req','date','tipe','transfer','note','total_tf','nama')
                        ->first();

        // $pdf = PDF::loadView('MoneyReq.money_pdf', compact('datas'));
        return view('/MoneyReq/money_pdf2', compact('datas','datasatu','datal'));
    }

    public function export_pdf3($id_money_req)
    {
        $datal = DB::table('money_req')
                ->join('users', 'users.nik', '=', 'money_req.nik')
                ->select('id_money_req','name', 'id_project', 'project_name', 'cogs','cogs_akhir')
                ->where('id_money_req',$id_money_req)
                ->first();

        $datas = DB::table('detail_money_req')
                        ->select('id_detail','id_money_req','date','tipe','transfer','note','total_tf','nama')
                        ->where('id_money_req',$id_money_req)
                        ->get();

        $datasatu = DB::table('detail_money_req')
                        ->select('id_detail','id_money_req','date','tipe','transfer','note','total_tf','nama')
                        ->first();

        // $pdf = PDF::loadView('MoneyReq.money_pdf', compact('datas'));
        return view('/MoneyReq/money_pdf3', compact('datas','datasatu','datal'));
    }

    public function export1($id_money_req)
    {
       $datal = DB::table('money_req')
                ->join('users', 'users.nik', '=', 'money_req.nik')
                ->select('id_money_req','name', 'id_project', 'project_name', 'cogs','cogs_akhir')
                ->where('id_money_req',$id_money_req)
                ->first();

        $datas = DB::table('detail_money_req')
                        ->select('id_detail','id_money_req','date','tipe','transfer','note','total_tf','nama')
                        ->where('id_money_req',$id_money_req)
                        ->get();

        $datasatu = DB::table('detail_money_req')
                        ->select('id_detail','id_money_req','date','tipe','transfer','note','total_tf','nama')
                        ->first();

        // $pdf = PDF::loadView('MoneyReq.money_pdf', compact('datas'));
        return view('/MoneyReq/Pertanggungjawaban/export1', compact('datas','datasatu','datal'));
    }

    public function export2($id_money_req)
    {
        $datal = DB::table('money_req')
                ->join('users', 'users.nik', '=', 'money_req.nik')
                ->select('id_money_req','name','id_project','project_name','cogs','cogs_akhir')
                ->where('id_money_req', $id_money_req)
                ->first();

        $datas = DB::table('detail_money_req')
                ->select('id_detail', 'id_money_req', 'date', 'tipe', 'transfer', 'note', 'total_tf', 'nama')
                ->where('id_money_req', $id_money_req)
                ->get();

        $datasatu = DB::table('detail_money_req')
                ->select('id_detail', 'id_money_req', 'date', 'tipe', 'transfer', 'note', 'total_tf', 'nama')
                ->first();

        return view('/MoneyReq/Pertanggungjawaban/export2', compact('datas','datasatu','datal'));

    }

    public function export3($id_money_req)
    {
       $datal = DB::table('money_req')
                ->join('users', 'users.nik', '=', 'money_req.nik')
                ->select('id_money_req','name','id_project','project_name','cogs','cogs_akhir')
                ->where('id_money_req', $id_money_req)
                ->first();

        $datas = DB::table('detail_money_req')
                ->select('id_detail', 'id_money_req', 'date', 'tipe', 'transfer', 'note', 'total_tf', 'nama')
                ->where('id_money_req', $id_money_req)
                ->get();

        $datasatu = DB::table('detail_money_req')
                ->select('id_detail', 'id_money_req', 'date', 'tipe', 'transfer', 'note', 'total_tf', 'nama')
                ->first();

        return view('/MoneyReq/Pertanggungjawaban/export3', compact('datas', 'datasatu', 'datal'));
    }

    public function export_uangsaku1($id_money_req)
    {
        $datal = DB::table('money_req')
                ->join('users', 'users.nik', '=', 'money_req.nik')
                ->select('id_money_req','name','id_project','project_name','cogs','cogs_akhir')
                ->where('id_money_req', $id_money_req)
                ->first();

        $datas = DB::table('detail_money_req')
                ->select('id_detail', 'id_money_req', 'date', 'tipe', 'transfer', 'note', 'total_tf', 'nama')
                ->where('id_money_req', $id_money_req)
                ->get();

        $datasatu = DB::table('detail_money_req')
                ->select('id_detail', 'id_money_req', 'date', 'tipe', 'transfer', 'note', 'total_tf', 'nama')
                ->first();

        return view('/MoneyReq/UangSaku/export_uangsaku', compact('datas', 'datasatu', 'datal'));
    }

     public function export_uangsaku2($id_money_req)
    {
        $datal = DB::table('money_req')
                ->join('users', 'users.nik', '=', 'money_req.nik')
                ->select('id_money_req','name','id_project','project_name','cogs','cogs_akhir')
                ->where('id_money_req', $id_money_req)
                ->first();

        $datas = DB::table('detail_money_req')
                ->select('id_detail', 'id_money_req', 'date', 'tipe', 'transfer', 'note', 'total_tf', 'nama')
                ->where('id_money_req', $id_money_req)
                ->get();

        $datasatu = DB::table('detail_money_req')
                ->select('id_detail', 'id_money_req', 'date', 'tipe', 'transfer', 'note', 'total_tf', 'nama')
                ->first();

        return view('/MoneyReq/UangSaku/export_uangsaku2', compact('datas', 'datasatu', 'datal'));
    }

    public function export_uangsaku3($id_money_req)
    {
        $datal = DB::table('money_req')
                ->join('users', 'users.nik', '=', 'money_req.nik')
                ->select('id_money_req','name','id_project','project_name','cogs','cogs_akhir')
                ->where('id_money_req', $id_money_req)
                ->first();

        $datas = DB::table('detail_money_req')
                ->select('id_detail', 'id_money_req', 'date', 'tipe', 'transfer', 'note', 'total_tf', 'nama')
                ->where('id_money_req', $id_money_req)
                ->get();

        $datasatu = DB::table('detail_money_req')
                ->select('id_detail', 'id_money_req', 'date', 'tipe', 'transfer', 'note', 'total_tf', 'nama')
                ->first();

        return view('/MoneyReq/UangSaku/export_uangsaku3', compact('datas', 'datasatu', 'datal'));
    }

    /*public function detail($id_money_req)
    {
        $tampilmoney = MoneyRequest::find($id_money_req);
        return view ('/MoneyReq/detail_money_req')->with('tampilmoney', $tampilmoney);
    }*/
}