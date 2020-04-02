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



input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}

</style>

<section class="content-header">
  <h1>
    Add PO Asset MSP
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

    <div class="box-body">
      <form method="POST" action="{{url('store_produk_po_msp')}}" id="modal_pr_asset" name="modal_pr_asset">
        @csrf
          <legend>Add Product</legend>

            <input type="id_pam" name="id_pam" value="{{$datas->id_po_asset}}" hidden>

            <div class="row">
              <div class="col-sm-11">
                <div class="form-group row" style="margin-left: -12px">
                  <label class="col-sm-2 control-label">No PO</label>
                  <div class="col-sm-10">
                    <input class="form-control" name="to_agen" id="to_agen" value="{{$datas->no_po}}" type="text" readonly>
                  </div>
                </div>

                <div class="form-group row" style="margin-left: -12px">
                  <label class="col-sm-2 control-label">Subj.</label>
                  <div class="col-sm-10">
                    <input class="form-control" name="subject" id="add" value="{{$datas->subject}}" type="text"  readonly>
                  </div>
                </div>

                <div class="form-group row" style="margin-left: -12px">
                  <label class="col-sm-2 control-label">To Supplier</label>
                  <div class="col-sm-10">
                    <input class="form-control" name="subject" id="add" value="{{$datas->to_agen}}" type="text"  readonly>
                  </div>
                </div>
              </div>
            </div>

            <div style="overflow: auto">
	          <table id="product-add" class="table product-add">
	            <tr class="tr-header">
	              <th>No</th>
	              <th width="30%">MSP Code</th>
	              <th>Description</th>
	              <th>Qty</th>
	              <th>Unit</th>
	              <!-- <th>Nominal</th> -->
	              <th><a href="javascript:void(0);" style="font-size:18px;" id="addMore" class="add"><span class="fa fa-plus"></span></a></th>
	            </tr>
	            <tr>
	            <td data-rowid="0" style="vertical-align: middle;"></td>
	            <td style="margin-bottom: 50px;">
	              <br><select class="form-control produk" name="msp_code[]" id="msp_code" data-rowid="0" style="font-size: 14px;width: 300px">
	                <option>-- Select MSP Code --</option>
	                @foreach($msp_code as $data)
	                   <option value="{{$data->kode_barang}}" >{{$data->kode_barang}} - {{$data->nama}}</option>
	                @endforeach
	              </select>
	            </td>
	              <td hidden>    
	                <input type="" name="id_barangs[]" id="id_barangs" class="id_barangs" value="" data-rowid="0" hidden>
	              </td>
	              <td style="margin-bottom: 50px">
	                <br>
	                <textarea type="text" class="form-control name_barangs" style="width:500px" data-rowid="0" name="name_product[]" id="information" readonly></textarea>
	              </td>
	              <td style="margin-bottom: 50px;">
	                <br>
	               <input type="number" class="form-control" placeholder="qty" name="qty[]" id="quantity" style="width: 70px;font-size: 14px" required>
	              </td>
	              <td style="margin-bottom: 50px">
	                <br><input type="text" class="form-control units" data-rowid="0" placeholder="Enter unit" name="unit[]" id="unit" readonly >
	              </td>
	              <!-- <td style="margin-bottom: 50px">
	                <br><input type="text" class="form-control money" data-rowid="0" placeholder="Enter nominal" name="nominal[]" id="nominal" >
	              </td> -->
	              <td>
	                <a href='javascript:void(0);'  class='remove'><span class="fa fa-times" style="font-size: 18px;margin-top: 20px;color: red;"></span></a>
	              </td>
	            </tr>
	          </table>
	          <div class="col-md-12" id="btn_submit">
	            <br>
	            <button type="submit" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
	          </div>
            </div>
          
      </form>
    </div>
  </div>
</section>


@endsection

@section('script')
  <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>

  <script type="text/javascript">
    var i = 1;
    $('#addMore').click(function(){  
         i++;  
         $('#product-add').append('<tr id="row'+i+'"><td data-rowid="'+i+'" style="vertical-align:middle"></td><td><br><select class="form-control" name="msp_code[]" data-rowid="'+i+'" id="msp_code"><option>-- Select MSPCode --</option>@foreach($msp_code as $data)<option value="{{$data->kode_barang}}">{{$data->kode_barang}}-{{$data->nama}}</option>@endforeach</select></td><td hidden><input type="" name="id_barangs[]" id="id_barangs" class="id_barangs" value="" data-rowid="'+i+'" hidden></td><td style="margin-bottom: 50px"><br><textarea type="text" class="form-control name_barangs" style="width:500px" data-rowid="'+i+'" name="name_product[]" id="information" readonly></textarea></td><td style="margin-bottom: 50px;"><br><input type="number" class="form-control" placeholder="qty" name="qty[]" id="quantity" style="width: 70px;font-size: 14px" ></td><td style="margin-bottom: 50px"><br><input type="text" class="form-control units" data-rowid="'+i+'" placeholder="Enter unit" name="unit[]" id="unit" readonly ></td><td><a href="javascript:void(0);" id="'+i+'"class="remove"><span class="fa fa-times" style="font-size: 18px;color:red;margin-top: 25px"></span></a></td></tr>');
           initproduk();

    });

    $('#msp_code').select2();

    function initproduk(){
      $('#msp_code ').select2();
    }

    $(document).on('click', '.remove', function() {
         var trIndex = $(this).closest("tr").index();
            if(trIndex>1) {
             $(this).closest("tr").remove();
           } else {
             alert("Sorry!! Can't remove first row!");
           }
    });

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
               $(".units[data-rowid='"+rowid+"']").val(value.unit);

               console.log(value.unit);
            });



          }
        });
    });
  </script>
@endsection