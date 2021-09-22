@extends('template.template_admin-lte')
@section('content')
<style type="text/css">
  input[type=number]::-webkit-inner-spin-button, 
  input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
  }

  .btn-ini span{
    display: block;
    width: 100px;
    height: 30px;
    border-radius: 2px;
    padding-top: 5px;
    text-align: center;
  }
</style>

<section class="content-header">
  <h1>
    MSP Delivery Order
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Delivery Order</li>
    <li class="active">MSP</li>
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

  @if ($message = Session::get('warning'))
    <div class="alert alert-warning notification-bar"><span>warning: </span> {{ $message }}.<button   type="button" class="dismisbar transparant pull-right"><i class="fa fa-times"></i></button></div>
  @endif

  <div class="box">
  	@if(Auth::User()->email == 'dev@sinergy.co.id')
  	<div>
  		<select class="form-control btn-sm btn-default" style="width: 100px">
  			<option>-- Filter By --</option>
  		</select>
  	</div>
  	@endif
    <div class="box-header with-border">
   <!--    <div class="col-md-3">
  		<select class="form-control" id="filter-warehouse" onchange="getFilterWarehouse()" >
	      <option>--Select Filter--</option>
	      <option value="status">Status</option>
	      <option value="customer">Customer</option>
	      <option value="project">Id Project</option>
	    </select>
	  </div>
	  <div class="col-md-3">
	  		<select class="form-control" id="filter-warehouse-child">
		      <option>--Select Filter--</option>
		    </select>
	  </div> -->

      <h3 class="box-title"><i class="fa fa-table"></i>&nbspDelivery Order Table</h3>
      
      @if(Auth::User()->id_position == 'WAREHOUSE')
        <a href="{{url('/return_produk_delivery')}}"><button class="btn btn-sm btn-danger pull-right margin-left" style="width: 110px"><i class="fa fa-plus"> </i>&nbsp Return Barang</button>
        <a href="{{url('/add/project_delivery')}}"><button class="btn btn-sm btn-primary pull-right" style="width: 110px"><i class="fa fa-plus"> </i>&nbsp Delivery Order</button></a>
      @endif
    </div>

    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-bordered display no-wrap" id="data_Table" width="100%" cellspacing="0" style="text-align: center;">
          <thead>
            @if(Auth::User()->id_position == 'ADMIN')
            <tr id="status" style="border-bottom: solid;">
              <th width="5%">Filter by Status</th>
              <th></th>
              <th>Filter by Customer</th>
              <th></th>
              <th>Filter by ID Project</th>
              <th colspan="3"></th>
              <th hidden=""></th>
              @if(Auth::User()->id_position == 'ADMIN')
              @endif
              <th hidden=""></th>
            </tr>
            @endif
            <tr>
              <th style="text-align: center;">No</th>
              <th width="10%" style="text-align: center;">Status</th>
              <th style="text-align: center;">Date</th>
              <th style="text-align: center;">To</th>
              <th style="text-align: center;">Subject</th>
              <th style="text-align: center;">No. DO</th>
              <th hidden=""></th>
              @if(Auth::User()->id_position == 'ADMIN')
              <th style="text-align: center;">PM</th>
              @endif
              <th width="20%" style="text-align: center;">Action</th>
              <th hidden></th>
            </tr>
          </thead>
          <tbody id="products-list" name="products-list">
            <?php $no = 1;?>
            @foreach($datas as $data)
            <tr>
              <td>{{$no++}}</td>
              <td class="btn-ini">
                @if(Auth::User()->id_division == 'PMO')
                  @if($data->status_kirim == 'PM')
                  <span style="background-color:#990000;color: white">PENDING</span>
                  @elseif($data->status_kirim == 'pending')
                  <span style="background-color:#990000;color: white">PENDING</span>
                  @elseif($data->status_kirim == 'SENT')
                  <span style="background-color:#006600;color: white">SENT</span>
                  @else
                  <span style="background-color:#3399ff;color: white">Published</span>
                  @endif
                @elseif(Auth::User()->id_position == 'ADMIN')
                  @if($data->status_kirim == 'PM')
                  <span style="background-color:#ff6600;color: white">PENDING</span>
                  @elseif($data->status_kirim == 'pending')
                  <span style="background-color:#ff6600;color: white">PENDING</span>
                  @elseif($data->status_kirim == 'SENT')
                  <span style="background-color:#006600;color: white">SENT</span>
                  @else
                  <span style="background-color:#3399ff;color: white">Published</span>
                  @endif
                @else
                  @if($data->status_kirim == 'PM')
                  <span style="background-color:#ff6600;color: white">PENDING</span>
                  @elseif($data->status_kirim == 'pending')
                  <span style="background-color:#ff6600;color: white">PENDING</span>
                  @elseif($data->status_kirim == 'SENT')
                  <span style="background-color:#006600;color: white">SENT</span>
                  @else
                  <span style="background-color:#3399ff;color: white">Published</span>
                  @endif
                @endif()
              </td>
              <td>{{$data->date}}</td>
              <td>{{$data->to_agen}}</td>
              <td>{{$data->subj}}</td>
              <td hidden>{{$data->id_project}}</td>
              <td>{{$data->no_do}}</td>
              @if(Auth::User()->id_position == 'ADMIN')
              <td>{{$data->name}}</td>
              @endif
              <td>
                <a href="{{url('/detail/do/msp',$data->id_transaction)}}"><button class="btn btn-sm btn-primary" style="width:60px">Detail</button></a>
                <a href="{{action('WarehouseProjectController@downloadPdfDO',$data->id_transaction)}}" target="_blank" onclick="print()"><button class="btn btn-sm btn-success" style="width: 60px"><b><i class="fa fa-print"></i> Pdf </b></button></a>
                @if($data->status_kirim == 'kirim' || $data->status_kirim == 'SENT')
                  @if(Auth::User()->id_position == 'WAREHOUSE')
                    <a href="{{url('/copy/do/msp',$data->id_transaction)}}"><button class="btn btn-sm btn-warning" style="width: 60px"><b><i class="fa fa-copy"></i>&nbspCopy</button></b></a>
                  @endif
                @else
                  @if(Auth::User()->id_position == 'WAREHOUSE')
                    <button class="btn btn-sm btn-warning disabled" style="width: 60px"><b><i class="fa fa-copy"></i>&nbspCopy</b></button>
                  @endif
                @endif
                <!-- @if(Auth::User()->id_position == 'DIRECTOR' && $data->status_kirim == 'pending')
                  <button name="accept" id="accept_do" class="btn btn-info btn-sm" style="width: 80px" value="{{$data->id_transaction}}"><b><i class="fa fa-check">&nbspApprove</i></b></button>
                  <button class="btn btn-sm btn-danger" style="width: 70px;" data-target="#reason_decline" data-toggle="modal"><i class="fa fa-times">&nbspDecline</i></button>
                @endif -->
              </td>
              <td hidden="">
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
          </tfoot>
        </table>
      </div>
    </div>
  </div>


  <div class="modal fade" id="modal_approve_do" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Approve Delivery Order</h4>
        </div>
        <form method="" action="" id="approve_do" name="">
          @csrf
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">To</label>
                  <input type="text" class="form-control" name="to_do" id="to_do">
                </div>
              </div>
            </div>
            <div class="form-group">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th rowspan="2" style="text-align: center;vertical-align:center;">MSP Code</th>
                    <th rowspan="2" style="text-align: center;vertical-align:center;" width="40%">Description</th>
                    <th colspan="3" style="text-align: center;vertical-align:center;">Qty</th>
                    <th rowspan="2" style="text-align: center;vertical-align:center;">Unit</th>
                  </tr>
                </thead>
                <tbody id="mytable">
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <table class="">
                <tbody id="footer-table">
                  
                </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
  
