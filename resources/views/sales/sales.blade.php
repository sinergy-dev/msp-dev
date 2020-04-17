@extends('template.template_admin-lte')
@section('content')
<style type="text/css">
  .transparant{
    background-color: Transparent;
    background-repeat:no-repeat;
    border: none;
    cursor:pointer;
    overflow: hidden;
    outline:none;
    width: 25px;
  }
  .alert-box {
      color:#555;
      border-radius:10px;
      font-family:Tahoma,Geneva,Arial,sans-serif;font-size:14px;
      padding:10px 36px;
      margin:10px;
  }
  .alert-box span {
      font-weight:bold;
      text-transform:uppercase;
  }
  .error {
      background:#ffecec;
      border:1px solid #f5aca6;
  }
  .success {
      background:#e9ffd9 ;
      border:1px solid #a6ca8a;
  }
  .warning {
      background:#fff8c4 ;
      border:1px solid #f2c779;
  }
  .notice {
      background:#e3f7fc;
      border:1px solid #8ed9f6;
  }

  .row:before, .row:after{
    display: inline-block; !important;
  }

  .dropbtn {
    background-color: #4CAF50;
    color: white;
    font-size: 12px;
    border: none;
    width: 140px;
    height: 30px;
    border-radius: 5px;
  }
  .dropbtn-add {
    background-color: #2fa8d8;
    color: white;
    font-size: 12px;
    border: none;
    width: 140px;
    height: 30px;
    border-radius: 5px;
  }
  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 140px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
  }
  .dropdown-content .year:hover {background-color: #ddd;}
  .dropdown:hover .dropdown-content {display: block;}
  .dropdown:hover .dropbtn {background-color: #3e8e41;}
  .transparant-filter{
    background-color: Transparent;
    background-repeat:no-repeat;
    border: none;
    cursor:pointer;
    overflow: hidden;
    outline:none;
  }
  div div ol li a{font-size: 14px;}
  div div i{font-size: 14px;}
  background-color:dodgerBlue;}
  .inputWithIconn.inputIconBg i{
    background-color:#aaa;
    color:#fff;
    padding:7px 4px;
    border-radius:4px 0 0 4px;
  }
  .inputWithIconn{
    position:relative;
  }
  .inputWithIconn i{
    position:absolute;
    left:0;
    top:28px;
    padding:9px 8px;
    color:#aaa;
    transition:.3s;
  }

  .modalIcon i{
    top:25px;
  }

  .inputWithIconn input[type=text]{
    padding-left:40px;
  }
  label.status-lose:hover{
    border-radius: 10%;
    background-color: grey;
   ;
    width: 75px;
    height: 30px;
    color: white;
    padding-top: 3px;
    cursor: zoom-in;
  }
  table.center{
  ;
  }
  .stats_item_number {
    white-space: nowrap;
    font-size: 2.25rem;
    line-height: 2.5rem;
    
    &:before {
      display: none;
    }
  }

  .txt_success {
    color: #2EAB6F;
  }

  .txt_warn {
    color: #f2562b;
  }

  .txt_sd {
    color: #04dda3;
  }

  .txt_tp{
    color: #f7e127;
  }

  .txt_win{
    color: #246d18;
  }

  .txt_lose{
    color: #e5140d;
  }

  .txt_smaller {
    font-size: .75em;
  }

  .flipY {
    transform: scaleY(-1);
    border-bottom-color: #fff;
  }

  .txt_faded {
    opacity: .65;
  }

  .txt_primary{
    color: #007bff;
  }
</style>

<section class="content-header">
  <h1>
    Lead Register
  </h1>
  <ol class="breadcrumb">
    <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Lead Register</li>
  </ol>
</section>

<section class="content">

  @if(Auth::User()->id_division == "SALES" && Auth::User()->id_position != 'ADMIN' || Auth::User()->id_division == "TECHNICAL PRESALES" || Auth::User()->id_position == "DIRECTOR" || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER')
    <div class="row">
      <div class="col-lg-3 col-xs-6">

        <div class="small-box bg-purple">            
            <div class="inner">
              	<div class="txt_serif stats_item_number"><center><h3 class="counter" id="lead_all">{{$total_lead}}</h3></center></div>
            	<center><p>Lead Register</p></center>
            </div>
            <div class="icon">
            	<i class="fa fa-list"></i>
            </div>
            <div class="small-box-footer"></div>
        </div>

      </div>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->

        <div class="small-box bg-yellow">
            <div class="inner">
              	<div class="txt_serif stats_item_number"><center><h3 class="counter" id="lead_tp">{{$total_tp}}</h3></center></div>

            	<center><p>Tender Process</p></center>

            </div>
            <div class="icon">
            	<i class="fa fa-briefcase"></i>
            </div>
            <div class="small-box-footer"></div>
        </div>

      </div>
      <div class="col-lg-3 col-xs-6">

        <div class="small-box bg-green">
            <div class="inner">
              <div class="txt_serif stats_item_number"><center><h3 class="counter" id="lead_win">{{$total_win}}</h3></center></div>

              <center><p>Win</p></center>

            </div>
            <div class="icon">
            	<i class="fa fa-calendar-check-o"></i>
            </div>
            <div class="small-box-footer"></div>
        </div>

      </div>
      <div class="col-lg-3 col-xs-6">

        <div class="small-box bg-red">
            <div class="inner">
              	<div class="txt_serif stats_item_number"><center><h3 class="counter" id="lead_lose">{{$total_lose}}</h3></center></div>

            	<center><p>Lose</p></center>

            </div>
            <div class="icon">
            	<i class="fa fa-calendar-times-o"></i>
            </div>
            <div class="small-box-footer"></div>
        </div>

      </div>
    </div>
  @endif
    
  @if (Auth::User()->id_division != 'TECHNICAL PRESALES' && Auth::User()->id_position != 'STAFF' && session('success'))
    <div class="alert-box notice" id="alert"><span>notice: </span> {{ session('success') }}.</div>
  @elseif (Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_position == 'STAFF' && session('success'))
    <div class="alert-box warning notification-bar"><span>warning: </span> {{ session('success') }}.<button   type="button" class="dismisbar transparant pull-right"><i class="fa fa-times"></i></button></div>
  @endif

  <div class="box">
    
    <div class="box-header with-border">
      
           {{-- <h3 class="box-title"><i class="fa fa-table"></i>&nbspLead Register Table</h3> --}}
           @if(Auth::User()->id_division == 'SALES' && Auth::User()->id_position != 'ADMIN' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'MSM' && Auth::User()->id_position == 'MANAGER')
           
           <div class="dropdown btn btn-md pull-right">
             <button type="button" class="dropbtn-add" id="btn_add_sales" data-toggle="modal" data-target="#modal_lead"><i class="fa fa-plus"> </i>&nbsp Lead Register</button>
           </div>

           @elseif(Auth::User()->id_division == 'PMO')
           <div class="pull-right">
              <button type="button" class="btn btn-warning-eksport dropdown-toggle float-right  margin-left-customt" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <b><i class="fa fa-download"></i> Export</b>
              </button>
            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
              <a class="dropdown-item" href="{{action('ReportController@downloadPdfwin')}}"> PDF </a>
              <a class="dropdown-item" href="{{action('PMOController@exportExcel')}}"> EXCEL </a>
            </div>
            </div>
           @endif
           <div class="dropdown btn btn-md pull-right">
	          <select name="year_dif" id="year_dif" class="btn btn-md btn-success fa" style="font-size: 14px;background-color:#4CAF50;border-style: none;height: 30px;width: 145px">
	        	@foreach($year as $years)
              @if($years->year < $year_now)
  	        	  <option value="{{$years->year}}"> &#xf073 &nbsp&nbsp{{$years->year}}</option>
              @endif
	        	@endforeach
            <option selected value="{{$year_now}}"> &#xf073 &nbsp&nbsp{{$year_now}}</option>
      </select>
      </div>
    </div>

    <div class="box-body">
      <div id="div_now">
        <div class="table-responsive">
        <table class="table table-bordered table-striped no-wrap" id="datasnow" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Lead ID</th>
              <th>Customer</th>
              <th>Opty Name</th>
              <th>Create Date</th>
              <th>Closing Date</th>
              <th>Owner</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Action</th>
              @if($cek_note > 0)
              <th>Note</th>
              @else
              @endif
            </tr>
            <tr id="status">
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              @if($cek_note > 0)
              <th></th>
              @else
              @endif
              <th hidden></th>
            </tr>
          </thead>
          <tbody id="products-list" name="products-list">
            @foreach($leads as $data)
            <tr>
              <td>
                @if(Auth::User()->id_division == 'PMO')
                  @if($data->result != 'OPEN')
                    @if($data->status_sho == 'PMO')
                      <a href="{{ url ('/detail_project', $data->lead_id) }}">{{$data->id_project}}</a>
                    @else
                      {{$data->id_project}}
                    @endif
                  @endif
                @else
                  @if(Auth::User()->id_division == 'PMO')
                    @if(Auth::User()->id_division == 'PMO' && $data->status_sho != 'PMO')
                    {{ $data->lead_id }}
                    @elseif(Auth::User()->id_division == 'PMO' && $data->status_handover != 'handover')
                    {{ $data->lead_id }}
                    @elseif($data->result != 'OPEN')
                    <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                    @else
                    {{ $data->lead_id }}
                    @endif
                  @else
                    @if(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->status_sho != 'PMO')
                    {{ $data->lead_id }}
                    @elseif(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->status_handover != 'handover')
                    {{ $data->lead_id }}
                    @elseif(Auth::User()->id_position == 'ENGINEER STAFF' && $data->status_sho != 'PMO')
                    {{ $data->lead_id }}
                    @elseif(Auth::User()->id_position == 'ENGINEER STAFF' && $data->status_handover != 'handover')
                    {{ $data->lead_id }}
                    @elseif($data->result != 'OPEN')
                      <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                    @endif
                  @endif
                @endif
              </td>
              <td>{{ $data->brand_name}}</td>
              <td>{{ $data->opp_name}}</td>
              <td>{!!substr($data->created_at,0,10)!!}</td>
              <td>{{ $data->closing_date}}</td>
              <td>{{ $data->name }}</td>
              @if(Auth::User()->id_division == 'PMO' && Auth::User()->id_position == 'STAFF' )
                <td>{{$data->pmo_nik}}</td>
              @endif
              @if($data->result == 'TP' || $data->result == 'WIN' || $data->result == 'LOSE' || $data->result == 'CANCEL')
                @if($data->deal_price == NULL)
                  <td><i></i><i class="money">{{$data->amount}}</i></td>
                @else
                  <td><i></i><i class="money">{{$data->deal_price}}</i></td>
                @endif
              @else
                @if($data->amount == '')
                  <td><i></i><i class="money"></i></td>
                @elseif($data->amount != '')
                  <td><i></i><i class="money">{{$data->amount}}</i></td>
                @endif
              @endif
              <td>
                @if($data->result == 'OPEN')
                  <label class="status-initial">INITIAL</label>
                @elseif($data->result == '')
                  <label class="status-open">OPEN</label>
                @elseif($data->result == 'SD')
                  <label class="status-sd">SD</label>
                @elseif($data->result == 'TP')
                  <label class="status-tp">TP</label>
                @elseif($data->result == 'WIN')
                  <label class="status-win">WIN</label>
                @elseif($data->result == 'LOSE')
                  <label class="status-lose" data-toggle="modal" data-target="#modal-reason" onclick="lose('{{$data->keterangan}}')">LOSE</label>
                @elseif($data->result == 'CANCEL')
                  <label class="status-lose" style="background-color: #071108">CANCEL</label>
                @elseif($data->result == 'HOLD')
                  <label class="status-initial" style="background-color: #919e92">HOLD</label>
                @endif
              </td>
              <td>
                @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES' && $data->result == 'WIN' && $data->status_handover != 'handover')
                <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES')
                  @if($data->result != 'OPEN')
                    <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                  @else
                    <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                  @endif
                @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'SALES')
                  @if($data->result != 'OPEN')
                    <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                  @else
                    <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                  @endif
                  @if($data->status == 'pending')
                  <button value="{{$data->lead_id}}" class="btn btn-xs btn-primary lead_id_pro" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">Request PID</button>
                  @endif
                @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                  @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result != 'OPEN')
                    @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'WIN')
                    <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                    @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'LOSE')
                    <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                    @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'TP')
                    <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                    @else
                    @endif
                  @else
                  @endif
                @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_position == 'DIRECTOR')
                  @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result != 'OPEN' || Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN')
                    @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN')
                      @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_sho != 'SHO')
                        @if($data->status_sho != 'PMO')
                          @if($data->status == 'pending')
                          <button value="{{$data->lead_id}}" class="btn btn-xs btn-primary lead_id_pro" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">Request PID</button>
                          @endif
                          @if($data->status_handover != 'handover')
                            <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                          @endif
                    @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover == 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover == 'handover')
                        @if($data->status_sho != 'PMO')
                            <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                          @elseif($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                            <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                            <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                          @else
                            <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                @if($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                              @else
                                <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                                @endif
                          @endif
                        @endif
                    @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover != 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover != 'handover')
                        <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                      @endif
                    @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'LOSE' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                    <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                    @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'TP' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                    <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                    @else
                    @endif
                  @else
                  @endif
                @elseif(Auth::User()->id_position == 'DIRECTOR')
                  @if(Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN')
                    @if(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN')
                    <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                    @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                    <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                    @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                    <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                    @else
                    @endif
                  @else
                  @endif
                @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'FINANCE' && $data->result == 'WIN' && $data->status_sho != 'SHO')
                  @if($data->status == 'pending')
                  <button value="{{$data->lead_id}}" class="btn btn-xs btn-primary lead_id_pro" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">Request PID</button>
                  @endif
                @elseif(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->result == 'WIN')
                  @if($data->status_sho == 'PMO' && $data->status_engineer == NULL)
                    <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                  @else
                    @if($data->status_engineer == 'v' && Auth::User()->id_position == 'ENGINEER MANAGER')
                    <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                    @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER MANAGER')
                    <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                    @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER STAFF')
                    <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                    @else
                    <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary disabled">Detail</button></a>
                    @endif
                  @endif
                @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'PMO' && $data->result == 'WIN' && $data->status_handover == 'handover' && $data->status_sho != 'PMO')
                  <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                @elseif(Auth::User()->id_division != 'PMO')
                  @if(Auth::User()->id_position == 'OPERATION DIRECTOR' || Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'MSM')
                    <button class="btn btn-xs disabled" style="background-color: black;color: white">No Action</button>
                  @else
                    <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                  @endif
                @else
                  @if($data->status_sho == 'PMO' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'PMO')
                   
                  <button onclick="reassignPMO('{{$data->lead_id}}','@foreach($contributes as $cons) @if($data->lead_id == $cons->lead_id){{$cons->pmo_nik}}@endif @endforeach','@foreach($users as $pmo_owner) {{$pmo_owner->nik}} @endforeach')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO" >Re-Assign</button></a>
                  @elseif($data->status_sho == 'PMO' && Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'PMO')
                  <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                  @else
                  <button class="btn btn-xs btn-primary disabled">Detail</button>
                  @endif
                @endif
              </td>
              <td>{{$data->keterangan}}</td>
              <td hidden>
                @if($data->result != 'LOSE' && $data->result != 'CANCEL' && $data->result != 'HOLD')
                {{$data->amount}}
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            @if(Auth::User()->id_territory != NULL)
              @if(Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_territory == 'DPG')
                <th colspan="6" style="text-align: right;">Total Amount:</th>
                <th colspan="4"></th>
              @else
                <th colspan="6" style="text-align: right;">Total Amount:</th>
                <th colspan="4"></th>
              @endif
            @elseif(Auth::User()->id_position == 'DIRECTOR')
              <th colspan="6" style="text-align: right;">Total Amount:</th>
              <th colspan="4"></th>
            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL')
              <th colspan="6" style="text-align: right;">Total Amount:</th>
              <th colspan="4"></th>
            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
              <th colspan="6" style="text-align: right;">Total Amount:</th>
              <th colspan="4"></th>
            @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'TECHNICAL PRESALES')
              <th colspan="6" style="text-align: right;">Total Amount:</th>
              <th colspan="4"></th>
            @elseif(Auth::User()->id_division == 'PMO')
              <th colspan="6" style="text-align: right;">Total Amount:</th>
              <th colspan="4"></th>
            @else
              <th colspan="6" style="text-align: right;">Total Amount:</th>
              <th colspan="4"></th>
            @endif
          </tfoot>
        </table>
        </div>
      </div>
      <div id="div_2019" style="display: none;">
          <div class="table-responsive">
            <table class="table table-bordered table-striped no-wrap" id="datas2019" width="100%" cellspacing="0">
              <thead>
                <tr>
                  @if(Auth::User()->id_division == 'PMO')
                  <th>Project ID</th>
                  @else
                  <th>Lead ID</th>
                  @endif
                  <th>Customer</th>
                  <th>Opty Name</th>
                  <th>Create Date</th>
                  <th>Closing Date</th>
                  <th>Owner</th>
                  <th>Amount</th>
                  <th>Status</th>
                  <th>Action</th>
                  @if($cek_note > 0)
                  <th>Note</th>
                  @else
                  @endif
                  <th hidden></th>
                </tr>
                <tr id="status_2019">
                  @if(Auth::User()->id_division == 'PMO')
                  <th></th>
                  @else
                  <th></th>
                  @endif
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  @if($cek_note > 0)
                  <th></th>
                  @else
                  @endif
                  <th hidden></th>
                  <th hidden></th>
                </tr>
              </thead>
              <tbody id="products-list" name="products-list">
              @foreach($lead as $datas => $data)
              <tr>
                <td>
                  @if(Auth::User()->id_division == 'PMO')
                    @if($data->result != 'OPEN')
                      @if($data->status_sho == 'PMO')
                        <a href="{{ url ('/detail_project', $data->lead_id) }}">{{$data->id_project}}</a>
                      @else
                        {{$data->id_project}}
                      @endif
                    @endif
                  @else
                    @if(Auth::User()->id_division == 'PMO')
                      @if(Auth::User()->id_division == 'PMO' && $data->status_sho != 'PMO')
                      {{ $data->lead_id }}
                      @elseif(Auth::User()->id_division == 'PMO' && $data->status_handover != 'handover')
                      {{ $data->lead_id }}
                      @elseif($data->result != 'OPEN')
                      <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                      @else
                      {{ $data->lead_id }}
                      @endif
                    @else
                      @if(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->status_sho != 'PMO')
                      {{ $data->lead_id }}
                      @elseif(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->status_handover != 'handover')
                      {{ $data->lead_id }}
                      @elseif(Auth::User()->id_position == 'ENGINEER STAFF' && $data->status_sho != 'PMO')
                      {{ $data->lead_id }}
                      @elseif(Auth::User()->id_position == 'ENGINEER STAFF' && $data->status_handover != 'handover')
                      {{ $data->lead_id }}
                      @elseif($data->result != 'OPEN')
                        @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_position == 'DIRECTOR')
                          @if($data->status_sho == 'PMO' || $data->status_sho == '' || $data->status_handover == 'handover')
                            <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                          @else
                            {{ $data->lead_id }}
                          @endif
                        @else
                          <a href="{{ url ('/detail_project', $data->lead_id) }}">{{ $data->lead_id }}</a>
                        @endif
                      @else
                      {{ $data->lead_id }}
                      @endif
                    @endif
                  @endif
                </td>
                <td>{{ $data->brand_name}}</td>
                <td>{{ $data->opp_name}}</td>
                <td>{!!substr($data->created_at,0,10)!!}</td>
                <td>{{ $data->closing_date}}</td>
                <td>{{ $data->name }}
                @if(Auth::User()->id_division == 'PMO' && Auth::User()->id_position == 'STAFF' )
                  {{$data->pmo_nik}}</td>
                @endif
                 @if($data->result == 'TP' || $data->result == 'WIN' || $data->result == 'LOSE' || $data->result == 'CANCEL')
                  @if($data->deal_price == NULL)
                    <td><i></i><i class="money">{{$data->amount}}</i></td>
                  @else
                    <td><i></i><i class="money">{{$data->deal_price}}</i></td>
                  @endif
                @else
                  @if($data->amount == '')
                    <td><i></i><i class="money"></i></td>
                  @elseif($data->amount != '')
                    <td><i></i><i class="money">{{$data->amount}}</i></td>
                  @endif
                @endif
                <td>
                  @if($data->result == 'OPEN')
                    <label class="status-initial">INITIAL</label>
                  @elseif($data->result == '')
                    <label class="status-open">OPEN</label>
                  @elseif($data->result == 'SD')
                    <label class="status-sd">SD</label>
                  @elseif($data->result == 'TP')
                    <label class="status-tp">TP</label>
                  @elseif($data->result == 'WIN')
                    <label class="status-win">WIN</label>
                  @elseif($data->result == 'LOSE')
                    <label class="status-lose" data-toggle="modal" data-target="#modal-reason" onclick="lose('{{$data->keterangan}}')">LOSE</label>
                  @elseif($data->result == 'CANCEL')
                    <label class="status-lose" style="background-color: #071108">CANCEL</label>
                  @elseif($data->result == 'HOLD')
                    <label class="status-initial" style="background-color: #919e92">HOLD</label>
                  @endif
                </td>
                <td>
                  @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES' && $data->result == 'WIN' && $data->status_handover != 'handover')
                  <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                  @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES')
                    @if($data->result != 'OPEN')
                      @if($data->result == 'TP')
                      <button class="btn btn-xs btn-primary " data-target="#edit_lead_register" data-toggle="modal" onclick="lead_id('{{$data->lead_id}}','{{$data->id_customer}}','{{$data->opp_name}}','{{$data->amount}}','{{$data->created_at}}','{{$data->closing_date}}','{{$data->keterangan}}')" style="width: 60px;">&nbspEdit</button>
                      @endif
                    @else
                      <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                    @endif
                  @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'SALES')
                    @if($data->result != 'OPEN')
                      @if($data->result == 'TP')
                      <button class="btn btn-xs btn-primary " data-target="#edit_lead_register" data-toggle="modal" onclick="lead_id('{{$data->lead_id}}','{{$data->id_customer}}','{{$data->opp_name}}','{{$data->amount}}','{{$data->created_at}}','{{$data->closing_date}}','{{$data->keterangan}}')" style="width: 60px;">&nbspEdit</button>
                      @endif
                    @else
                      <a href="#"><button class="btn btn-xs btn-primary" disabled>Detail</button></a>
                    @endif
                  @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
                    @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result != 'OPEN')
                      @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'WIN')
                      <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                      @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'LOSE')
                      <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                      @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES' && $data->result == 'TP')
                      <!-- <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Edit</button></a> -->
                      <button class="btn btn-xs btn-primary " data-target="#edit_lead_register" data-toggle="modal" onclick="lead_id('{{$data->lead_id}}','{{$data->id_customer}}','{{$data->opp_name}}','{{$data->amount}}','{{$data->created_at}}','{{$data->closing_date}}','{{$data->keterangan}}')" style="width: 60px;">&nbspEdit</button>
                      @else
                      @endif
                    @else
                    @endif
                  @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_position == 'DIRECTOR')
                    @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result != 'OPEN' || Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN')
                      @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN')
                        @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_sho != 'SHO' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_sho != 'SHO')
                          @if($data->status_sho != 'PMO')
                            @if($data->status == 'pending')
                            <button value="{{$data->lead_id}}" class="btn btn-xs btn-primary lead_id_pro" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">Request PID</button>
                            @endif
                            @if($data->status_handover != 'handover')
                              <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                            @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover == 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover == 'handover')
                          @if($data->status_sho != 'PMO')
                              <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                            @elseif($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                              <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                              <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                            @else
                              <button onclick="reassignPMO('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO">Re-Assign</button></a>
                                  @if($data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || $data->status_sho == 'PMO' && $data->status_engineer == '' && Auth::User()->id_position == 'DIRECTOR')
                                  <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                                @else
                                  <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                                  @endif
                            @endif
                          @endif
                        @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'WIN' && $data->status_handover != 'handover' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN' && $data->status_handover != 'handover')
                          <button data-target="#modal_sho" data-toggle="modal" class="btn btn-xs btn-primary" onclick="sho('{{$data->lead_id}}')">Handover</button>
                        @endif
                      @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'LOSE' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                      <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                      @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' && $data->result == 'TP' || Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                      <button class="btn btn-xs btn-primary " data-target="#edit_lead_register" data-toggle="modal" onclick="lead_id('{{$data->lead_id}}','{{$data->id_customer}}','{{$data->opp_name}}','{{$data->amount}}','{{$data->created_at}}','{{$data->closing_date}}','{{$data->keterangan}}')" style="width: 60px;">&nbspEdit</button>
                      @else
                      @endif
                    @else
                    @endif
                  @elseif(Auth::User()->id_position == 'DIRECTOR')
                    @if(Auth::User()->id_position == 'DIRECTOR' && $data->result != 'OPEN')
                      @if(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'WIN')
                      <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                      @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'LOSE')
                      <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                      @elseif(Auth::User()->id_position == 'DIRECTOR' && $data->result == 'TP')
                      <button class="btn btn-xs btn-primary " data-target="#edit_lead_register" data-toggle="modal" onclick="lead_id('{{$data->lead_id}}','{{$data->id_customer}}','{{$data->opp_name}}','{{$data->amount}}','{{$data->created_at}}','{{$data->closing_date}}','{{$data->keterangan}}')" style="width: 60px;">&nbspEdit</button>
                      @else
                      @endif
                    @else
                    @endif
                  @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'FINANCE' && $data->result == 'WIN' && $data->status_sho != 'SHO')
                    @if($data->status == 'pending')
                    <button value="{{$data->lead_id}}" class="btn btn-xs btn-primary lead_id_pro" onclick="id_pro('{{$data->lead_id}}','{{$data->nik}}','{{$data->opp_name}}')">Request PID</button>
                    @endif
                  @elseif(Auth::User()->id_position == 'ENGINEER MANAGER' && $data->result == 'WIN')
                    @if($data->status_sho == 'PMO' && $data->status_engineer == NULL)
                      <button type="button" class="btn btn-xs btn-primary" onclick="assignEngineer('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignEngineer">Assign</button>
                    @else
                      @if($data->status_engineer == 'v' && Auth::User()->id_position == 'ENGINEER MANAGER')
                      <button onclick="reassignEngineer('{{$data->lead_id}}')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignEngineer">Re-Assign</button></a>
                      @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER MANAGER')
                      <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                      @elseif($data->status_handover != 'handover' && Auth::User()->id_position == 'ENGINEER STAFF')
                      <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                      @else
                      <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary disabled">Detail</button></a>
                      @endif
                    @endif
                  @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'PMO' && $data->result == 'WIN' && $data->status_handover == 'handover' && $data->status_sho != 'PMO')
                    <button type="button" class="btn btn-xs btn-primary" onclick="assignPMO('{{$data->lead_id}}')" data-toggle="modal" data-target="#assignModalPMO">Assign</button>
                  @elseif(Auth::User()->id_division != 'PMO')
                  @if(Auth::User()->id_position == 'OPERATION DIRECTOR')
                    <button class="btn btn-xs disabled" style="background-color: black;color: white">No Action</button>
                  @else
                    <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                  @endif
                  @else
                    @if($data->status_sho == 'PMO' && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'PMO')
                     
                    <button onclick="reassignPMO('{{$data->lead_id}}','@foreach($contributes as $cons) @if($data->lead_id == $cons->lead_id){{$cons->pmo_nik}}@endif @endforeach','@foreach($users as $pmo_owner) {{$pmo_owner->nik}} @endforeach')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reassignModalPMO" >Re-Assign</button></a>
                    @elseif($data->status_sho == 'PMO' && Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'PMO')
                    <a href="{{ url ('/detail_project', $data->lead_id) }}"><button class="btn btn-xs btn-primary">Detail</button></a>
                    @else
                    <button class="btn btn-xs btn-primary disabled">Detail</button>
                    @endif
                  @endif
                </td>
                @if(Auth::User()->id_division == 'SALES' || Auth::User()->id_company == '1' && Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_company == '2' && Auth::User()->id_division != 'TECHNICAL')
                @endif
                @if($cek_note > 0)
                <td>{{$data->keterangan}}</td>
                @else
                @endif
                <td hidden>{{$data->year}}</td>
                <td hidden="">
                  @if($data->result != 'LOSE' && $data->result != 'HOLD' && $data->result != 'CANCEL')
                  {{$data->amount}}
                  @endif
                </td>
              </tr>
              @endforeach
              </tbody>
              <tfoot>
                <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
              </tfoot>
            </table>
            </div>
          </div>
      </div>
  </div>

  @if(Auth::User()->id_division == 'SALES' || Auth::User()->id_division == 'TECHNICAL PRESALES')
      <div class="row">
          <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                  <table class="table table-bordered center" width="100%" cellspacing="0">
                      <thead style="background-color: #343a40!important">
                        <tr style="color: white">
                          <th>Object Privelege</th>
                          <th>Sales</th>
                          <th>Presales Manager</th>
                          <th>Presales</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th>Lead Register</th>
                          <td>CR</td>
                          <td>R</td>
                          <td>R</td>
                        </tr>
                        <tr>
                          <th>Solution Design</th>
                          <td>R</td>
                          <td>R</td>
                          <td>CRU</td>
                        </tr>
                        <tr>
                          <th>Tender Process</th>
                          <td>CRU</td>
                          <td>R</td>
                          <td>R</td>
                        </tr>
                        <tr>
                          <th>Result Win/Lose</th>
                          <td>RU</td>
                          <td>R</td>
                          <td>R</td>
                        </tr>
                        <tr>
                          <th>Sales Handover</th>
                          <td>CR</td>
                          <td>R</td>
                          <td>R</td>
                        </tr>
                        <tr>
                          <th>Assign Presales</th>
                          <td>-</td>
                          <td>CRU</td>
                          <td>-</td>
                        </tr>
                      </tbody>
                  </table>
                  <div>
                    <h6><b>Note :</b></h6>
                    <h6>C : CREATE</h6>
                    <h6>R : READ</h6>
                    <h6>U : UPDATE</h6>
                    <h6>D : DELETE</h6>
                  </div>
                </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                  <table class="table table-bordered" width="100%" cellspacing="0" >
                      <thead style="background-color: #343a40!important">
                        <tr style="color: white">
                          <th>Status</th>
                          <th>Deskripsi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th>Initial</th>
                          <td>Lead Register pertama kali dibuat</td>
                        </tr>
                        <tr>
                          <th>
                            Open
                          </th>
                          <td>Presales Manager telah mengalokasikan presales</td>
                        </tr>
                        <tr>
                          <th>SD</th>
                          <td>(Solution Design) Presales yang di assign mengerjakan solution design</td>
                        </tr>
                        <tr>
                          <th>TP</th>
                          <td>(Tender Process) Proses Solution Design oleh Presales selesai dilakukan dan Sales mengisi form Tender Process</td>
                        </tr>
                        <tr>
                          <th>Win</th>
                          <td>Tender berhasil dimenangkan</td>
                        </tr>
                        <tr>
                          <th>Lose</th>
                          <td>Tender gagal</td>
                        </tr>
                        <tr>
                          <th>Hold</th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>Cancel</th>
                          <td>Tender tidak dilanjutkan</td>
                        </tr>
                      </tbody>
                  </table>
                </div>
            </div>
          </div>
      </div>
  @elseif(Auth::User()->id_division != 'SALES' || Auth::User()->id_division != 'TECHNICAL PRESALES')
      <div class="card mb-3">
            <div class="card-body">
              <table class="table table-bordered" width="100%" cellspacing="0" >
                  <thead style="background-color: #343a40!important">
                    <tr style="color: white">
                      <th>Status</th>
                      <th>Deskripsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th>Initial</th>
                      <td>Lead Register pertama kali dibuat</td>
                    </tr>
                    <tr>
                      <th>
                        Open
                      </th>
                      <td>Presales Manager telah mengalokasikan presales</td>
                    </tr>
                    <tr>
                      <th>SD</th>
                      <td>(Solution Design) Presales yang di assign mengerjakan solution design</td>
                    </tr>
                    <tr>
                      <th>TP</th>
                      <td>(Tender Process) Proses Solution Design oleh Presales selesai dilakukan dan Sales mengisi form Tender Process</td>
                    </tr>
                    <tr>
                      <th>Win</th>
                      <td>Tender berhasil dimenangkan</td>
                    </tr>
                    <tr>
                      <th>Lose</th>
                      <td>Tender gagal</td>
                    </tr>
                  </tbody>
                  <tfoot></tfoot>
              </table>
            </div>
      </div>
      @endif

