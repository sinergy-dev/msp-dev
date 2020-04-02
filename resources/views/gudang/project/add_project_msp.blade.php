@extends('template.template_admin-lte')
@section('content')
<style type="text/css">

  input[type=text], select, textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: vertical;
  }

  label {
    padding: 12px 12px 12px 0;
    display: inline-block;
  }

  .container-form {
    border-radius: 5px;
    background-color: #fff;
    padding: 20px;
    border-style: solid;
    border-color: rgb(212, 217, 219);
  }

  .col-25 {
    float: left;
    width: 25%;
    margin-top: 6px;
  }

  .col-75 {
    float: left;
    width: 75%;
    margin-top: 6px;
  }

  /* Clear floats after the columns */
  .row:after {
    content: "";
    display: table;
    clear: both;
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
        text-align: center;
  }

  .hover-biru:hover{
    color: blue;
  }



  input[type=number]::-webkit-inner-spin-button, 
  input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
  }

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
    background-color: #0d1b33;
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
  	@if(Auth::User()->id_division == 'PMO')
    Form Request Delivery Order
  	@elseif(Auth::User()->id_position == 'ADMIN')
    Form Delivery Order
  	@endif
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Delivery Order</li>
    <li class="active">MSP</li>
    <li class="active">Add</li>
  </ol>
</section>

