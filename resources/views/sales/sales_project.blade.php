@extends('template.template_admin-lte')
@section('content')
<style type="text/css">
  .DTFC_LeftBodyLiner{overflow-y:unset !important}
  .DTFC_RightBodyLiner{overflow-y:unset !important}


  .radios {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 14px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }

  /* Hide the browser's default radio button */
  .radios input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
  }

  /* Create a custom radio button */
  .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
    border-radius: 50%;
  }

  /* On radiosmouse-over, add a grey background color */
  .radios:hover input ~ .checkmark {
    background-color: #ccc;
  }

  /* When the radio button is checked, add a blue background */
  .radios input:checked ~ .checkmark {
    background-color: #2196F3;
  }

  /* Create the indicator (the dot/circle - hidden when not checked) */
  .checkmark:after {
    content: "";
    position: absolute;
    display: none;
  }

  /* Show the indicator (dot/circle) when checked */
  .radios input:checked ~ .checkmark:after {
    display: block;
  }

  /* Style the indicator (dot/circle) */
  .radios .checkmark:after {
    top: 9px;
    left: 9px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: white;
  }
</style>

<section class="content-header">
  <h1>
    ID Project
  </h1>
  <ol class="breadcrumb">
    <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">ID Project</li>
  </ol>
</section>