</section>

  <!--MODAL ADD PROJECT-->
<div class="modal fade" id="modal_lead" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Add Lead Register</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('store')}}" id="modalSalesLead" name="modalSalesLead">
            @csrf
          <!-- <div class="form-group">
            <label for="lead_id">Lead Id</label>
            <input type="text" class="form-control" id="lead_id" name="lead_id" placeholder="Lead Id" readonly required>
          </div> -->
          
            @if(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_company == '2')
              <div class="form-group">
              <label for="">Owner</label>
              <select class="form-control" style="width: 100%;" id="owner_sales" onkeyup="copytextbox();" name="owner_sales" required>
                <option value="">-- Select Sales --</option>
                @foreach($owner as $data)
                  @if($data->id_division == 'SALES' && $data->id_company == '2' && $data->id_position != 'ADMIN' || $data->name == 'Presales')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach
              </select>
              </div>
            @elseif(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_company == '2')
              <div class="form-group">
              <label for="">Owner</label>
              <select class="form-control" style="width: 100%;" id="owner_sales" onkeyup="copytextbox();" name="owner_sales" required>
                <option value="">-- Select Sales --</option>
                @foreach($owner as $data)
                  @if($data->id_division == 'SALES' && $data->id_company != '1')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach
              </select>
              </div>
            @elseif(Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER')
              <div class="form-group">
              <label for="">Owner</label>
              <select class="form-control" style="width: 100%;" id="owner_sales" onkeyup="copytextbox();" name="owner_sales" required>
                <option value="">-- Select Sales --</option>
                @foreach($owner as $data)
                  @if($data->id_division == 'SALES' && $data->id_company == '2' && $data->id_position != 'ADMIN')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach
              </select>
              </div>
            @elseif(Auth::User()->id_position == 'DIRECTOR' && Auth::User()->id_company == '2' )
              <div class="form-group">
              <label for="">Owner</label>
              <select class="form-control" style="width: 100%;" id="owner_sales" onkeyup="copytextbox();" name="owner_sales" required>
                <option value="">-- Select Sales --</option>
                @foreach($owner as $data)
                  @if($data->id_division == 'SALES'  && $data->id_position != 'ADMIN' || $data->id_position == 'DIRECTOR' || $data->id_division == 'TECHNICAL' && $data->id_position == 'MANAGER' && $data->id_territory == '' && $data->name != 'TECH HEAD')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach
              </select>
              </div>
            @elseif(Auth::User()->id_position == 'DIRECTOR' && Auth::User()->id_company == '2')
              <div class="form-group">
              <label for="">Owner</label>
              <select class="form-control" style="width: 100%;" id="owner_sales" onkeyup="copytextbox();" name="owner_sales" required>
                <option value="">-- Select Sales --</option>
                @foreach($owner as $data)
                  @if($data->id_division == 'SALES' && $data->id_company != '1')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach
              </select>
              </div>
            @endif

          <div class="form-group">
            <label for="">Customer (Brand Name)</label>
             <select class="form-control" style="width: 100%;" id="contact" onkeyup="copytextbox();" name="contact" required>
              <option value="">-- Select Contact --</option>
              @foreach($code as $data)
                <option value="{{$data->id_customer}}">{{$data->brand_name}} </option>
                @endforeach
            </select>
          </div>

         <div class="form-group">
          <label for="">Opportunity Name</label>
          <input type="text" class="form-control" placeholder="Enter Opportunity Name" name="opp_name" id="opp_name" required>
         </div>

          <div class="form-group  modalIcon inputIconBg">
            <label for="">Amount</label>
            <input type="text" class="form-control money" placeholder="Enter Amount" name="amount" id="amount">
            <i class="" aria-hidden="true">Rp.</i>
          </div>

          <div class="form-group">
            <label for="">Closing Date</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" name="closing_date" id="closing_date">
            </div>
            {{-- <input type="date" class="form-control" name="closing_date" id="closing_date" required> --}}
          </div>

          @if(Auth::User()->email == "tech@sinergy.co.id")
            <div class="form-group">
              <label for="">Closing Date</label>
              <input type="text" class="form-control pull-right" id="datepicker">
            </div>
          @endif

          <div class="form-group">
          <label for="">Note (jika perlu)</label>
          <input type="text" class="form-control" placeholder="Enter Note" name="note" id="note">
         </div>

          <!-- <div class="form-group modalIcon inputIconBg">
            <label for="">Kurs To Dollar</label>
            <input type="text" class="form-control" disabled="disabled" placeholder="Kurs">
            <i class="" aria-hidden="true">&nbsp$&nbsp </i>
          </div> -->       
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" id="add_lead" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
            </div>
        </form>
        </div>
      </div>
    </div>
</div>


<!-- MODAL EDIT PROJECT-->
<div class="modal fade" id="edit_lead_register" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Edit Lead Register</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('update_lead_register')}}" id="modal_edit_saleslead" name="modal_edit_saleslead">
            @csrf

          <input type="" name="lead_id_edit" id="lead_id_edit" hidden>

          <!-- <div class="form-group">
            <label for="">Customer</label>
             <select class="form-control" style="width: 100%;" id="contact_edit" onkeyup="copytextbox();" name="contact_edit" required>
              <option value="">-- Select Contact --</option>
              @foreach($code as $data)
                <option value="{{$data->id_customer}}">{{$data->brand_name}}</option>
                @endforeach
            </select>
          </div> -->

         <div class="form-group">
          <label for="">Opportunity Name</label>
          <textarea type="text" class="form-control" placeholder="Enter Opportunity Name" name="opp_name_edit" id="opp_name_edit">
          </textarea>
         </div>

         <!-- <div class="form-group  modalIcon inputIconBg">
            <label for="">Create Date</label>
            <input type="date" name="create_date_edit" id="create_date_edit" class="form-control">
          </div> -->

          <div class="form-group  modalIcon inputIconBg">
            <label for="">Amount</label>
            <input type="text" class="form-control money" placeholder="Enter Amount" name="amount_edit" id="amount_edit">
            <i class="" aria-hidden="true">Rp.</i>
          </div>

          <div class="form-group">
            <label for="">Closing Date</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" name="closing_date_edit" id="closing_date_edit">
            </div>
            {{-- <input type="date" name="closing_date_edit" id="closing_date_edit" class="form-control"> --}}
          </div>

          <div class="form-group">
          <label for="">Note (jika perlu)</label>
          <input type="text" class="form-control" placeholder="Enter Note" name="note_edit" id="note_edit">
         </div>

          <!-- <div class="form-group modalIcon inputIconBg">
            <label for="">Kurs To Dollar</label>
            <input type="text" class="form-control" disabled="disabled" placeholder="Kurs">
            <i class="" aria-hidden="true">&nbsp$&nbsp </i>
          </div> -->     
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
            </div>
        </form>
        </div>
      </div>
    </div>
