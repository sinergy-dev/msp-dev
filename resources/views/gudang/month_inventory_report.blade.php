@extends('template.template_admin-lte')
@section('content')

<section class="content-header">
    <h1>
        Inventory Report Per Bulan
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Inventory Report</li>
        <li class="active">Per Bulan</li>
    </ol>
</section>

<section class="content">

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><b>In</b>&nbsp;</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        
        <div class="box-body">
            <form action="" method="get" class="margin-bottom">
                <div class="row">
                    <div class="col-md-2">
                        <input type="text" id="startdate" class="form-control" placeholder="DD/MM/YYYY">
                    </div>
                    <div>
                        <p class="pull-right" style="margin-top: 5px">&nbspto&nbsp</p>
                    </div>
                    <div class="col-md-2">
                        <input type="text" id="enddate" class="form-control" placeholder="DD/MM/YYYY" disabled>
                    </div>
                    <div class="col-md-2">
                        <input type="button" name="filter_submit" id="filter_submit" value="Filter" class="btn btn-primary" onclick="enableBtnSubmit()" disabled>
                    </div>
                    <button class="btn btn-xs btn-warning float-right margin-left-custom" type="button" id="btnSubmit" onclick="exportPdf()" disabled><i class="fa fa-cloud-download"></i>&nbsp&nbspExport PDF</button>
                    <button class="btn btn-xs btn-success float-right margin-left-custom" type="button" id="btnSubmitExcel" onclick="exportExcel()" disabled><i class="fa fa-cloud-download"></i>&nbsp&nbspExport Excel</button>
                </div>
            </form>
            <table class="table table-bordered table-striped" id="month_report_po" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 100px"><center>MSP Code</center></th>
                        <th><center>Nama Barang</center></th>
                        <th style="width: 100px"><center>Qty</center></th>
                        {{--  <th style="width: 150px"><center>Date</center></th>  --}}
                    </tr>
                </thead>
                <tbody id="report_po" name="report_po">
                    @foreach($po as $data)
                    <tr>
                        <td>{{ $data->kode_barang }}</td>
                        <td>{{ $data->nama }}</td>
                        <td> +{{ $data->qty }} {{ $data->unit }}</td>
                        {{--  <td>{{ $data->created_at }}</td>  --}}
                    </tr>
                    @endforeach
                </tbody>
                {{--  <tbody id="report_po_stock" name="report_po_stock">
                    @foreach($po2 as $data)
                    <tr>
                        <td>{{ $data->kode_barang }}</td>
                        <td>{{ $data->name_product }}</td>
                        <td style="width: 100px"> +{{ $data->qty_terima }} {{ $data->unit }}</td>
                        <td>{{ $data->updated_at }}</td>
                    </tr>
                    @endforeach
                </tbody>  --}}
            </table>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><b>Out</b>&nbsp;</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        
        <div class="box-body">
            <table class="table table-bordered table-striped" id="month_report_do" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        {{-- <th style="width: 100px">ID Project</th> --}}
                        <th style="width: 100px"><center>MSP Code</center></th>
                        <th><center>Nama Barang</center></th>
                        <th style="width: 100px"><center>Qty</center></th>
                        {{--  <th style="width: 150px"><center>Date</center></th>  --}}
                    </tr>
                </thead>
                <tbody id="report_do" name="report_do">
                    @foreach($do as $data)
                    <tr>
                        {{-- <td>{{ $data->id_project }}</td> --}}
                        <td>{{ $data->kode_barang }}</td>
                        <td>{{ $data->nama }}</td>
                        <td> -{{$data->qty_transac}} {{ $data->unit }}</td>
                        {{--  <td>{{ $data->updated_at }}</td>  --}}
                    </tr>
                    @endforeach
                </tbody>
                {{--  <tfoot>
                    <tr>
                        <td></td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>  --}}
            </table>
        </div>
    </div>

</section>

@endsection

