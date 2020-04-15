@extends('template.template_admin-lte')
@section('content')

  <section class="content-header">
    <h1>
      Daftar Buku Admin (Quote Number)
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Admin</li>
      <li class="active">Quote Number</li>
    </ol>
  </section>

  <section class="content">
    @if (session('update'))
      <div class="alert alert-warning" id="alert">
          {{ session('update') }}
      </div>
        @endif

        @if (session('success'))
          <div class="alert alert-success notification-bar"><span>Notice : </span> {{ session('success') }}<button type="button" class="dismisbar transparant pull-right"><i class="fa fa-times fa-lg"></i></button><br>Get your Quote Number :<h4> {{$pops->quote_number}}</h4></div>
        @endif

        @if (session('alert'))
      <div class="alert alert-success" id="alert">
          {{ session('alert') }}
      </div>
    @endif

    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><i class="fa fa-table"></i>&nbspQuote Number</h3>
          <div class="pull-right">
            @if(Auth::User()->id_position == 'ADMIN' || Auth::User()->id_division == 'SALES' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL'  || Auth::User()->id_position == 'STAFF GA')
            <button type="button" class="btn btn-success pull-right" style="width: 100px;" data-target="#modalAdd" data-toggle="modal"><i class="fa fa-plus"> </i> &nbspAdd Quote</button>
            @endif
            <a href="{{url('/downloadExcelQuote')}}"><button class="btn btn-warning" style="margin-right: 10px;"><i class="fa fa-print"> &nbsp Excel</i></button></a>
          </div>
      </div>
      <div class="box-body">
        <div class="nav-tabs-custom">
          <!-- <ul class="nav nav-tabs">
            <li class="active"><a href="#all" data-toggle="tab">All</a></li>
            <li><a href="#backdate" data-toggle="tab">Backdate</a></li>
          </ul> -->

          <!-- <div class="tab-content">

            <div class="tab-pane active" id="all">
              <div class="table-responsive">
                <table class="table table-bordered nowrap table-striped dataTable" id="data_all" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Quote Number</th>
                      <th>Position</th>
                      <th>Type of Letter</th>
                      <th>Month</th>
                      <th>Date</th>
                      <th>Customer</th>
                      <th>Attention</th>
                      <th>Title</th>
                      <th>Project</th>
                      <th>Description</th>
                      <th>From</th>
                      <th>Amount</th>
                      <th>Note</th>
                      @if(Auth::User()->id_position == 'ADMIN' || Auth::User()->id_division == 'SALES' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL')
                        <th>Action</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody id="products-list" name="products-list">
                    @foreach($datas as $data)
                    <tr>
                      <td>{{ $data->quote_number }}</td>
                      <td>{{ $data->position }}</td>
                      <td>{{ $data->type_of_letter }}</td>
                      <td>{{ $data->month }}</td>
                      <td>{{ $data->date }}</td>
                      <td>{{ $data->to }}</td>
                      <td>{{ $data->attention }}</td>
                      <td>{{ $data->title }}</td>
                      <td>{{ $data->project }}</td>
                      <td>{{ $data->description }}</td>
                      <td>{{ $data->name }}</td>
                      <td><i class="money">{{ $data->amount }}</i></td>
                      <td>{{ $data->note }}</td>
                      @if(Auth::User()->id_position == 'ADMIN' || Auth::User()->id_division == 'SALES' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL')
                        <td>
                          @if(Auth::User()->nik == $data->nik)
                          <button class="btn btn-xs btn-primary" style="vertical-align: top; width: 60px" data-target="#modalEdit" data-toggle="modal" onclick="quote('{{$data->quote_number}}','{{$data->position}}','{{$data->to}}','{{$data->attention}}','{{$data->title}}','{{$data->project}}')">&nbsp Edit
                          </button>
                          @else
                          <button class="btn btn-xs btn-primary disabled" style="vertical-align: top; width: 60px">&nbsp Edit
                          </button>
                          @endif

                           <a href="{{ url('delete?id_quote='. $data->id_quote) }}"><button class="btn btn-sm btn-danger fa fa-trash fa-lg" style="width: 40px;height: 40px;text-align: center;" onclick="return confirm('Are you sure want to delete this data?')">
                          </button></a>
                        </td>
                      @endif
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

          </div> -->

          <div class="box-body">
            <div class="table-responsive">
                  <table class="table table-bordered table-striped dataTable display nowrap" id="data_all" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Quote Number</th>
                        <th>Position</th>
                        <th>Type of Letter</th>
                        <th>Month</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Attention</th>
                        <th>Title</th>
                        <th>Project</th>
                        <th>Description</th>
                        <th>From</th>
                        <th>Amount</th>
                        <th>Project Type</th>
                        <th>Note</th>
                        @if(Auth::User()->id_position == 'ADMIN' || Auth::User()->id_division == 'SALES' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL')
                          <th>Action</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody id="products-list" name="products-list">
                      @foreach($datas as $data)
                      <tr>
                        <td>{{ $data->quote_number }}</td>
                        <td>{{ $data->position }}</td>
                        <td>{{ $data->type_of_letter }}</td>
                        <td>{{ $data->month }}</td>
                        <td>{{ $data->date }}</td>
                        <td>{{ $data->customer_legal_name }}</td>
                        <td>{{ $data->attention }}</td>
                        <td>{{ $data->title }}</td>
                        <td>{{ $data->project }}</td>
                        <td>{{ $data->description }}</td>
                        <td>{{ $data->name }}</td>
                        <td><i class="money">{{ $data->amount }}</i></td>
                        <td>{{$data->project_type}}</td>
                        <td>{{ $data->note }}</td>
                        @if(Auth::User()->id_position == 'ADMIN' || Auth::User()->id_division == 'SALES' || Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL')
                          <td>
                            @if(Auth::User()->nik == $data->nik)
                            <button class="btn btn-xs btn-primary" style="vertical-align: top; width: 60px" data-target="#modalEdit" data-toggle="modal" onclick="quote('{{$data->quote_number}}','{{$data->position}}','{{$data->to}}','{{$data->attention}}','{{$data->title}}','{{$data->project}}','{{$data->description}}', '{{$data->note}}')">&nbsp Edit
                            </button>
                            @else
                            <button class="btn btn-xs btn-primary disabled" style="vertical-align: top; width: 60px">&nbsp Edit
                            </button>
                            @endif
                            </button></a>
                          </td>
                        @endif
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            </div>
           </div>
        </div>
      </div>
    </div>

       <!--MODAL ADD-->  
<div class="modal fade" id="modalAdd" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content modal-md">
          <div class="modal-header">
            <h4 class="modal-title">Add Quote</h4>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{url('/quote/store')}}" id="modalAddQuote" name="modalAddQuote">
              @csrf        
              <!-- <div class="form-group">
                  <label>Date</label>
                  <input type="date" class="form-control" id="date" name="date" required>
              </div> -->

              <div class="form-group">
                <label for="">Date</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right date" name="date" id="date">
                </div>
              </div>

              <div class="form-group">
                <label>Customer</label>
                <select id="to" name="to" required style="width: 100%">
                @foreach($customer as $data)
                  <option value="{{$data->id_customer}}">{{$data->customer_legal_name}}</option>
                @endforeach
                </select>
              </div>

              <div class="form-group">
                  <label>Attention</label>
                  <input class="form-control" placeholder="Enter Attention" id="attention" name="attention" >
              </div>

              <div class="form-group">
                  <label>Title</label>
                  <input class="form-control" placeholder="Enter Title" id="title" name="title" >
              </div>

              <div class="form-group">
                  <label>Project</label>
                  <input class="form-control" placeholder="Enter Project" id="project" name="project" >
              </div>         
              <div class="form-group">
                  <label for="">Description</label>
                  <textarea class="form-control" id="description" name="description" placeholder="Enter Description"></textarea>
              </div>
              <div class="form-group  modalIcon inputIconBg">
                <label for="">Amount</label>
                <input type="text" class="form-control money" placeholder="Enter Amount" name="amount" id="amount" required>
                <i class="" aria-hidden="true">Rp.</i>
              </div>
              <div class="form-group">
                <label>Project Type</label>
                <select class="form-control" id="project_type" name="project_type" required style="width: 100%">
                  <option>--Choose Project Type--</option>
                  <option value="Supply Only">Supply Only</option>
                  <option value="Maintenance">Maintenance</option>
                  <option value="Implementation">Implementation</option>
                  <option value="Managed-Services">Managed-Services</option>
                  <option value="Services">Services</option>
                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
              </div>
          </form>
          </div>
        </div>
      </div>
</div>

<!-- BACKDATE -->
<!-- <div class="modal fade" id="letter_backdate" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Add Quote (Backdate)</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/store_quotebackdate')}}" id="quote_backdate" name="quote_backdate">
            @csrf
          <div class="form-group">
            <label for="">Position</label>
            <select type="text" class="form-control" placeholder="Select Position" name="position" id="position" required>
                <option value="TAM">TAM</option>
                <option value="DIR">DIR</option>
                <option value="MSM">MSM</option>
            </select>
          </div>
          <div class="form-group">
            <label for="">Date</label>
            <input type="date" class="form-control" name="date" id="date" required>
          </div>
          <div class="form-group">
            <label for="">To</label>
            <input type="text" class="form-control" placeholder="Enter To" name="to" id="to" required>
          </div> 
          <div class="form-group">
            <label for="">Attention</label>
            <input type="text" class="form-control" placeholder="Enter Attention" name="attention" id="attention">
          </div> 
          <div class="form-group">
            <label for="">Title</label>
            <input type="text" class="form-control" placeholder="Enter Title" name="title" id="title">
          </div>
          <div class="form-group">
            <label for="">Project</label>
            <input type="text" class="form-control" placeholder="Enter Project" name="project" id="project">
          </div>
          <div class="form-group">
            <label for="">Description</label>
            <textarea class="form-control" id="description" name="description" placeholder="Enter Description"></textarea>
          </div>
          <div class="form-group">
            <label for="">Division</label>
            <select type="text" class="form-control" placeholder="Select Division" name="division" id="division" required>
                <option>PMO</option>
                <option>MSM</option>
                <option>Marketing</option>
                <option>TEC</option>
            </select>
          </div>
          <div class="form-group">
            <label for="">Project ID</label>
            <input type="text" class="form-control" placeholder="Enter Project ID" name="project_id" id="project_id">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
          </div>
        </form>
        </div>
      </div>
    </div>
</div> -->

<!--MODAL EDIT-->  
  <div class="modal fade" id="modalEdit" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Edit Quote</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/quote/update')}}" id="modalEditQuote" name="modalQuote">
            @csrf
            <div class="form-group" hidden>
                <label>Quote Number</label>
                <input class="form-control" id="edit_quote_number" name="quote_number">
            </div>
            <div class="form-group">
                <label>To</label>
                <input class="form-control" id="edit_to" placeholder="Enter To" name="edit_to" >
            </div>

            <div class="form-group">
                <label>Attention</label>
                <input class="form-control" id="edit_attention" placeholder="Enter Attention" name="edit_attention" >
            </div>

            <div class="form-group">
                <label>Title</label>
                <input class="form-control" id="edit_title" placeholder="Enter Title" name="edit_title" >
            </div>

            <div class="form-group">
                <label>Project</label>
                <input class="form-control" id="edit_project" name="edit_project" placeholder="Enter Project">
            </div> 
            <div class="form-group">
                  <label for="">Description</label>
                  <textarea class="form-control" id="edit_description" name="edit_description" placeholder="Enter Description"></textarea>
            </div>  
            <div class="form-group">
                <label>Note</label>
                <input class="form-control" id="edit_note" name="edit_note" placeholder="Enter Note">
            </div> 
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-success"><i class="fa fa-check"> </i>&nbspUpdate</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>
    
  </section>

@endsection

@section('script')
  <script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/dataTables.fixedColumns.min.js')}}"></script>
  <script src="{{asset('template2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
  <script type="text/javascript">
    $('.money').mask('000,000,000,000,000', {reverse: true});
    function quote(quote_number,position,to,attention,title,project,description,note) {
      $('#edit_quote_number').val(quote_number);
      $('#edit_position').val(position);
      $('#edit_to').val(to);
      $('#edit_attention').val(attention);
      $('#edit_title').val(title);
      $('#edit_project').val(project);
      $('#edit_description').val(description);
      $('#edit_note').val(note);
    }

    $('#data_all').DataTable( {
        "retrive" : true,
        "scrollX": true,
        "order": [[ 0, "desc" ]],
        fixedColumns:   {
            leftColumns: 1
        },
    });

    $('#data_backdate').DataTable({
      "retrive" : true,
      "autowidth": true,
      "responsive": true,
      "order": [[ 0, "desc" ]],
      fixedColumns:   {
            leftColumns: 1
        },
    });

    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

    $('#date').datepicker({
      autoclose: true,
      startDate: today,
      todayHighlight: true, 
    }).attr('readonly','readonly').css('background-color','#fff');


    $("#to").select2({});

    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
      $("#alert").slideUp(300);
    });

    $(".dismisbar").click(function(){
      $(".notification-bar").slideUp(300);
    }); 

  </script>
@endsection