</div>

<!-- Presales Assignment -->
  <div class="modal fade" id="assignModal" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Presales Assignment</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('assign_to_presales')}}" id="modalAssign" name="modalAssign">
            @csrf
          <div class="form-group">
            <input type="text" name="cek_nik" id="cek_nik" value="" hidden>
            <input type="text" name="coba_lead" id="coba_lead" value=""  hidden>
            <input type="text" name="cek_created_at" id="cek_created_at" value=""  hidden>
            <h2 for="">Choose Presales</h2>
            <div style="width: 500px">
              <select class="form-control margin-left-custom" id="owner" name="owner" required>
              <option>-- Choose --</option>
              @if(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_company == '1' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_company == '1' || Auth::User()->id_position == 'DIRECTOR' && Auth::User()->id_company == '1')
                @foreach($owner as $data)
                  @if($data->id_division == 'TECHNICAL PRESALES' && $data->id_company == '1')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach
              @elseif(Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_company == '2' || Auth::User()->id_position == 'DIRECTOR' && Auth::User()->id_company == '2')
                @foreach($owner as $data)
                  @if($data->id_division == 'TECHNICAL PRESALES' && $data->id_company == '2' || $data->id_division == 'TECHNICAL' && $data->id_company == '2')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach
              @endif
            </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"> </i>&nbspSubmit</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>

