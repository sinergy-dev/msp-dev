@extends('template.template_admin-lte')
@section('content')

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
          <h3 class="box-title"><b>Product Delivery Order</b>&nbsp;</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            {{-- <button class="btn btn-warning float-right margin-left-custom" id="btnSubmit" disabled onclick="exportPdf()"><i class="fa fa-cloud-download"></i>&nbsp&nbspExport</button> --}}
          </div>
          {{-- <select class="form-control-report" style="margin-left: 20px;" id="dropdown">
              @foreach($dropdown as $data)
                  <option value="{{ $data->id_pro }}">{{ $data->id_project }}</option>
              @endforeach
          </select> --}}

          {{--  <select class="form-control-report float-right margin-left-custom" id="dropdown">
              <option >Select Option</option>
              <option value="id_project">Id Project</option>
              <option value="delivery_order">Delivery Order</option>
          </select>  --}}
          
          {{--  <select class="form-control-report float-right margin-left-custom" id="dropdown2">
          </select>  --}}

          {{-- <input type="text" id="enddate" class="form-control-date pull-right" placeholder="DD/MM/YYYY">
          <p class="pull-right" style="margin-top: 5px">&nbsp&nbspto&nbsp&nbsp</p>
          <input type="text" id="startdate" class="form-control-date pull-right" placeholder="DD/MM/YYYY"> --}}
        </div>

        <div class="box-body">
            <table class="table table-bordered table-striped" id="datado" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        {{--  <th style="width: 10px"><center>No</center></th>  --}}
                        <th style="width: 100px">ID Project</th>
                        <th style="width: 100px"><center>MSP Code</center></th>
                        <th><center>Nama Barang</center></th>
                        <th style="width: 100px"><center>Qty</center></th>
                        <th style="width: 150px"><center>Date</center></th>
                        {{--  <th><center>Invoice</center></th>
                        <th><center>Total</center></th>
                        <th><center>Status Kirim</center></th>  --}}
                    </tr>
                </thead>
                <tbody id="report" name="report">
                  @foreach($po2 as $data)
                    <tr>
                      {{--  <td>{{ $no++ }}</td>  --}}
                      <td>PO Stock</td>
                      <td>{{ $data->kode_barang }}</td>
                      <td>{{ $data->name_product }}</td>
                      <td style="width: 100px"> +{{ $data->qty_terima }} {{ $data->unit }}</td>
                      <td>{{ $data->updated_at }}</td>
                    </tr>
                  @endforeach
                  @foreach($po as $data)
                    <tr>
                      <td>{{ $data->id_project }}</td>
                      <td>{{ $data->kode_barang }}</td>
                      <td>{{ $data->name_product }}</td>
                      <td> +{{ $data->qty_terima }} {{ $data->unit }}</td>
                      <td>{{ $data->updated_at }}</td>
                    </tr>
                  @endforeach
                  @foreach($do as $data)
                    <tr>
                      {{--  <td>{{ $no++ }}</td>  --}}
                      <td>{{ $data->id_project }}</td>
                      <td>{{ $data->kode_barang }}</td>
                      <td>{{ $data->nama }}</td>
                      <td> -{{ number_format($data->qty_transac) }} {{ $data->unit }}</td>
                      <td>{{ $data->updated_at }}</td>
                      {{--  <td><center>-</center></td>
                      <td><center>-</center></td>
                      <td><center>
                          @if($data->status_kirim == '' || $data->status_kirim == 'PM')
                            <label class="status-open">PENDING</label>
                          @elseif($data->status_kirim == 'kirim')
                            <label class="status-sd">DONE</label>
                          @endif
                      </center></td>  --}}
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="2"></th>
                  </tr>
                </tfoot>
            </table>
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
              {{--  <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown" id="btnSubmitPO" disabled><i class="fa fa-cloud-download"></i>&nbsp&nbspExport&nbsp&nbsp<span class="caret"></span></button></button>
              <ul class="dropdown-menu">
                <li><a onclick="exportPdfPO()">PDF</a></li>
              </ul>  --}}
            </div>
          </div>
    
          <div class="box-body">
            <table class="table table-bordered table-striped" id="nopo" width="100%" cellspacing="0">
              <thead>
                  <tr>
                      <th><center>ID Project</center></th>
                      <th style="width: 100px"><center>No.PO</center></th>
                      <th><center>Product Name</center></th>
                      <th style="width: 100px"><center>Qty</center></th>
                      <th>Date</th>
                      {{--  <th><center>No.Invoice</center></th>  --}}
                  </tr>
              </thead>
              <tbody id="report_nopo" name="report_nopo">
              <?php $no = 1; ?>
                @foreach($nopo as $data)
                  <tr>
                    <td>{{ $data->id_project }}</td>
                    <td>{{ $data->no_po }}</td>
                    <td>{{ $data->kode_barang }}</td>
                    <td> +{{ $data->qty_terima }} {{ $data->unit }}</td>
                    <td>{!!substr($data->updated_at,0,10)!!}</td>
                    {{--  <td>{!!nl2br($data->no_invoice)!!}</td>  --}}
                  </tr>
                @endforeach
                @foreach($nopo2 as $data)
                  <tr>
                    <td>PO Stock</td>
                    <td>{{ $data->no_po }}</td>
                    <td>{{ $data->kode_barang }}</td>
                    <td> +{{ $data->qty_terima }} {{ $data->unit }}</td>
                    <td>{!!substr($data->updated_at,0,10)!!}</td>
                    {{--  <td>{!!nl2br($data->no_invoice)!!}</td>  --}}
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <th></th>
                <th></th>
                <th></th>
                <th colspan="2"></th>
              </tfoot>
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
                      <th><center>ID Project</center></th>
                      <th style="width: 100px"><center>No.DO</center></th>
                      <th><center>Product Name</center></th>
                      <th style="width: 100px"><center>Qty</center></th>
                      <th>Date</th>
                  </tr>
              </thead>
              <tbody id="report_nodo" name="report_nodo">
                @foreach($nodo as $data)
                  <tr>
                    <td>{{ $data->id_project }}</td>
                    <td>{{ $data->no_do }}</td>
                    <td>{{ $data->kode_barang }}</td>
                    <td> -{{ number_format($data->qty_transac)}} {{ $data->unit }}</td>
                    <td>{!!substr($data->updated_at,0,10)!!}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <th></th>
                <th></th>
                <th></th>
                <th colspan="2"></th>
              </tfoot>
            </table>
          </div>
        </div>
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

    $('.money').mask('000,000,000,000,000', {reverse: true});

    $(document).ready(function() {
      $('#datado').DataTable( {
        "order": [[ 4, "desc" ]],
        initComplete: function () {
          this.api().columns([[0],[1],[2]]).every( function () {
            var column = this;
            var select = $('<select class="form-control kat_idpro" id="kat_idpro" name="kat_idpro"><option value=""></option></select>')
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
      } );
    } );

    $('#kat_idpro').select2();

    $(document).ready(function() {
      $('#nopo').DataTable( {
        "order": [[ 4, "desc" ]],
        initComplete: function () {
          this.api().columns([[0],[1],[2]]).every( function () {
            var column = this;
            var select = $('<select class="form-control kat_nopo" id="kat_nopo" name="kat_nopo"><option value=""></option></select>')
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
      } );
    } );

    $(document).ready(function() {
      $('#nodo').DataTable( {
        "order": [[ 4, "desc" ]],
        initComplete: function () {
          this.api().columns([[0],[1],[2]]).every( function () {
            var column = this;
            var select = $('<select class="form-control kat_nodo" id="kat_nodo" name="kat_nodo"><option value=""></option></select>')
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
      } );
    } );

    $('#date_penerimaan').datepicker({
      autoclose: true
    })

    var url = {!! json_encode(url('/')) !!}

    function exportPdf() {
      type = encodeURI($("#dropdown").val())
      dropdown2 = encodeURI($("#dropdown2").val())
      myUrl = url+"/getdatadropdown2?type="+type+"&data="+dropdown2
      location.assign(myUrl)
    }

    function exportPdfPO() {
      type = encodeURI($("#dropdown").val())
      dropdown2 = encodeURI($("#dropdown2").val())
      myUrl = url+"/getdatadropdownpo?type="+type+"&data="+dropdown2
      location.assign(myUrl)
    }

    $("#dropdown2").on('change',function(){
      if($(this).find('option:selected').text()=="Select Option")
        $("#btnSubmit").attr('disabled',true)
      else
        $("#btnSubmit").attr('disabled',false)
    });

    $("#dropdown2").on('change',function(){
      if($(this).find('option:selected').text()=="Select Option")
        $("#btnSubmitPO").attr('disabled',true)
      else
        $("#btnSubmitPO").attr('disabled',false)
    });

    $('#dropdown2').select2();

    $('#dropdown').select2();

    $('#dropdown').change(function(){
        console.log(this.value);
        var type = this.value;

        var no = 1;

        {{--  $("#dropdown2").change(function(){
          console.log(this.value);
          $.ajax({
            type:"GET",
            url:"getdatadropdown_po",
            data:{
              data:this.value,
              type:type,
            },
            success: function(result){
              $('#report').empty();
              var table = "";

              $.each(result, function(key, value){

                table = table + '<tr>';
                table = table + '<td>' + no++ + '</td>';
                table = table + '<td>' +value.name_product+ '</td>';
                table = table + '<td>' + '+' +value.qty_terima + ' ' + value.unit + '</td>';
                table = table + '<td><center>' + value.no_invoice + '</center></td>';
                table = table + '<td style="text-align: right;">' + value.total_nominal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'.00' + '</td>';

                if (value.qty == '0') {
                  table = table + '<td><center><label class="status-win">DONE</label></center></td>';
                } else {
                  if (value.status_po == 'NEW') {
                    table = table + '<td><center><label class="status-initial">PENDING</label></center></td>';
                  } else if (value.status_po == 'SAVED') {
                    table = table + '<td><center><label class="status-sd">SAVED</label></center></td>';
                  } else if (value.status_po == 'FINANCE') {
                    table = table + '<td><center><label class="status-tp">FINANCE</label></center></td>';
                  } else if (value.status_po == 'PENDING') {
                    table = table + '<td><center><label class="status-lose">PENDING</label></center></td>';
                  } else if (value.status_po == 'DONE') {
                    table = table + '<td><center><label class="status-win">DONE</label></center></td>';
                  }
                } 

                table = table + '</tr>';

              });

              $('#report').append(table);

            },
          });
        });  --}}

        $("#dropdown2").change(function(){
            console.log(this.value);
            $.ajax({
              type:"GET",
              url:"getdatadropdown_do",
              data:{
                data:this.value,
                type:type,
              },
              success: function(result){
                $('#report').empty();
                var table = "";

                $.each(result, function(key, value){

                  table = table + '<tr>';
                  table = table + '<td>' +value.id_project+ '</td>';
                  table = table + '<td>' +value.kode_barang+ '</td>';
                  table = table + '<td>' +value.nama+ '</td>';
                  table = table + '<td>' + '-' +value.qty_transac + ' ' + value.unit + '</td>';
                  table = table + '<td>' +value.updated_at+ '</td>';
                  {{--  table = table + '<td><center>-</center></td>';
                  table = table + '<td><center>-</center></td>';
                  
                  if (value.status_kirim != 'kirim') {
                    table = table + '<td><center><label class="status-open">PENDING</label></center> </td>';
                  } else if (value.status_kirim == 'kirim') {
                    table = table + '<td><center><label class="status-sd">DONE</label></center> </td>';
                  } 
                  table = table + '</tr>';  --}}

                });

                $('#report').append(table);

              },
            });

            $.ajax({
              type:"GET",
              url:"getdatadropdown_do2",
              data:{
                data:this.value,
                type:type,
              },
              success: function(result){
                var table = "";
  
                $.each(result, function(key, value){
  
                  table = table + '<tr>';
                  table = table + '<td>' +value.id_project+ '</td>';
                  table = table + '<td>' +value.kode_barang+ '</td>';
                  table = table + '<td>' +value.name_product+ '</td>';
                  table = table + '<td>' + '+' +value.qty_terima + ' ' + value.unit + '</td>';
                  table = table + '<td>' +value.updated_at+ '</td>';
                  {{--  table = table + '<td><center>-</center></td>';
                  table = table + '<td><center>-</center></td>';
                  
                  if (value.status_kirim != 'kirim') {
                    table = table + '<td><center><label class="status-open">PENDING</label></center> </td>';
                  } else if (value.status_kirim == 'kirim') {
                    table = table + '<td><center><label class="status-sd">DONE</label></center> </td>';
                  } 
                  table = table + '</tr>';  --}}
  
                });
  
                $('#report').append(table);
  
              },
            });
        });

        $("#dropdown2").change(function(){
          console.log(this.value);
          $.ajax({
            type:"GET",
            url:"nodoo",
            data:{
              data:this.value,
              type:type,
            },
            success: function(result){
              $('#report_nodo').empty();

              var table_nodo = "";
              var no_do = 1;

              $.each(result, function(key, value){

                var str = value.updated_at;
                var date = str.substring(0, 10);

                table_nodo = table_nodo + '<tr>';
                table_nodo = table_nodo + '<td>' + no_do++ + '</td>';
                table_nodo = table_nodo + '<td><center>' +value.no_do+ '</center></td>';
                table_nodo = table_nodo + '<td>' + value.kode_barang + ' - ' + value.nama+ '</td>';
                table_nodo = table_nodo + '<td>' + '-' + value.qty_transac + ' ' + value.unit + '</td>';
                table_nodo = table_nodo + '<td>' + date + '</td>';
                table_nodo = table_nodo + '<td>' + value.id_project + '</td>';
                table_nodo = table_nodo + '</tr>';

              });

              $('#nodo').append(table_nodo);

            },
          });
        });

        $("#dropdown2").change(function(){
          console.log(this.value);
          $.ajax({
            type:"GET",
            url:"nopoo",
            data:{
              data:this.value,
              type:type,
            },
            success: function(result){
              $('#report_nopo').empty();

              var table_nopo = "";
              var no_po = 1;

              $.each(result, function(key, value){

                var str = value.updated_at;
                var date = str.substring(0, 10);

                table_nopo = table_nopo + '<tr>';
                table_nopo = table_nopo + '<td>' + no_po++ + '</td>';
                table_nopo = table_nopo + '<td><center>' + value.no_po + '<input class="form-control hidden" value="'+ value.project_id +'">' + '</center></td>';
                table_nopo = table_nopo + '<td>' + value.kode_barang + ' - ' + value.name_product + '</td>';
                table_nopo = table_nopo + '<td>' + '+' + value.qty_terima + ' ' + value.unit + '</td>';
                table_nopo = table_nopo + '<td>' + date + '</td>';
                table_nopo = table_nopo + '<td>' + value.no_invoice + '</td>';
                table_nopo = table_nopo + '</tr>';

              });

              $('#nopo').append(table_nopo);

            },
          });
        });
        
        $.ajax({
            type:"GET",
            url:"/getdropdownreport",
            data:{
              id_client:this.value,
            },
            success: function(result){

              var append = "";
              $('#dropdown2').html(append)
              var append = "<option selected='selected'>Select Option</option>";

              if (result[1] == 'id_project') {
              $.each(result[0], function(key, value){
                append = append + "<option>" + value.id_project + "</option>";
              });
              } else if (result[1] == 'delivery_order') {
                $.each(result[0], function(key, value){
                append = append + "<option>" + value.no_do + "</option>";
              });
              }
              $('#dropdown2').html(append);
            },
        });

    });

</script>

@endsection