<section class="content">
  

  <div class="box">
    <div class="box-header">
      
    </div>

    <div class="box-body">
    	<form method="POST" action="{{url('inventory/store/do/msp')}}" id="modal_pr_asset" name="modal_pr_asset">
        @csrf
        <div class="row">
          <div class="col-sm-7">

          	<div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">ID Project</label>
              <div class="col-sm-10">
                <select type="text" class="form-control id_project" placeholder="Enter ID Project" name="id_project" id="id_project" required>
                 <option>-- Select Id Project --</option>
                  @foreach($project_id as $data)
                  <option value="{{$data->id_pro}}">{{$data->id_project}}</option>
                  @endforeach
                </select>
                <!-- <label class="hover-biru">Id Project belum ada ?</label> -->
              </div>
              <div class="col-sm-10" style="display: none">
              	<input type="text" name="">
              </div>
            </div>

            <fieldset class="aktifkan" disabled>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">No DO</label>
              <div class="col-sm-10">
                <input class="form-control" name="no_do" id="no_do" type="number" placeholder="Enter No">
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">To</label>
              <div class="col-sm-10">
                <input class="form-control" name="to_agen" id="to_agen" type="text" placeholder="Enter To">
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">From</label>
              <div class="col-sm-10">
              	<input type="text" name="from" id="from" class="form-control" value="PT. MULTI SOLUSINDO PERKASA" readonly placeholder="Enter From">
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Address</label>
              <div class="col-sm-10">
              	<textarea class="form-control" name="add" id="add"type="text" placeholder="Enter Address"></textarea>
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Fax</label>
              <div class="col-sm-10">
              	<input type="number" name="fax" id="fax" class="form-control" placeholder="Enter Fax.">
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Attn.</label>
              <div class="col-sm-10">
              	<input type="text" name="att" id="att" class="form-control" placeholder="Enter Attention">
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Subj.</label>
              <div class="col-sm-10">
                <textarea type="text" name="subj" id="subj" class="form-control" placeholder="Enter Subject"></textarea>
              </div>
            </div> 

            </fieldset>
          </div>

          <div class="col-sm-5">
          	<fieldset class="aktifkan" disabled>
            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-4 control-label">Date</label>
              <div class="col-sm-8">
                <input class="form-control" id="todays" type="date" name="date_today">
              </div>
            </div>

          
            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-4 control-label">Telp</label>
              <div class="col-sm-8">
              	<input type="number" name="telp" id="telp" class="form-control" placeholder="Enter No. Telp">
              </div>
            </div>


            @if(Auth::user()->id_position == 'ADMIN' || Auth::User()->email == 'budigunawan@solusindoperkasa.co.id')
            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-4 control-label">Requested By PM :</label>
              <div class="col-sm-8">
                <select name="pm_nik" id="pm_nik">
                  @foreach($owner as $data)
                    @if($data->id_company == '2' && $data->id_position == 'PM')
                    	@if($data->email != 'tri@solusindo.co.id' && $data->email != 'reggy@sinergy.co.id' && $data->email != 'edi@sinergy.co.id' && $data->email != 'irkham@sinergy.co.id')
	                  	<option value="{{$data->nik}}">{{$data->name}}</option>
                    	@endif
                    @endif
                  @endforeach
                </select>
              </div>
            </div>
        	</fieldset>

            
            <div class="form-group row" style="margin-left: -12px;">
              <label class="col-sm-4 control-label">No Purchase Order :</label>
              <div class="col-sm-8">
                <select name="po-number" id="po-number" class="po-number" disabled>
                  <option value="">-- Select Purchase Order --</option>
                  @foreach($no_po as $data)
                  <option value="{{$data->id_po_asset}}">{{$data->no_po}} - {{$data->to_agen}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            @endif
          </div>
          <legend></legend>

	      <div class="row" style="overflow:auto;margin-left: 10px;margin-right: 10px" >

          <div class="form-group">
          	<legend><u>Add Product</u></legend>
            <table class="table table-bordered" width="100%" id="table" style="width: 1200px">
              <thead>
              <tr>
                <th rowspan="2" style="text-align: center;vertical-align:center;">MSP Code</th>
                <th rowspan="2" style="text-align: center;vertical-align:center;" width="40%">Description</th>
                <th colspan="2" style="text-align: center;vertical-align:center;">Qty</th>
                <th rowspan="2" style="text-align: center;vertical-align:center;">Unit</th>
              </tr>
              <tr>
                <th style="text-align: center;vertical-align:center; width: 20px;" >PO</th>
                <th style="text-align: center;vertical-align:center;" width="10%">DO</th>
              </tr>
              </thead>
              <tbody id="mytable">
                
              </tbody>
            </table>
          </div>

          <legend><u>Add Product</u></legend>
	      	<table id="product-add" class="table product-add" width="100%">
	          <input type="" name="id_pam_set" id="id_pam_set" hidden>
	          <tr class="tr-header">
              <th><center>No</center></th>
	            <th width="50%"><center>MSP Code</center></th>
	            <th><center>Description</center></th>
	            <th><center>Stock</center></th>
              <th><center>Unit</center></th>
              <th></th>
	            <th><center>Qty</center></th>
	            <th>
	              <div id="plusss">
	              <a href="javascript:void(0);" style="font-size:18px" id="addMoreYa"><span class="fa fa-plus"></span></a>
	              </div>
	            </th>
	          </tr>
	          <tr>
              <td data-rowid="0" style="vertical-align: middle;"></td>
	            <td>
	              <br><select class="form-control produk" name="product[]" id="product0" data-rowid="0" style="font-size: 14px;width: 300px">
	                <option>-- Select MSPCode --</option>
	                @foreach($barang as $data)
	                <option value="{{$data->id_product}}" >{{$data->kode_barang}} - {{$data->nama}}</option>
	                @endforeach
	              </select>
	            </td>
	            <td>
	              <br>
	              <textarea type="text" class="form-control name_barangs" style="width:300px" data-rowid="0" name="information[]" id="information" readonly></textarea>
	            </td>
	            <td>
	              <br>
	              <input type="text" name="ket_aja[]" id="ket0" class="form-control ket" data-rowid="0" readonly style="width: 80px">
	            </td>
              <td hidden>
                <br>
                <input type="text" value="" name="qty_terima[]" id="ket0" class="form-control ket" data-rowid="0" readonly style="width: 80px">
              </td>
              <td hidden>
                <br>
                <input type="text" value="" name="qty_awal_po[]" id="ket0" class="form-control ket" data-rowid="0" readonly style="width: 80px">
              </td>
              <td style="margin-bottom: 50px">
                <br>
                <input type="text" class="form-control unit" name="unit[]" id="unit" data-rowid="0" readonly style="width: 100px">
              </td>
              <td style="margin-bottom: 50px">
                <br>
                <select class="form-control unite unite3" data-rowid="0" name="unite[]" id="unite" style="display: none">
                    <option value="" readonly>Select</option>
                    <option value="roll">roll</option>
                    <option value="meter">meter</option>
                </select>
              </td>
	            <td style="margin-bottom: 50px">
	              <br>
                <input type="number" class="form-control qty" step="0.01" placeholder="Qty" name="qty[]" id="qty"  data-rowid="0" style="width: 70px;">
	            </td>
	            <td>
	              <a href='javascript:void(0);'  class='remove'><span class='fa fa-times' style="font-size: 18px;color: red;margin-top: 25px"></span></a>
	            </td>
	          </tr>
	      	</table>

		      	<div class="col-sm-11" id="submit-btn">
		          <br>
		          @if($detail == NULL)
		          <button type="submit" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
		          @endif
		        </div> 
	  		</div>
        </div>
        
      </form>
    </div>
  </div>

  <div class="modal fade" id="add_id_pro" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create Project Id</h4>
        </div>
        <form method="POST" action="{{url('/add_id_pro')}}">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <input type="" name="last_idpro" value="{{$idpro->id_pro}}" hidden="">
              <input type="text" name="input_id_project" id="input_id_project" class="form-control" placeholder="Masukkan Id Project">
            </div>
          </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary">&nbspSubmit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
        </div>
        </form>
        </div>
        </div>
      </div>
  </div>
</section>

<style type="text/css">
   .transparant{
      background-color: Transparent;
      background-repeat:no-repeat;
      border: none;
      cursor:pointer;
      overflow: hidden;
      outline:none;
      width: 25px;
    }
    .select2{
    	width: 100%!important;
    }

</style>

@endsection

@section('script')
  <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
  <!-- <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap" async defer></script> -->
  <script type="text/javascript">
  	function showMe(e) {
	// i am spammy!
	  alert(e.value);
	}

	$('.produk').select2();

    $('.id_project').select2();

    var $beh = $('.id_project').val();

	$('.id_project').on('change',function(e){
		if ($beh != '') {
			$(".aktifkan").prop('disabled', false);
			$(".po-number").prop('disabled', false);
		}else{
			$(".aktifkan").prop('disabled', true);
			$(".po-number").prop('disabled', true);
		}
		

	})

    $('.submit_id_pro').click(function(){
      var input_id_project = $("input[name=input_id_project]").val(); 
      console.log(input_id_project);
      $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '/add_id_pro',
          type: "POST",
          data: $('#add_id_pro').serialize(), 
          success:  function(data){
              //alert("---"+data);
              alert("Project Id has been updated successfully.");
              window.location.reload(true);
          }
      });
    }) 

    function initproduk(){
      $('.produk').select2();
    }

    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
         $("#alert").slideUp(300);
    });

    $('#data_Table').DataTable( {
     "scrollX": true,
    });

    $("#po-number").select2();

    var i = 1;
    $('#addMore').click(function(){  
           i++;  
           $('#product-add').append('<tr id="row'+i+'"><td><br><select class="form-control produk" name="product[]" data-rowid="'+i+'" id="product'+i+'" style="font-size: 14px;width: 300px"><option>-- Select MSPCode --</option>@foreach($barang as $data)<option value="{{$data->id_product}}" >{{$data->kode_barang}} - {{$data->nama}}</option>@endforeach</select></td><td><br><textarea type="text" class="form-control name_barangs" style="width:500px" data-rowid="'+i+'" name="information[]" id="information" readonly></textarea></td><td><br><input type="text" name="ket_aja[]" id="ket0" class="form-control ket" data-rowid="'+i+'" readonly style="width: 50px"></td><td><br><input type="number" class="form-control qty" placeholder="Qty" name="qty[]" id="qty" data-rowid="'+i+'" style="width:60px"></td><td><br><input type="text" readonly class="form-control unit" placeholder="Unit" name="unit[]" id="unit'+i+'" data-rowid="'+i+'" style="width:100px"></td><td style="margin-bottom: 50px"><br><div id="ifYes" style="display: none"><input type="" name="kg[]" placeholder="Kg" style="width: 50px" class="form-control"></div></td><td style="margin-bottom: 50px"><br><div id="volYes" style="display: none"><input type="" name="vol[]" placeholder="Vol" style="width: 50px" class="form-control"></div></td><td><a href="javascript:void(0);" id="'+i+'"class="remove"><span class="fa fa-times" style="font-size: 18px;color:red;margin-top: 25px"></span></a></td></tr>');
           initproduk();
    });

    $('#addMoreYa').click(function(){  
           i++;  
           $('#product-add').append('<tr id="row'+i+'"><td data-rowid="'+i+'" style="vertical-align: middle;"><br></td><td style="margin-bottom: 50px;"><br><select class="form-control produk" name="product[]" id="product0" data-rowid="'+i+'" style="font-size: 14px;width: 300px"><option>-- Select MSPCode --</option>@foreach($barang as $data)<option value="{{$data->id_product}}" >{{$data->kode_barang}} - {{$data->nama}}</option>@endforeach</select></td><td><br><textarea type="text" class="form-control name_barangs" style="width:300px" data-rowid="'+i+'" name="information[]" id="information" readonly></textarea></td><td><br><input type="text" name="ket_aja[]" id="ket0" class="form-control ket" data-rowid="'+i+'" readonly style="width: 80px"></td><td hidden><br><input type="text" name="qty_terima[]" value="" id="ket0" class="form-control ket" data-rowid="'+i+'" readonly style="width: 80px"></td><td hidden><br><input type="text" name="qty_awal_po[]" value="" id="ket0" class="form-control ket" data-rowid="'+i+'" readonly style="width: 80px"></td><td style="margin-bottom: 50px"><br><input type="text" class="form-control unit" placeholder="Unit" name="unit[]" id="unit" data-rowid="'+i+'" readonly style="width: 100px"></td><td style="margin-bottom: 50px"><br><select class="form-control unite unite4" data-rowid="'+i+'" name="unite[]" id="unite" style="display: none"><option value="" readonly>Select</option><option value="roll">roll</option><option value="meter">meter</option></select></td><td style="margin-bottom: 50px"><br><input type="number" class="form-control qty" step="0.01" placeholder="Qty" name="qty[]" id="qty"  data-rowid="'+i+'" style="width: 70px" required></td><td><br><a href="javascript:void(0);" id="'+i+'"class="remove"><span class="fa fa-times" style="font-size: 18px;color:red;margin-top:5px"></span></a></td></tr>');
           initproduk();
    });

    /*$(document).on('keyup keydown', "input[id^='qty']", function(e){
    var rowid = $(this).attr("data-rowid");
    var qty_before = $(".ket[data-rowid='"+rowid+"']").val();
    console.log(qty_before);
        if ($(this).val() > parseFloat(qty_before)
            && e.keyCode != 46
            && e.keyCode != 8
           ) {
           e.preventDefault();     
           $(this).val(qty_before);
        }
    });*/

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
              $(".name_barangs[data-rowid='"+rowid+"']").val(value.nama);
              $(".produbs[data-rowid='"+rowid+"']").val(value.kode_barang);
              if (value.qty_sisa_submit == null || value.qty_sisa_submit == '0.0' ) {
                  $(".ket[data-rowid='"+rowid+"']").val(parseFloat(value.qty));
              }else{
                  $(".ket[data-rowid='"+rowid+"']").val(parseFloat(value.qty_sisa_submit));
              }
              $(".unit[data-rowid='"+rowid+"']").val(value.unit);
              $(".qty[data-rowid='"+rowid+"']").val('');
              
              var id = $(".produbs[data-rowid='"+rowid+"']").val();
              var unit = $(".unit[data-rowid='"+rowid+"']").val();

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

    $('#po-number').on('change',function(e){
      $("#table").show();

      console.log($('#po-number').val());
      var product = $('#po-number').val();

      $.ajax({
          type:"GET",
          url:'/dropdownPO2?product=' + product,
          data:{
            product:this.value,
          },
          success: function(result){
            $('#mytable').empty();

            var table = "";

            $.each(result[0], function(key, value){
              table = table + '<tr>';
                table = table + '<td hidden>' +'<input type="text" name="product[]" style="width:80px;" class="transparant" value="'+value.id_product_inventory+'" readonly>'+ '</td>'
                table = table + '<td >' +'<input type="text" name="msp_code_edit[]" id="msp_code_edit" style="width:80px;" class="transparant" value="'+value.msp_code+'" readonly>'+ '</td>';
                table = table + '<td >' +'<textarea name="information[]" style="width:300px" class="transparant" readonly>'+value.name_product+'</textarea>'+'</td>';
                if (value.qty_do == null) {
                	table = table + '<td >' +'<input type="number" name="qty_terima[]" id="qty_katalog" class="qty_katalog" style="width:35px;height:30px;border:none;" value="'+value.qty_terima+'" readonly>'+ '</td>';
                } else{
                	table = table + '<td >' +'<input type="number" name="qty_terima[]" id="qty_katalog" class="qty_katalog" style="width:35px;height:30px;border:none;" value="'+value.qty_do+'" readonly>'+ '</td>';
                }
                if (value.qty_sisa_submit == null || value.qty_sisa_submit == '0.0' ) {
  	                table = table + '<td hidden>' +'<input type="number" name="ket_aja[]" id="qty_master" data-rowid="'+value.msp_code+'" class="qty_katalog ket_aja" style="width:55px;height:30px;border:none;" value="'+value.qty_master+'" readonly>'+ '</td>';
  	            }else{
  	                table = table + '<td hidden>' +'<input type="number" name="ket_aja[]" id="qty_master" data-rowid="'+value.msp_code+'" class="qty_katalog ket_aja" style="width:55px;height:30px;border:none;" value="'+value.qty_sisa_submit+'" readonly>'+ '</td>';
  	            }
                table = table + '<td >' + '<input type="number" name="qty[]" value="0" id="qty_terima" data-rowid="'+value.msp_code+'" placeholder="0" class="form-control qty_terima" style="width:70px;" required">'+ '</td>';
                table = table + '<td hidden>' + '<input type="number" name="qty_awal_po[]" id="qty_awal_po" data-rowid="'+value.msp_code+'" placeholder="0" class="form-control qty_awal_po" style="width:70px;" required">'+ '</td>';
                if (value.unit == 'roll') {
                  table = table + '<td >' +'<input type="text" name="unit[]" style="width:70px" data-rowid="'+value.msp_code+'" class="transparant unitt" value="'+value.unit+'" readonly>'+ '</td>';
                  table = table + '<td >' +'<select class="form-control unite2" data-rowid="'+value.msp_code+'" name="unite[]" id="unite2"><option value="" readonly>Select</option><option value="roll">roll</option> <option value="meter">meter</option></select>' + '</td>';
                  $(document).on('change',"select[id^='unite2']",function(e) { 
                  	var rowid = $(this).attr("data-rowid");

                    var unite2 = $(".unite2[data-rowid='"+rowid+"']").val();

                    console.log(unite2);

                    if (unite2 == 'roll') {
                    	$(".unitt[data-rowid='"+rowid+"']").val('roll');
                  	}else if (unite2 == 'meter') {
                    	$(".unitt[data-rowid='"+rowid+"']").val('meter');
                  	}
                  });
                } else {
                  table = table + '<td >' +'<input type="text" name="unit[]" style="width:70px" class="transparant" value="'+value.unit+'" readonly>'+ '</td>';
                  table = table + '<td hidden>' +'<select class="form-control unite2"  name="unite[]" id="unite2"><option value="" readonly>Select</option><option value="roll">roll</option> <option value="meter">meter</option></select>' + '</td>';
                }
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

	$(document).on('keyup', "input[id^='qty_terima']", function(e){
    	var rowid = $(this).attr("data-rowid");
    	$("#qty_awal_po[data-rowid='" + rowid + "']").val($("#qty_terima[data-rowid='" + rowid + "']").val()).change();
    	console.log(rowid);
    })

    $(document).on('click', '.remove', function() {
       var trIndex = $(this).closest("tr").index();
       $(this).closest("tr").remove();   
    });


    $(".dismisbar").click(function(){
      $(".notification-bar").slideUp(300);
    });

    /*let today = new Date().toISOString().substr(0, 10);
    document.querySelector("#todays").value = today;*/

    $('.hover-biru').click(function(){
      $('#add_id_pro').modal('show');
      // $("#munculkan").toggle("slow");
    })


  </script>
@endsection