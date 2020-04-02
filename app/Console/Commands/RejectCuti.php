<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Mail\CutiKaryawan;
use App\CutiMSP;
use DB;

class RejectCuti extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'RejectCuti:rejectcuti';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otomatis reject cuti jika permohonan cuti belum di approved dan melewati hari cuti';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $max_date = DB::table('tb_cuti_msp')
                    ->join('users','users.nik','=','tb_cuti_msp.nik')
                    ->join("tb_detail_cuti_msp",'tb_detail_cuti_msp.id_cuti','=','tb_cuti_msp.id_cuti')
                    ->select(DB::raw('MAX(date_off) as date_off'),'users.nik','tb_cuti_msp.id_cuti','users.email','decline_reason')
                    ->where('tb_cuti_msp.status','n')
                    ->groupby('tb_cuti_msp.id_cuti')
                    ->having(DB::raw("DATEDIFF(date_off, now())"), '=', '0')
                    ->get();

        print_r($max_date);

        foreach ($max_date as $data) {
            $update = CutiMSP::where('id_cuti',$data->id_cuti)->first();
            $update->status = 'd';
            $update->decline_reason = 'Di Reject oleh sistem karena hari cuti telah kadaluwarsa';
            $update->update();

            $name_cuti = DB::table('tb_cuti_msp')
                    ->join('users','users.nik','=','tb_cuti_msp.nik')
                    ->select('users.name')
                    ->where('id_cuti', $data->id_cuti)->first();

            $hari = DB::table('tb_cuti_msp')
                ->join('tb_detail_cuti_msp','tb_detail_cuti_msp.id_cuti','=','tb_cuti_msp.id_cuti')
                ->select(db::raw('count(tb_detail_cuti_msp.id_cuti) as days'),'tb_cuti_msp.date_req','tb_cuti_msp.reason_leave','decline_reason','tb_cuti_msp.status',DB::raw('group_concat(date_off) as dates'),DB::raw("(CASE WHEN (status = 'd') THEN 'c' ELSE status END) as status"))
                ->groupby('tb_detail_cuti_msp.id_cuti')
                ->where('tb_cuti_msp.id_cuti', $data->id_cuti)
                ->first();

            $ardetil = explode(',',$hari->dates);

            $ardetil_after = "";

            Mail::to('faiqoh@sinergy.co.id')->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[SIMS-App] Permohonan Cuti (Rejected by Sistem)'));
        }
    }
}