<section class="content">
  @if (session('success'))
    <div class="alert alert-success notification-bar"><span>Notice : </span> {{ session('success') }}<button type="button" class="dismisbar transparant pull-right"><i class="fa fa-times fa-lg"></i></button><br>Get your PID :<h4> {{$pops->id_project}}</h4></div>
  @elseif (session('error'))
    <div class="alert alert-danger notification-bar" id="alert"><span>notice: </span> {{ session('error') }}.</div>
  @endif

    <div class="box-body">
      @if(Auth::User()->id_division == 'FINANCE')
        <div class="nav-tabs-custom" style="padding: 25px">
        <ul class="nav nav-tabs">
          <li>
            <a href="#tab_2" data-toggle="tab">MSP</a>
          </li>
        </ul>
        <div class="tab-content">

          <div class="tab-pane" id="tab_2">
            <div class="table-responsive">
              <table class="table table-bordered table-striped display nowrap dataTable" id="msp-data" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>ID Project</th>
                    <th>Lead ID</th>
                    <th>NO. PO Customer</th>
                    <th>Customer Name</th>
                    <th>Project Name</th>
                    <th>Note</th>
                    <th>Invoice</th>
                    <th>Sales</th>
                  </tr>
                </thead>
                <tbody id="products-list" name="products-list">
                  @foreach($salesmsp as $data)
                  <tr>
                    <td>{{$data->date}}</td>
                    <td>{{$data->id_project}}</td>
                    <td>{{$data->lead_id}}</td>
                    <td>
                        @if($data->lead_id == "MSPPO")
                        {{$data->no_po_customer}}
                        @else
                        {{$data->no_po}}
                        @endif
                    </td>
                    <td>
                        @if($data->lead_id == "MSPQUO")
                        {{$data->no_po_customer}}
                        @else
                        {{$data->quote_number}}
                        @endif
                    </td>
                    <td>
                        @if($data->lead_id == 'MSPQUO' || $data->lead_id == 'MSPPO')
                        {{$data->customer_name}}
                        @else
                        {{$data->customer_legal_name}}
                        @endif
                    </td>
                    <td>
                        @if($data->lead_id == 'MSPQUO' || $data->lead_id == 'MSPPO')
                        {{$data->name_project}}
                        @else
                        {{$data->opp_name}}
                        @endif
                    </td>
                    <td>{{$data->note}}</td>
                    <td>
                      @if($data->invoice == 'H')
                        Setengah Bayar
                      @elseif($data->invoice == 'F')
                        Sudah Bayar
                      @elseif($data->invoice == 'N')
                        Belum Bayar
                      @endif
                    </td>
                    <td>{{$data->name}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        </div>
      @elseif(Auth::User()->id_division != 'FINANCE')
        <div class="nav-tabs-custom" style="padding: 25px">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">ID Project</a></li>
            <!-- <li><a href="#tab_2" data-toggle="tab">Request ID</a></li> -->
            </ul>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
              @if(Auth::User()->id_company == '1')
                <div class="table-responsive">
                  <table class="table table-bordered table-striped display nowrap dataTable" id="sip-prj" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>ID Project</th>
                        <th>Lead ID</th>
                        <th>NO. PO Customer</th>
                        <th>Customer Name</th>
                        <th>Project Name</th>
                        <th>Note</th>
                        <th>Sales</th>
                      </tr>
                    </thead>
                    <tbody id="products-list" name="products-list">
                      @foreach($salessp as $data)
                      <tr>
                        <td>{{$data->date}}</td>
                        <td>{{$data->id_project}}</td>
                        <td>{{$data->lead_id}}</td>
                        <td>
                        @if($data->lead_id == "MSPPO")
                        {{$data->no_po_customer}}
                        @else
                        {{$data->no_po}}
                        @endif
                      </td>
                      <td>
                        @if($data->lead_id == "MSPQUO")
                        {{$data->no_po_customer}}
                        @else
                        {{$data->quote_number}}
                        @endif
                      </td>
                      <td>
                        @if($data->lead_id == 'MSPQUO' || $data->lead_id == 'MSPPO')
                        {{$data->customer_name}}
                        @else
                        {{$data->customer_legal_name}}
                        @endif
                      </td>
                      <td>
                        @if($data->lead_id == 'MSPQUO' || $data->lead_id == 'MSPPO')
                        {{$data->name_project}}
                        @else
                        {{$data->opp_name}}
                        @endif
                      </td>
                        <td>{{$data->note}}</td>
                        <td>
                          @if($data->lead_id == 'MSPQUO')
                          {{$data->sales_name}}
                          @else
                          {{$data->name}}
                          @endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @elseif(Auth::User()->id_company == '2')
                <div class="table-responsive">
                  <table class="table table-bordered table-striped display nowrap dataTable" id="msp-prj" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>ID Project</th>
                        <th>Lead ID</th>
                        <th>NO. PO Customer</th>
                        <th>Quotation</th>
                        <th>Customer Name</th>
                        <th>Project Name</th>
                        <th>Note</th>
                        <th>Sales</th>
                        @if(Auth::User()->email == 'fuad@solusindoperkasa.co.id')
                        <th>Action</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody id="products-list" name="products-list">
                      @foreach($salesmsp as $data)
                      <tr>
                        <td>{{$data->date}}</td>
                        <td>{{$data->id_project}}</td>
                        <td>{{$data->lead_id}}</td>
                        <td>
                        @if($data->lead_id == "MSPPO")
                        {{$data->no_po_customer}}
                        @else
                        {{$data->no_po}}
                        @endif
                        
                        </td>
                        <td>
                          @if($data->lead_id == "MSPQUO")
                          {{$data->no_po_customer}}
                          @else
                          {{$data->quote_number}}
                          @endif
                        </td>
                        <td>
                          @if($data->lead_id == 'MSPQUO' || $data->lead_id == 'MSPPO')
                          {{$data->customer_name}}
                          @else
                          {{$data->customer_legal_name}}
                          @endif
                        </td>
                        <td>
                          @if($data->lead_id == 'MSPQUO' || $data->lead_id == 'MSPPO')
                          {{$data->name_project}}
                          @else
                          {{$data->opp_name}}
                          @endif
                        </td>
                        <td>{{$data->note}}</td>
                        <td>
                          @if($data->lead_id == 'MSPQUO' || $data->lead_id == 'MSPPO')
                          {{$data->sales_name}}
                          @else
                          {{$data->name}}
                          @endif
                        </td>
                        @if(Auth::User()->email == 'fuad@solusindoperkasa.co.id')
                        <td>
                          @if($data->id_customer == '33' || $data->lead_id == 'MSPQUO')
                          <button class="btn btn-xs btn-success" style="width:35px;height:30px;border-radius: 25px!important;outline: none;" id="details_id_pro" value="{{$data->id_pro}}"><i class="fa fa-edit" data-toggle="tooltip" title="Tambah PO" data-placement="bottom"></i></button>   
                          @else
                          <button class="btn btn-xs btn-success" style="width:35px;height:30px;border-radius: 25px!important;outline: none;" disabled><i class="fa fa-edit" data-toggle="tooltip" data-placement="bottom"></i></button>
                          @endif                       
                        </td>
                        @endif
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
            </div>
            <div class="tab-pane" id="tab_2">
              <div class="row">
                <div class="col-md-12">
   
                  <button class="btn btn-success pull-right" data-target="#requestProjectID" data-toggle="modal" >
                    Add
                  </button>
                </div>
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped display nowrap dataTable" id="requestProjectID-table" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Created</th>
                          <th>Project</th>
                          <th>Quote No.</th>
                          <th>Sales</th>
                          <th>Date</th>
                          @if(Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'SALES' && Auth::User()->id_position != 'ADMIN'|| Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_division == 'FINANCE' && Auth::User()->id_position != 'STAFF')
                          <th>Amount</th>
                          @endif
                          <th>Note</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($pid_request as $pid)
                          <tr>
                            <td>{{$pid->created_at}}</td>
                            <td>{{$pid->project}}</td>
                            <td>{{$pid->quote_number}}</td>
                            <td>{{$pid->name}}</td>
                            <td>{{$pid->date}}</td>
                            <td>
                            @if(Auth::User()->name == $pid->name)
                            <i class="money">
                              {{$pid->amount}}
                            </i>
                            @else
                            @endif
                            </td>
                            <td>{{$pid->note}}</td>
                            <td>
                              @if($pid->status == "done")
                                <small class="label label-success"> Done</small>
                              @else
                                <small class="label label-danger"> Requested</small>
                              @endif
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif

    </div>
  </div>

<div class="modal fade" id="modal_tambah_po" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add PO</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{url('store_po')}}" id="modal_update" name="modalProgress">
        @csrf
        <input type="text" name="id_pro" id="id_pro" hidden>
        <input type="text" name="id_pid" id="id_pid" hidden>
        <div class="form-group">
          <label for="">Id Project</label>
          <input type="text" id="inputProjectId" class="form-control" readonly>
        </div>
        <div class="form-group">
          <label for="">Project Name</label>
          <input type="text" id="inputProjectName" class="form-control" readonly>
        </div>
        <div class="form-group">
          <label for="">No PO</label>
          <input type="text" placeholder="Enter Note" name="inputNoPo" id="inputNoPo" class="form-control">
        </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times">&nbsp</i>Close</button>
        <button class="btn btn-primary-custom" ><i class="fa fa-check">&nbsp</i>Submit</button>
      </div>
      </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="requestProjectID" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Request Project ID</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="">Quote No.</label>
          <select class="form-control select2" style="width: 100%" id="inputQuo">
            <option>Select Quote</option>
            @foreach($quote_number as $quote)
              <option value="{{$quote->id_quote}}">{{$quote->quote_number}} - {{$quote->project}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="">Project</label>
          <input type="text" id="inputProject" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="">Customer</label>
          <input type="text" id="inputCustomer" class="form-control" required>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="">Sales</label>
              <input type="text" id="inputSales" class="form-control" required>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="">Date Quote</label>
              <input type="date" id="inputDate" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="form-group  modalIcon inputIconBg">
          <label for="">Amount</label>
          <input type="text" class="form-control money" placeholder="Enter Amount" name="amount" id="inputAmount" required>
          <i class="" aria-hidden="true" style="margin-bottom: 24px">Rp.</i>
        </div>
        <div class="form-group">
          <label for="">Note</label>
          <input type="text" placeholder="Enter Note" name="note" id="inputNote" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal">
          <i class=" fa fa-times">&nbsp</i>Close
        </button>
        <button class="btn btn-primary-custom" onclick="submitRequestID()" >
          <i class="fa fa-check">&nbsp</i>Submit
        </button>
      </div>
    </div>
  </div>
</div>

  <!--add project SIP-->

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
                <!-- <input list="browsers" name="customer_name" id="customer_name" class="form-control">
                
                <datalist id="browsers">
                </datalist> -->
                <select name="customer_name" id="customer_name" style="width: 100%;" class="form-control">
                  <option>-- Select Lead ID --</option>
                  @foreach($lead_sp as $data)
                  <option value="{{$data->lead_id}}">
                  @if($data->pid == NULL)
                  <b>{{$data->lead_id}}</b> &nbsp {{$data->opp_name}}
                    @else
                  ( {{$data->pid}} )&nbsp<b>{{$data->lead_id}}</b> &nbsp {{$data->opp_name}}
                  @endif
                  </option>
                  @endforeach
                </select>
                
              <!-- <input type="text" id="customer_name" name="customer_name" class="form-control" readonly> -->
            </div>

            <div class="form-group" hidden>
              <label for="">Sales</label>
              <input type="text" name="sales" id="sales" class="form-control" readonly>
            </div>

            <div class="form-group  modalIcon inputIconBg">
              <label for="">Amount</label>
              <input type="text" class="form-control money" placeholder="Enter Amount" name="amount" id="amount" required>
              <i class="" aria-hidden="true" style="margin-bottom: 24px">Rp.</i>
            </div>

            <div class="form-group">
              <label for="">Note</label>
              <input type="text" placeholder="Enter Note" name="note" id="note" class="form-control">
            </div>
     
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
                <button type="submit" class="btn btn-primary-custom" ><i class="fa fa-check">&nbsp</i>Submit</button>
              </div>
          </form>
          </div>
        </div>
      </div>
</div>

<!--add project MSP-->
<div class="modal fade" id="salesprojectmsp" role="dialog">
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
                <!-- <input list="browsers" name="customer_name" id="customer_name" class="form-control">
                
                <datalist id="browsers">
                </datalist> -->
                <select name="customer_name" id="contact_msp" style="width: 100%" class="form-control">
                  <option>-- Select Lead ID --</option>
                  @foreach($lead_msp as $data)
                  <option value="{{$data->lead_id}}">
                  @if($data->pid == NULL)
                  <b>{{$data->lead_id}}</b> &nbsp {{$data->opp_name}}
                  @else
                  ( {{$data->pid}} )&nbsp<b>{{$data->lead_id}}</b> &nbsp {{$data->opp_name}}
                  @endif
                  </option>
                  @endforeach
                </select>
                
              <!-- <input type="text" id="customer_name" name="customer_name" class="form-control" readonly> -->
            </div>

            <div class="form-group" hidden>
              <label for="">Sales</label>
              <input type="text" name="sales" id="sales" class="form-control" readonly>
            </div>

            <div class="form-group  modalIcon inputIconBg">
              <label for="">Amount</label>
              <input type="text" class="form-control money" placeholder="Enter Amount" name="amount" id="amount" required>
              <i class="" aria-hidden="true" style="margin-bottom: 24px">Rp.</i>
            </div>

            <div class="form-group">
              <label for="">Note</label>
              <input type="text" placeholder="Enter Note" name="note" id="note" class="form-control">
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

<div class="modal fade" id="modal_add_idpro" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add ID Project</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{url('add_idpro_manual')}}">
          @csrf
        <div class="form-group">
          <label for="">Date</label>
          <input type="date" name="date_manual" id="date_manual" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="">Lead ID</label>
            <select name="lead_id_manual" id="lead_id_manual" style="width: 100%" class="form-control">
              <option>-- Select Lead ID --</option>
              @foreach($lead_msp as $data)
              <option value="{{$data->lead_id}}">
              @if($data->pid == NULL)
              <b>{{$data->lead_id}}</b> &nbsp {{$data->opp_name}}
              @else
              ( {{$data->pid}} )&nbsp<b>{{$data->lead_id}}</b> &nbsp {{$data->opp_name}}
              @endif
              </option>
              @endforeach
            </select>
        </div>

        <div class="form-group">
          <label for="">ID Project</label>
          <input type="idpro_manual" name="idpro_manual" id="idpro_manual" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="">No. PO Customer</label>
          <input type="text" name="po_customer_manual" id="po_customer_manual" class="form-control">
        </div>

        <div class="form-group">
          <label for="">Note</label>
          <input type="text" placeholder="Enter Note" name="note_manual" id="note_manual" class="form-control">
        </div>

        {{-- <div class="form-group">
          <label>Kontrak Payung</label>
          <div class="form-group margin-top">
            <label>Check this checkbox for YA</label>
            <input type="checkbox" style="margin-left: 20px" name="payungs" id="payungs" value="SP">
          </div>
        </div> --}}
 
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
            <button type="submit" class="btn btn-primary-custom"><i class="fa fa-check">&nbsp</i>Submit</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</div>