<!-- PMO Assignment -->
  <div class="modal fade" id="assignModalPMO" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">PMO Assignment</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('assign_to_pmo')}}" id="modalAssignPMO" name="modalAssignPMO">
            @csrf
          <div class="form-group row">
            <input type="text" name="coba_lead_pmo" id="coba_lead_pmo" value="" hidden>
            <label for="">Choose PMO</label><br>
            <select class="form-control-small margin-left-custom" id="pmo_nik" name="pmo_nik" required>
              <option value="">-- Choose --</option>
                @foreach($owner as $data)
                  @if($data->id_division == 'PMO')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"> </i>&nbspSubmit</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div> 

  <div class="modal fade" id="assignEngineer" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Engineer Assignment</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('engineer_assign')}}" id="modalAssignPMO" name="modalAssignPMO">
            @csrf
          <div class="form-group row">
            <input type="text" name="engineer_lead" id="engineer_lead" value="" hidden>
            <label for="">Choose Engineer</label><br>
            <select class="form-control-small margin-left-custom" id="engineer_nik" name="engineer_nik" required>
              <option>-- Choose Engineer--</option>
                @foreach($owner as $data)
                  @if($data->id_position == 'ENGINEER MANAGER')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach
                @foreach($owner as $data)
                  @if($data->id_position == 'ENGINEER STAFF')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach

            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"> </i>&nbspSubmit</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div> 

  <!-- PMO reAssignment -->
  <div class="modal fade" id="reassignModalPMO" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">PMO Re-Assignment</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('reassign_to_pmo')}}" id="modalAssignPMO" name="modalAssignPMO">
            @csrf
          <div class="form-group row">
            <div>
            </div>
            <input type="text" name="pmo_reassign" id="pmo_reassign" value="" hidden>

            <input type="text" name="pmo_nik_update" id="pmo_nik_update" value="" hidden>

            <input type="text" name="owner_pmo" id="owner_pmo" hidden>
             

            <label for="">Choose PMO</label><br>
            <select class="form-control-small margin-left-custom" id="upadte_pmo_nik" name="upadte_pmo_nik" required>
              <option value="">-- Choose PMO --</option>
              @if(Auth::User()->id_division == 'PMO' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_position == 'DIRECTOR')
                @foreach($users as $data)
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                @endforeach
              @endif
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"> </i>&nbspSubmit</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div> 

  <div class="modal fade" id="reassignEngineer" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Engineer Re-Assignment</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('reassign_to_engineer')}}" id="modalAssignPMO" name="modalAssignPMO">
            @csrf
          <div class="form-group row">
            <input type="text" name="engineer_lead_reassign" id="engineer_lead_reassign" hidden>
            <label for="">Choose Engineer</label><br>
            <select class="form-control-small margin-left-custom" id="nik_engineer" name="nik_engineer" required>
              <option>-- Choose --</option>
                @foreach($owner as $data)
                  @if($data->id_position == 'ENGINEER MANAGER')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach
                @foreach($owner as $data)
                  @if($data->id_position == 'ENGINEER STAFF')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"> </i>&nbspSubmit</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>  

  <!-- Re-Presales Assignment -->
  <div class="modal fade" id="reassignModal" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Presales Re-Assignment</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('reassign_to_presales')}}" id="modalreAssign" name="modalreAssign">
            @csrf
          <div class="form-group">
            <input type="text" name="coba_lead_reassign" id="coba_lead_reassign" value="" hidden>
          <!--   <label for="">Current Presales</label><br>
            <input type="text" class="form-control margin-bottom" name="current_presales_update" id="current_presales_update" value="" readonly> -->
            <h2>Choose Presales</h2>
            <div style="width: 500px">
              <select class="form-control margin-left-custom" id="owner_reassign" name="owner_reassign" required>
              <option>-- Choose Presales --</option>
              @if(Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_company == '1' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_company == '1' || Auth::User()->id_position == 'DIRECTOR' && Auth::User()->id_company == '1')
                @foreach($owner as $data)
                  @if($data->id_division == 'TECHNICAL PRESALES' && $data->id_company == '1')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach
              @elseif(Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_company == '2' || Auth::User()->id_position == 'DIRECTOR' && Auth::User()->id_company == '2')
                @foreach($owner as $data)
                  @if($data->id_division == 'TECHNICAL PRESALES' && $data->id_company == '2' || $data->id_division == 'TECHNICAL' && $data->id_company == '2')
                    <option value="{{$data->nik}}">{{$data->name}}</option>
                  @endif
                @endforeach
              @endif
            </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp Close</button>
              <!--  <button type="submit" class="btn btn-primary" id="btn-save" value="add"  data-dismiss="modal" >Submit</button>
              <input type="hidden" id="lead_id" name="lead_id" value="0"> -->
            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"> </i>&nbspSubmit</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Handover -->
  <div class="modal fade" id="modal_sho" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Add Sales Handover</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('store_sho')}}" id="modalCustomer" name="modalCustomer">
            @csrf
          
          <input type="" name="lead_to_sho" id="lead_to_sho" hidden>
          <!-- <div class="form-group">
            <label for="pid">PID</label>
            <input type="text" class="form-control" id="pid" name="pid" placeholder="PID" readonly>
          </div> -->
          <div class="form-group">
            <label for="name_contact">Scope Of Work</label>
            <textarea class="form-control" id="sow" name="sow"></textarea>
          </div>

          <div class="form-group">
            <label for="timeline">Timeline</label>
            <input type="text" class="form-control" id="timeline" name="timeline" placeholder="Enter Timeline">
          </div>

          <div class="form-group">
            <label for="top">Term of Payment</label>
            <textarea type="text" class="form-control" id="top" name="top" placeholder="" required> </textarea>
          </div>

          <div class="form-group inputWithIconn inputIconBg">
            <label for="budget">Budget</label>
            <input class="form-control-medium money" type="text" placeholder="Enter Project Budget" name="pro_budget"  id="pro_budget" value="" />
                <i class="" aria-hidden="true">Rp.</i>
          </div>

          <div class="form-group">
            <label for="meeting">Meeting Date</label>
            <input type="date" class="form-control" id="meeting" name="meeting">
          </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspAdd</button>
            </div>
        </form>
        </div>
      </div>
    </div>
