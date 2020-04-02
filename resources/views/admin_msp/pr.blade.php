@extends('template.template_admin-lte')
@section('content')
<head>
  <!-- <script src="https://www.gstatic.com/firebasejs/7.5.0/firebase-app.js"></script> -->
  <script src="https://www.gstatic.com/firebasejs/6.3.4/firebase.js"></script>
  <link rel="manifest"  href="manifest.json">
</head>

<section class="content-header">
  <h1>
    Purchase Request
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Admin</li>
    <li class="active">Purchase Request</li>
  </ol>
</section>

<section class="content">

  @if (session('update'))
    <div class="alert alert-warning" id="alert">
        {{ session('update') }}
    </div>
  @endif

  @if (session('success'))
    <div class="alert alert-primary" id="alert">
        {{ session('success') }}
    </div>
  @endif

  @if (session('alert'))
    <div class="alert alert-success" id="alert">
        {{ session('alert') }}
    </div>
  @endif

  <div class="box">
    <div class="box-header with-border">
      <div class="pull-right">
        @if(Auth::User()->email == "putri@sinergy.co.id")
        <a href="{{url('/add_pr_msp')}}">
          
        </a>
        <button type="button" class="btn btn-sm btn-success margin-bottom pull-right" data-toggle="modal" data-target="#modal_tipe" style="width: 200px" id=""><i class="fa fa-plus"> </i>&nbsp Number Purchase Request</button>
        @else
        <a href="{{url('/add_pr_msp')}}"><button type="button" class="btn btn-sm btn-success margin-bottom pull-right" style="width: 200px" id=""><i class="fa fa-plus"> </i>&nbsp Number Purchase Request</button></a>
        @endif
        <!-- <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
          <a class="dropdown-item disabled" href="{{url('/downloadPdfESM')}}"> PDF </a> -->
          <a href="{{url('/downloadExcelPr')}}"> <button class="btn btn-sm btn-warning" style="margin-right: 10px;">EXCEL </button></a>
        <!-- </div> -->
      </div>
      <!-- <div class="box-body">
        <form action="{{ url('/import_pr_msp') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="file" name="file" class="form-control">
          <br>
          <button class="btn btn-success pull-left">Import Data</button>
        </form>
      </div> -->
    </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-bordered display no-wrap" id="data_Table" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Month</th>
              <th>Date</th>
              <th>To</th>
              <th>Attention</th>
              <th>Title</th>
              <th>Project</th>
              <th>Description</th>
              <th>From</th>
              <th>Issuance</th>
              <th>Project ID</th>
            </tr>
          </thead>
          <tbody id="products-list" name="products-list">
            <?php $no = 1;?>
            @foreach($datas2 as $data)
            <tr>
              <td>{{$data->no_pr}}</td>
              <td>{{$data->month}}</td>
              <td>{{$data->date}}</td>
              <td>{{$data->to}}</td>
              <td>{{$data->attention}}</td>
              <td>{{$data->title}}</td>
              <td>{{$data->project}}</td>
              <td>{{$data->description}}</td>
              <td>{{$data->name}}</td>
              <td>{{$data->issuance}}</td>
              <td>{{$data->id_project}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!--MODAL ADD PROJECT-->
<div class="modal fade" id="modal_pr" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Add Number Purchase Request</h4>
        </div>
        <div class="modal-body">
          <form id="add_pr" name="add_pr" method="POST" action="{{url('/store_pr_msp')}}">
            @csrf
          <div class="form-group">
            <label>No PR</label>
            <input class="form-control" type="number" name="no_pr" id="no_pr" required>
          </div>
          <div class="form-group">
            <label for="">Date</label>
            <input type="date" class="form-control" name="date" id="date" required>
          </div>
          <div class="form-group">
            <label for="">To</label>
            <input type="text" class="form-control" placeholder="To" name="to" id="to">
          </div> 
          <div class="form-group">
            <label for="">Attention</label>
            <input type="text" class="form-control" placeholder="Enter Attention" name="attention" id="attention">
          </div> 
          <div class="form-group">
            <label for="">Subject</label>
            <input type="text" class="form-control" placeholder="Enter Subject" name="subject" id="subject">
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
            <label for="">Issuance</label>
            <input type="text" class="form-control" placeholder="Enter Issuance" name="issuance" id="issuance">
          </div>
          <div class="form-group">
            <label for="">Project ID</label>
            {{-- <input type="text" class="form-control" placeholder="Enter Project ID" name="id_project" id="id_project"> --}}
            <select class="form-control" id="project_id" name="project_id" style="width: 100%" required>
              <option value="">-- Select ID Project --</option>
              @foreach($id_pro_stock as $stock)
                  <option value="{{$stock->id_pro}}">{{$stock->id_project}}</option>
              @endforeach
              @foreach($id_pro as $data)
                  <option value="{{$data->id_pro}}">{{$data->id_project}}</option>
              @endforeach
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
   <!--          <input type="button" name="add_pr" id="add_pr" class="btn btn-primary-pr btn-sm" value="Submit" /> -->
            <!-- <div class="btn btn-primary btn-sm">
              <span class="fa fa-check"></span>
              <input type="button" class="transparant" value="Submit">
            </div> -->
          </div>
        </form>
        </div>
      </div>
    </div>
</div>


<!--Modal Edit-->
<div class="modal fade" id="modaledit" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Edit Purchase Request</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/update_pr_msp')}}" id="modaledit" name="modaledit">
            @csrf
          <input type="text" class="form-control" placeholder="Enter No PR" name="edit_no_pr" id="edit_no_pr" hidden>
          <div class="form-group"> 
            <label for="">To</label>
            <input type="text" class="form-control" placeholder="Enter To" name="edit_to" id="edit_to" required>
          </div>
          <div class="form-group">
            <label for="">Attention</label>
            <input type="text" class="form-control" placeholder="Enter Attention" name="edit_attention" id="edit_attention" required>
          </div> 
          <div class="form-group">
            <label for="">Title</label>
            <input type="text" class="form-control" placeholder="Enter Title" name="edit_title" id="edit_title" required>
          </div> 
          <div class="form-group">
            <label for="">Project</label>
            <input type="text" class="form-control" placeholder="Enter Project" name="edit_project" id="edit_project" required>
          </div>
          <div class="form-group">
            <label for="">Description</label>
            <textarea type="text" class="form-control" placeholder="Enter Description" name="edit_description" id="edit_description" required> </textarea>
          </div>
          <div class="form-group">
            <label for="">Issuance</label>
            <input type="text" class="form-control" placeholder="Enter Issuance" name="edit_issuance" id="edit_issuance">
          </div>
          <div class="form-group">
            <label for="">Project ID</label>
            <input type="text" class="form-control" placeholder="Enter Project ID" name="edit_project_id" id="edit_project_id">
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

<!--modal tipe-->
<div class="modal fade" id="modal_tipe" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content modal-md">
        <div class="modal-header">
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="">Pilih Tipe PR</label>
            <form method="GET" action="{{url('/add_pr_msp')}}">
              <SELECT class="form-control" id="dropdown_tipe_pr" name="dropdown_tipe_pr">
                <OPTION>-- Select Option --</OPTION>
                <OPTION value="Internal">Internal</OPTION>
                <OPTION value="Eksternal">Eksternal</OPTION>
              </SELECT>
              <input type="" id="input_tipe_pr" name="submit_tipe_pr" hidden>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" id="submit_tipe_pr" value="" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>


<style type="text/css">
    .transparant{
      background-color: Transparent;
      background-repeat:no-repeat;
      border: none;
      cursor:pointer;
      overflow: hidden;
      outline:none;
      width: 50px;
      color: white;
    }

    .btnPR{
      color: #fff;
      background-color: #007bff;
      border-color: #007bff;
      width: 170px;
      padding-top: 4px;
      padding-left: 10px;
    }
 /* This is for the placeholder */


</style>

@endsection

@section('script')
  <script src="{{asset('js/firebase.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript">
    function edit_pr(no,to,attention,title,project,description,from,issuance,id_project) {
      $('#edit_no_pr').val(no);
      $('#edit_to').val(to);
      $('#edit_attention').val(attention);
      $('#edit_title').val(title);
      $('#edit_project').val(project);
      $('#edit_description').val(description);
      $('#edit_from').val(from);
      $('#edit_issuance').val(issuance);
      $('#edit_project_id').val(id_project);
    }

    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
         $("#alert").slideUp(300);
    });

    $('#data_Table').DataTable({
        "order": [[ 2, "desc" ]],
        pageLength:20,
    });

    $('#project_id').select2();

    /*$('#add_pr').click(function(){            
         $.ajax({  
              url:"/store_pr_msp",  
              method:"POST",  
              data:$('#add_pr').serialize(),  
              success:function(data)  
              { 
                swal({
                      title: "Success!",
                      text:  "You have been add number's purchase request",
                      type: "success",
                      timer: 2000,
                      showConfirmButton: false
                  });
                     setTimeout(function() {
                         window.location.href = window.location;
                      }, 3000);                                
              }
         });  
    });*/

    $('#dropdown_tipe_pr').change(function(){
      if ( $('#dropdown_tipe_pr').val() == 'Internal') {
        
        $('#input_tipe_pr').val('Internal');
      }else{
        $('#input_tipe_pr').val('Eksternal');
      }
    });

    $('#submit_tipe_pr').click(function(){
      if ( $('#dropdown_tipe_pr').val() == 'Internal') {
        
        console.log($('#submit_tipe_pr').val());
        location.href = "{{url('/add_pr_msp')}}";
        // alert('Internal');
      }else{
        location.href = "{{url('/add_pr_msp')}}";
        // alert('Eksternal');
      }
    });
  </script>
@endsection