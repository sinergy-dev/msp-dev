<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sales;
use DB;
use Auth;
use Charts;

class DASHBOARDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->year = date('Y');
    }

    public function index()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;
        $company = DB::table('users')->select('id_company')->where('nik', $nik)->first();
        $com = $company->id_company;

        
        // TOP 5

        $top_win_msp = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->join('tb_company', 'tb_company.id_company', '=', 'users.id_company')
                        ->select(DB::raw('COUNT(sales_lead_register.lead_id) as leads'), DB::raw('SUM(sales_lead_register.amount) as amounts'), DB::raw('SUM(sales_lead_register.deal_price) as deal_prices'), 'users.name', 'tb_company.code_company')
                        ->where('result', 'WIN')
                        ->where('year', $this->year)
                        ->where('users.id_company', '2')
                        ->groupBy('sales_lead_register.nik')
                        ->orderBy('deal_prices', 'desc')
                        ->take(5)
                        ->get();

        // count id project
        if($div == 'FINANCE' && $pos == 'MANAGER'){
            $idp = DB::table('tb_id_project')
                ->get();
            $idps = count($idp);
        }

        //count lead
        if($div == 'SALES' ) {
            if($pos == 'MANAGER') {
                $count = DB::table('sales_lead_register')
                            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                            ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                            ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                            'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                            ->where('id_company', '2')
                            ->where('year',$this->year)
                            ->where('result','!=','hmm')
                            ->get();
                $counts = count($count);
            } else {
                $count = DB::table('sales_lead_register')
                            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                            ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                            ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                            'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                            ->where('id_company', '2')
                            ->where('year',$this->year)
                            ->where('result','!=','hmm')
                            ->where('sales_lead_register.nik', $nik)
                            ->get();
                $counts = count($count);
            }
        } elseif($div == 'TECHNICAL PRESALES') {
            if($pos == 'MANAGER') {
                $count = DB::table('sales_lead_register')
                            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                            ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                            ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                            'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                            ->where('id_company', '2')
                            ->where('year',$this->year)
                            ->where('result','!=','hmm')
                            ->get();
                $counts = count($count);
            } else {
                $count = DB::table('sales_lead_register')
                            ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                            ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                            ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                            'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                            ->where('id_company', '2')
                            ->where('year',$this->year)
                            ->where('result','!=','hmm')
                            ->where('sales_solution_design.nik', $nik)
                            ->get();
                $counts = count($count);
            }
        } elseif($pos == 'ADMIN') {
            $counts = DB::table('inventory_produk_msp')
                    ->count();

            $pur = DB::table('inventory_delivery_msp')
                ->get();
            $purs = count($pur);

            $puo = DB::table('tb_po_msp')
                ->get();
            $puos = count($puo);

            $quotes = DB::table('tb_pr_msp')
                        ->get();
            $quotes = count($quotes);

            $inventory_in = DB::table('inventory_changelog_msp')
                            ->join('inventory_produk_msp','inventory_produk_msp.id_product','=','inventory_changelog_msp.id_product')
                            ->select('kode_barang','nama','inventory_changelog_msp.qty','inventory_changelog_msp.created_at')
                            ->where('inventory_changelog_msp.status','P')
                            ->whereDate('inventory_changelog_msp.created_at', date('Y-m-d'))
                            ->orderBy('created_at','desc')
                            ->get();

        } else {
            $count = DB::table('sales_lead_register')
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                        ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                        'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                        ->where('id_company','2')
                        ->where('year',$this->year)
                        ->where('result','!=','hmm')
                        ->get();
            $counts = count($count);

            //count WO
            if ($div == 'WAREHOUSE') {
                // $countss = DB::table('tb_po_msp')
                //         ->count('no');

                $countss = DB::table('tb_po_asset_msp')
                                ->count('id_po_asset');

                // $openss = DB::table('tb_do_msp')
                //         ->count('no');

                $openss = DB::table('inventory_delivery_msp')
                        ->count('id_transaction');

                $ba = DB::table('inventory_changelog_msp')
                        ->where('status', 'D')
                        ->orWhere('status', 'P')
                        ->count('status');

                $co = DB::table('inventory_asset_msp')
                        ->count('id');
            }
        }
        
        // count status open
        if($div == 'SALES') {
            if($pos == 'MANAGER') {
                $open = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', '')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->get();
                $opens = count($open);
            } else {
                $open = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', '')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->where('sales_lead_register.nik', $nik)
                    ->get();
                $opens = count($open);
            }
        } elseif($div == 'TECHNICAL PRESALES') {
            if($pos == 'MANAGER') {
                $open = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', '')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->get();
                $opens = count($open);
            } else {
                $open = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', '')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->where('sales_solution_design.nik', $nik)
                    ->get();
                $opens = count($open);
            }
        } else {
            $open = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result', '')
                ->where('year',$this->year)
                ->where('id_company','2')
                ->where('result','!=','hmm')
                ->get();
            $opens = count($open);
        }

        // count status sd
        if($div == 'SALES') {
            if($pos == 'MANAGER') {
                $sd = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', 'SD')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->get();
                $sds = count($sd);
            } else {
                $sd = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', 'SD')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->where('sales_lead_register.nik', $nik)
                    ->get();
                $sds = count($sd);
            }
        } elseif($div == 'TECHNICAL PRESALES') {
            if($pos == 'MANAGER') {
                $sd = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', 'SD')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->get();
                $sds = count($sd);
            } else {
                $sd = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', 'SD')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->where('sales_solution_design.nik', $nik)
                    ->get();
                $sds = count($sd);
            }
        } else {
            $sd = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result', 'SD')
                ->where('year',$this->year)
                ->where('id_company','2')
                ->where('result','!=','hmm')
                ->get();
            $sds = count($sd);
        }

        // count status tp
        if($div == 'SALES') {
            if($pos == 'MANAGER') {
                $tp = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', 'TP')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->get();
                $tps = count($tp);
            } else {
                $tp = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', 'TP')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->where('sales_lead_register.nik', $nik)
                    ->get();
                $tps = count($tp);
            }
        } elseif($div == 'TECHNICAL PRESALES') {
            if($pos == 'MANAGER') {
                $tp = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', 'TP')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->get();
                $tps = count($tp);
            } else {
                $tp = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', 'TP')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->where('sales_solution_design.nik', $nik)
                    ->get();
                $tps = count($tp);
            }
        } else {
            $tp = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result', 'TP')
                ->where('year',$this->year)
                ->where('id_company','2')
                ->where('result','!=','hmm')
                ->get();
            $tps = count($tp);
        }   

        // count status win
        if($div == 'SALES') {
            if($pos == 'MANAGER') {
                $win = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', 'WIN')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->get();
                $wins = count($win);
            } else {
                $win = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', 'WIN')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->where('sales_lead_register.nik', $nik)
                    ->get();
                $wins = count($win);
            }
        } elseif($div == 'TECHNICAL PRESALES') {
            if($pos == 'MANAGER') {
                $win = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', 'WIN')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->get();
                $wins = count($win);
            } else {
                $win = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', 'WIN')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->where('sales_solution_design.nik', $nik)
                    ->get();
                $wins = count($win);
            }
        } else {
            $win = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','WIN')
                ->where('year',$this->year)
                ->where('id_company','2')
                ->where('result','!=','hmm')
                ->get();
            $wins = count($win);
        }

        // count status lose
        if($div == 'SALES') {
            if($pos == 'MANAGER') {
                $lose = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', 'LOSE')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->get();
                $loses = count($lose);
            } else {
                $lose = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', 'LOSE')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->where('sales_lead_register.nik', $nik)
                    ->get();
                $loses = count($lose);
            }
        } elseif($div == 'TECHNICAL PRESALES') {
            if($pos == 'MANAGER') {
                $lose = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', 'LOSE')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->get();
                $loses = count($lose);
            } else {
                $lose = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                    ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('result', 'LOSE')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->where('result','!=','hmm')
                    ->where('sales_solution_design.nik', $nik)
                    ->get();
                $loses = count($lose);
            }
        } else {
            $lose = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','LOSE')
                ->where('year',$this->year)
                ->where('id_company','2')
                ->where('result','!=','hmm')
                ->get();
            $loses = count($lose);
        }

        if ($div == 'SALES' && $pos != 'ADMIN') {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER' ) {
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

       

        return view('dashboard/dashboard', compact('cnotif', 'purs', 'puos', 'quotes', 'pos','div','results','idps', 'counts','opens', 'sds', 'tps', 'notiftp', 'notifsd', 'notifOpen', 'wins', 'loses', 'notif', 'notifClaim','countmsp','losemsp','win1','win2','lose1','lose2','countss','openss','ba','co', 'top_win_msp','inventory_in'));

    }

    public function indexqoe()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;
        $company = DB::table('users')->select('id_company')->where('nik', $nik)->first();
        $com = $company->id_company;

        // count id project
        if($div == 'FINANCE' && $pos == 'MANAGER'){
            $idp = DB::table('tb_id_project')
                ->get();
            $idps = count($idp);
        }

        //count lead
        if($div == 'SALES' && $pos != 'ADMIN' || $pos == 'STAFF' && $com == '2'){
            $count = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('id_company', '1')
                ->where('year',$this->year)
                ->get();
            $counts = count($count);

            $count = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('id_company', '2')
                ->where('year',$this->year)
                ->get();
            $countmsp = count($count);
        } elseif($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $count = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('sales_solution_design.nik', $nik)
                ->where('id_company', '1')
                ->where('year',$this->year)
                ->get();
            $counts = count($count);
        } elseif ($pos == 'ADMIN') {
            $count = DB::table('dvg_esm')
                    ->join('users', 'users.nik', '=', 'dvg_esm.personnel')
                    ->select('no','date','users.name', 'type', 'description', 'amount', 'id_project', 'remarks', 'status')
                    ->where('status', 'ADMIN')
                    ->where('nik_admin', $nik)
                    ->where('id_company', '1')
                    ->get();
            $counts = count($count);

        } elseif ($div == 'FINANCE') {
            $count = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','win')
                ->where('id_company', '1')
                ->where('year',$this->year)
                ->get();
            $counts = count($count);
        }elseif($pos == 'ENGINEER MANAGER') {
            $count = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name','sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.nik','sales_lead_register.status_engineer')
                ->where('sales_lead_register.result','WIN')
                ->where('sales_lead_register.status_sho','PMO')
                ->where('id_company', '1')
                ->where('year',$this->year)
                ->get();
            $counts = count($count);
        }elseif($pos == 'ENGINEER STAFF') {
            $count = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('tb_engineer','sales_lead_register.lead_id','=','tb_engineer.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name','sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.nik','sales_lead_register.status_engineer')
                ->where('sales_lead_register.result','WIN')
                ->where('tb_engineer.nik',$nik)
                ->where('id_company', '1')
                ->where('year',$this->year)
                ->get();
            $counts = count($count);
        }elseif ($div == 'PMO' && $pos == 'STAFF') {
            $count = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('tb_pmo', 'tb_pmo.lead_id', '=', 'sales_lead_register.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('tb_pmo.pmo_nik', $nik)
                ->where('id_company', '1')
                ->where('year',$this->year)
                ->get();
            $counts = count($count);
        } elseif ($div == 'PMO' && $pos == 'MANAGER') {
            $count = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.brand_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'sales_lead_register.result', 'users.name')
                ->where('sales_lead_register.status_sho','')
                ->where('id_company', '1')
                ->where('year',$this->year)
                ->get();
            $counts = count($count);
        }elseif ($com == '2' ) {
            $count = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.brand_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'sales_lead_register.result', 'users.name')
                ->where('sales_lead_register.status_sho','')
                ->where('id_company', '2')
                ->where('year',$this->year)
                ->get();
            $counts = count($count);

            $countss = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('id_company','2')
                ->where('year',$this->year)
                ->get();
            $countmsp = count($countss);
        }else {
            $count = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('year',$this->year)
                ->get();
            $counts = count($count);
        }
        
        // count status open
        if($div == 'SALES' && $pos != 'ADMIN'){
            $open = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result', '')
                ->get();
            $opens = count($open);
        } elseif($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $open = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result', '')
                ->where('sales_solution_design.nik', $nik)
                ->where('year',$this->year)
                ->get();
            $opens = count($open);
        } elseif ($div == 'FINANCE' && $pos == 'MANAGER') {
            $open = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('tb_id_project', 'tb_id_project.lead_id', '=', 'sales_lead_register.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('sales_lead_register.status_sho','')
                ->where('year',$this->year)
                ->get();
            $opens = count($open);
        } elseif ($div == 'TECHNICAL' && $ter == 'DPG') {
            $open = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result3','DONE')
                ->where('year',$this->year)
                ->get();
            $opens = count($open);
        }elseif ($pos == 'ADMIN') {
            $open = DB::table('tb_pr')
                ->select('no')
                ->get();
            $opens = count($open);
        } else {
            $open = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','')
                ->where('year',$this->year)
                ->get();
            $opens = count($open);
        }

        // count status sd
        if($div == 'SALES' && $pos != 'ADMIN'){
            $sd = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result', 'SD')
                ->where('year',$this->year)
                ->get();
            $sds = count($sd);
        } elseif($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $sd = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result', 'SD')
                ->where('sales_solution_design.nik', $nik)
                ->where('year',$this->year)
                ->get();
            $sds = count($sd);
        } elseif ($div == 'FINANCE') {
            $sd = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->join('tb_id_project', 'tb_id_project.lead_id', '=', 'sales_lead_register.lead_id')
                    ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'sales_lead_register.opp_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('sales_lead_register.lead_id','tb_id_project.lead_id')
                    ->where('year',$this->year)
                    ->get();
            $sds = count($sd);
        } elseif ($div == 'TECHNICAL' && $ter == 'DPG') {
            $sd = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result3','DONE')
                ->where('year',$this->year)
                ->get();
            $sds = count($sd);
        }elseif ($pos == 'ADMIN') {
            $sd = DB::table('tb_po')
                ->select('no')
                ->get();
            $sds = count($sd);
        } else {
            $sd = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','SD')
                ->where('year',$this->year)
                ->get();
            $sds = count($sd);
        }

        // count status tp
        if($div == 'SALES' && $pos != 'ADMIN'){
            $tp = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result', 'TP')
                ->where('year',$this->year)
                ->get();
            $tps = count($tp);
        } elseif($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $tp = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result', 'TP')
                ->where('sales_solution_design.nik', $nik)
                ->where('year',$this->year)
                ->get();
            $tps = count($tp);
        }elseif ($div == 'FINANCE') {
            $tp = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                    ->join('tb_id_project', 'tb_id_project.lead_id', '=', 'sales_lead_register.lead_id')
                    ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'sales_lead_register.opp_name',
                    'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                    ->where('sales_lead_register.lead_id','tb_id_project.lead_id')
                    ->where('year',$this->year)
                    ->get();
            $tps = count($tp);
        } elseif ($div == 'TECHNICAL' && $ter == 'DPG') {
            $tp = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result3','DONE')
                ->where('year',$this->year)
                ->get();
            $tps = count($tp);
        } else {
            $tp = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','TP')
                ->where('year',$this->year)
                ->get();
            $tps = count($tp);
        }   

        // count status win
        if($div == 'SALES' && $pos != 'ADMIN'){
            $win = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result', 'WIN')
                ->where('id_company','2')
                ->where('sales_lead_register.nik',$nik)
                ->where('year',$this->year)
                ->get();
            $wins = count($win);

            $winss = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','WIN')
                ->where('id_company','2')
                ->where('year',$this->year)
                ->get();
            $win2 = count($winss);
        } elseif($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $win = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result', 'WIN')
                ->where('id_company','2')
                ->where('sales_solution_design.nik', $nik)
                ->where('year',$this->year)
                ->get();
            $wins = count($win);

            $winss = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','WIN')
                ->where('id_company','2')
                ->where('year',$this->year)
                ->get();
            $win2 = count($winss);
        } elseif ($div == 'FINANCE') {
            $win = DB::table('dvg_esm')
                    ->join('users', 'users.nik', '=', 'dvg_esm.personnel')
                    ->select('no','date','users.name', 'type', 'description', 'amount', 'id_project', 'remarks', 'status')
                    ->where('status', 'FINANCE')
                    ->get();
            $wins = count($win);

            $winss = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','WIN')
                ->where('year',$this->year)
                ->get();
            $win2 = count($winss);
        }elseif ($div == 'HR') {
            $win = DB::table('dvg_esm')
                    ->join('users', 'users.nik', '=', 'dvg_esm.personnel')
                    ->select('no','date','users.name', 'type', 'description', 'amount', 'id_project', 'remarks', 'status')
                    ->where('status', 'HRD')
                    ->get();
            $wins = count($win);

            $winss = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','WIN')
                ->where('year',$this->year)
                ->get();
            $win2 = count($winss);
        } else {
            $win = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','WIN')
                ->where('year',$this->year)
                ->get();
            $wins = count($win);

            $winss = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','WIN')
                ->where('year',$this->year)
                ->get();
            $win2 = count($winss);
        }

        // count status lose
        if ($div == 'SALES' && $pos != 'ADMIN' || $pos == 'DIRECTOR' && $com == '2' || $pos == 'STAFF' && $com == '2') {
            $lose = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result', 'LOSE')
                ->where('year',$this->year)
                ->get();
            $loses = count($lose);

            $lose = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result', 'LOSE')
                ->where('id_company','2')
                ->where('year',$this->year)
                ->get();
            $losemsp = count($lose);

             $losess = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','LOSE')
                ->where('year',$this->year)
                ->where('year',$this->year)
                ->get();
            $lose2 = count($losess);
        } elseif($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $lose = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result', 'LOSE')
                ->where('sales_solution_design.nik', $nik)
                ->where('year',$this->year)
                ->get();
            $loses = count($lose);

            $losess = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','LOSE')
                ->where('year',$this->year)
                ->where('year',$this->year)
                ->get();
            $lose2 = count($losess);
        } elseif ($div == 'FINANCE') {
            $lose = DB::table('dvg_esm')
                    ->join('users', 'users.nik', '=', 'dvg_esm.personnel')
                    ->select('no','date','users.name', 'type', 'description', 'amount', 'id_project', 'remarks', 'status')
                    ->where('status', 'TRANSFER')
                    ->get();
            $loses = count($lose);

            $losess = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','LOSE')
                ->where('year',$this->year)
                ->where('year',$this->year)
                ->get();
            $lose2 = count($losess);
        }elseif ($div == 'HR') {
            $lose = DB::table('dvg_esm')
                    ->join('users', 'users.nik', '=', 'dvg_esm.personnel')
                    ->select('no','date','users.name', 'type', 'description', 'amount', 'id_project', 'remarks', 'status')
                    ->where('status', 'TRANSFER')
                    ->get();
            $loses = count($lose);

            $losess = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','LOSE')
                ->where('year',$this->year)
                ->where('year',$this->year)
                ->get();
            $lose2 = count($losess);
        } elseif ($pos == 'ADMIN') {
            $lose = DB::table('tb_quote')
                        ->select('id_quote','quote_number','position','type_of_letter','date','to','attention','title','project')
                        ->get();
            $loses = count($lose);

            $losess = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','LOSE')
                ->where('year',$this->year)
                ->where('year',$this->year)
                ->get();
            $lose2 = count($losess);
        } else {
            $lose = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','LOSE')
                ->where('year',$this->year)
                ->get();
            $loses = count($lose);

            $losess = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result','LOSE')
                ->where('year',$this->year)
                ->where('year',$this->year)
                ->get();
            $lose2 = count($losess);

            $lose = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result')
                ->where('result', 'LOSE')
                ->where('id_company','2')
                ->where('year',$this->year)
                ->get();
            $losemsp = count($lose);
        }

        if ($div == 'SALES' && $pos != 'ADMIN') {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER' ) {
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

        return view('dashboard/dashboardqoe', compact('pos','div','results','idps', 'counts','opens', 'sds', 'tps', 'notiftp', 'notifsd', 'notifOpen', 'wins', 'loses', 'notif', 'notifClaim','countmsp','losemsp','win1','win2','lose1','lose2'));

    }

    public function getChart()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;
        $company = DB::table('users')->select('id_company')->where('nik', $nik)->first();
        $com = $company->id_company;


        if($div == 'SALES'){
            if ($pos == 'MANAGER') {
               $chart = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->orderBy('month_msp')
                    ->where('year', $this->year)
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190101')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190102')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190103')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190104')
                    ->get();
            }else{
                $chart = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->orderBy('month_msp')
                    ->where('year', $this->year)
                    ->where('sales_lead_register.nik',$nik)
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190101')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190102')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190103')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190104')
                    ->get();
            }
            
        }elseif($div == 'TECHNICAL PRESALES' && $pos == 'STAFF'){
            $chart = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                    ->orderBy('month_msp')
                    ->where('sales_solution_design.nik', $nik)
                    ->where('year',$this->year)
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190101')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190102')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190103')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190104')
                    ->get();

            $first = $chart[0];
            $hasil = [0,0,0,0,0,0,0,0,0,0,0,0];

            $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $bulan_angka = [1,2,3,4,5,6,7,8,9,10,11,12];

            foreach ($bulan_angka as $key => $value2) {
                foreach ($chart as $value) {
                    if ($value->month_msp == $value2) {
                        $hasil[$key]++;
                    }
                }
            }
            return $hasil;
        }else if($div == 'WAREHOUSE'){
            $chart = DB::table('inventory_changelog_msp')
                    ->select(DB::raw('MONTH(created_at) month'),'inventory_changelog_msp.status')
                    ->where('status','P')
                    ->get();

            $chart2 = DB::table('inventory_changelog_msp')
                    ->select(DB::raw('MONTH(created_at) month'),'inventory_changelog_msp.status')
                    ->where('status','D')
                    ->get();

            $chart3 = DB::table('inventory_produk_msp')
                    ->select(DB::raw('MONTH(created_at) month'))
                    ->where('tipe','return')
                    ->get();

            // $first = $chart[0];
            $hasil = [[0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0]];

            $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $bulan_angka = [1,2,3,4,5,6,7,8,9,10,11,12];

            // $data = array();
            foreach ($bulan_angka as $key => $value2) {
                foreach ($chart as $value) {
                    if ($value->month == $value2) {
                        $hasil[0][$key]++;
                    }
                }
            }

            foreach ($bulan_angka as $key => $value2) {
                foreach ($chart2 as $value) {
                    if ($value->month == $value2) {
                        $hasil[1][$key]++;
                    }
                }
            }

            foreach ($bulan_angka as $key => $value2) {
                foreach ($chart3 as $value) {
                    if ($value->month == $value2) {
                        $hasil[2][$key]++;
                    }
                }
            }

            // foreach ($chart2 as $key => $value) {
            //     $data[$key] = $value;
            // }

            return $hasil;

        }else{
            $chart = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->orderBy('month_msp')
                    ->where('year',$this->year)
                    ->where('users.id_company',2)
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190101')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190102')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190103')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190104')
                    ->get();

            $first = $chart[0];
            $hasil = [0,0,0,0,0,0,0,0,0,0,0,0];

            $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $bulan_angka = [1,2,3,4,5,6,7,8,9,10,11,12];

            foreach ($bulan_angka as $key => $value2) {
                foreach ($chart as $value) {
                    if ($value->month_msp == $value2) {
                        $hasil[$key]++;
                    }
                }
            }
            return $hasil;
        }
    }

    public function getChartInv()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users' )->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;
        $company = DB::table('users')->select('id_company')->where('nik', $nik)->first();
        $com = $company->id_company;


        if($div == 'SALES'){
            if ($pos == 'MANAGER') {
               $chart = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->orderBy('month_msp')
                    ->where('year', $this->year)
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190101')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190102')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190103')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190104')
                    ->get();
            }else{
                $chart = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->orderBy('month_msp')
                    ->where('year', $this->year)
                    ->where('sales_lead_register.nik',$nik)
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190101')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190102')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190103')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190104')
                    ->get();
            }
            
        }elseif($div == 'TECHNICAL PRESALES' && $pos == 'STAFF'){
            $chart = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                    ->orderBy('month_msp')
                    ->where('sales_solution_design.nik', $nik)
                    ->where('year',$this->year)
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190101')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190102')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190103')
                    ->where('sales_lead_register.lead_id','!=','MSPCOBA190104')
                    ->get();

            $first = $chart[0];
            $hasil = [0,0,0,0,0,0,0,0,0,0,0,0];

            $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $bulan_angka = [1,2,3,4,5,6,7,8,9,10,11,12];

            foreach ($bulan_angka as $key => $value2) {
                foreach ($chart as $value) {
                    if ($value->month_msp == $value2) {
                        $hasil[$key]++;
                    }
                }
            }
            return $hasil;
        }else if($div == 'WAREHOUSE'){
            $chart = DB::table('inventory_changelog_msp')
                    ->select(DB::raw('MONTH(created_at) month'),'inventory_changelog_msp.status')
                    ->where('status','P')
                    ->whereYear('created_at',$this->year)
                    ->get();

            $chart2 = DB::table('inventory_changelog_msp')
                    ->select(DB::raw('MONTH(created_at) month'),'inventory_changelog_msp.status')
                    ->where('status','D')
                    ->whereYear('created_at',$this->year)
                    ->get();

            $chart3 = DB::table('inventory_produk_msp')
                    ->select(DB::raw('MONTH(created_at) month'))
                    ->where('tipe','return')
                    ->whereYear('created_at',$this->year)
                    ->get();

            // $first = $chart[0];
            $hasil = [[0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0]];

            $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $bulan_angka = [1,2,3,4,5,6,7,8,9,10,11,12];

            // $data = array();
            foreach ($bulan_angka as $key => $value2) {
                foreach ($chart as $value) {
                    if ($value->month == $value2) {
                        $hasil[0][$key]++;
                    }
                }
            }

            foreach ($bulan_angka as $key => $value2) {
                foreach ($chart2 as $value) {
                    if ($value->month == $value2) {
                        $hasil[1][$key]++;
                    }
                }
            }

            foreach ($bulan_angka as $key => $value2) {
                foreach ($chart3 as $value) {
                    if ($value->month == $value2) {
                        $hasil[2][$key]++;
                    }
                }
            }

            // foreach ($chart2 as $key => $value) {
            //     $data[$key] = $value;
            // }

            return $hasil;

        }else{
            $year = date('Y'); 

            $chart = DB::table('inventory_changelog_msp')
                    ->select(DB::raw('MONTH(created_at) month'),'inventory_changelog_msp.status')
                    ->where('status','P')
                    ->whereYear('created_at',$this->year)
                    ->get();

            $chart2 = DB::table('inventory_changelog_msp')
                    ->select(DB::raw('MONTH(created_at) month'),'inventory_changelog_msp.status')
                    ->where('status','D')
                    ->whereYear('created_at',$this->year)
                    ->get();

            $chart3 = DB::table('inventory_produk_msp')
                    ->select(DB::raw('MONTH(created_at) month'))
                    ->where('tipe','return')
                    ->whereYear('created_at',$this->year)
                    ->get();

            // $first = $chart[0];
            $hasil = [[0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,0,0,0,0]];

            $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $bulan_angka = [1,2,3,4,5,6,7,8,9,10,11,12];

            // $data = array();
            foreach ($bulan_angka as $key => $value2) {
                foreach ($chart as $value) {
                    if ($value->month == $value2) {
                        $hasil[0][$key]++;
                    }
                }
            }

            foreach ($bulan_angka as $key => $value2) {
                foreach ($chart2 as $value) {
                    if ($value->month == $value2) {
                        $hasil[1][$key]++;
                    }
                }
            }

            foreach ($bulan_angka as $key => $value2) {
                foreach ($chart3 as $value) {
                    if ($value->month == $value2) {
                        $hasil[2][$key]++;
                    }
                }
            }

            // foreach ($chart2 as $key => $value) {
            //     $data[$key] = $value;
            // }

            return $hasil;
        }
        
    }

    public function getChartAdmin()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        if($pos == 'ADMIN'){
            $chart = DB::table('dvg_esm')
                    ->orderBy('month_msp')
                    ->where('year',$this->year)
                    ->get();
        }if($pos == 'HR MANAGER'){
            $chart = DB::table('dvg_esm')
                    ->orderBy('month_msp')
                    ->where('year',$this->year)
                    ->get();
        }if($div == 'FINANCE'){
            $chart = DB::table('dvg_esm')
                    ->orderBy('month_msp')
                    ->where('year',$this->year)
                    ->get();
        }

        $first = $chart[0]->month_msp;
        $hasil = [0,0,0,0,0,0,0,0,0,0,0,0];

        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $bulan_angka = [1,2,3,4,5,6,7,8,9,10,11,12];

        foreach ($bulan_angka as $key => $value2) {
            foreach ($chart as $value) {
                if ($value->month_msp == $value2) {
                    $hasil[$key]++;
                }
            }
        }
        return $hasil;
    }



    public function getPieChart()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $pie = 0;


        if($div == 'SALES'){
            if ($pos == 'MANAGER') {
                $status = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->orderBy('result')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->get();
            }else{
                $status = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->orderBy('result')
                    ->where('year',$this->year)
                    ->where('sales_lead_register.nik',$nik)
                    ->where('id_company','2')
                    ->get();
            }
            
        }elseif($div == 'TECHNICAL PRESALES' && $pos == 'STAFF'){
            $status = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                    ->orderBy('result')
                    ->where('sales_solution_design.nik', $nik)
                    ->where('year',$this->year)
                    ->get();
        }else{
            $status = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->orderBy('result')
                    ->where('users.id_company',2)
                    ->where('year',$this->year)
                    ->get();
        }

        $first = $status[0]->result;
        $hasil = [0,0,0];
        $bulan_angka = ['TP', 'WIN', 'LOSE'];

        foreach ($bulan_angka as $key => $value2) {
            foreach ($status as $value) {
                    if ($value->result == $value2) {
                        $hasil[$key]++;
                        $pie++;
                    }
                }
        }

        $hasil2 = [0,0,0];
        foreach ($hasil as $key => $value) {
            $hasil2[$key] = ($value/$pie)*100;
        }

        return $hasil2;
    }

    public function getPieChartAFH()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $pie = 0;

        $year = date('Y');

        if($pos == 'ADMIN' ){
            $status = DB::table('dvg_esm')
                    ->join('users', 'dvg_esm.nik_admin', '=', 'users.nik')
                    ->orderBy('status')
                    ->where('year',$year)
                    ->where('dvg_esm.nik_admin',$nik)
                    ->get();
        }else if ($div == 'FINANCE' || $pos == 'HR MANAGER') {
        	$status = DB::table('dvg_esm')
                    ->join('users', 'dvg_esm.nik_admin', '=', 'users.nik')
                    ->orderBy('status')
                    ->where('year',$year)
                    ->get();
        }

        $first = $status[0]->status;
        $hasil = [0,0,0,0];
        $bulan_angka = ['ADMIN', 'HRD', 'FINANCE', 'TRANSFER'];

        foreach ($bulan_angka as $key => $value2) {
            foreach ($status as $value) {
                    if ($value->status == $value2) {
                        $hasil[$key]++;
                        $pie++;
                    }
                }
        }

        $hasil2 = [0,0,0,0];
        foreach ($hasil as $key => $value) {
            $hasil2[$key] = ($value/$pie)*100;
        }

        return $hasil2;
    }

    public function getAreaChart()
    {   
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        if($div == 'SALES' ){
            if ($pos == 'MANAGER') {
                $chart = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->orderBy('amount')
                    ->where('year','2018')
                    ->get();
            }else{
                $chart = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->orderBy('amount')
                    ->where('year','2018')
                    ->where('sales_lead_register.nik',$nik)
                    ->get();
            }
            
        }elseif($div == 'TECHNICAL PRESALES' && $pos == 'STAFF'){
            $chart = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                    ->orderBy('amount')
                    ->where('sales_solution_design.nik', $nik)
                    ->where('year','2018')
                    ->get();
        }else{
            $chart = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->orderBy('amount')
                    ->where('year','2018')
                    ->where('users.id_company',2)
                    ->get();
        }

        $first = $chart[0]->month_msp;
        $hasil = [0,0,0,0,0,0,0,0,0,0,0,0];

        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $bulan_angka = [1,2,3,4,5,6,7,8,9,10,11,12];

        foreach ($bulan_angka as $key => $value2) {
           foreach ($chart as $value) {
               if ($value->month_msp == $value2) {
                    $hasil[$key] = $hasil[$key]+$value->amount;
                }
            }
        }
        return $hasil;
    }

    public function getAreaChart2019()
    {   
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        if($div == 'SALES'){
            if ($pos == 'MANAGER') {
                $chart = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->orderBy('amount')
                    ->where('year',$this->year)
                    ->get();
            }else{
                $chart = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->orderBy('amount')
                    ->where('year',$this->year)
                    ->where('sales_lead_register.nik',$nik)
                    ->get();
            }
            
        }elseif($div == 'TECHNICAL PRESALES' && $pos == 'STAFF'){
            $chart = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                    ->orderBy('amount')
                    ->where('sales_solution_design.nik', $nik)
                    ->where('year',$this->year)
                    ->get();
        }else{
            $chart = DB::table('sales_lead_register')
            		->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->orderBy('amount')
                    ->where('year',$this->year)
                    ->where('users.id_company',2)
                    ->get();
        }

        $first = $chart[0]->month_msp;
        $hasil = [0,0,0,0,0,0,0,0,0,0,0,0];

        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $bulan_angka = [1,2,3,4,5,6,7,8,9,10,11,12];

        foreach ($bulan_angka as $key => $value2) {
           foreach ($chart as $value) {
               if ($value->month_msp == $value2) {
                    $hasil[$key] = $hasil[$key]+$value->amount;
                }
            }
        }
        return $hasil;
    }

    public function getAreaChartAdmin()
    {   
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        if($pos == 'ADMIN'){
            $chart = DB::table('dvg_esm')
                    ->orderBy('amount')
                    ->where('year',$this->year)
                    ->where('nik_admin',$nik)
                    ->get();
        }elseif($pos == 'HR MANAGER'){
            $chart = DB::table('dvg_esm')
                    ->orderBy('amount')
                    ->where('year',$this->year)
                    ->get();
        }elseif($div == 'FINANCE'){
            $chart = DB::table('dvg_esm')
                    ->orderBy('amount')
                    ->where('year',$this->year)
                    ->get();
        }

        $first = $chart[0]->month;
        $hasil = [0,0,0,0,0,0,0,0,0,0,0,0];

        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $bulan_angka = [1,2,3,4,5,6,7,8,9,10,11,12];

        foreach ($bulan_angka as $key => $value2) {
           foreach ($chart as $value) {
               if ($value->month == $value2) {
                    $hasil[$key] = $hasil[$key]+$value->amount;
                }
            }
        }
        return $hasil;
    }

    public function getAreaChartAdmin2018()
    {   
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $date = date('Y');

        if($pos == 'ADMIN'){
            $chart = DB::table('dvg_esm')
                    ->orderBy('amount')
                    ->where('year','2018')
                    ->get();
        }elseif($pos == 'HR MANAGER'){
            $chart = DB::table('dvg_esm')
                    ->orderBy('amount')
                    ->where('year','2018')
                    ->get();
        }elseif($div == 'FINANCE'){
            $chart = DB::table('dvg_esm')
                    ->orderBy('amount')
                    ->where('year','2018')
                    ->get();
        }

        $first = $chart[0]->month;
        $hasil = [0,0,0,0,0,0,0,0,0,0,0,0];

        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $bulan_angka = [1,2,3,4,5,6,7,8,9,10,11,12];

        foreach ($bulan_angka as $key => $value2) {
           foreach ($chart as $value) {
               if ($value->month == $value2) {
                    $hasil[$key] = $hasil[$key]+$value->amount;
                }
            }
        }
        return $hasil;
    }

    public function getDoughnutChart()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $pie = 0;
        if($div == 'SALES'){
            if ($pos == 'MANAGER') {
              $status = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->orderBy('result')
                    ->where('year',$this->year)
                    ->where('id_company','2')
                    ->get();  
            }else{
               $status = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->orderBy('result')
                    ->where('year',$this->year)
                    ->where('sales_lead_register.nik',$nik)
                    ->where('id_company','2')
                    ->get(); 
            }
            
        }elseif($div == 'TECHNICAL PRESALES' && $pos == 'STAFF'){
            $status = DB::table('sales_lead_register')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                    ->orderBy('result')
                    ->where('sales_solution_design.nik', $nik)
                    ->where('year',$this->year)
                    ->get();
        }else{
            $status = DB::table('sales_lead_register')
                    ->orderBy('result')
                    ->join('users', 'sales_lead_register.nik', '=', 'users.nik')
                    ->where('year',$this->year)
                    ->where('users.id_company',2)
                    ->get();
        }

        $first = $status[0]->result;
        $hasil = [0,0];
        $bulan_angka = ['WIN', 'LOSE'];

        foreach ($bulan_angka as $key => $value2) {
            foreach ($status as $value) {
                    if ($value->result == $value2) {
                        $hasil[$key]++;
                        $pie++;
                    }
                }
        }

        $hasil2 = [0,0];
        foreach ($hasil as $key => $value) {
            $hasil2[$key] = ($value/$pie)*100;
        }

        return $hasil2;
    }

    public function getDoughnutChartAFH()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $pie = 0;

        $year = date('Y');

        if($div == 'FINANCE' || $pos == 'ADMIN' || $pos == 'HR MANAGER'){
            $data = DB::table('dvg_esm')
                    ->orderBy('status')
                    ->where('year',$year)
                    ->get();
        }

        $first = $data[0]->status;
        $hasil = [0,0];
        if($div == 'FINANCE'){
            $bulan_angka = ['FINANCE', 'TRANSFER'];
        }elseif($pos == 'ADMIN'){
            $bulan_angka = ['ADMIN', 'TRANSFER'];
        }elseif($pos == 'HR MANAGER'){
            $bulan_angka = ['HRD', 'TRANSFER'];
        }

        foreach ($bulan_angka as $key => $value2) {
            foreach ($data as $value) {
                    if ($value->status == $value2) {
                        $hasil[$key]++;
                        $pie++;
                    }
                }
        }

        $hasil2 = [0,0];
        foreach ($hasil as $key => $value) {
            $hasil2[$key] = ($value/$pie)*100;
        }

        return $hasil2;
    }

    public function maintenance()
    {
    	return view('maintenance');
    }

}
