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

.modalIcon input[type=text]{
      padding-left:40px;
    }


    .modalIcon.inputIconBg input[type=text]:focus + i{
      color:#fff;
      background-color:dodgerBlue;
    }

   .modalIcon.inputIconBg i{
      background-color:#aaa;
      color:#fff;
      padding:7px 4px ;
      border-radius:4px 0 0 4px;
    }

  .modalIcon{
      position:relative;
    }

   .modalIcon i{
      position:absolute;
      left:9px;
      top:0px;
      padding:9px 8px;
      color:#aaa;
      transition:.3s;
    }


    .newIcon input[type=text]{
      padding-left:34px;
    }

    .newIcon.inputIconBg input[type=text]:focus + i{
      color:#fff;
      background-color:dodgerBlue;
    }

   .newIcon.inputIconBg i{
      background-color:#aaa;
      color:#fff;
      padding:6px 6px ;
      border-radius:4px 0 0 4px;
    }

  .newIcon{
      position:relative;
    }

   .newIcon i{
      position:absolute;
      left:0px;
      top:34px;
      padding:9px 8px;
      color:#aaa;
      transition:.3s;
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
    Do-Sup
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Gudang</li>
    <li class="active">MSP</li>
    <li class="active">Add</li>
  </ol>
</section>

<section class="content">
  

  <div class="box">
    <div class="box-header">
      
    </div>

    <div class="box-body">
      @if($detail != NULL)
      <form method="POST" action="" id="modal_pr_asset" name="modal_pr_asset">
      @else
      <form method="POST" action="{{url('store_do_sup')}}" id="modal_pr_asset" name="modal_pr_asset">
      @endif
        @csrf
        <div class="row">

          <div class="col-sm-7">
            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">No. DO Supplier</label>
              @if($detail != NULL)
              <div class="col-sm-10">
                <input class="form-control" name="do_sup" id="do_sup" type="text" value="{{$detail->no_do_sup}}" placeholder="Enter No. DO Supplier" readonly>
              </div>
              @else
              <div class="col-sm-10">
                <input class="form-control" name="do_sup" id="do_sup" type="text" value="" placeholder="Enter No. DO Supplier">
              </div>
              @endif
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">To</label>
              @if($detail != NULL)
              <div class="col-sm-10">
                <input class="form-control" name="to_agen" id="to_agen" type="text" value="{{$detail->to_agen}}" placeholder="Enter To" readonly>
              </div>
              @else
              <div class="col-sm-10">
                <input class="form-control" name="to_agen" id="to_agen" type="text" placeholder="Enter To">
              </div>
              @endif
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Address</label>
              @if($detail != NULL)
              <div class="col-sm-10">
                <textarea class="form-control" name="add" id="add" type="text" placeholder="Enter Address" readonly>{{$detail->address}}</textarea>
              </div>
              @else
              <div class="col-sm-10">
                <textarea class="form-control" name="add" id="add" type="text" placeholder="Enter Address"></textarea>
              </div>
              @endif
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Fax</label>
              @if($detail != NULL)
              <div class="col-sm-10">
                <input type="text" name="fax" id="fax" class="form-control" value="{{$detail->fax}}" placeholder="Enter Fax." readonly>
              </div>
              @else
              <div class="col-sm-10">
                <input type="text" name="fax" id="fax" class="form-control" placeholder="Enter Fax.">
              </div>
              @endif
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Email</label>
              @if($detail != NULL)
              <div class="col-sm-10">
                <input type="text" name="email" id="email" class="form-control" value="{{$detail->email}}" placeholder="Enter email." readonly>
              </div>
              @else
              <div class="col-sm-10">
                <input type="text" name="email" id="email" class="form-control" placeholder="Enter email.">
              </div>
              @endif
              
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Attn.</label>
              @if($detail != NULL)
              <div class="col-sm-10">
                <input type="text" name="att" id="att" class="form-control" value="{{$detail->attention}}" placeholder="Enter Attention" readonly>
              </div>
              @else
              <div class="col-sm-10">
                <input type="text" name="att" id="att" class="form-control" placeholder="Enter Attention">
              </div>
              @endif
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Subj.</label>
              @if($detail != NULL)
              <div class="col-sm-10">
                <textarea type="text" name="subject" id="subj" class="form-control" placeholder="Enter Subject" readonly>{{$detail->subject}}</textarea>
              </div>
              @else
              <div class="col-sm-10">
                <textarea type="text" name="subject" id="subj" class="form-control" placeholder="Enter Subject"></textarea>
              </div>
              @endif
              
            </div> 

       
          </div>
          <div class="col-sm-5">
            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-4 control-label">Date</label>
              @if($detail != NULL)
              <div class="col-sm-8">
                <input class="form-control" id="today" type="date" value="{{$detail->date_handover}}" readonly>
              </div>
              @else
              <div class="col-sm-8">
                <input class="form-control" id="todays" type="date" readonly>
              </div>
              @endif
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-4 control-label">Project</label>
              @if($detail != NULL)
              <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="Enter Project" value="{{$detail->project}}" name="project" id="project" readonly>
              </div>
              @else
              <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="Enter Project" name="project" id="project">
              </div>
              @endif
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-4 control-label">ID Project</label>
              @if($detail != NULL)
              <div class="col-sm-8">
                <select class="form-control" id="project_id" name="project_id">
                  @foreach($project_id as $data)
                  <option value="{{$data->id_project}}"
                        @if($data->id_project === $detail->project_id)
                          selected
                        @endif>{{$data->id_project}}</option>
                  @endforeach
                </select>
              </div>
              @else
              <div class="col-sm-8">
                <select class="form-control" id="project_id" name="project_id">
                  <option value="">-- Select Project ID --</option>
                    @foreach($project_id as $data)
                        <option value="{{$data->id_project}}">{{$data->id_project}}</option>
                    @endforeach
                </select>
              </div>
              @endif
            </div>
            

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-4 control-label">Telp</label>
              @if($detail != NULL)
              <div class="col-sm-8">
                <input type="number" name="telp" id="telp" class="form-control" value="{{$detail->telp}}" placeholder="Enter No. Telp" readonly>
              </div>
              @else
              <div class="col-sm-8">
                <input type="number" name="telp" id="telp" class="form-control" placeholder="Enter No. Telp">
              </div>
              @endif
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-4 control-label">Terms & Condition</label>
              @if($detail != NULL)
              <div class="col-sm-8">
                <textarea class="form-control" name="term" id="term" placeholder="Enter Terms & Condition" readonly>{!! $detail->term !!}</textarea>
              </div>
              @else
              <div class="col-sm-8">
                <textarea class="form-control" name="term" id="term" placeholder="Enter Terms & Condition"></textarea>
              </div>
              @endif
            </div>

            <div class="form-group">
              <label for="">PPn.(Harus Diisi)</label><br>
              <label class="radios">Ya
                <input type="radio" name="ppn" id="yesCheck" value="YA" onclick="javascript:yesnoCheck();" required>
                <span class="checkmark"></span>
              </label>
              <label class="radios">Tidak
                <input type="radio" name="ppn" id="noCheck" value="TIDAK" onclick="javascript:yesnoCheck();" required>
                <span class="checkmark"></span>
              </label>
            </div>

          </div>

     <!--      <table id="product-add" class="table margin-left" >
            <input type="" name="id_pam_set" id="id_pam_set" hidden>
            <tr class="tr-header">
              <th style="width: 300px">Product</th>
              <th style="width: 100px">Qty</th>
              <th style="width: 100px">Unit</th>
              <th style="width: 500px">Description</th>
              <th style="width: 100px">Kg</th>
              <th style="width: 100px">Vol</th>
              <th>
                <div id="plusss">
                <a href="javascript:void(0);" style="font-size:18px;" id="addMoreYa"><span class="fa fa-plus"></span></a>
                </div>
              </th>
            </tr>
            <tr>
              <td style="margin-bottom: 50px;">
                <br>
                <input type="text" class="form-control" name="barang" id="barang">
              </td>
              <td style="margin-bottom: 50px">
                <br>
                <input type="number" class="form-control qty" placeholder="Qty" name="qty[]" id="qty" required>
              </td>
              <td style="margin-bottom: 50px">
                <br>
                <input type="text" class="form-control unit" placeholder="Unit" name="unit[]" id="unit" >
              </td>
              <td style="margin-bottom: 50px">
                <br>
                <textarea type="text" class="form-control"  name="information[]" id="information"></textarea>
              </td>
              <td style="margin-bottom: 50px">
                <br>
                <input type="" name="kg[]" placeholder="Kg" class="form-control">
              </td>
              <td style="margin-bottom: 50px">
                <br>
                <input type="" name="vol[]" placeholder="Vol" class="form-control">
              </td>
              <td>
                <a href='javascript:void(0);'  class='remove'><span class='fa fa-times' style="font-size: 18px;color: red;margin-top: 25px"></span></a>
              </td>
            </tr>
          </table> -->

          @if($detail != NULL)
            <table class="table table-bordered table-striped" style="margin-right: 10px;margin-left:10px " cellspacing="0">
              <thead>
              <tr>
                <th colspan="7" style="text-align: center;">LIST PRODUK</th>
              </tr>
              <tr>
                <th>NO ID</th>
                <th>MSP Code</th>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total Price</th>
              </tr>
              </thead>
              <tbody>
              <?php $no = 1;?>
              @foreach($barang_detail as $data)
              <tr>
                <td>{{$no++}}</td>
                <td>{{$data->msp_code}}</td>
                <td>{{$data->name_product}}</td>
                <td>{{$data->qty}}</td>
                <td><b class="money">{{$data->nominal}}</b></td>
                <td><b class="money">{{$data->total_nominal}}</b></td>
              </tr>
              @endforeach
              </tbody>
            </table>
          @else
          @endif
          

          <table id="product-add" class="table margin-left">
            <h2 style="margin-left: 20px">Add Produk</h2>
            <tr class="tr-header">
              <th>MSP Code</th>
              <th>Name</th>
              <th>Qty</th>
              <th>Unit</th>
              <th>Nominal</th>
              <th>Description</th>
              <th><a href="javascript:void(0);" style="font-size:18px;" id="addMore"><span class="fa fa-plus"></span></a></th>
            </tr>
            <tr>
              <td style="margin-bottom: 50px;">
                <br><select class="form-control searchcode" name="msp_code[]" id="msp_code" data-rowid="0" style="font-size: 14px" required>
                  <option>-- Select Product --</option>
                  @foreach($msp_code as $data)
                      <option value="{{$data->kode_barang}}">{{$data->kode_barang}}</option>
                  @endforeach
                </select>
              </td>
              <td hidden>    
                <input type="" name="id_barangs[]" id="id_barangs" class="id_barangs" value="" data-rowid="0" hidden>
              </td>
              <td style="margin-bottom: 50px">
                <br><input type="text" class="form-control name_barangs" data-rowid="0" placeholder="Enter Name" name="name_product[]" id="name" readonly>
              </td>
              <td style="margin-bottom: 50px;">
                <br>
               <input type="number" class="form-control" placeholder="qty" name="qty[]" id="quantity" style="width: 70px;font-size: 14px" required>
              </td>
              <td style="margin-bottom: 50px">
                <br><input type="text" class="form-control unit" placeholder="Enter unit" name="unit[]" id="unit" data-rowid="0" readonly>
              </td>
              <td style="margin-bottom: 50px">
                <br><div class="modalIcon inputIconBg" style="padding-left: 10px">
                <input type="text" class="form-control money" placeholder="Enter Amount" name="nominal[]" id="nominal[]" required>
                <i class="" aria-hidden="true">Rp.</i>
                </div>
              </td>
              <td style="margin-bottom: 50px">
                <br>
                <textarea type="text" class="form-control" style="width:500px" name="ket[]" id="information"></textarea>
              </td>
              <td>
                <a href='javascript:void(0);'  class='remove'><span class='fa fa-times' style="font-size: 18px;margin-top: 20px;color: red;"></span></a>
              </td>
            </tr>
          </table>
        </div>

        <div class="row" style="margin-left:5px" id="btn_submit">
          <br>
          @if($detail != NULL)
          <button type="submit" class="btn btn-warning"><i class="fa fa-check"> </i>&nbspUpdate</button>
          @else
          <button type="submit" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
          @endif
        </div>
      </form>
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

</style>

@endsection

@section('script')
  <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript">
  	function showMe(e) {
	// i am spammy!
	  alert(e.value);
	}
/*
    $('.produk').select2();

    function initproduk(){
      $('.produk').select2();
    }*/

    function yesnoCheck() {
      if (document.getElementById('yesCheck').checked) {
      // document.getElementById('product-add').style.display = 'block'; 
      document.getElementById('btn_submit').style.display = 'block';
      $("#product-add").find("tr:gt(1)").remove();
      }
      else {
      // document.getElementById('product-add').style.display = 'block'; 
      document.getElementById('btn_submit').style.display = 'block';
      $("#product-add").find("tr:gt(1)").remove();
      }
    }

    function edit_product(id_transaction,no_do){
        $('#id_transaction_edit').val(id_transaction);
        $('#no_do_edit').val(no_do);
    }


    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
         $("#alert").slideUp(300);
    });

    $('#data_Table').DataTable( {
     "scrollX": true,
    });

    var i = 1;
    $('#addMore').click(function(){  
         i++;  
         /*$('#product-add').append('<tr id="row'+i+'"><td style="margin-bottom: 50px;"><br><input type="text" class="form-control" name="barang" id="barang"></td><td style="margin-bottom: 50px"><br><input type="number" class="form-control qty" placeholder="Qty" name="qty[]" id="qty" required></td><td style="margin-bottom: 50px"><br><input type="text" class="form-control unit" placeholder="Unit" name="unit[]" id="unit"></td><td style="margin-bottom: 50px"><br><textarea type="text" class="form-control"  name="information[]" id="information"></textarea></td>><td style="margin-bottom: 50px"><br><input type="" name="kg[]" placeholder="Kg" class="form-control"></td><td style="margin-bottom: 50px"><br><input type="" name="vol[]" placeholder="Vol" class="form-control"></td><td><br><a href="javascript:void(0);" id="'+i+'"class="remove"><span class="fa fa-times" style="font-size: 18px;color:red;margin-top:5px"></span></a></td></tr>');*/

         $('#product-add').append('<tr id="row'+i+'"><td style="margin-bottom:50px;"><br><select class="form-control searchcode" id="msp_code" data-rowid="'+i+'" name="msp_code[]" required><option value="">-- Select Product--</option>@foreach($msp_code as $data)<option value="{{$data->kode_barang}}">{{$data->kode_barang}}</option>@endforeach</select></td> <td hidden><input type="" name="id_barangs[]" id="id_barangs" class="id_barangs" value="" data-rowid="'+i+'"></td><td><br><input type="text" class="form-control name_barangs" data-rowid="'+i+'" placeholder="Enter Name" name="name_product[]" id="name" readonly required></td><td><br> <input type="number" class="form-control" placeholder="qty" name="qty[]" id="quantity" style="width: 70px;font-size: 14px" required></td><td><br><input type="text" class="form-control unit" data-rowid="'+i+'" placeholder="Enter Unit" name="unit[]" id="po" required readonly></td><td style="margin-bottom: 50px"><br><div class="modalIcon inputIconBg" style="padding-left: 10px"><input type="text" class="form-control money" placeholder="Enter Amount" name="nominal[]" id="nominal[]" required><i class="" aria-hidden="true">Rp.</i></div></td><td><br><textarea type="text" class="form-control" style="width:500px" name="ket[]" id="information"></textarea></td><td><a href="javascript:void(0);" id="'+i+'"  class="remove"><span class="fa fa-times" style="font-size: 18px;color:red;margin-top:25px"></span></a></td></tr>');
         initMaskMoney();
         initsearchcode();
    });

    function initMaskMoney() {
        $('input[id^="nominal"]').mask('000,000,000,000,000', {reverse: true});
    }

    function initsearchcode() {
      $(".searchcode").select2();
    }

    $(document).on('click', '.remove', function() {
         var trIndex = $(this).closest("tr").index();
            if(trIndex>1) {
             $(this).closest("tr").remove();
           } else {
             alert("Sorry!! Can't remove first row!");
           }
    });

     function removeRow(oButton) {
        var empTab = document.getElementById('mytable');
        empTab.deleteRow(oButton.parentNode.parentNode.rowIndex);       // BUTTON -> TD -> TR.
    }

    $(document).on('change',"select[id^='msp_code']",function(e) {
      var product = $('#msp_code').val();
      var rowid = $(this).attr("data-rowid");

         $.ajax({
          type:"GET",
          url:'/getIDbarang',
          data:{
            product:this.value,
          },
          success: function(result){
            $.each(result[0], function(key, value){
               $(".id_barangs[data-rowid='"+rowid+"']").val(value.id_product);
               $(".name_barangs[data-rowid='"+rowid+"']").val(value.nama);
               $(".unit[data-rowid='"+rowid+"']").val(value.unit);
            });

          }
        });
    });

    $(".dismisbar").click(function(){
      $(".notification-bar").slideUp(300);
    });

    $('#project_id').select2();  

    $('#owner_pr').select2();

    let today = new Date().toISOString().substr(0, 10);
    document.querySelector("#todays").value = today;
    
  </script>
@endsection