<!--edit project-->
<div class="modal fade" id="edit_salessp" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Project</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('update_sp')}}">
            @csrf
          <input type="" name="id_project_edit" id="id_project_edit" hidden>
          <div class="form-group">
            <label for="">No. PO Customer</label>
            <input type="text" name="po_customer_edit" id="po_customer_edit" class="form-control" @if(Auth::User()->id_position == 'STAFF') readonly @endif>
          </div>

          <div class="form-group">
            <label for="">Project Name</label>
            <input type="text" name="name_project_edit" id="name_project_edit" class="form-control" @if(Auth::User()->id_position == 'STAFF') readonly @endif>
          </div>

          @if(Auth::User()->id_position == 'MANAGER')
          <div class="form-group  modalIcon inputIconBg">
            <label for="">Amount</label>
            <input type="text" class="form-control money" placeholder="Enter Amount" name="amount_edit" id="amount_edit" required>
            <i class="" aria-hidden="true" style="margin-bottom: 24px">Rp.</i>
          </div>
          @endif

          <div class="form-group">
            <label for="">Note</label>
            <input type="text" placeholder="Enter Note" name="note_edit" id="note_edit" class="form-control">
          </div>

          <div class="form-group">
            <label for="">Invoice info</label><br>
            <label class="radios">Sudah Bayar
        <input type="radio" name="invoice" id="invoice_edit_f" value="F">
        <span class="checkmark"></span>
      </label>
      <label class="radios">Setengah Bayar
        <input type="radio" name="invoice" id="invoice_edit_h" value="H">
        <span class="checkmark"></span>
      </label>
      <label class="radios">Belum Bayar
        <input type="radio" name="invoice" id="invoice_edit_n" value="N">
        <span class="checkmark"></span>
      </label>
          </div>


          <!-- <div class="form-group modalIcon inputIconBg">
            <label for="">Kurs To Dollar</label>
            <input type="text" class="form-control" readonly placeholder="Kurs" name="kurs_edit" id="kurs_edit">
            <i class="" aria-hidden="true">&nbsp$&nbsp </i>
          </div>   -->     
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-warning"><i class="fa fa-check">&nbsp</i>Edit</button>
            </div>
        </form>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modal_delete" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form action="{{url('delete_project')}}" method="GET">
            {!! csrf_field() !!}
            <input type="text"  name="id_pro" id="id_pro" hidden>
            <input type="text"  name="lead_id" id="id_delete_pro" hidden>
            <div style="text-align: center;">
              <h3>Are you sure?</h3><br><h3>Delete</h3>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><b>Close</b></button>
            <button class="btn btn-sm btn-success-raise" type="submit"><b>Yes</b></button>
          </div>
          </form>
        </div>
      </div>
    </div>
