@extends('template.template_admin-lte')
@section('content')
<style type="text/css">
	input[type=number]::-webkit-inner-spin-button, 
	input[type=number]::-webkit-outer-spin-button { 
	    -webkit-appearance: none; 
	    margin: 0; 
	}

	.inputWithIcon input[type=text]{
	    padding-left:40px;
	}

	input[type=checkbox]
	{
	  /* Double-sized Checkboxes */
	  -ms-transform: scale(3); /* IE */
	  -moz-transform: scale(3); /* FF */
	  -webkit-transform: scale(3); /* Safari and Chrome */
	  -o-transform: scale(3); /* Opera */
	      margin-top: 13px;
	    margin-right: 8px;
	  
	}
	input[type=text]:focus{
    border-color:dodgerBlue;
    box-shadow:0 0 8px 0 dodgerBlue;
  }

 .inputWithIcon.inputIconBg input[type=text]:focus + i{
    color:#fff;
    background-color:dodgerBlue;
  }

 .inputWithIcon.inputIconBg i{
    background-color:#aaa;
    color:#fff;
    padding:10px 9px;
    border-radius:4px 0 0 4px;
  }

 .inputWithIcon{
    position:relative;
  }

 .inputWithIcon i{
    position:absolute;
    left:0;
    top:0;
    padding:9px 9px;
    color:#aaa;
    transition:.3s;
  }

  div.box-header{
    height: 50px;
  }
</style>

<section class="content-header">
  <h1>
    MSP Inventory
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Inventory</li>
    <li class="active">MSP</li>
  </ol>
</section>

