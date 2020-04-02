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
    Copy PO MSP
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">PR Asset</li>
    <li class="active">MSP</li>
    <li class="active">Add</li>
  </ol>
</section>

<section class="content">
  

  <div class="box">
    <div class="box-header">
      
    </div>

    <div class="box-body">
      <form method="POST" action="{{url('store_copy_po')}}" id="modal_pr_asset" name="modal_pr_asset">
        @csrf
        <div class="row">

          <div class="col-sm-7">
            <legend>Purchase Order</legend>
          </div>



          <div class="col-sm-7">
            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">No PR</label>
              <div class="col-sm-10">
                <select class="form-control" id="no_pr" name="no_pr" required>
                  <option value="">-- Select No PR --</option>
                  @foreach($no_pr as $data)
                      <option value="{{$data->no}}">{{$data->no_pr}} - {{$data->subject}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            
            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">To</label>
              <div class="col-sm-10">
                <input class="form-control" name="to_agen" id="to_agen" value="{{$tampilkan->to_agen}}" type="text" placeholder="Enter To" >
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Address</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="address" id="add" type="text" placeholder="Enter Address">{{$tampilkan->address}}</textarea>
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Fax</label>
              <div class="col-sm-10">
                <input type="number" name="fax" id="fax" class="form-control" value="{{$tampilkan->fax}}" placeholder="Enter Fax.">
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Telp</label>
              <div class="col-sm-10">
                <input type="number" name="telp" id="telp" class="form-control" value="{{$tampilkan->telp}}" placeholder="Enter Telp.">
              </div>
            </div>

             <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10">
                <input type="text" name="email" id="email" class="form-control" value="{{$tampilkan->email}}" placeholder="Enter Email.">
              </div>
            </div>

            
          </div>

          <div class="col-sm-5">
            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Date</label>
              <div class="col-sm-10">
                <input class="form-control" id="today" type="date" readonly>
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Project</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Enter Project" name="project" id="project" value="{{$tampilkan->project}}">
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">ID Project</label>
              <div class="col-sm-10">
                <input type="text" class="" placeholder="Enter Project" name="project_id" id="project_id" hidden>
                <input type="text" class="form-control" placeholder="Enter Project" name="id_project" id="id_project">
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Attn.</label>
              <div class="col-sm-10">
                <input type="text" name="att" id="att" class="form-control" value="{{$tampilkan->attention}}" placeholder="Enter Attention">
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Subj.</label>
              <div class="col-sm-10">
                <textarea type="text" name="subject" id="subj" class="form-control"  placeholder="Enter Subject">{{$tampilkan->subject}}</textarea>
              </div>
            </div> 
          </div>

          
        </div>

        <legend>Product</legend>

        <div class="col-md-12" style="overflow:auto;margin-left: 10px;margin-right: 10px">
          <table id="product-add" class="table table-bordered product-add" width="100%">
            <input type="" name="id_pam_set" id="id_pam_set" hidden>
            <tr class="tr-header">
              <th>No</th>
              <th width="30%">MSP Code</th>
              <th width="30%">Description</th>
              <th>Qty</th>
              <th width="10%">Unit</th>
              <th width="10%">
                <div id="plusss">
                <a href="javascript:void(0);" style="font-size:18px" id="addMoreYa"><span class="fa fa-plus"></span></a>
                </div>
              </th>
            </tr>
            @foreach($produks as $data)
            <tr>
              <td data-rowid="0" style="vertical-align: middle;"><br></td>
              <td style="margin-bottom: 50px;">
                <br>
                <input type="" class="id_produks" name="product[]" id="product[]" data-rowid="{{$data->id_product}}" value="{{$data->id_product}}" hidden="">
                <input type="" class="id_produks" name="msp_code[]" id="msp_code[]" data-rowid="{{$data->id_product}}" value="{{$data->kode_barang}}" hidden="">
                {{$data->msp_code}}
              </td>
              <td>
                <br>
                <input type="text" name="information[]" value="{{$data->name_product}}" readonly hidden>
                {{$data->name_product}}
              </td>
              <td>
                <br>
                <input type="" name="ket_aja[]" class="form-control ket_aja" id="ket_aja" data-rowid="{{$data->id_product}}" style="border-style: none;width: 60px" value="{{$data->qty}}" readonly="">
              </td>
              <td style="margin-bottom: 50px">
                <br>
                <input type="text" class="transparant" name="unit[]" value="{{$data->unit}}" readonly hidden>
                {{$data->unit}}
              </td>
              <td>
                <br>
                <button class="btn btn-sm btn-primary edit_btn" style="width: 30px" data-rowid="{{$data->id_product}}" id="edit_btn" type="button"><i class="fa fa-edit"></i></button>
                <button class="btn btn-sm btn-danger" style="width: 30px"  onclick="return confirm('Are you sure want to delete this data?')"><i class="fa fa-times"></i></button>
              </td>
            </tr>
            @endforeach
            </table>
            <div class="col-md-12">
              <hr style="border-top: 1px solid red;">
              <div class="form-group">
                <label>*Please Check Agree For Create New Copy PO</label><br>
                <label class="margin-right">Agree</label>
                <input type="checkbox" style="width:7px;height:7px;margin-left: 10px" name="" class="pubs" id="pubs"><br>
                <button class="btn btn-sm btn-success" id="create_new" disabled type="submit" >Create New</button>
              </div> 
            </div>
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


   $(document).on('click', ".edit_btn", function(e){
    var rowid = $(this).attr("data-rowid");
    $(".edit_btn[data-rowid='"+rowid+"']").removeClass("edit_btn").addClass("save-btn");
     //document.getElementsByClassName("ket_aja").readOnly = false;
     // document.getElementsByClassName("ket_aja")[rowid].readOnly = true; 
     // $("#ket_aja").readOnly = true;
     $(".ket_aja[data-rowid='"+rowid+"']").prop('readonly', false);
     console.log(rowid);
   });


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

     function removeRow(oButton) {
        var empTab = document.getElementById('mytable');
        empTab.deleteRow(oButton.parentNode.parentNode.rowIndex);       // BUTTON -> TD -> TR.
    }

    $('#no_pr').on('change', function(e){
      var Product = $('#no_pr').val();

         $.ajax({
          type:"GET",
          url:'/getdatapr',
          data:{
            Product:this.value,
          },
          success: function(result){
            $.each(result[0], function(key, value){
              if (value.project_id == null) {
                $("#project_id").val();
                $("#id_project").val('');
               }
              $("#id_project").val(value.id_project);
              $("#project_id").val(value.project_id);
            });
          }
        });
         console.log($('#no_pr').val());
    });

    var i = 1;
    $('#addMoreYa').click(function(){  
       i++;  
       $('#product-add').append('<tr id="row'+i+'"><td data-rowid="'+i+'" style="vertical-align: middle;"><br></td><td style="margin-bottom: 50px;"><br><select class="form-control produk" name="product[]" id="product" data-rowid="'+i+'" style="font-size: 14px;width: 300px"><option>-- Select MSPCode --</option>@foreach($msp_code as $data)<option value="{{$data->id_product}}" >{{$data->kode_barang}} - {{$data->nama}}</option>@endforeach</select></td><td><br><textarea type="text" class="form-control name_barangs" data-rowid="'+i+'" name="information[]" id="information" readonly></textarea></td><td><br><input type="number" class="form-control qty" step="0.01" placeholder="Qty" name="ket_aja[]" id="qty"  data-rowid="'+i+'" style="width: 70px" required></td><td style="margin-bottom: 50px"><br><input type="text" class="form-control unit" data-rowid="'+i+'" name="unit[]" readonly ></td><td><br><a href="javascript:void(0);" id="'+i+'"class="remove"><span class="fa fa-times" style="font-size: 18px;color:red;margin-top:5px"></span></a></td></tr>');
         initproduk();
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
              $(".id_barangs[data-rowid='"+rowid+"']").val(value.id_product);
              $(".ket[data-rowid='"+rowid+"']").val(value.qty);
              $(".unit[data-rowid='"+rowid+"']").val(value.unit);
              $(".name_barangs[data-rowid='"+rowid+"']").val(value.nama);

            });
          }
        });
  });

    $(".dismisbar").click(function(){
      $(".notification-bar").slideUp(300);
    });

    $('#no_pr').select2();  

    $('#msp_code').select2();  

    $('#owner_pr').select2();

   
    function initproduk(){
      $('.produk').select2();
    }

    let today = new Date().toISOString().substr(0, 10);
    document.querySelector("#today").value = today;

    var checker = document.getElementById('pubs');
    var sendbtn = document.getElementById('create_new');
    checker.onchange = function() {
      $("#create_new").attr("disabled", !this.checked);
    };
  </script>
@endsection