@section('script')
<script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.fixedColumns.min.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{asset('template2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

<script type="text/javascript">

    $("#startdate").on('change',function(){
        $("#enddate").attr('disabled',false)
        
        $("#enddate").on('change',function(){
            $("#filter_submit").attr('disabled',false)
        });
    });

    function enableBtnSubmit() {
        $("#btnSubmit").attr('disabled',false)
        $("#btnSubmitExcel").attr('disabled',false)
    }

    var url = {!! json_encode(url('/')) !!}

    function exportPdf() {
        date_start = encodeURI(moment($("#startdate").datepicker("getDate")).format("YYYY-MM-DD 00:00:00"))
        date_end = encodeURI(moment($("#enddate").datepicker("getDate")).format("YYYY-MM-DD 23:59:59"))
        myUrl = url+"/getDataMonth?start="+date_start+"&end="+date_end
        location.assign(myUrl)
    }

    function exportExcel() {
        date_start = encodeURI(moment($("#startdate").datepicker("getDate")).format("YYYY-MM-DD 00:00:00"))
        date_end = encodeURI(moment($("#enddate").datepicker("getDate")).format("YYYY-MM-DD 23:59:59"))
        myUrl = url+"/getDataMonthExcel?start="+date_start+"&end="+date_end
        location.assign(myUrl)
    }

    $('#startdate').datepicker({
        autoclose: true
    })

    $('#enddate').datepicker({
        autoclose: true
    })  

    $(document).ready(function(){
        $( "#startdate" ).datepicker({
           dateFormat: 'dd-mm-yy',
           onSelect: function(selected) {
              $("#enddate").datepicker("option","10/03/2015", selected);
              enableDisableSubmitBtn();
              }
        });
        $( "#startdate" ).change(function(){
          console.log($( "#startdate" ).datepicker("getDate"));
          console.log(moment($( "#startdate" ).datepicker("getDate")).format("YYYY-MM-DD 00:00:00"));
        });
        $( "#enddate" ).datepicker({
          dateFormat: 'dd-mm-yy' ,
          onSelect: function(selected) {
             $("#startdate").datepicker("option","09/04/2015", selected);
             enableDisableSubmitBtn();
            }
        });
        $( "#enddate" ).change(function(){
          console.log($( "#enddate" ).datepicker("getDate"));
          console.log(moment($( "#enddate" ).datepicker("getDate")).format("YYYY-MM-DD 23:59:59"));
        });

        $('#filter_submit').click(function() {
            var type = this.value;
            console.log(this.value);
                $.ajax({
                  type:"GET",
                  url:"/getdofilter",
                  data:{
                    data:this.value,
                    type:type,
                    start:moment($( "#startdate" ).datepicker("getDate")).format("YYYY-MM-DD 00:00:00"),
                    end:moment($( "#enddate" ).datepicker("getDate")).format("YYYY-MM-DD 23:59:59"),
                  },
                  success: function(result){
                    $('#report_do').empty();
    
                    var table = "";
    
                    $.each(result, function(key, value){
                      table = table + '<tr>';
                      table = table + '<td>' +value.kode_barang+ '</td>';
                      table = table + '<td>' +value.nama+ '</td>';
                      table = table + '<td>-' +value.total_transac+ ' ' + value.unit + '</td>';
                      table = table + '</tr>';
    
                    });
                    $('#report_do').append(table);
                    
                  },
                });

                $.ajax({
                    type:"GET",
                    url:"/getpofilter",
                    data:{
                      data:this.value,
                      type:type,
                      start:moment($( "#startdate" ).datepicker("getDate")).format("YYYY-MM-DD 00:00:00"),
                      end:moment($( "#enddate" ).datepicker("getDate")).format("YYYY-MM-DD 23:59:59")
                    },
                    success: function(result){
                    $('#report_po').empty();

                      var table = "";
      
                      $.each(result, function(key, value){
                        table = table + '<tr>';
                        table = table + '<td>' +value.kode_barang+ '</td>';
                        table = table + '<td>' +value.nama+ '</td>';
                        table = table + '<td>+' + value.total_terima + ' ' + value.unit + '</td>';
                        table = table + '</tr>';
      
                      });
                      $('#report_po').append(table);
                    },
                  });

                {{--  $.ajax({
                    type:"GET",
                    url:"/getpostockfilter",
                    data:{
                      data:this.value,
                      type:type,
                      start:moment($( "#startdate" ).datepicker("getDate")).format("YYYY-MM-DD HH:mm:ss"),
                      end:moment($( "#enddate" ).datepicker("getDate")).format("YYYY-MM-DD HH:mm:ss")
                    },
                    success: function(result){
                    $('#report_po_stock').empty();

                      var table = "";
      
                      $.each(result, function(key, value){
                        table = table + '<tr>';
                        table = table + '<td>' +value.kode_barang+ '</td>';
                        table = table + '<td>' +value.nama+ '</td>';
                        table = table + '<td>+' + value.total_terima + ' ' + value.unit + '</td>';
                        table = table + '<td></td>';
                        table = table + '</tr>';
      
                      });
                      $('#report_po_stock').append(table);
                    },
                  });  --}}
        });

    });

    $(document).ready(function() {
        $('#month_report_do').DataTable({
            "order": [[ 0, "asc" ]],
            initComplete: function () {
                this.api().columns([0]).every( function () {
                var column = this;
                var select = $('<select class="form-control" id="msp_code" name="msp_code"><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
    
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
    
                    column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
                } );
            }
        });

        $('#month_report_po').DataTable({
            "order": [[ 0, "asc" ]],
        });
    });

</script>

@endsection