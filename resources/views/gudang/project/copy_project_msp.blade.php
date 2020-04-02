@extends('template.template_admin-lte')
@section('content')

<style type="text/css">
  input[type=number]::-webkit-inner-spin-button, 
  input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
  }

  .select2{
      width: 100%!important;
  }

  .product-add tr:nth-child(2){
  counter-reset: rowNumber;
  }
  .product-add tr {
      counter-increment: rowNumber;
  }
  .product-add tr td:first-child::before {
      content: counter(rowNumber);
      min-width: 1em;
      margin-left: 1.5em;
      margin-top: 3em;
      text-align: center;
      vertical-align: center;
  }
</style>

<section class="content-header">
  <h1>
    Copy Delivery Order
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{url('project')}}"><i class="fa fa-dashboard"></i> Home </a></li>
    <li class=""><a href="{{url('inventory/do/msp')}}">Delivery Order</a></li>
    <li class="active">MSP</li>
    <li class="active">Detail</li>
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
        <div class="col-md-12" style="border-top: solid;border-bottom: solid;border-width: 1px;outline-color: grey">
          <div class="col-md-9">
            <i><h4><b>{{$to->subj}}</b></h4></i>
          </div>
        </div>
        <h4 class="pull-right"><b>Owner PM</b>     : {{$to->name}}<input type="" name="pm_nik" value="{{$to->nik_pm}}" hidden></h4>
    </div>
    <div class="box-body">
      <form method="POST" action="{{url('/store_copy_do')}}" id="modal_pr_asset" name="modal_pr_asset">
        @csrf
        <div class="row">
          <div class="col-sm-7">
            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">To</label>
              <div class="col-sm-10">
                <input class="form-control" name="to_agen" id="to_agen" value="{{$cek->to_agen}}" type="text" placeholder="Enter To">
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">From</label>
              <div class="col-sm-10">
                <input type="text" name="from" id="from" class="form-control" value="{{$cek->from}}" placeholder="Enter From" >
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Address</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="add" id="add"type="text" placeholder="Enter Address">{{$cek->address}}</textarea>
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Fax</label>
              <div class="col-sm-10">
                <input type="text" name="fax" id="fax" class="form-control" value="{{$cek->fax}}" placeholder="Enter Fax.">
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Attn.</label>
              <div class="col-sm-10">
                <input type="text" name="att" id="att" class="form-control" value="{{$cek->attn}}" placeholder="Enter Attention">
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Subj.</label>
              <div class="col-sm-10">
                <textarea type="text" name="subj" id="subj" class="form-control"  placeholder="Enter Subject">{{$cek->subj}}</textarea>
              </div>
            </div> 
          </div>

          <div class="col-sm-5">
            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-4 control-label">Date</label>
              <div class="col-sm-8">
                <input class="form-control" id="todays" type="date" value="{{$cek->date}}" readonly>
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-4 control-label">ID Project</label>
              <div class="col-sm-8">
                <select type="text" class="form-control" placeholder="Enter ID Project" name="id_project" id="id_project" required>
                  @foreach($project_id as $data)
                  <option value="{{$data->id_pro}}">{{$data->id_project}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-4 control-label">Telp</label>
              <div class="col-sm-8">
                <input type="number" name="telp" id="telp" class="form-control" value="{{$cek->telp}}" placeholder="Enter No. Telp">
              </div>
            </div>

            @if(Auth::user()->id_position == 'ADMIN')
            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-4 control-label">Requested By PM :</label>
              <div class="col-sm-8">
                <select name="pm_nik" id="pm_nik" class="form-control">
                  @foreach($owner as $data)
                    @if($data->id_company == '2' && $data->id_position == 'PM')
                  <option value="{{$data->nik}}">{{$data->name}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            </div>
            @endif
          
          </div>

          <div class="col-md-12" style="overflow:auto;margin-left: 10px;margin-right: 10px">
          <table id="product-add" class="table table-bordered product-add" width="100%">
            <input type="" name="id_pam_set" id="id_pam_set" hidden>
            <tr class="tr-header">
              <th><center>No</center></th>
              <th width="20%"><center>MSP Code</center></th>
              <th width="30%"><center>Description</center></th>
              <th><center>Stock</center></th>
              <th><center>Unit</center></th>
              <th width="10%"></th>
              <th width="10%"><center>Qty</center></th>
              <th>
                <div id="plusss">
                <a href="javascript:void(0);" style="font-size:18px" id="addMoreYa"><span class="fa fa-plus"></span></a>
                </div>
              </th>
            </tr>
            @foreach($detail as $data)
            <tr>
              <td data-rowid="0" style="vertical-align: middle;"><br></td>
              <td style="margin-bottom: 50px;">
                <br>
                <input type="" class="id_produks" name="product[]" id="product[]" data-rowid="{{$data->id_product}}" value="{{$data->id_product}}" hidden>
                {{$data->kode_barang}}
              </td>
              <td>
                <br>
                <!-- <textarea type="text" class="form-control name_barangs" style="width:300px" data-rowid="0" name="information[]" id="information" readonly></textarea> -->
                <input type="text" name="information[]" value="{{$data->nama}}" readonly hidden>
                {{$data->nama}}
              </td>
              <td>
                <br>
                @if($data->qty_sisa_submit == 0)
                <input type="" name="ket_aja[]" data-rowid="{{$data->id_product}}" style="border-style: none;width: 80px" class="" value="{{$data->qty_sisa_submit}}" readonly>
                @else
                <input type="" name="ket_aja[]" data-rowid="{{$data->id_product}}" style="border-style: none;width: 80px" class="" value="{{$data->qty}}" readonly>
                @endif
                <!-- <input type="text" name="ket_aja[]" id="ket0" class="form-control ket" data-rowid="0" readonly style="width: 80px"> -->
              </td>
              <td style="margin-bottom: 50px">
                <br>
                <!-- <input type="text" class="form-control unit" name="unit[]" id="unit" data-rowid="0" readonly style="width: 100px"> -->
                <input type="text" class="transparant" name="unit[]" value="{{$data->unit_publish}}" readonly hidden>
                {{$data->unit}}
              </td>
              <td style="margin-bottom: 50px">
                <br>
                <select class="form-control unite" data-rowid="0" name="unite" id="unite" style="display: none">
                    <option value="" readonly>Select</option>
                    <option value="roll">roll</option>
                    <option value="meter">meter</option>
                </select>
              </td>
              <td style="margin-bottom: 50px">
                <br>
                <input type="" name="qty[]" data-rowid="{{$data->id_product}}" style="border-style: none;width: 80px" class="form-control qty_before" value="0" readonly>
              </td>
              <td>
                <br>
                <input type="button" style="width: 50px;height: 25.2px" value="Edit" name="" data-rowid="{{$data->id_product}}" class="btn btn-xs btn-warning modal_edit">
                <a><input type="button" style="width: 50px;height: 25.2px" value="Delete" name="" class="btn btn-xs btn-danger delete" onclick="return confirm('Are you sure want to delete this data?')"></a>
              </td>
            </tr>
            @endforeach
            </table>
            <div class="col-md-12">
              <hr style="border-top: 1px solid red;">
              <div class="form-group">
                <label>*Please Check Agree For Create New Copy DO</label><br>
                <label class="margin-right">Agree</label>
                <input type="checkbox" style="width:7px;height:7px;margin-left: 10px" name="" class="pubs" id="pubs"><br>
                <button class="btn btn-sm btn-success" id="create_new" onclick="edit_product('{{$details->id_transaction}}')" disabled type="submit" >Create New</button>
              </div> 
            </div>
          </div>
        
        </div>
      </form>
    </div>
  </div>


<div class="modal fade" id="modal_publish" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content modal-sm">
        <div class="modal-body">
          <form method="POST" action="{{url('/publish-status')}}" id="modaledit" name="modaledit">
            @csrf
          <input type="text" class="form-control" name="id_transac_edit" id="id_transac_edit">
          <input type="text" class="form-control" name="id_produks_edit" id="id_produks_edit">
          
          <div class="form-group">
           <h4>Yakin Data yang Anda masukkan benar sebelum <span style="color:red">publish!</span></h4>
          </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspCancel</button>
              <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"> </i>&nbsp&nbspYes</button>
            </div>
        </form>
        </div>
      </div>
    </div>
</div>


<!--  MODAL TURUNKAN  -->
  <div class="modal fade" id="modal_tambah_meter" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Stock</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/tambah_meter_do')}}">
            @csrf

            <div class="form-group">
              <input type="text" id="iprom" name="iprom" hidden>
              <input type="text" id="ipro" name="ipro" hidden>
              <label for="">Masukkan jumlah penambahan (dalam bentuk roll)</label>
              <input type="number" class="form-control" placeholder="Entry jumlah roll" name="jml_roll" id="jml_roll" step="any" required>
            </div>
    
            <div class="modal-footer">
              <button type="button" class="btn btn-xs btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-xs btn-primary" id="add_kat"><i class="fa fa-check"> </i>&nbspSubmit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal_add_stock" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Stock</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/edit_qty_do')}}">
            @csrf

            <div class="form-group">
              <input type="text" id="id_detail_do_tambah" name="id_detail_do" hidden><input type="text" id="id_transac_add" name="id_transaction_edit" hidden><input type="text" id="id_product_add" name="id_product_edit" hidden><br>
              <label for="">Req Qty</label>
              <input type="number" class="form-control" placeholder="Entry jumlah" name="qty_tras" id="qty_tras" required readonly>
              <label for="">Masukkan Inputan Untuk Menambah Stock</label>
              <input type="number" class="form-control" placeholder="Entry jumlah" name="qty_produk" id="" step="any" required>
            </div>
    
            <div class="modal-footer">
              <button type="button" class="btn btn-xs btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-xs btn-primary" id="add_kat"><i class="fa fa-check"> </i>&nbspSubmit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal_kurang_stock" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Kurang Stock</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/return_do_product_msp')}}">
            @csrf

            <div class="form-group">
              <input type="text" id="id_detail_do_kurang" name="id_detail_do" hidden><input type="text" id="id_transac_minus" name="id_transaction_edit" hidden><input type="text" id="id_product_minus" name="id_product_edit" hidden><br>
              <label for="">Req Qty</label>
              <input type="number" class="form-control" placeholder="Entry jumlah" name="qty_tras_kurang" id="qty_tras_kurang" readonly>
              <label for="">Masukkan Inputan Untuk Mengurangi Stock</label>
              <input type="number" class="form-control" placeholder="Entry jumlah " name="qty_produk" step="any" id="qty_produk_kurang" required>
            </div>
    
            <div class="modal-footer">
              <button type="button" class="btn btn-xs btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-xs btn-primary" id="add_kat"><i class="fa fa-check"> </i>&nbspSubmit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="modal_edit" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Revisi Stock</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{url('/revisi_stok')}}">
                    @csrf

                    <div class="form-group">
                        <input type="text" id="id_project_revisi" name="id_project_revisi" hidden><input type="text" id="id_detail_do_revisi" name="id_detail_do_revisi" hidden><input type="text" id="id_transac_revisi" name="id_transaction_revisi" hidden><input type="text" id="id_product_revisi" name="id_product_revisi" hidden>
                        <input type="" name="qty_before_revisi" id="qty_before_revisi" hidden>
                        <div class="form-group inputWithIconn inputIconBg">
                            <label for="">Masukkan Inputan Untuk Revisi Stock</label>
                            <input type="number" class="form-control" placeholder="Entry jumlah revisi" name="qty_revisi" step="any" id="qty_revisi" required>
                            <i class="unito" style="margin-top: -4px;margin-left: 245px" aria-hidden="true">Roll</i>
                        </div>
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



</section>

@endsection
@section('script')
<script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
<script type="text/javascript">

  $('#data_Table').DataTable({
     "scroll-X":true,
  });

  $('#product').select2();

  $('#id_project').select2();

  function initproduk(){
    $('.produk').select2();
  }

  function Return(id_product,id_transaction,qty_transac,id_detail_do_msp){
      $('#id_product_edit').val(id_product);
      $('#id_transaction_edit').val(id_transaction);
      $('#qty').val(qty_transac);
      $('#id_detail_do_edit').val(id_detail_do_msp);
  }

  function tambah_produk(id_transaction,no,id_pro){
      $('#id_transaction_product').val(id_transaction);
      $('#no_do_edit').val(no);
      $('#id_pro_edit').val(id_pro);
  }

  function edit_product(id_transaction)
  {
    $('#id_transac_edit').val(id_transaction);

  }

  function tambah_meter(id_product,id_product) {
    $('#iprom').val(id_product);
    $('#ipro').val(id_product - 1);
  }

  $("#alert").fadeTo(2000, 500).slideUp(500, function(){
      $("#alert").slideUp(300);
  });

  $(document).on('click', "#addMorelagi", function(e){
   $("#modal_pr_product_edit").modal();
   var lines = $('textarea').val().split(',');
   console.log(lines);
  });


  $(document).on('change',"select[id^='product']",function(e) {
        var rowid = $(this).attr("data-rowid");

         $.ajax({
          type:"GET",
          url:'/dropdownQty',
          data:{
            product:this.value,
          },
          success: function(result){
            $.each(result[0], function(key, value){
               if (value.qty_sisa_submit != 0) {
                $(".ket[data-rowid='"+rowid+"']").val(value.qty_sisa_submit);
               }else{
                $(".ket[data-rowid='"+rowid+"']").val(value.qty);
               }
               $(".unit[data-rowid='"+rowid+"']").val(value.unit);
               $(".name_barangs[data-rowid='"+rowid+"']").val(value.nama);


               if (value.unit == 'roll') {
                $(".unite[data-rowid='"+rowid+"']").css("display", "block");

                $(document).on('change',"select[id^='unite']",function(e) { 
                  var rowid = $(this).attr("data-rowid");

                  var unite = $(".unite[data-rowid='"+rowid+"']").val();

                  console.log(unite);

                  if (unite == 'roll') {
                    $(".unit[data-rowid='"+rowid+"']").val('roll');
                  }else if (unite == 'meter') {
                    $(".unit[data-rowid='"+rowid+"']").val('meter');
                  }
                });

              } else {

                $(".unite[data-rowid='"+rowid+"']").css("display", "none");
              }
            });
          }
        });
  });

  $(document).on('keyup keydown', "input[id^='qty_back']", function(e){ 

    var rowid = $(this).attr("data-rowid");
    $(".submit-qty[data-rowid='"+rowid+"']").prop('disabled', false);
      $(".cancel-qty[data-rowid='"+rowid+"']").prop('disabled', false);

    var qty_before = $(".qty_before[data-rowid='"+rowid+"']").val();
    console.log(qty_before);
    if ($(this).val() > parseFloat(qty_before)
        && e.keyCode != 46
        && e.keyCode != 8
       ) {
       e.preventDefault();     
      $(this).val(qty_before);
      
    }
  });

  $(document).on('click', "input[id^='edit']", function(e){
    $("#modal_tambah_stock").modal();
   /* $(document).on('keyup keydown', "input[id^='qty_produk_tras']", function(e){ 

    var qty_produk = $("#qty_tras").val();
    console.log(qty_produk);
    if ($(this).val() > parseFloat(qty_produk)
        && e.keyCode != 46
        && e.keyCode != 8
       ) {
       e.preventDefault();     
      $(this).val(qty_produk);
      
    }

    });*/
  })

  $(document).on('click', "input[id^='return']", function(e){
    $("#modal_tambah_stock").modal();
    $(document).on('keyup keydown', "input[id^='qty_tras_kurang']", function(e){ 

    var qty_produk = $("#qty_produk_kurang").val();
    console.log(qty_produk);
    if ($(this).val() > parseFloat(qty_produk)
        && e.keyCode != 46
        && e.keyCode != 8
       ) {
       e.preventDefault();     
      $(this).val(qty_produk);
      
    }
    });
  })

  

  $(document).on('keyup keydown', "input[id^='qty_tras']", function(e){ 

    var rowid = $(this).attr("data-rowid");

    var that = this;
    setTimeout(function(){ 
        $(".qty_edit_clone[data-rowid='"+rowid+"']").val(that.value);
    },10);

    $(".e-submit-qty[data-rowid='"+rowid+"']").prop('disabled', false);
    $(".e-cancel-qty[data-rowid='"+rowid+"']").prop('disabled', false);

    var qty_produk = $(".qty_produk[data-rowid='"+rowid+"']").val();
    console.log(qty_produk);
    if ($(this).val() > parseFloat(qty_produk)
        && e.keyCode != 46
        && e.keyCode != 8
       ) {
       e.preventDefault();     
      $(this).val(qty_produk);
      
    }

  });

  $(document).on('keyup keydown', "input[id^='qty_produk']", function(e){ 
    var qty_produk = $("#qty_tras_kurang").val();
    console.log(qty_produk);
    if ($(this).val() > parseFloat(qty_produk)
        && e.keyCode != 46
        && e.keyCode != 8
       ) {
       e.preventDefault();     
      $(this).val(parseFloat(qty_produk)-0.1);
      
    }

  });

  $(document).on('click', "input[id^='cancel-qty']", function(e){
    var rowid = $(this).attr("data-rowid");
      $(".qty_back[data-rowid='"+rowid+"']").val('');
      $(".qty_back[data-rowid='"+rowid+"']").prop('disabled', true);
      $(".submit-qty[data-rowid='"+rowid+"']").prop('disabled', true);
      console.log(rowid)
  });

  $(document).on('click', "input[id^='e-cancel-qty']", function(e){
    var rowid = $(this).attr("data-rowid");
      $(".qty_edit[data-rowid='"+rowid+"']").val('');
      $(".qty_edit[data-rowid='"+rowid+"']").prop('disabled', true);
      $(".e-submit-qty[data-rowid='"+rowid+"']").prop('disabled', true);
      console.log(rowid)
  });

  function getadd(id_detail_do_msp,qty_transac,id_transaction,id_product){
    $('#id_transac_add').val(id_transaction)
    $('#id_detail_do_tambah').val(id_detail_do_msp);
    $('#qty_tras').val(parseFloat(qty_transac));
    $('#id_product_add').val(id_product);
  }

  function getminus(id_detail_do_msp,qty_transac,id_transaction,id_product){
    $('#id_transac_minus').val(id_transaction)
    $('#id_detail_do_kurang').val(id_detail_do_msp);
    $('#qty_tras_kurang').val(parseFloat(qty_transac));
    $('#id_product_minus').val(id_product);
  }

  function revisi(id_detail_do_msp, qty_transac, id_transaction, id_product, id_project, unit) {

        $('#id_product_revisi').val(id_product);
        $('#id_project_revisi').val(id_project);
        $('#id_transac_revisi').val(id_transaction)
        $('#id_detail_do_revisi').val(id_detail_do_msp);
        $('#qty_before_revisi').val(parseFloat(qty_transac));

        if (unit == 'roll') {
          $('.unito').text('Roll') 
        } else if (unit == 'Ea') {
          $('.unito').text('Ea')
        } else if (unit == 'Bh'){
          $('.unito').text('Bh')
        } else if (unit == 'Lgh') {
          $('.unito').text('lgh')
        } else if (unit == 'Meter') {
          $('.unito').text('Meter')
        } else if (unit == 'pcs') {
          $('.unito').text('Pcs')
        } else if (unit == 'Pack') {
          $('.unito').text('Pack')
        } else {
          $('.unito').text('Unit')
        }

        
    }

  var i = 1;
  $('#addMoreYa').click(function(){  
     i++;  
     $('#product-add').append('<tr id="row'+i+'"><td data-rowid="'+i+'" style="vertical-align: middle;"><br></td><td style="margin-bottom: 50px;"><br><select class="form-control produk" name="product[]" id="product0" data-rowid="'+i+'" style="font-size: 14px;width: 300px"><option>-- Select MSPCode --</option>@foreach($barang_copy as $data)<option value="{{$data->id_product}}" >{{$data->kode_barang}} - {{$data->nama}}</option>@endforeach</select></td><td><br><textarea type="text" class="form-control name_barangs" data-rowid="'+i+'" name="information[]" id="information" readonly></textarea></td><td><br><input type="text" name="ket_aja[]" id="ket0" class="form-control ket" data-rowid="'+i+'" readonly style="width: 80px"></td><td style="margin-bottom: 50px"><br><input type="text" class="form-control unit" placeholder="Unit" name="unit[]" id="unit" data-rowid="'+i+'" readonly style="width: 100px"></td><td style="margin-bottom: 50px"><br><select class="form-control unite" data-rowid="'+i+'" name="unite" id="unite" style="display: none"><option value="" readonly>Select</option><option value="roll">roll</option><option value="meter">meter</option></select></td><td style="margin-bottom: 50px"><br><input type="number" class="form-control qty" step="0.01" placeholder="Qty" name="qty[]" id="qty"  data-rowid="'+i+'" style="width: 70px" required></td><td><br><a href="javascript:void(0);" id="'+i+'"class="remove"><span class="fa fa-times" style="font-size: 18px;color:red;margin-top:5px"></span></a></td></tr>');
        initproduk();
  });


  $(document).on('click', '.remove', function() {
      var trIndex = $(this).closest("tr").index();
      if(trIndex < 0)
      {
        $(".btn-submit").css("display", "none");
      }else{

        $(this).closest("tr").remove();
      }
  });

  $(document).on('click', '.delete', function() {
      var trIndex = $(this).closest("tr").index();
      $(this).closest("tr").remove();
      
  });

var checker = document.getElementById('pubs');
var sendbtn = document.getElementById('create_new');
checker.onchange = function() {
  $("#create_new").attr("disabled", !this.checked);
};

$('.modal_edit').click(function(){
  var rowid = $(this).attr("data-rowid");
  $(".qty_before[data-rowid='"+rowid+"']").prop('readonly', false).focus();
})
</script>
@endsection