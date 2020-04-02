@extends('template.template_admin-lte')
@section('content')
<style type="text/css">
</style>

<section class="content-header">
    <h1>
        Inventory Report
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Inventory Report</li>
    </ol>
</section>

<section class="content">

    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><b></b>&nbsp;</h3>
          <div class="box-tools pull-left">
            <button class="btn btn-warning float-right margin-left-custom" id="btnSubmit" disabled onclick="exportPdf()" style="width: 100px;"><i class="fa fa-cloud-download"></i>&nbsp&nbspExport Pdf</button> 
            <button class="btn btn-success float-right margin-left-custom" id="btnSubmitExcel" disabled onclick="exportExcel()" style="width: 120px;"><i class="fa fa-cloud-download"></i>&nbsp&nbspExport Excel</button>
          </div>

          <div class="pull-left">
	          <select class="form-control" style="width: 300px" id="dropdown">
	              <option >Select Id Project</option>
	              @foreach($dropdown as $data)
	                <option value="{{ $data->id_pro }}">{{ $data->id_project }}</option>
	              @endforeach
	          </select>
          </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><b>No.PO</b>&nbsp;</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
      
            <div class="box-body">
              <table class="table table-bordered table-striped" id="nopo" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 60px;"><center>No</center></th>
                        <th><center>No.PO</center></th>
                    </tr>
                </thead>
                <tbody id="report_nopo" name="report_nopo">
                  <?php $no = 1; ?>
                  @foreach($no_po as $data)
                    <tr>
                      <td>{{ $no++}}</td>
                      <td>{{ $data->no_po }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><b>No.DO</b>&nbsp;</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
      
            <div class="box-body">
              <table class="table table-bordered table-striped" id="nodo" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 60px;"><center>No</center></th>
                        <th><center>No.DO</center></th>
                    </tr>
                </thead>
                <tbody id="report_nodo" name="report_nodo">
                  <?php $no = 1; ?>
                  @foreach($no_do as $data)
                    <tr>
                      <td>{{ $no++}}</td>
                      <td>{{ $data->no_do }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>

    <div class="row">
	    <div class="col-md-12">
	        <div class="box">
	          <div class="box-header with-border">
	            <h3 class="box-title"><b>Purchase Order</b>&nbsp;</h3>
	            <div class="box-tools pull-right">
	              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	              </button>
	              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	            </div>
	          </div>
	    
		        <div class="box-body">
		            <table class="table table-bordered table-striped" id="po" width="100%" cellspacing="0">
		              <thead>
		                  <tr>
	                        <th style="width: 80px;"><center>MSP Code</center></th>
		                      <th><center>Product Name</center></th>
		                      <th style="width: 100px"><center>Qty</center></th>
		                  </tr>
		              </thead>
		              <tbody id="report_po" name="report_po">
		              <?php $no = 1; ?>
		                @foreach($poo as $data)
		                  <tr>
	                      <td>{{ $data->msp_code }}</td>
		                    <td>{{ $data->name_product }}</td>
		                    <td> +{{ $data->qty_terima }} {{ $data->unit }}</td>
		                  </tr>
		                @endforeach
		              </tbody>
		            </table>
		        </div>
	        </div>
	    </div>

	      <div class="col-md-12">
	        <div class="box">
	          <div class="box-header with-border">
	            <h3 class="box-title"><b>Delivery Order</b>&nbsp;</h3>
	            <div class="box-tools pull-right">
	              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	              </button>
	              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	            </div>
	          </div>
	    
	          <div class="box-body">
	            <table class="table table-bordered table-striped" id="do" width="100%" cellspacing="0">
	              <thead>
	                  <tr>
                        <th style="width: 80px;"><center>MSP Code</center></th>
	                      <th><center>Product Name</center></th>
	                      <th style="width: 100px"><center>Qty</center></th>
	                  </tr>
	              </thead>
	              <tbody id="report_do" name="report_do">
	                @foreach($doo as $data)
	                  <tr>
                      <td>{{ $data->kode_barang }}</td>
	                    <td>{{ $data->nama }}</td>
	                    <td>-{{ number_format($data->qty_transac)}} {{ $data->unit }}</td>
	                  </tr>
	                @endforeach
	              </tbody>
	            </table>
	          </div>
	        </div>
	      </div>
	</div>


</section>

@endsection

@section('script')
<!-- <script type="text/javascript" src="{{asset('js/jquery.mask.maskin.js')}}"></script> -->
<script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.fixedColumns.min.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{asset('template2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

<script type="text/javascript">

	$('#nopo').dataTable({});
	$('#nodo').dataTable({});
    $('#po').dataTable({});
    $('#do').dataTable({});

	$('#enddate').datepicker({
      autoclose: true
    })

    $('#startdate').datepicker({
      autoclose: true
    })

    $("#dropdown").on('change',function(){
     if($(this).find('option:selected').text()=="Select Id Project")
         $("#btnSubmit").attr('disabled',true)
     else
         $("#btnSubmit").attr('disabled',false)
     	 $("#btnSubmitExcel").attr('disabled',false)
    });
    var enableDisableSubmitBtn = function(){
     var disableBtn =  startVal.length == 0 ||  endVal.length == 0;
     $('#dropdown').attr('disabled',disableBtn);
    }

    var url = {!! json_encode(url('/')) !!}

    function exportPdf() {
      type = encodeURI($("#dropdown").val())
      myUrl = url+"/getdataidpropdf?type="+type
      location.assign(myUrl)
    }

    function exportExcel() {
      type = encodeURI($("#dropdown").val())
      myUrl = url+"/getdataidproexcel?type="+type
      location.assign(myUrl)
    }

    $('#dropdown2').select2();

    $('#dropdown').select2();

    $("#dropdown").change(function(){
      console.log(this.value);
      var type = this.value;
      $.ajax({
        type:"GET",
        url:"getdataidpro",
        data:{
          data:this.value,
          type:type,
        },
        success: function(result){
          $('#report_po').empty();
          var table = "";

          $.each(result, function(key, value){

            table = table + '<tr>';
            table = table + '<td>' + value.kode_barang + '</td>';
            table = table + '<td>' + value.nama + '</td>';
            table = table + '<td>' + value.total_terima + ' ' + value.unit + '</td>';

            table = table + '</tr>';

          });

          $('#report_po').append(table);
        },
      });

      $.ajax({
        type:"GET",
        url:"getdataidpro2",
        data:{
          data:this.value,
          type:type,
        },
        success: function(result){
          $('#report_do').empty();
          var table_do = "";

          $.each(result, function(key, value){

            table_do = table_do + '<tr>';
            table_do = table_do + '<td>' + value.kode_barang + '</td>';
            table_do = table_do + '<td>' + value.nama + '</td>';
            table_do = table_do + '<td>' + value.total_transac + ' ' + value.unit + '</td>';
            table_do = table_do + '</tr>';

          });

          $('#report_do').append(table_do);
        },
      });

      $.ajax({
        type:"GET",
        url:"getnopo",
        data:{
          data:this.value,
          type:type,
        },
        success: function(result){
          $('#report_nopo').empty();
          var table_nopo = "";
          var no_po = 1;

          $.each(result, function(key, value){

            table_nopo = table_nopo + '<tr>';
            table_nopo = table_nopo + '<td>' + no_po++ + '</td>';
            table_nopo = table_nopo + '<td>' + value.no_po + '</td>';
            table_nopo = table_nopo + '</tr>';

          });

          $('#report_nopo').append(table_nopo);
        },
      });

      $.ajax({
        type:"GET",
        url:"getnodo",
        data:{
          data:this.value,
          type:type,
        },
        success: function(result){
          $('#report_nodo').empty();
          var table_nodo = "";
          var no_do = 1;

          $.each(result, function(key, value){

            table_nodo = table_nodo + '<tr>';
            table_nodo = table_nodo + '<td>' + no_do++ + '</td>';
            table_nodo = table_nodo + '<td>' + value.no_do + '</td>';
            table_nodo = table_nodo + '</tr>';

          });

          $('#report_nodo').append(table_nodo);
        },
      });

    });



</script>

@endsection