</section>

@endsection

@section('script')
  <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript">

    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
         $("#alert").slideUp(300);
    });

    @if (Auth::User()->id_position == 'ADMIN') {
      $('#data_Table').DataTable({
      	pageLength:25,
        "columnDefs": [
        { "orderable": false, "targets": 7},
        { "orderable": false, "targets": 8}
        ],
        initComplete: function () {
          this.api().columns([[1],[3],[5]]).every( function () {
              var column = this;
              var title = $(this).text();
              var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Show All'+ title +'</option></select>')
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
    }
    @else
    var table = $('#data_Table').DataTable({
    	pageLength:25,
    })
    @endif
    

    function initkat()
    {
      $('.kat_drop').select2();
    }


    $(".dismisbar").click(function(){
      $(".notification-bar").slideUp(300);
    });

    function print()
    {
      window.print();
    }

    $('#accept_do').click(function(){
      var value = $('#accept_do').val();

      $('#modal_approve_do').modal('show')
      $.ajax({
        type:"GET",
        url:"{{url('/inventory/getDataDo')}}",
        data:{
          id:value,
        },
        success:function(result){
          console.log(result)
          $("#to_do").val(result.data[0].to_agen);
          $('#mytable').empty();
          var table = "";
          $.each(result[0], function(key, value){
            table = table + '<tr>';
              table = table + '<td >' +'<input type="text" name="id_produks[]" style="width:80px;" class="transparant" value="'+value.kode_barang+'" readonly>'+ '</td>';
              table = table + '<td >' +'<textarea name="name_product_edit[]" style="width:300px" class="transparant" readonly>'+value.nama+'</textarea>'+'</td>';
              table = table + '<td >' +'<input type="number" name="qty_before[]" id="qty_katalog" class="qty_katalog" style="width:25px;height:30px;border:none;" value="'+value.qty_transac+'" readonly>'+ '</td>';
              table = table + '<td >' +'<input type="text" name="unit_publish[]" style="width:30px" class="transparant" value="'+value.unit+'" readonly>'+ '</td>';
            table = table + '</tr>';
            // console.log(value.msp_code);
          });
          $('#mytable').append(table);
        }
      })
    });

    // $('#accept_do').on('click',function(e){
    //   console.log($('#accept_do').val());
    //   var id = $('#accept_do').val();

    //   $.ajax({
    //       type:"GET",
    //       url:'/inventory/getDataDo?id=' + id,
    //       data:{
    //         id:this.value,
    //       },
    //       success: function(result){
    //         $('#mytable').empty();

    //         var table = "";

    //         $.each(result[0], function(key, value){
    //           table = table + '<tr>';
    //             table = table + '<td >' +'<input type="text" name="id_produks[]" style="width:80px;" class="transparant" value="'+value.kode_barang+'" readonly>'+ '</td>';
    //             table = table + '<td >' +'<textarea name="name_product_edit[]" style="width:300px" class="transparant" readonly>'+value.nama+'</textarea>'+'</td>';
    //             table = table + '<td >' +'<input type="number" name="qty_before[]" id="qty_katalog" class="qty_katalog" style="width:25px;height:30px;border:none;" value="'+value.qty_transac+'" readonly>'+ '</td>';
    //             table = table + '<td >' +'<input type="text" name="unit_publish[]" style="width:30px" class="transparant" value="'+value.unit+'" readonly>'+ '</td>';
    //           table = table + '</tr>';
    //           // console.log(value.msp_code);
    //         });

    //         $('#mytable').append(table);
             
    //       }
    //   });
      
    // });

  </script>
@endsection