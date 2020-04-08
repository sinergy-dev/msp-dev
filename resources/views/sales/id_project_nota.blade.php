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
      <div class="nav-tabs-custom" style="padding: 25px">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab">ID Project</a></li>
          <!-- <li><a href="#tab_2" data-toggle="tab">Request ID</a></li> -->
          </ul>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            @if(Auth::User()->id_company == '2')
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
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="products-list" name="products-list">
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                      <td></td>
                      <td>
                      </td>
                      <td>                      
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            @endif
          </div>
        </div>
      </div>

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


</section>

@endsection

@section('script')
  <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/dataTables.fixedColumns.min.js')}}"></script>
  <script type="text/javascript">

  $(document).on('click',"#details_id_pro",function(e) { 
      // console.log(this.value);
      $.ajax({
          type:"GET",
          url:"{{url('/getIdProject')}}",
          data:{
            id_pro:this.value,
          },
          success: function(result){
            $('#id_pro').val(result[0].id_pro);
            $('#id_pid').val(result[0].id_pid);
            $('#inputProjectId').val(result[0].id_project);
            $('#inputProjectName').val(result[0].name_project);
            $('#inputNoPo').val(result[0].no_po_customer);
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

      $('#lead_id_manual').select2();

      $("#alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#alert").slideUp(300);
      });

      $(".dismisbar").click(function(){
         $(".notification-bar").slideUp(300);
      }); 
  </script>
@endsection