<section class="content">
  @if (session('update'))
    <div class="alert alert-warning" id="alert">
        {{ session('update') }}
    </div>
  @endif

  @if (session('sukses'))
    <div class="alert alert-danger notification-bar"><button type="button" class="dismisbar transparant pull-right"><i class="fa fa-times fa-lg"></i></button><span><h3>Warning : </span> {{ session('sukses') }}</h3><br><h4>Klik Button untuk menuju halaman Return barang :<a href="{{url('return_produk_delivery')}}"><button class="btn btn-sm btn-primary margin-left">Return Page</button></a></h4></div>
  @endif

  @if (session('success'))
    <div class="alert alert-success notification-bar" id="alert">
        {{ session('success') }}
    </div>
  @endif

  @if (session('alert'))
    <div class="alert alert-success" id="alert">
        {{ session('alert') }}
    </div>
  @endif

   <!-- <div class="box">
    <div class="box-header with-border">
      <h2>Input Data Excel</h2>
    </div>

    <div class="box-body">
      <form action="{{ url('import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" class="form-control">
        <br>
        <button class="btn btn-success pull-left">Import Data</button>
      </form>
    </div>
  </div> 
 -->
  <div class="box">
    <div class="box-header with-border">
      {{--  <h3 class="box-title"><i class="fa fa-table"></i>&nbsp<b>Kategori</b></h3>  --}}
      {{--  <select name="dropdown_kat" id="dropdown_kat">
        <option value="" selected disabled>Choose Category</option>
        @foreach($categorys as $catsss)
        <option value="{{ $catsss->id }}">{{ $catsss->name }}</option>
        @endforeach
      </select>  --}}
      <div class="box-tools pull-right">
          <button class="btn btn-sm btn-success" style="width: 100px;margin-right: 10px" id="btnSubmitExcel" onclick="exportExcel()" style="width: 120px;"><i class="fa fa-cloud-download"></i>&nbsp&nbspExport Excel</button>
        <button class="btn btn-sm btn-primary" style="width: 100px;margin-right: 10px" id="kat" data-target="#modal_kat" data-toggle="modal"><i class="fa fa-plus"> </i>&nbsp Kategori</button>
        @if(Auth::User()->id_position == 'WAREHOUSE')
        <button class="btn btn-sm btn-primary" style="width: 140px;margin-right: 10px" id="" data-target="#modal_penerimaan" data-toggle="modal"><i class="fa fa-plus"> </i>&nbsp Penerimaan Barang</button>
        @endif
        <button class="btn btn-sm btn-primary" style="width: 130px;margin-right: 10px" id="" data-target="#modal_katalog" data-toggle="modal"><i class="fa fa-plus"> </i>&nbsp Katalog Barang</button>
        
      </div>
    </div>

    <div class="box-body">
      {{--  <div class="nav-tabs-custom active" id="CAT" role="tabpanel" aria-labelledby="cat-tab">

          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item active">
              <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">ALL</a>
            </li>
          </ul>

          <div class="tab-content" id="myTabContentCAT">
            <div class="tab-pane active" id="all" role="tabpanel" aria-labelledby="all-tab">
              <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width: 10px"><center>No</center></th>
                      <th style="width: 150px"><center>MSPCode</center></th>
                      <th style="width: 25px"><center>Stock</center></th>
                      <th style="width: 35px"><center>Unit</center></th>
                      <th><center>Description</center></th>
                      @if(Auth::User()->id_position == 'DIRECTOR' && Auth::User()->id_company == '2')
                      <th><center>Action</center></th>
                      @endif
                    </tr>
                  </thead>
                  <tbody id="products-list" name="products-list">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
      </div>  --}}

      <div class="table-responsive">
        <table class="table table-bordered table-striped" id="data_all" width="100%" cellspacing="0">
          <thead>
          	<tr id="search-aku">
              <th style="width: 10px" colspan="4"><center></center></th>
              <th hidden>Kategori</th>
              <th><center></center></th>
              @if(Auth::User()->id_position == 'DIRECTOR' && Auth::User()->id_company == '2')
              <th><center></center></th>
              @endif
            </tr>
            <tr>
              <th style="width: 10px"><center>No</center></th>
              <th style="width: 150px"><center>MSPCode</center></th>
              <th style="width: 25px"><center>Stock</center></th>
              <th style="width: 35px"><center>Unit</center></th>
              <th hidden>Kategori</th>
              <th><center>Description</center></th>
              @if(Auth::User()->id_position == 'DIRECTOR' && Auth::User()->id_company == '2')
              <th><center>Action</center></th>
              @endif
            </tr>
          </thead>
          <tbody id="products-list" name="products-list">
            <?php $no = 1; ?>
            @foreach($data as $data_cat)
              <tr>
                <td>{{$no++}}</td>
                <td>
                  <center>
                  @if($data_cat->status != NULL || $data_cat->tipe == 'return')
                  <a href="{{url('detail_inventory_msp',$data_cat->id_product)}}"><button class="btn btn-sm btn-primary">{{$data_cat->kode_barang}}</button></a>
                  @else
                  <button class="btn btn-sm btn-default disabled">{{$data_cat->kode_barang}}</button>
                  @endif
                  </center>
                </td>
                @if(substr($data_cat->kode_barang, -1) == 'M')
                  <td><center><a data-target="#modal_turunkan" data-toggle="modal" onclick="turunkan('{{$data_cat->id_product}}','{{$data_cat->qty}}')"><button class="btn btn-default" style="width: 50px">{{$data_cat->qty}}</button></a></center>
                  </td>
                @else
                  @if($data_cat->unit == 'roll')
                    <td><center>{{ number_format($data_cat->qty,1)}}</center></td>
                  @else
                    <td><center>{!!substr($data_cat->qty, 0, strpos($data_cat->qty, '.'))!!}</center></td>
                  @endif
                @endif
                <td><center>{{$data_cat->unit}}</center></td>
                <td hidden>{{$data_cat->name}}</td>
                <td>{{$data_cat->nama}}</td>
                @if(Auth::User()->id_position == 'DIRECTOR' && Auth::User()->id_company == '2')
                <td>
                  @if($data_cat->status2 != '')
                  <button class="btn btn-sm btn-danger" data-target="#modal_kurang_jml" data-toggle="modal" onclick="turunkan('{{$data_cat->id_product}}','{{$data_cat->qty}}','{{$data_cat->status2}}')">Accept</button>
                  @endif
                </td>
                @endif
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th colspan="4"><center>Choose Category :</center></th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      </div>

    </div>
  </div>

  <!--  MODAL TURUNKAN  -->
  <div class="modal fade" id="modal_turunkan" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">+ Stock</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/turunkan')}}">
            @csrf

            <div class="form-group">
              <input type="text" id="ipro" name="ipro" hidden>
              <label for="">Jumlah (dalam bentuk roll)</label>
              <input type="number" class="form-control" placeholder="Entry jumlah roll" name="jml_roll" id="jml_roll" required>
            </div>

            Apakah ada stok kabel yang ingin di revisi?
            <br><input style="width: 10px;height: 10px;margin-left: 10px" type="checkbox" name="revisix" onclick="revision()" id="revisix"> Ya<br>
            <div class="form-group" id="revisi" style="display: none">
              <label for="">Jumlah (dalam bentuk meter)</label>
              <input type="" class="qty_lo" name="qty_lo" id="qty_lo" hidden>
              <input type="number" name="jml_meter" id="jml_meter" placeholder="Entry Jumlah meter untuk kurangi stock" class="form-control" >
            </div>
    
            <div class="modal-footer" id="btn-revisi" style="display: none">
              <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-sm btn-primary" id="add_kat"><i class="fa fa-check"> </i>&nbspSubmit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

   <!--  MODAL Kurang Jumlah  -->
  <div class="modal fade" id="modal_kurang_jml" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">- Stock</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/turunkan')}}">
            @csrf
            <input type="text" id="ipro2" name="ipro" hidden>
            <h4>Apakah anda yakin stok kabel ingin di revisi?</h4><br>
            <h4>Stock Kabel Sekarang : <b><span id="qty_now"></span> meter</b></h4>
            <h4>Jumlah Kabel ingin direvisi : <b><span id="qty_revisi"></span> meter</b></h4>
    
            <div class="modal-footer" id="btn-revisi">
              <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!--MODAL ADD PENERIMAAN-->
  <div class="modal fade" id="modal_penerimaan" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Penerimaan</h4>
        </div>
        <form method="" action="" id="store_lead" name="store_lead">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label>No. Purchase Order</label>
              <select name="po_number" style="width: 100%" id="po-number" class="form-control">
                <option value="">-- Select Purchase Order --</option>
                @foreach($datas as $data)
                <option value="{{$data->id_po_asset}}">{{$data->no_po}} - {{$data->to_agen}}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <table class="table table-bordered">
                <thead>
                <tr>
                  <th rowspan="2" style="text-align: center;vertical-align:center;">MSP Code</th>
                  <th rowspan="2" style="text-align: center;vertical-align:center;" width="40%">Description</th>
                  <th colspan="3" style="text-align: center;vertical-align:center;">Qty</th>
                  <th rowspan="2" style="text-align: center;vertical-align:center;">Unit</th>
                  <!-- <th rowspan="2" style="text-align: center;vertical-align:center;">Description</th> -->
                </tr>
                <tr>
                  <th style="text-align: center;vertical-align:center;">Accepted</th>
                  <th style="text-align: center;vertical-align:center;">PR</th>
                  <th style="text-align: center;vertical-align:center;" width="10%">Accept</th>
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

  <!--Modal Kategori-->
  <div class="modal fade" id="modal_kat" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Kategori</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/add_kat')}}">
            @csrf

            <div class="form-group">
              <label for="">Nama Kategori</label>
              <input type="text" class="form-control" placeholder="Entry Nama Kategori" name="nama_kategori" id="nama_kategori" required>
            </div>
    
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-sm btn-primary" id="add_kat"><i class="fa fa-check"> </i>&nbspSubmit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<!--Modal Katalog-->
<div class="modal fade" id="modal_katalog" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Katalog</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{url('/katalog/store')}}">
          @csrf

        <div class="form-group">
          <label for="">Category</label>
          <select name="kategori" id="kategori" class="form-control" required>
            <option disabled selected>Pilih Kategori</option>
            @foreach($categorys as $drop_cats)
            <option value="{{ $drop_cats->id }}">{{ $drop_cats->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
        <label for="">MSP Code</label>
        <input type="text" class="form-control" placeholder="Entry Kode Barang" name="kode_barang_katalog" id="kode_barang_katalog" required>
        </div>

        <div class="form-group">
        <label for="">Description</label>
        <textarea type="text" class="form-control" placeholder="Entry Nama Barang" name="barang_katalog" id="barang_katalog" required></textarea>
        <!-- <input type="text" class="form-control" placeholder="Entry Nama Barang" name="barang_katalog" id="barang_katalog" required> -->
        </div>

        <div class="form-group">
          <label for="">Stock</label>
          <input type="number" step="any" class="form-control" placeholder="Entry Stock Barang" name="stock" id="stock" required>
        </div>

        <div class="form-group">
        <label for="">Unit</label>
        {{--  <input type="text" class="form-control" placeholder="Entry Unit Barang" name="unit" id="unit" required>  --}}
        <select class="form-control" name="unit" id="unit">
          <option value="" selected disabled>Pilih Unit</option>
          <option value="roll">roll</option>
          <option value="meter">meter</option>
          <option value="pcs">pcs</option>
          <option value="lgh">lgh</option>
          <option value="ea">ea</option>
          <option value="unit">unit</option>
          <option value="pack">pack</option>
          <option value="pcs">pcs</option>
        </select>
        </div>

        <div class="form-group">
          <label for="">Tipe</label><br />
            <label class="radio-inline"><input type="radio" name="optradio" value="project" checked>Project</label>
            <label class="radio-inline"><input type="radio" name="optradio" value="stock">Stock</label>
            <label class="radio-inline"><input type="radio" name="optradio" value="return">Return</label>
        </div>

     <!--    <div class="form-group">
        <label for="">Deskripsi Barang</label>
        <textarea class="form-control" name="desc_katalog" id="desc_katalog" required></textarea>
        </div> -->

        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
          <button type="submit" class="btn btn-sm btn-primary" id="add_lead"><i class="fa fa-check"> </i>&nbspSubmit</button>
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
  <script type="text/javascript">

    var url = {!! json_encode(url('/')) !!}

    function exportExcel() {
      type = encodeURI($("#dropdown").val())
      myUrl = url+"/getdatawarehouse?type="+type
      location.assign(myUrl)
    }

    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
         $("#alert").slideUp(300);
    });

    function turunkan(id_product,qty,status2){
      $('#ipro').val(id_product);
      $('#ipro2').val(id_product);
      $('#qty_lo').val(qty);
      $('#qty_now').text(qty);
      $('#qty_revisi').text(status2);
    }

    $(document).on('click', '.btn-submit', function(e){
      var lines = $('textarea').val().split('\n');
      console.log(lines);
      for(var i = 0;i < lines.length;i++){
          
      }

      /*$.ajax({
          type:"POST",
          url:'/store/msp/serial_number',
          data:$('#update_sn').serialize(),
          success: function(result){
              swal({
                  title: "Success!",
                  text:  "You have been add product",
                  type: "success",
                  timer: 2000,
                  showConfirmButton: false
              });
            setTimeout(function() {
                window.location.href = window.location;
            }, 2000);  
          },
      });*/
    }); 

    $(document).on('click', '.btn-save', function(e){
      $.ajax({
          type:"POST",
          url:'/inventory/store/msp',
          data:$('#store_lead').serialize(),
          success: function(result){
              swal({
                  title: "Success!",
                  text:  "You have been add product",
                  type: "success",
                  timer: 2000,
                  showConfirmButton: false
              });
            setTimeout(function() {
                window.location.href = window.location;
            }, 2000);  
          },
      });
    }); 

    $(document).on('click', '.btn-update', function(e){
      console.log($('#sn').val())
      $.ajax({
          type:"POST",
          url:'/inventory/msp/update',
          data:$('#store_lead').serialize(),
          success: function(result){
              swal({
                  title: "Success!",
                  text:  "You have been Update product",
                  type: "success",
                  timer: 2000,
                  showConfirmButton: false
              });
            setTimeout(function() {
                window.location.href = window.location;
            }, 2000);  
          },
      }); 
    }); 

    @foreach($categorys as $pane_cats)
    $("#data_{{ $pane_cats->id }}").DataTable({

    });
    @endforeach

    $("#kat_table").DataTable({
    });

    $("#dropdown_kat").select2();
    $("#po-number").select2();
    {{--$("#kategori").select2();--}}

    $('#dropdown_kat').on('change',function(e){
      console.log($('#dropdown_kat').val());
      var kategori = $('#dropdown_kat').val();

      $.ajax({
          type:"GET",
          url:'/dropdownKategori?kategori=' + kategori,
          data:{
            kategori:this.value,
          },
          success: function(result){
            $('#products-list').empty();

            var table = "";
            var no = 1;

            $.each(result[0], function(key, value){
              table = table + '<tr>';
                table = table + '<td>' + no++ + '</td>';
                if(value.status != '') {
                  table = table + '<td><center><button class="btn btn-sm btn-primary">' + value.kode_barang + '</button></center></td>'; 
                } else {
                  table = table + '<td><center><button class="btn btn-sm btn-default disabled">' + value.kode_barang + '</button></center></td>'; 
                }
                table = table + '<td>' + value.qty + '</td>';
                table = table + '<td>' + value.unit + '</td>';
                table = table + '<td>' + value.nama + '</td>';
              table = table + '</tr>';
              console.log(value.id_product);
            });

            $('#products-list').append(table);
             
          }
      });
     
    });

    $('#po-number').on('change',function(e){
      console.log($('#po-number').val());
      var product = $('#po-number').val();

      $.ajax({
          type:"GET",
          url:'/dropdownPO?product=' + product,
          data:{
            product:this.value,
          },
          success: function(result){
            $('#mytable').empty();

            var table = "";

            $.each(result[0], function(key, value){
              table = table + '<tr>';
                table = table + '<td >' +'<input type="text" name="msp_code_edit[]" style="width:80px;" class="transparant" value="'+value.msp_code+'" readonly>'+ '</td>';
                table = table + '<td >' +'<textarea name="name_product_edit[]" style="width:300px" class="transparant" readonly>'+value.name_product+'</textarea>'+'</td>';
                table = table + '<td >' +'<input type="number" name="qty_katalog[]" id="qty_katalog" class="qty_katalog" style="width:25px;height:30px;border:none;" value="'+value.qty_terima+'" readonly>'+ '</td>';
                table = table + '<td hidden>' +'<input type="number" name="qty_master[]" id="qty_master" class="qty_katalog" style="width:25px;height:30px;border:none;" value="'+value.qty_master+'" readonly>'+ '</td>';
                if (value.qty_sisa == null) {
                  table = table + '<td hidden>' +'<input type="number" name="qty_sisa[]" value="0" id="qty_sisa" class="qty_katalog" style="width:25px;height:30px;border:none;" value="'+value.qty_sisa+'" readonly>'+ '</td>';
                }else{
                  table = table + '<td hidden>' +'<input type="number" name="qty_sisa[]" id="qty_sisa" class="qty_katalog" style="width:25px;height:30px;border:none;" value="'+value.qty_sisa+'" readonly>'+ '</td>';
                }
                table = table + '<td>' +'<input type="number" name="qty_awal[]" id="qty_awal" data-rowid="'+value.msp_code+'" class="qty_awal" style="width:40px;height:30px;border:none;" value="'+value.qty+'" readonly>'+ '</td>';
                if (value.qty == 0) {
                table = table + '<td >' + '<input type="number" name="qty_terima[]" class="form-control" id="qty_terima" style="width:70px" value="0"readonly>'+ '</td>';
                }else{
                table = table + '<td >' + '<input type="number" name="qty_terima[]" id="qty_terima" data-rowid="'+value.msp_code+'" value="0" placeholder="0" class="form-control qty_terima" style="width:70px;" required">'+ '</td>';
                }
                table = table + '<td >' +'<input type="text" name="unit_edit[]" style="width:30px" class="transparant" value="'+value.unit+'" readonly>'+ '</td>';
                /*if (value.status == 'Y') {
                table = table + '<td >' + 'v'+ '</td>';
                }else if(value.status == 'N'){
                table = table + '<td >' + 'x'+ '</td>';
                }
                else{
                table = table + '<td>' + '<select name="sn_edit[]" id="sn_edit"><option value="Y">Y</option><option value="N">N</option></select>'+ '</td>';
                }*/
                // table = table + '<td >' +'<textarea class="transparant" style="width:200px" name="desc_edit[]">'+value.description+'</textarea>'+ '</td>';
                // table = table + '<td >' +'<input type="text" name="no_po_edit[]" class="transparant" value="'+value.no_po+'" readonly>'+ '</td>';
                table = table + '<td hidden>' +'<input type="text" name="id_product_edit[]" class="" value="'+value.id_barang+'" readonly>'+ '</td>';
                table = table + '<td hidden>' +'<input type="text" name="id_pam[]" class="" value="'+value.id_po_asset+'" readonly>'+ '</td>';
                table = table + '<td hidden>' +'<input type="text" name="id_product_pam[]" class="" value="'+value.id_product+'" readonly>'+ '</td>';
              table = table + '</tr>';
              console.log(value.msp_code);
            });

            $('#mytable').append(table);
             
          }
      });
      
    });

    $('#po-number').on('change',function(e){
      console.log($('#po-number').val());
      var product = $('#po-number').val();

      $.ajax({
          type:"GET",
          url:'/dropdownSubmitPO?product=' + product,
          data:{
            product:this.value,
          },
          success: function(result){
            $('#footer-table').empty();

            var table = "";
// 
            // $.each(result[0], function(key, value){
              // if (value.status_po == 'PENDING') {
              //   table = table + '<tr>';
              //   table = table + '<td colspan="6" >'+'<input type="button" name="update" id="btn-update" class="btn-update btn btn-sm btn-warning" value="update" />'+ '<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-left:5px"><i class=" fa fa-times"></i>&nbspClose</button>'+ '</td>';
              //   table = table + '</tr>';
              // }else if (value.status_po == 'FINANCE') {
              //   table = table + '<tr>';
              //   table = table + '<td colspan="6" >'+'<input type="button" name="update" id="btn-update" class="btn-update btn btn-sm btn-warning" value="update" />'+ '<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-left:5px"><i class=" fa fa-times"></i>&nbspClose</button>'+ '</td>';
              //   table = table + '</tr>';
                /*table = table + '<tr>';
                table = table + '<td colspan="6" >'+'<input type="button" name="submit" id="btn-save" class="btn-save btn btn-sm btn-primary" value="Submit" />'+ '<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-left:5px"><i class=" fa fa-times"></i>&nbspClose</button>'+ '</td>';
                table = table + '</tr>';*/
              // }
            // });

            table = table + '<tr>';
            table = table + '<td colspan="6" >'+'<input type="button" name="update" id="btn-update" class="btn-update btn btn-sm btn-warning" value="Update" />'+ '<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-left:5px"><i class=" fa fa-times"></i>&nbspClose</button>'+ '</td>';
            table = table + '</tr>';

            $('#footer-table').append(table);
             
          }
      });
    });

    $(document).on('click', '.show', function(e){
      console.log('haha');
      var rowid = $(this).attr("data-rowid");
      $(".show2[data-rowid='"+rowid+"']").css('display', 'block');
      $(".show[data-rowid='"+rowid+"']").css('display', 'none');
    });

    $(document).on('click', '.show3', function(e){
      console.log('haha');
      var rowid = $(this).attr("data-rowid");
      $(".show4[data-rowid='"+rowid+"']").css('display', 'block');
      $(".show3[data-rowid='"+rowid+"']").css('display', 'none');
    });
    
    function id_product(id_product)
    {
      $('#id_product_edit').val(id_product);
    }


    $(document).on('keyup keydown', "input[id^='qty_terima']", function(e){
    var rowid = $(this).attr("data-rowid");
    var qty_before = $(".qty_awal[data-rowid='"+rowid+"']").val();
    console.log(qty_before);
        if ($(this).val() > parseFloat(qty_before)
            && e.keyCode != 46
            && e.keyCode != 8
           ) {
           e.preventDefault();     
           $(this).val(qty_before);
        }
    });

    $(document).ready(function() {
        var table = $('#data_all').DataTable( {
        	dom: 'frtlip',    
            pageLength: 25,
            initComplete: function () {
                this.api().columns([4]).every( function () {
                    var column = this;
                    var select = $('<select class="form-control kat_drop" id="kat_drop" name="kat_drop"><option value=""></option></select>')
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

                    initkat();
                } );

             this.api().columns([0]).every( function () {
                var column = this;
                var title = 'By MSPCode';
                var select = $('<input type="text" style="width:100%" class="form-control" placeholder="Search '+title+'" />')
                    .appendTo($("#search-aku").find("th").eq(column.index()))
                    .on( 'keyup change clear', function () {
                    	table
                    	.columns(1)
                    	.search( this.value )
        				.draw();
		        });                
                  
              });

              this.api().columns([2]).every( function () {
                var column = this;
                var title = 'By Description';
                var select = $('<input type="text" style="width:100%" class="form-control" placeholder="Search '+title+'" />')
                    .appendTo($("#search-aku").find("th").eq(column.index()))
                    .on( 'keyup change clear', function () {
                    	table
                    	.columns(5)
                    	.search( this.value )
        				.draw();
		        });                
                  
              });
            }
        } );

        $("#searchbox").keyup(function() {
        	table.fnFilter(this.value);
    	});   
    } );

    function initkat()
    {
      $('.kat_drop').select2();
    }

    function revision()
    {
      var checkBox = document.getElementById("revisix");
      if (checkBox.checked == true){
      document.getElementById('revisi').style.display = "block";
      document.getElementById("jml_roll").disabled = true;
      } else {
        document.getElementById('revisi').style.display = "none";
        document.getElementById("jml_roll").disabled = false;
        document.getElementById("jml_meter").value = '';
      }
    }

    $(document).on('keyup keydown', "#jml_roll", function(e){
      var cek = $('#jml_roll').val();
      
      document.getElementById('btn-revisi').style.display = "block";
      if (cek.length < 1) {
        document.getElementById("revisix").disabled = false;
      }else{
        document.getElementById("revisix").disabled = true;
      }
      console.log(cek.length);


    });

     $(document).on('keyup keydown', "#jml_meter", function(e){
      var qty_before = $("#qty_lo").val();
      document.getElementById('btn-revisi').style.display = "block";
      console.log(qty_before);
      if ($(this).val() > parseFloat(qty_before)
          && e.keyCode != 46
          && e.keyCode != 8
         ) {
         e.preventDefault();     
         $(this).val(qty_before);
      }



    });

    //lengthmenu -> add a margin to the right and reset clear 
	$(".dataTables_length").css('clear', 'none');
	$(".dataTables_length").css('margin-right', '20px');

	//info -> reset clear and padding
	$(".dataTables_info").css('clear', 'none');
	$(".dataTables_info").css('padding', '0');

	$(".dismisbar").click(function(){
      $(".notification-bar").slideUp(300);
    });

  </script>
@endsection