</div>

  <div class="modal fade" id="salesproject" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add ID Project</h4>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{url('store_sp')}}">
              @csrf
            <div class="form-group">
              <label for="">Date</label>
              <input type="date" name="date" id="date" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="">No. PO Customer</label>
              <input type="text" name="po_customer" id="po_customer" class="form-control">
            </div>

            <div class="form-group">
              <label for="">Lead ID</label>
              <input type="text" id="customer_name" name="customer_name" class="form-control" readonly>
            </div>

            <div class="form-group">
              <label for="">Project Name</label>
              <input type="text" name="name_project" id="name_project" class="form-control" readonly>
            </div>

            <div class="form-group" hidden>
              <label for="">Sales</label>
              <input type="text" name="sales" id="sales" class="form-control" readonly>
               <!-- <select class="form-control" id="sales" name="sales" required o>
                    <option value="{{$data->nik}}">{{$data->name}}</option>
              </select> -->
            </div>

            <div class="form-group  modalIcon inputIconBg">
              <label for="">Amount</label>
              <input type="text" class="form-control money" placeholder="Enter Amount" name="amount" id="amount" required>
              <i class="" aria-hidden="true">Rp.</i>
            </div>

            <!-- <div class="form-group modalIcon inputIconBg">
              <label for="">Kurs To Dollar</label>
              <input type="text" class="form-control" readonly placeholder="Kurs" name="kurs" id="kurs">
              <i class="" aria-hidden="true">&nbsp$&nbsp </i>
            </div>   -->     
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
                <button type="submit" class="btn btn-primary-custom"><i class="fa fa-check">&nbsp</i>Submit</button>
              </div>
          </form>
          </div>
        </div>
      </div>
  </div>

  <div class="modal fade" id="modal-reason" role="dialog">
    <div class="modal-dialog modal-sd">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Reason of Lose</h4>
        </div>
          <div class="modal-body">
            <div class="form-group">
              <textarea class="form-control" readonly id="keterangan_lose" name="keterangan_lose"></textarea>
            </div>
          </div>
        <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
        </div>
        </div>
      </div>
  </div>

  <div class="modal fade" id="tunggu" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-body">
            <div class="form-group">
              <div class="">Lead Register Anda Akan di Proses. . .</div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <div class="modal fade" id="request_id" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Request ID Project</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('update_result_idpro')}}">
            @csrf
          <div class="form-group">
            <label for="">Lead ID</label>
            <input type="" name="lead_id" class="leadss" hidden>
            <input type="text" id="customer_name" name="" class="form-control customer_names" readonly>
          </div>

          <div class="form-group">
            <label for="">Project Name</label>
            <input type="text" name="name_project" id="name_project" class="form-control project_names" readonly>
          </div>

          <div class="form-group" hidden>
            <label for="">Sales</label>
            <input type="text" name="sales" id="sales" class="form-control" readonly>
          </div>

          <div class="form-group  modalIcon inputIconBg">
            <label for="">Amount PO</label>
            <input type="text" class="form-control money amount_pids" placeholder="Enter Amount" name="amount" id="amount_id_project" required>
            <i class="" aria-hidden="true">Rp.</i>
          </div>

          <div class="form-group">
            <label for="">Date PO</label>
            <input type="text" name="date" id="date" class="form-control dates" required>
          </div>

          <div class="form-group  modalIcon inputIconBg">
            <label for="">Amount Quote</label>
            <input type="text" class="form-control money amount_quote" placeholder="Enter Amount" name="amount" id="amount_id_project" required>
            <i class="" aria-hidden="true">Rp.</i>
          </div>

          <div class="form-group">
            <label for="">Date Quote</label>
            <input type="text" name="date" id="date" class="form-control date_quote" required>
          </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-primary-custom"><i class="fa fa-check">&nbsp</i>Submit</button>
            </div>
        </form>
        </div>
      </div>
    </div>
