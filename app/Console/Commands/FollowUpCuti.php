<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Mail;
use App\Mail\CutiKaryawan;
use App\User;

class FollowUpCuti extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FollowUpCuti:followupcuti';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Follow up Cuti';

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
                    ->join('tb_detail_cuti_msp','tb_detail_cuti_msp.id_cuti','=','tb_cuti_msp.id_cuti')
                    ->select(DB::raw('MAX(date_off) as date_off'),'users.nik','tb_cuti_msp.id_cuti','users.id_territory','users.id_division')
                    ->where('tb_cuti_msp.status', 'n')
                    ->groupby('tb_cuti_msp.id_cuti')
                    ->having(DB::raw("DATEDIFF(now(), date_off)"), '=', '-3')
                    ->orhaving(DB::raw("DATEDIFF(now(), date_off)"), '=', '-1')
                    ->get();

        print_r($max_date);


        foreach ($max_date as $data) {
            $nik = $data->nik;
            $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
            $ter = $territory->id_territory;
            $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
            $div = $division->id_division;
            $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
            $pos = $position->id_position; 
            $company = DB::table('users')->select('id_company')->where('nik',$nik)->first();
            $com = $company->id_company;

            if ($ter != NULL) { 
                if ($ter == 'SALES MSP' && $pos == 'STAFF') {
                    $nik_kirim = DB::table('users')->select('users.email')->where('id_position','MANAGER')->where('id_company','2')->first();
                }else if ($div == 'OPERATION'){
                    $nik_kirim = DB::table('users')->select('users.email')->where('email','ferry@solusindoperkasa.co.id')->where('id_company','2')->first();
                }
                
                
                // $kirim = User::where('email', $nik_kirim->email)->first()->email;

                $kirim = User::where('email', 'faiqoh@sinergy.co.id')->first();

                // $kirim = DB::table('users')->where('email', $nik_kirim->email)->first()->email;

                $name_cuti = DB::table('tb_cuti_msp')
                    ->join('users','users.nik','=','tb_cuti_msp.nik')
                    ->select('users.name')
                    ->where('id_cuti', $data->id_cuti)->first();

                $hari = DB::table('tb_cuti_msp')
                    ->join('tb_detail_cuti_msp','tb_detail_cuti_msp.id_cuti','=','tb_cuti_msp.id_cuti')
                    ->select(db::raw('count(tb_detail_cuti_msp.id_cuti) as days'),'tb_cuti_msp.date_req','tb_cuti_msp.reason_leave','tb_cuti_msp.status',DB::raw('group_concat(date_off) as dates'))
                    ->groupby('tb_detail_cuti_msp.id_cuti')
                    ->where('tb_cuti_msp.id_cuti', $data->id_cuti)
                    ->first();

                $ardetil = explode(',',$hari->dates);

                $ardetil_after = "";

                Mail::to($kirim)->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[SIMS-App] Permohonan Cuti (Follow Up)'));          
            
            }else{
                if ($div == 'TECHNICAL' || $div == 'TECHNICAL PRESALES') {
                    $nik_kirim = DB::table('users')->select('users.email')->where('email','sinung@solusindoperkasa.co.id')->where('id_company','2')->first();
                }else{
                     $nik_kirim = DB::table('users')->select('users.email')->where('email','ferry@solusindoperkasa.co.id')->where('id_company','2')->first();
                }
                
                $kirim = User::where('email', 'faiqoh@sinergy.co.id')->first();


                // $kirim = DB::table('users')->where('email', $nik_kirim->email)->first()->email;

                $name_cuti = DB::table('tb_cuti_msp')
                    ->join('users','users.nik','=','tb_cuti_msp.nik')
                    ->select('users.name')
                    ->where('id_cuti', $data->id_cuti)->first();

                $hari = DB::table('tb_cuti_msp')
                    ->join('tb_detail_cuti_msp','tb_detail_cuti_msp.id_cuti','=','tb_cuti_msp.id_cuti')
                    ->select(db::raw('count(tb_detail_cuti_msp.id_cuti) as days'),'tb_cuti_msp.date_req','tb_cuti_msp.reason_leave','tb_cuti_msp.status',DB::raw('group_concat(date_off) as dates'))
                    ->groupby('tb_detail_cuti_msp.id_cuti')
                    ->where('tb_cuti_msp.id_cuti', $data->id_cuti)
                    ->first();

                $ardetil = explode(',',$hari->dates);

                $ardetil_after = "";

                Mail::to($kirim)->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[SIMS-App] Permohonan Cuti (Follow Up)'));
            }


        } 
    }
}