</div>

</section>

@endsection

@section('script')
  <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/dataTables.fixedColumns.min.js')}}"></script>
  <script type="text/javascript">

  function submitRequestID(){
    $.ajax({
      type:"GET",
      url:"{{url('/salesproject/saveRequestID')}}",
      data:{
        quote:$("#inputQuo").val(),
        date:$("#inputDate").val(),
        amount:$("#inputAmount").val(),
        note:$("#inputNote").val(),
      },
      success:function(result){
        location.reload()
        $("#requestProjectID").modal('toggle')
      }
    })
    // console.log($("#inputQuo").val())
    // console.log($("#inputDate").val())
    // console.log($("#inputAmount").val())
    // console.log($("#inputNote").val())
  }

  $(document).on('click',"#details_id_pro",function(e) { 
      console.log(this.value);
      $.ajax({
          type:"GET",
          url:"{{url('getIdProject')}}",
          data:{
            id_project:this.value,
          },
          success: function(result){
            $('#id_pro').val(result[0].id_pro);
            $('#id_pid').val(result[0].id_pid);
            $('#inputProjectId').val(result[0].id_project);
            $('#inputProjectName').val(result[0].name_project);
            $('#inputNoPo').val(result[0].no_po);
          },
      });

      $('#modal_tambah_po').modal('show')
  });

     $('.money').mask('000,000,000,000,000,000', {reverse: true});

     $('#sip-data').DataTable({
        "scrollX": true,
        "retrieve": true,
        "order": [[ 1, "desc" ]],
        fixedColumns:   {
          leftColumns: 2
        },
      });

     $('#sip-prj').DataTable({
        "scrollX": true,
        "retrieve": true,
        "order": [[ 1, "desc" ]],
        fixedColumns:   {
          leftColumns: 2
        },
      });

     $('#requestProjectID-table').DataTable({
        "scrollX": true,
        "retrieve": true,
      });

     $('#msp-data').DataTable({
      "order": [[ 1, "desc" ]],
      "scrollX": true,
      "paging": true,
      "retrieve": true,
      });


     $('#msp-prj').DataTable({
        "retrieve": true,
        "order": [[ 1, "desc" ]],
        "scrollX": true,
        fixedColumns:   {
        leftColumns: 2
      },
      });
    /* $(document).ready(function() {
        $('#customer_name').select2();
      });*/
        @if(Auth::User()->id_position == 'STAFF')
        function Edit_sp(id_project,no_po_customer,name_project,note,invoice)
        {
          $('#id_project_edit').val(id_project);
          $('#po_customer_edit').val(no_po_customer);
          $('#name_project_edit').val(name_project);
          $('#note_edit').val(note);
          if (invoice == 'H') {
            $('#invoice_edit_h').prop('checked', true);
          }
          else if (invoice == 'F') {
            $('#invoice_edit_f').prop('checked', true);
          }else if (invoice == 'N') {
            $('#invoice_edit_n').prop('checked', true);
          }
        }
        @else
        function Edit_sp(id_project,no_po_customer,name_project,amount_idr,note,invoice)
        {
          $('#id_project_edit').val(id_project);
          $('#po_customer_edit').val(no_po_customer);
          $('#name_project_edit').val(name_project);
          $('#amount_edit').val(amount_idr);
          $('#note_edit').val(note);
          if (invoice == 'H') {
            $('#invoice_edit_h').prop('checked', true);
          }
          else if (invoice == 'F') {
            $('#invoice_edit_f').prop('checked', true);
          }else if (invoice == 'N') {
            $('#invoice_edit_n').prop('checked', true);
          }
        }
        @endif

      function delete_project(lead_id,id_pro)
      {
        $('#id_pro').val(lead_id);
        $('#id_delete_pro').val(id_pro);
      }

      $('#customer_name').select2();
      $('#contact_msp').select2();
      $('#inputQuo').select2();
      // $('#inputQuo').select2();
      $('#inputQuo').on('select2:select', function (e) {
        var data = e.params.data;
        // console.log(data.id);
        $.ajax({
          type:"GET",
          url:"{{url('/salesproject/getQuoteDetail')}}",
          data:{
            id:data.id
          },
          success: function(result){
            $("#inputProject").val(result.project)
            $("#inputCustomer").val(result.to)
            $("#inputSales").val(result.name)
            $("#inputDate").val(result.date)
            $("#inputAmount").val(result.amount)
          }
        })
      });

      $('#lead_id_manual').select2();

      $("#alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#alert").slideUp(300);
      });

      $(".dismisbar").click(function(){
         $(".notification-bar").slideUp(300);
      }); 
  </script>
@endsection