</div>

@endsection

@section('script')
  <script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/sum().js')}}"></script>
  <!-- bootstrap datepicker -->
  <script src="{{asset("template2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")}}"></script>
  <script type="">

    $('.counter').each(function () {
     var size = $(this).text().split(".")[1] ? $(this).text().split(".")[1] : 0;
     $(this).prop('Counter', 0).animate({
        Counter: $(this).text()
     }, {
        duration: 5000,
        step: function (func) {
           $(this).text(parseFloat(func).toFixed(size));
        }
     });
    });

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

    $('#closing_date').datepicker({
      autoclose: true,
      startDate: today
    })

    $('#closing_date_edit').datepicker({
      startDate: today
    })

    $('#add_lead').click(function(){
      $('#tunggu').modal('show')
      $('#modal_lead').modal('hide')
      setTimeout(function() {$('#tunggu').modal('hide');}, 1000);
    });

    function assign(lead_id,nik,created_at){
      $('#coba_lead').val(lead_id);
      $('#cek_nik').val(nik);
      $('#cek_created_at').val(created_at);
    }

    function sho(lead_id,id_project){
      $('#lead_to_sho').val(lead_id);  
      $('#id_project_sho').val(id_project);     
    }

    function reassignEngineer(lead_id){
       $('#engineer_lead_reassign').val(lead_id);  
    }

    function assignEngineer(lead_id){
       $('#engineer_lead').val(lead_id);  
    }

    function id_pro(lead_id,nik,opp_name){
      $('#customer_name').val(lead_id);
      $('#sales').val(nik);
      $('#name_project').val(opp_name);
    }

    function assignPMO(lead_id){
      $('#coba_lead_pmo').val(lead_id);
    }

    function reassignPMO(lead_id,pmo_nik,nik){
      $('#pmo_reassign').val(lead_id);
      $('#pmo_nik_update').val(pmo_nik);
      $('#owner_pmo').val(nik);

      var b = document.getElementById("pmo_nik_update").value;
      var c = document.getElementById("owner_pmo").value;

    }

    function reassign(lead_id,nik,name){
      $('#coba_lead_reassign').val(lead_id);
      $('#current_presales_update').val(nik);
      $('#owner_reassign').val(users.name);
    }

    function lead_id(lead_id,id_customer,opp_name,amount,created_at,closing_date,keterangan){
      $('#lead_id_edit').val(lead_id);
      $('#contact_edit').val(id_customer);
      $('#opp_name_edit').val(opp_name);
      $('#amount_edit').val(amount);
      $('#create_date_edit').val(created_at.substring(0,10));
      $('#closing_date_edit').val(closing_date);
      $('#note_edit').val(keterangan);
    }

    function lose(keterangan){
      $('#keterangan_lose').val(keterangan);
    }

      $('.money').mask('000,000,000,000,000', {reverse: true});
      $(document).ready(function() {
          $('#contact').select2();
          $('#contact_edit').select2();
          $('#owner_sales').select2();
      });

      $("#alert").fadeTo(2000, 500).slideUp(500, function(){
      $("#alert").slideUp(300);
      });

      $(".dismisbar").click(function(){
      $(".notification-bar").slideUp(300);
      }); 

  
      @if (Auth::User()->id_division == 'SALES' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER') {
      	$('#datasnow').DataTable({
           "responsive":true,
           "order": [[ "3", "desc" ]],
           pageLength: 50,
           "orderCellsTop": true,
           "footerCallback": function( row, data, start, end, display ) {
	            var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp.' ).display;

	            var api = this.api(),data;

	            var filtered = api.column(10, {"filter": "applied"} ).data().sum();

	            var totalpage = api.column(6).data().sum();

	            $( api.column( 6 ).footer() ).html(numFormat(filtered)+'');

	        },
          initComplete: function () {
            this.api().columns([[0],[1],[2],[5],[7]]).every( function () {
                var column = this;
                var title = $(this).text();
                var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Show All '+ title +'</option></select>')
                    .appendTo($("#status").find("th").eq(column.index()))
                    .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val());                                     

                    column.search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
                
                console.log(select);

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option>' + d + '</option>')
                });

                initkat();
                
            });
          }
        });

        var table = $('#datas2019').DataTable({
           // "scrollX": true,
          "columnDefs":[
              {"width": "15%", "targets":9},
              {"width": "20%", "targets":6},
              {"width": "7%", "targets":3},
              {"width": "20%", "targets":1},
              {"width": "25%", "targets":2},
             ],
           "responsive":true,
           "order": [[ 3, "desc" ]],
           "footerCallback": function( row, data, start, end, display ) {
          
            var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp.' ).display;

            var api = this.api(),data;
                // Remove the formatting to get integer data for summation

            var filtered = api.column(11, {"filter": "applied"} ).data().sum();

            $( api.column( 5 ).footer() ).html("Total Amount");
               
            $( api.column( 6 ).footer() ).html(numFormat(filtered));

          },
          initComplete: function () {
            this.api().columns([[0],[1],[2],[5],[7]]).every( function () {
                var column = this;
                var title = $(this).text();
                var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Show All '+ title +'</option></select>')
                    .appendTo($("#status_2019").find("th").eq(column.index()))
                    .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val());                                     

                    column.search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
                
                console.log(select);

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option>' + d + '</option>')
                });

                initkat();
                
            });
          }
        })
      }@else{
      	$('#datasnow').DataTable({
           "responsive":true,
           "order": [[ "3", "desc" ]],
           pageLength: 50,
           "orderCellsTop": true,
           "footerCallback": function( row, data, start, end, display ) {
	            var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp.' ).display;

	            var api = this.api(),data;

	            var filtered = api.column(10, {"filter": "applied"} ).data().sum();

	            var totalpage = api.column(6).data().sum();

	            $( api.column( 6 ).footer() ).html(numFormat(filtered)+'');

	        },
          initComplete: function () {
            this.api().columns([[0],[1],[2],[7]]).every( function () {
                var column = this;
                var title = $(this).text();
                var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Show All '+ title +'</option></select>')
                    .appendTo($("#status").find("th").eq(column.index()))
                    .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val());                                     

                    column.search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
                
                console.log(select);

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option>' + d + '</option>')
                });

                initkat();
                
            });
        }
        });

        var table = $('#datas2019').DataTable({
          "columnDefs":[
              {"width": "15%", "targets":9},
              {"width": "20%", "targets":6},
              {"width": "7%", "targets":3},
              {"width": "20%", "targets":1},
              {"width": "25%", "targets":2},
             ],
           "responsive":true,
           "order": [[ 7, "asc" ]],
           "footerCallback": function( row, data, start, end, display ) {
          
            var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp.' ).display;

            var api = this.api(),data;

            var filtered = api.column(11, {"filter": "applied"} ).data().sum();

            $( api.column( 5 ).footer() ).html("Total Amount");
               
            $( api.column( 6 ).footer() ).html(numFormat(filtered));

          },
          initComplete: function () {
            this.api().columns([[0],[1],[2],[7]]).every( function () {
                var column = this;
                var title = $(this).text();
                var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Show All '+ title +'</option></select>')
                    .appendTo($("#status_2019").find("th").eq(column.index()))
                    .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val());                                     

                    column.search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
                
                console.log(select);

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option>' + d + '</option>')
                });

                initkat();
                
            });
        }
        })
      }@endif

      $(document).ready(function(){
        $('#year_dif').on('change', function() {

            $('#div_now').css("display", "none");
            $('#div_2019').css("display", "block");


            table.draw();

            var product = $('#year_dif').val();
            
            console.log(product);

            $.ajax({
              type:"GET",
              url:'/year_initial',
              data:{
                product:this.value,
              },
              success: function(result){
                $.each(result[0], function(key, value){
                if (value == null) {
                  $('#lead_all').text('0');
                }else{
                  $('#lead_all').text(result[0].length);
                }
                });
                 
              }
            });

            // $.ajax({
            //   type:"GET",
            //   url:'/year_open',
            //   data:{
            //     product:this.value,
            //   },
            //   success: function(result){
            //     $.each(result[0], function(key, value){
            //     $('#lead_open').text(result[0].length);
            //     });
                 
            //   }
            // });

            // $.ajax({
            //   type:"GET",
            //   url:'/year_sd',
            //   data:{
            //     product:this.value,
            //   },
            //   success: function(result){
            //     $.each(result[0], function(key, value){
            //     $('#lead_sd').text(result[0].length);
            //     });
                 
            //   }
            // });

            $.ajax({
              type:"GET",
              url:'/year_tp',
              data:{
                product:this.value,
              },
              success: function(result){
                $.each(result[0], function(key, value){
                $('#lead_tp').text(result[0].length);
                });
                 
              }
            });

            $.ajax({
              type:"GET",
              url:'/year_win',
              data:{
                product:this.value,
              },
              success: function(result){
                $.each(result[0], function(key, value){
                $('#lead_win').text(result[0].length);
                });
                 
              }
            });


            $.ajax({
              type:"GET",
              url:'/year_lose',
              data:{
                product:this.value,
              },
              success: function(result){
                $.each(result[0], function(key, value){
                $('#lead_lose').text(result[0].length);
                });
                 
              }
            });

            $.fn.dataTable.ext.search.push(
              function(settings, data, dataIndex) {
                  var years = parseInt($('#year_dif').val());
                  var tahunbanding = parseInt(data[10]);
              if ( ( isNaN( years ) ) ||
                   ( years  ==  tahunbanding ))
              {
              return true;
              }
              return false;  
              }
            );
      
        });
 
      });

      $(".lead_id_pro").click(function(){
      var cn = this.value;
      console.log(cn);

        $.ajax({
          type:"GET",
          url:'/getleadpid',
          data:{
            lead_sp:cn,
          },
          success: function(result){
            $.each(result[0], function(key, value){
              $('.leadss').val(value.lead_id);
              $('.customer_names').val(value.lead_id);
              $('.project_names').val(value.opp_name);
              $('.dates').val(moment(value.date_po).format('L'));
              $('.amount_pids').val(value.amount_pid);
              $('.date_quote').val(moment(value.date).format('L'));
              $('.amount_quote').val(value.amount);
            }); 
          },
        }); 

      $("#request_id").modal("show");
    });


    function initkat()
    {
        $('.kat_drop').select2();
    }

  </script>
@endsection